<?php

/**
 * 首页控制器
 *
 * @author cdlei
 */

require 'CommonController.php';

class Member_IndexController extends Member_CommonController
{
    /**
     * 初始化
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
    }

    /**
     * 默认动作
     * 
     * @return void
     */
    public function indexAction()
    {
        $memberLoginModel = new Application_Model_MemberLogin();
        $borrowingModel = new Application_Model_Borrowing();
        $borrowingDetailModel = new Application_Model_BorrowingDetail();
        $memberModel = new Application_Model_Member();
        $repaymentDetailModel = new Application_Model_RepaymentDetail();
        $repaymentModel = new Application_Model_Repayment();
        $accountDetailsModel = new Application_Model_AccountDetails();
        $orderModel = new Application_Model_Order();

        $row = $memberLoginModel->getLoginedRow();
        
        $memberEnterpriseRow = array();
        if($row['userType'] == 'E') {
        	$memberEnterpriseModel = new Application_Model_MemberEnterprise();
        	$memberEnterpriseRow = $memberEnterpriseModel->fetchRow("`userName` = '{$row['userName']}'");
        }
        
        //判断用户资料是否填写完整
        $infoComplete = $memberLoginModel->hasCompleteInfo($row, $memberEnterpriseRow);

        //资金总额
        $amounts = $accountDetailsModel->getSurplusAmounts($row['userName']);

        //最新订单
        $orderTypes = $this->_configs['project']['memberVars']['orderType'];
        $orderSelect = $orderModel->select(false)
	        ->setIntegrityCheck(false)
	        ->from(array('o'=>$orderModel->getTableName()), array('*'))
	        ->joinLeft(array('b'=>$borrowingModel->getTableName()), "`o`.`borrowCode` = `b`.`code`", array('title', 'yearInterestRate', 'deadline', 'endTime', 'repayEndTime'))
	        ->order('o.addTime DESC')
	        ->where("`o`.`buyUser` = {$orderModel->getAdapter()->quote($row['userName'])}")
        	->limit(3);
        $orderRows = $orderModel->fetchAll($orderSelect);
        foreach($orderRows as $key=>$orderRow) {
        	$orderRow['status'] = $orderTypes[$orderRow['status']];
        	$orderRows[$key] = $orderRow;
        }
        

        //待收本金利息
        $lenderNoRepaymentAmounts = $repaymentDetailModel->getNoRepaymentAmounts($row['userName']);

        //已收本金利息
        $lenderRepaymentAmounts = $repaymentDetailModel->getRepaymentAmounts($row['userName']);

        //未还本金利息
        $noRepaymentAmounts = $repaymentModel->getNoRepaymentAmounts($row['userName']);

        //充值总额
        $accountCharge = $accountDetailsModel->getTotalAmount($row['userName'], 'account_charge');

        //提现总额
        $accountWithdrawals = $accountDetailsModel->getTotalAmount($row['userName'], 'account_withdrawals');

        //借入总额
        $borrowingAmount = $borrowingModel->getBorrwingAmount($row['userName']);

        //已还总额
        $repaymentAmounts = $repaymentModel->getRepaymentAmounts($row['userName']);

        //借出总额
        $borrowingDetailAmount = $borrowingDetailModel->getBorrwingDetailAmount($row['userName']);

        $this->view->infoComplete = $infoComplete;
        $this->view->memeberRow = $row;
        $this->view->memberEnterpriseRow = $memberEnterpriseRow;
        $this->view->orderRows = $orderRows;
        $this->view->surplusAvailableAmount = $amounts['surplusAvailableAmount'];
        $this->view->surplusLockAmount = $amounts['surplusLockAmount'];
        $this->view->lenderNoRepaymentAmounts = $lenderNoRepaymentAmounts;
        $this->view->lenderRepaymentAmounts = $lenderRepaymentAmounts;
        $this->view->noRepaymentAmounts = $noRepaymentAmounts;
        $this->view->accountCharge = $accountCharge;
        $this->view->accountWithdrawals = $accountWithdrawals;
        $this->view->borrowingAmount = $borrowingAmount;
        $this->view->repaymentAmounts = $repaymentAmounts;
        $this->view->borrowingDetailAmount = $borrowingDetailAmount;
    }
}