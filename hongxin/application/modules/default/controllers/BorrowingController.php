<?php

/**
 * 借款列表
 *
 * @author cdlei
 */

require 'CommonController.php';

class BorrowingController extends CommonController
{
    /**
     * 初始化
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_Borrowing();
    }

    /**
     * 默认动作
     * 
     * @return void
     */
    public function indexAction()
    {
        $memberModel = new Application_Model_Member();

        //获取当前页码
        $pageSize = 15;
        $pageNo = intval($this->_request->get('pageNo'));
        if (empty($pageNo)) {
            $pageNo = 1;
        }

        //设置URL模板以及条件
        $urls = array();
        $wheres = array();
        $vars = array();

        $vars['status'] = in_array($this->_request->get('status'), array('1', '2', '3')) ? $this->_request->get('status') : '1';
        $vars['keyword'] = trim($this->_request->get('keyword'));
        $vars['amount1'] = trim($this->_request->get('amount1')) != '' ? intval($this->_request->get('amount1')) : NULL;
        $vars['amount2'] = trim($this->_request->get('amount2')) != '' ? intval($this->_request->get('amount2')) : NULL;
        $vars['deadlineLimit'] = trim($this->_request->get('deadlineLimit'));
        $vars['orderby'] = trim($this->_request->get('orderby'));

        if ($vars['status'] == '1') {
            $wheres[] = "`b`.`status` IN ('1', '2')";
        } else if ($vars['status'] == '2') {
            $wheres[] = "`b`.`status` IN ('3')";
        } else if ($vars['status'] == '3') {
            $wheres[] = "`b`.`status` IN ('4', '5')";
        }
        if ($vars['keyword'] != '') {
            $wheres[] = "`b`.`code` = {$this->_model->getAdapter()->quote($vars['keyword'])} OR `b`.`title` LIKE '%" . addslashes($vars['keyword']) . "%'";
        }
        if ($vars['amount1'] !== NULL) {
            $wheres[] = "`b`.`amount` >= {$vars['amount1']}";
        }
        if ($vars['amount2'] !== NULL) {
            $wheres[] = "`b`.`amount` <= {$vars['amount2']}";
        }
        if (in_array($vars['deadlineLimit'], array('1', '2'))) {
            if ($vars['deadlineLimit'] == '1') {
                $wheres[] = "`b`.`deadline` >= 1 AND `b`.`deadline` <= 6";
            } else if ($vars['deadlineLimit'] == '2') {
                $wheres[] = "`b`.`deadline` >= 7 AND `b`.`deadline` <= 12";
            }
        }

        $orderby = "`b`.`addTime` DESC";
        if ($vars['orderby'] == '1') {
            $orderby = "`b`.`addTime` DESC";
        } else if ($vars['orderby'] == '2') {
            $orderby = "`b`.`amount` DESC";
        } else if ($vars['orderby'] == '3') {
            $orderby = "`b`.`monthInterestRate` DESC";
        } else if ($vars['orderby'] == '4') {
            $orderby = "get_borrowed_amount(`b`.`code`)/`b`.`amount` DESC";
        }

        $urls = $vars;
        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT `b`.*, `m`.`avatarPath`, `m`.`name` AS `memberName`, get_borrowed_json(`b`.`code`) AS `borrowedJson` FROM `{$this->_model->getTableName()}` AS `b`" 
             . " LEFT JOIN `{$memberModel->getTableName()}` AS `m` ON `b`.`userName` = `m`.`userName`"
             . " {$where} ORDER BY {$orderby}";
        $dbPaginator = new Application_Model_DbPaginator($sql, $pageSize, $pageNo);
        $recordCount = $dbPaginator->getRecodCount();

        //获取分页html字符
        Zend_Loader::loadClass('Project_Paginator');
        $paginator = new Project_Paginator($recordCount, $pageSize, $pageNo);
        $paginator->urlTemplateContent = $urlTemplate;
        $rows = $dbPaginator->getRows();

        foreach($rows as $key=>$row) {
            if (!empty($row['avatarPath'])) {
                $row['avatarUrl'] = $this->_configs['project']['memberAvatarBaseUrl'] . $row['avatarPath'];
            } else {
                $row['avatarUrl'] = $this->_configs['project']['memberAvatarDefaultUrl'];
            }
            $borrowedInfo = Zend_Json::decode($row['borrowedJson']);
            $row['schedule'] = round($borrowedInfo['amount'] / $row['amount'] * 100, 1);
            $row['borrowedCount'] = $borrowedInfo['count'];
            $rows[$key] = $row;
        }

        //分配view(分页处理后的记录集以及分页HTML字符)
        $this->view->pageString = $paginator->getPageString();
        $this->view->rows = $rows;
        $urls['pageNo'] = $pageNo;
        $this->view->pageUrl = $this->view->projectUrl($urls);
        $this->view->vars = $vars;
        $this->view->title = '借款项目列表 - ' . $this->view->title;
    }

    /**
     * 查看
     * 
     * @return void
     */
    public function viewAction()
    {
        $memberModel = new Application_Model_Member();
        $memberBaseModel = new Application_Model_MemberBase();
        $memberBalanceModel = new Application_Model_MemberBalance();
        $serviceModel = new Application_Model_Service();
        $borrowingDetailModel = new Application_Model_BorrowingDetail();
        $repaymentModel = new Application_Model_Repayment();
        $code = trim($this->_request->get('code'));

        $borrowingSelect = $this->_model->select(false)
                 ->setIntegrityCheck(false)
                 ->from(array('b'=>$this->_model->getTableName()), array('*'))
                 ->joinLeft(array('m'=>$memberModel->getTableName()), "`b`.`userName` = `m`.`userName`", array('gender', 'birthday', 'avatarPath', 'idCardAddress', 'regTime', 'lastVisitTime'=>new Zend_Db_Expr('get_member_last_visit_time(`b`.`userName`)'), 'borrowedJson'=>new Zend_Db_Expr('get_borrowed_json(`b`.`code`)')))
                 ->order('b.addTime DESC')
                 ->where("`b`.`code` = {$this->_model->getAdapter()->quote($code)}");
        $row = $this->_model->fetchRow($borrowingSelect);
        if (empty($row)) {
            echo $this->view->message('记录不存在，请返回重试！', $this->view->projectUrl(array('action'=>'index'))) ;
            exit;
        }
        if (!empty($row['avatarPath'])) {
            $row['avatarUrl'] = $this->_configs['project']['memberAvatarBaseUrl'] . $row['avatarPath'];
        } else {
            $row['avatarUrl'] = $this->_configs['project']['memberAvatarDefaultUrl'];
        }
        $borrowedInfo = Zend_Json::decode($row['borrowedJson']);
        $row['schedule'] = round($borrowedInfo['amount'] / $row['amount'] * 100, 1);
        $row['borrowedCount'] = $borrowedInfo['count'];
        $row['borrowedAmount'] = $borrowedInfo['amount'];

        $serviceRow = $memberModel->getMemberGradeServiceRow($row['userName']);
        $memberBaseRow = $memberBaseModel->fetchRow("`userName` = '{$row['userName']}'");
        $memberBalanceRow = $memberBalanceModel->fetchRow("`userName` = '{$row['userName']}'");
        $x = Application_Model_Borrowing::fetchAllX(100, $row['monthInterestRate'], $row['deadline'], $row['repaymentType']);
        $borrowingDetailRows = $borrowingDetailModel->fetchAll("`borrowingCode` = '{$row['code']}'");
        $borrowingNoPayRows = $this->_model->fetchAll("`userName` = '{$row['userName']}' AND `status` = '3'", 'id DESC', 20);//此会员所有未还款记录
        foreach($borrowingNoPayRows as $key=>$borrowingNoPayRow) {
            $borrowingNoPayRow['bx'] = Application_Model_Borrowing::fetchAllBx($borrowingNoPayRow['amount'], $borrowingNoPayRow['monthInterestRate'], $borrowingNoPayRow['deadline'], $borrowingNoPayRow['repaymentType']);
            $borrowingNoPayRows[$key] = $borrowingNoPayRow;
        }

        $this->view->row = $row;
        $this->view->x = $x;
        $this->view->serviceRow = $serviceRow;
        $this->view->memberBaseRow = $memberBaseRow;
        $this->view->memberBalanceRow = $memberBalanceRow;
        $this->view->memberVars = $this->_configs['project']['memberVars'];
        $this->view->borrowingDetailRows = $borrowingDetailRows;
        $this->view->borrowingNoPayRows = $borrowingNoPayRows;
        $this->view->title = "{$row['title']} - " . $this->view->title;
    }

    /**
     * 投标
     * 
     * @return void
     */
    public function loanAction()
    {
        $memberModel = new Application_Model_Member();
        $accountDetailsModel = new Application_Model_AccountDetails();
        $borrowingDetailModel = new Application_Model_BorrowingDetail();
        $repaymentModel = new Application_Model_Repayment();
        $code = trim($this->_request->get('code'));

        $borrowingSelect = $this->_model->select(false)
                 ->setIntegrityCheck(false)
                 ->from(array('b'=>$this->_model->getTableName()), array('*'))
                 ->joinLeft(array('m'=>$memberModel->getTableName()), "`b`.`userName` = `m`.`userName`", array('gender', 'birthday', 'avatarPath', 'idCardAddress', 'regTime', 'lastVisitTime'=>new Zend_Db_Expr('get_member_last_visit_time(`b`.`userName`)'), 'borrowedJson'=>new Zend_Db_Expr('get_borrowed_json(`b`.`code`)')))
                 ->order('b.addTime DESC')
                 ->where("`b`.`code` = {$this->_model->getAdapter()->quote($code)}");
        $row = $this->_model->fetchRow($borrowingSelect);

        $errorMessage = NULL;
        if (empty($row)) {
            $errorMessage = '记录不存在，请返回重试！';
        }
        if ($row['status'] != '2' && $errorMessage === NULL) {
            $errorMessage = '投标失败，此借款当前不是可投状态！';
        }
        if (trim(Application_Model_MemberLogin::getLoginedUserName()) == '' && $errorMessage === NULL) {
            $errorMessage = '投标失败，你还没有<a href="' . $this->view->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'login')) . '" style="text-decoration:underline;">登录</a>，如果还没不是本站会员，请<a href="' . $this->view->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'register')) . '" style="text-decoration:underline;">注册</a>。' ;
        }
        if (Application_Model_MemberLogin::getLoginedUserName() == $row['userName'] && $errorMessage === NULL) {
            $errorMessage = '投标失败，你不能投自己的标！' ;
        }
        if ($errorMessage !== NULL && $errorMessage === NULL) {
            $memberLoginModel = new Application_Model_MemberLogin();
            $currentMemberRow  = $row = $memberLoginModel->getLoginedRow();
            if ($currentMemberRow['lendersStatus'] != '3') {
                $errorMessage = '投标失败，投资资料未提交或还未审核通过，如有疑问请与管理员联系！' ;
            }
        }
        if ($errorMessage === NULL && $errorMessage === NULL) {
            $borrowedInfo = Zend_Json::decode($row['borrowedJson']);
            $row['schedule'] = round($borrowedInfo['amount'] / $row['amount'] * 100, 1);
            $row['borrowedCount'] = $borrowedInfo['count'];
            $row['borrowedAmount'] = $borrowedInfo['amount'];
            $surplusAvailableAmount = $accountDetailsModel->getSurplusAvailableAmount(Application_Model_MemberLogin::getLoginedUserName());
            $this->view->row = $row;
            $this->view->surplusAvailableAmount = $surplusAvailableAmount;
        }
        $this->view->errorMessage = $errorMessage;

        if ($this->_request->isPost()) {
            $backUrl = $this->view->projectUrl(array('action'=>'view', 'code'=>$code));
            if ($errorMessage !== NULL) {
                echo $this->view->message($errorMessage, $backUrl) ;
                exit;
            } else {
                $amount = trim($this->_request->get('borrowingAmount'));
                if (!is_numeric($amount)) {
                    echo $this->view->message('金额填写错误', $backUrl) ;
                    exit; 
                }
                if ($amount <= 0) {
                    echo $this->view->message('金额填写错误', $backUrl) ;
                    exit; 
                }
                if ($amount > ($row['amount'] - $row['borrowedAmount'])) {
                    echo $this->view->message('投资金额不能大于此标可投金额。', $backUrl) ;
                    exit; 
                }
                if ($amount < $row['amountMinUnit'] && $row['amountMinUnit'] != 0) {
                    echo $this->view->message("投资金额必须大于投资限额￥{$row['amountMinUnit']}。", $backUrl) ;
                    exit; 
                }
                if ($amount > $row['amountMaxUnit'] && $row['amountMaxUnit'] != 0) {
                    echo $this->view->message("投资金额必须小于投资限额￥{$row['amountMaxUnit']}。", $backUrl) ;
                    exit; 
                }
                if ($amount > $surplusAvailableAmount) {
                    echo $this->view->message("投资金额不能大于你的帐号可用金额￥{$surplusAvailableAmount}。", $backUrl) ;
                    exit; 
                }
                $field = array();
                $field['borrowingCode'] = $code;
                $field['userName'] = Application_Model_MemberLogin::getLoginedUserName();
                $field['amount'] = $amount;
                $field['addTime'] = time();
                $borrowingDetailModel->insert($field);
                echo $this->view->message("投标成功。") ;
                exit; 
            }
        }
    }
}