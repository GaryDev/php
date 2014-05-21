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
        $accountDetailsModel = new Application_Model_AccountDetails();
        $repaymentDetailModel = new Application_Model_RepaymentDetail();
        $repaymentModel = new Application_Model_Repayment();
        $accountDetailsModel = new Application_Model_AccountDetails();

        $row = $memberLoginModel->getLoginedRow();

        if (!empty($row['avatarPath'])) {
            $avatarUrl = $this->_configs['project']['memberAvatarBaseUrl'] . $row['avatarPath'];
        } else {
            $avatarUrl = $this->_configs['project']['memberAvatarDefaultUrl'];
        }
        
        $memberEnterpriseRow = array();
        if($row['userType'] == 'E') {
        	$memberEnterpriseModel = new Application_Model_MemberEnterprise();
        	$memberEnterpriseRow = $memberEnterpriseModel->fetchRow("`userName` = '{$row['userName']}'");
        }
        
        //判断用户资料是否填写完整
        $infoComplete = $memberLoginModel->hasCompleteInfo($row, $memberEnterpriseRow);
        
        //客服代表
        $serviceRow = $memberLoginModel->getMemberGradeServiceRow($row['userName']);

        //资金总额
        $amounts = $accountDetailsModel->getSurplusAmounts($row['userName']);
        

        //最新贷款的项目
        $borrowingSelect = $borrowingModel->select(false)
                 ->setIntegrityCheck(false)
                 ->from(array('b'=>$borrowingModel->getTableName()), array('borrowedAmount'=>new Zend_Db_Expr('get_borrowed_amount(`b`.`code`)'), '*'))
                 ->joinLeft(array('m'=>$memberModel->getTableName()), "`b`.`userName` = `m`.`userName`", "avatarPath")
                 ->order('b.addTime DESC')
                 ->where("`b`.`status`  IN('1', '2')")
                 ->limit(8);
        $borrowingRows = $borrowingModel->fetchAll($borrowingSelect);
        foreach($borrowingRows as $key=>$borrowingRow) {
            if (!empty($borrowingRow['avatarPath'])) {
                $borrowingRow['avatarUrl'] = $this->_configs['project']['memberAvatarBaseUrl'] . $borrowingRow['avatarPath'];
            } else {
                $borrowingRow['avatarUrl'] = $this->_configs['project']['memberAvatarDefaultUrl'];
            }
            $borrowingRow['schedule'] = round($borrowingRow['borrowedAmount'] / $borrowingRow['amount'] * 100, 1);
            $borrowingRows[$key] = $borrowingRow;
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

        $this->view->avatarUrl = $avatarUrl;
        $this->view->infoComplete = $infoComplete;
        $this->view->memeberRow = $row;
        $this->view->memberEnterpriseRow = $memberEnterpriseRow;
        $this->view->serviceRow = $serviceRow;
        $this->view->borrowingRows = $borrowingRows;
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