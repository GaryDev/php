<?php

/**
 * 资金明细
 *
 * @author cdlei
 */

require 'CommonController.php';

class Member_AccountDetailsController extends Member_CommonController
{
    /**
     * 初始化
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_AccountDetails();
    }

    /**
     * 提现记录列表
     * 
     * @return void
     */
    public function listAction()
    {
        //获取当前页码
        $pageSize = 15;
        $pageNo = intval($this->_request->get('pageNo'));
        if (empty($pageNo)) {
            $pageNo = 1;
        }

        //设置URL模板以及条件
        $urls = array();
        $wheres = array();

        $wheres[] = "`userName` = {$this->_model->getAdapter()->quote(Application_Model_MemberLogin::getLoginedUserName())}";

        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT * FROM `{$this->_model->getTableName()}` {$where} ORDER BY `id` DESC";
        $dbPaginator = new Application_Model_DbPaginator($sql, $pageSize, $pageNo);
        $recordCount = $dbPaginator->getRecodCount();

        //获取分页html字符
        Zend_Loader::loadClass('Project_Paginator');
        $paginator = new Project_Paginator($recordCount, $pageSize, $pageNo);
        $paginator->urlTemplateContent = $urlTemplate;

        //分配view(分页处理后的记录集以及分页HTML字符)
        $this->view->pageString = $paginator->getPageString();
        $this->view->rows = $dbPaginator->getRows();
        $urls['pageNo'] = $pageNo;
        $this->view->pageUrl = $this->view->projectUrl($urls);
    }

    /**
     * 申请
     * 
     * @return void
     */
    public function applyAction()
    {
        $memberLoginModel = new Application_Model_MemberLogin();
        $accountDetailsModel = new Application_Model_AccountDetails();
        $memberRow = $memberLoginModel->getLoginedRow();
        if ($memberRow['bankStatus'] != 3) {
            echo $this->view->message('你的银行账号还没通过审核，暂不能提现！', $this->view->projectUrl(array('controller'=>'user', 'action'=>'bank'))) ;
            exit;
        }
        $this->view->memberRow = $memberRow;
        $amounts = $accountDetailsModel->getSurplusAmounts($memberRow['userName']);
        $this->view->surplusAvailableAmount = $amounts['surplusAvailableAmount'];
        $this->view->surplusLockAmount = $amounts['surplusLockAmount'];
        $this->view->withdrawalsUnitAmount = $this->_configs['project']['withdrawalsUnitAmount'];
        $this->view->withdrawalsUnitAmountFee = $this->_configs['project']['withdrawalsUnitAmountFee'];

        if ($this->_request->isPost()) {
            $surplusAvailableAmount = $amounts['surplusAvailableAmount'];
            $amount = intval($this->_request->get('amount'));
            $fee = ceil($amount / $this->_configs['project']['withdrawalsUnitAmount']) * $this->_configs['project']['withdrawalsUnitAmountFee'];

            $filter = new Zend_Filter_StripTags();
            $field = array();
            $field['userName'] = Application_Model_MemberLogin::getLoginedUserName();
            $field['amount'] = $amount;
            $field['fee'] = $fee;
            $field['applyTime'] = time();
            $field['status'] = '1';
            $field['statusLog'] = '';
            $field['statusNotes'] = '';
            $field['userNotes'] = $filter->filter(trim($this->_request->get('userNotes')));

            if ($amount <= 0) {
                echo $this->view->message('提交失败，金额填写错误。');
                exit;
            } else if ($amount + $fee > $surplusAvailableAmount) {
                echo $this->view->message("提交失败，你提现的金额+手续费：￥" . ($amount + $fee) . "，不能大于账户可用金额：￥{$surplusAvailableAmount}。");
                exit;
            } else if ($this->_model->getIsNoCheck(Application_Model_MemberLogin::getLoginedUserName())) {
                echo $this->view->message('提交失败，你有一条提现处于待审核状态。');
                exit;
            }
            $this->_model->insert($field);
            echo $this->view->message('提交成功，请等待审核！');
            exit;
        }
    }

    /**
     * 检查申请VIP会员，返回json格式{'status':0, 'message':'成功'}
     * 
     * @return void
     */
    public function checkAction()
    {
        $accountDetailsModel = new Application_Model_AccountDetails();
        $amounts = $accountDetailsModel->getSurplusAmounts(Application_Model_MemberLogin::getLoginedUserName());
        $surplusAvailableAmount = $amounts['surplusAvailableAmount'];
        $amount = intval($this->_request->get('amount'));
        $fee = ceil($amount / $this->_configs['project']['withdrawalsUnitAmount']) * $this->_configs['project']['withdrawalsUnitAmountFee'];
        if ($amount <= 0) {
            $result = array('status'=>1, 'message'=>'提交失败，金额填写错误。');
        } else if ($amount + $fee > $surplusAvailableAmount) {
            $result = array('status'=>2, 'message'=>"提交失败，你提现的金额+手续费：￥" . ($amount + $fee) . "，不能大于账户可用金额：￥{$surplusAvailableAmount}。");
        } else if ($this->_model->getIsNoCheck(Application_Model_MemberLogin::getLoginedUserName())) {
            $result = array('status'=>3, 'message'=>'提交失败，你有一条提现处于待审核状态。');
        } else {
            $result = array('status'=>0, 'message'=>'可以提现。');
        }
        $this->_helper->getHelper('Json')->sendJson($result);
    }
}