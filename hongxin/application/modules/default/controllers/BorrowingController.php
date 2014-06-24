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
        $pageSize = 20;
        $pageNo = intval($this->_request->get('pageNo'));
        if (empty($pageNo)) {
            $pageNo = 1;
        }

        //设置URL模板以及条件
        $urls = array();
        $wheres = array();
        $vars = array();

        $vars['qFrom'] = trim($this->_request->get('qFrom'));
        $vars['qBank'] = trim($this->_request->get('qBank'));
        $vars['qDeadLine'] = trim($this->_request->get('qDeadLine'));
        $vars['qYearRate'] = trim($this->_request->get('qYearRate'));
        $vars['qAmount'] = trim($this->_request->get('qAmount'));
        
        $wheres[] = "`b`.`status` IN ('3') AND endTime >= unix_timestamp(current_date())";
        
        if($vars['qFrom'] == 'self') {
	        if ($vars['qBank'] != '') {
	            $wheres[] = "`b`.`repaymentBank` = {$this->_model->getAdapter()->quote($vars['qBank'])}";
	        }
	        
	        if (in_array($vars['qDeadLine'], array('1', '2', '3', '4', '5'))) {
	            if ($vars['qDeadLine'] == '1') {
	                $wheres[] = "`b`.`deadline` < 30";
	            } else if ($vars['qDeadLine'] == '2') {
	                $wheres[] = "`b`.`deadline` >= 30 AND `b`.`deadline` < 90";
	            } else if ($vars['qDeadLine'] == '3') {
	                $wheres[] = "`b`.`deadline` >= 90 AND `b`.`deadline` < 180";
	            } else if ($vars['qDeadLine'] == '4') {
	                $wheres[] = "`b`.`deadline` >= 180 AND `b`.`deadline` < 365";
	            } else if ($vars['qDeadLine'] == '5') {
	                $wheres[] = "`b`.`deadline` >= 365";
	            }
	        }
	        
        	if (in_array($vars['qYearRate'], array('1', '2', '3'))) {
	        	if ($vars['qYearRate'] == '1') {
	        		$wheres[] = "`b`.`yearInterestRate` >= 5 AND `b`.`yearInterestRate` < 6.5";
	        	} else if ($vars['qYearRate'] == '2') {
	        		$wheres[] = "`b`.`yearInterestRate` >= 6.5 AND `b`.`yearInterestRate` < 8.5";
	        	} else if ($vars['qYearRate'] == '3') {
	        		$wheres[] = "`b`.`yearInterestRate` >= 8.5 AND `b`.`yearInterestRate` < 10";
	        	}
	        }
	        
	        if (in_array($vars['qAmount'], array('1', '2', '3', '4', '5'))) {
	        	if ($vars['qAmount'] == '1') {
	        		$wheres[] = "`b`.`amount` < 100000";
	        	} else if ($vars['qAmount'] == '2') {
	        		$wheres[] = "`b`.`amount` >= 100000 AND `b`.`amount` < 300000";
	        	} else if ($vars['qAmount'] == '3') {
	        		$wheres[] = "`b`.`amount` >= 300000 AND `b`.`amount` < 500000";
	        	} else if ($vars['qAmount'] == '4') {
	        		$wheres[] = "`b`.`amount` >= 500000 AND `b`.`amount` < 1000000";
	        	} else if ($vars['qAmount'] == '5') {
	        		$wheres[] = "`b`.`amount` >= 1000000";
	        	}
	        }
        } else if($vars['qFrom'] == 'home') {
        	
        	if (!empty($vars['qDeadLine'])) {
        		$wheres[] = "`b`.`deadline` >= {$vars['qDeadLine']}";
        	}
        	
        	if (!empty($vars['qYearRate'])) {
        		$wheres[] = "`b`.`yearInterestRate` >= {$vars['qYearRate']}";
        	}
        	
        	if (!empty($vars['qAmount'])) {
        		$wheres[] = "`b`.`amount` >= {$vars['qAmount']}";
        	}
        	        	
        }

        $orderby = "`b`.`addTime` DESC";
        /*
        if ($vars['orderby'] == '1') {
            $orderby = "`b`.`addTime` DESC";
        } else if ($vars['orderby'] == '2') {
            $orderby = "`b`.`amount` DESC";
        } else if ($vars['orderby'] == '3') {
            $orderby = "`b`.`monthInterestRate` DESC";
        } else if ($vars['orderby'] == '4') {
            $orderby = "get_borrowed_amount(`b`.`code`)/`b`.`amount` DESC";
        }*/

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
            $row['borrowedCount'] = $row['amountMaxUnit'] - $row['amountUnit'];
            $row['percent'] = floor($row['borrowedCount'] / $row['amountMaxUnit'] * 100);
        	if($row['borrowedCount'] > 0 && $row['percent'] < 1) {
            	$row['percent'] = 1;
            } else if($row['percent'] > 100) {
            	$row['percent'] = 99;
            }
            $row['amount'] = number_format($row['amount']);
            $rows[$key] = $row;
        }

        
        $this->view->banks = explode(",", $this->_configs['project']['bankTypes']);
        
        //分配view(分页处理后的记录集以及分页HTML字符)
        $this->view->pageString = $paginator->getPageString();
        $this->view->rows = $rows;
        $urls['pageNo'] = $pageNo;
        $this->view->pageUrl = $this->view->projectUrl($urls);
        $this->view->vars = $vars;
        $this->view->title = '融资项目列表 - ' . $this->view->title;
    }

    /**
     * 查看
     * 
     * @return void
     */
    public function viewAction()
    {
        $memberModel = new Application_Model_Member();
        /*$memberBaseModel = new Application_Model_MemberBase();
        $memberBalanceModel = new Application_Model_MemberBalance();
        $serviceModel = new Application_Model_Service();
        $borrowingDetailModel = new Application_Model_BorrowingDetail();
        $repaymentModel = new Application_Model_Repayment();*/
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
        if (!empty($row['ticketCopyPath'])) {
            $row['ticketCopyPath'] = $this->_configs['project']['ticketCopyBaseUrl'] . $row['ticketCopyPath'];
        } else {
            $row['ticketCopyPath'] = $this->_configs['project']['ticketCopyBaseUrl'];
        }
        
        $row['borrowedCount'] = $row['amountMaxUnit'] - $row['amountUnit'];
        $row['percent'] = floor($row['borrowedCount'] / $row['amountMaxUnit'] * 100);
        if($row['borrowedCount'] > 0 && $row['percent'] < 1) {
        	$row['percent'] = 1;
        } else if($row['borrowedCount'] > 0 && $row['percent'] > 100) {
        	$row['percent'] = 99;
        }
        $row['amount'] = number_format($row['amount']);
        
        /*
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
		*/
        $this->view->row = $row;
        /*$this->view->x = $x;
        $this->view->serviceRow = $serviceRow;
        $this->view->memberBaseRow = $memberBaseRow;
        $this->view->memberBalanceRow = $memberBalanceRow;*/
        $this->view->memberVars = $this->_configs['project']['memberVars'];
        //$this->view->borrowingDetailRows = $borrowingDetailRows;
        //$this->view->borrowingNoPayRows = $borrowingNoPayRows;
        $this->view->title = "{$row['title']} - " . $this->view->title;
    }
    
    public function getQtyAction()
    {
    	$code = trim($this->_request->get('code'));
    	$row = $this->_model->fetchRow("`code` = {$this->_model->getAdapter()->quote($code)}");
    	$qty = intval($row['amountUnit']);
    	echo Zend_Json::encode($qty);
    	exit;
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