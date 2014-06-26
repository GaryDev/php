<?php

require 'CommonController.php';

class Member_CessionController extends Member_CommonController
{
	/**
	 * 初始化
	 *
	 * @return void
	 */
	public function init()
	{
		parent::init();
		echo $this->view->message('功能暂未开放，敬请期待！', $this->view->projectUrl(array('controller'=>'index', 'action'=>'index'))) ;
		exit;
		//$this->_model = new Application_Model_Borrowing();
	}
	
	public function applyAction()
	{
		$memberLoginModel = new Application_Model_MemberLogin();
		//$memberBorrowingAvailableAmountDetailsModel = new Application_Model_MemberBorrowingAvailableAmountDetails();
	
		$memberType = Application_Model_MemberLogin::getLoginedUserType();
		if ($memberType != 'P') {
			echo $this->view->message('您不是个人会员，不能发布转让信息！', $this->view->projectUrl(array('module'=>'default', 'controller'=>'member', 'action'=>'index')));
			exit;
		}
	
		$memberRow = $memberLoginModel->getLoginedRow();
		if ($memberRow['lendersStatus'] != 3) {
			echo $this->view->message('你的资料还没通过认证，暂不能申请！', $this->view->projectUrl(array('controller'=>'index', 'action'=>'index'))) ;
			exit;
		}
		/*
		 if ($memberRow['borrowingCreditIsOpen'] == 0 && $memberRow['borrowingRecommendIsOpen'] == 0) {
		echo $this->view->message('你的账户借款类型没有开启，请与管理员联系！', $this->view->projectUrl(array('controller'=>'user', 'action'=>'index'))) ;
		exit;
		}
	
	
		//费用列表
		$creditFeeList = array();
		for($i = 1; $i <= 12; $i++){
		$creditFeeList[$i] = $this->_model->getFee(Application_Model_MemberLogin::getLoginedUserName(), 1, 'credit', $i, '1');
		}
		$recommendFeeList = array();
		for($i = 1; $i <= 12; $i++){
		$recommendFeeList[$i] = $this->_model->getFee(Application_Model_MemberLogin::getLoginedUserName(), 1, 'recommend', $i, '2');
		}
	
		//获取额度
		$creditAmount = $memberBorrowingAvailableAmountDetailsModel->getSurplusAmount(Application_Model_MemberLogin::getLoginedUserName(), 'credit');
		$recommendAmount = $memberBorrowingAvailableAmountDetailsModel->getSurplusAmount(Application_Model_MemberLogin::getLoginedUserName(), 'recommend');
		*/
		//获取是否没有审核过的
		$isNoCheck = false; //$this->_model->getIsNoCheck(Application_Model_MemberLogin::getLoginedUserName());
		/*if ($isNoCheck) {
		 echo $this->view->message('你尚未审核的申请，暂不能提交新的申请。！', $this->view->projectUrl(array('controller'=>'user', 'action'=>'index'))) ;
		exit;
		}*/
	
	
		$this->view->banks = explode(",", $this->_configs['project']['bankTypes']);
		//$this->view->maxYearRate = $this->_configs['project']['pbcYearRate'] * 4;//最大年利率
		$this->view->maxYearRate = $this->_configs['project']['pbcYearRate']; //参考年利率
		//$this->view->borrowingMin = $this->_configs['project']['borrowingMin'];//单笔借款最少金额
		$this->view->memberRow = $memberRow;
		//$this->view->creditFeeList = $creditFeeList;//信用借款费用列表
		//$this->view->recommendFeeList = $recommendFeeList;//推荐借款费用列表
		//$this->view->creditAmount = $creditAmount;//用户信用借款最大额度
		//$this->view->recommendAmount = $recommendAmount;//用户推荐借款最大额度
		//$this->view->borrowingUnitEnterMax1 = $this->_configs['project']['borrowingUnitEnterMax1'];//投标限额-最小填写
		//$this->view->borrowingUnitEnterMax2 = $this->_configs['project']['borrowingUnitEnterMax2'];//投标限额-最大填写
		//$this->view->isNoCheck = $isNoCheck;
	
		if ($this->_request->isPost() && !$isNoCheck) {
			$filter = new Zend_Filter_StripTags();
			$field = array();
			$field['userName'] = Application_Model_MemberLogin::getLoginedUserName();
			$field['type'] = 'credit';
			$field['repaymentType'] = 3;	//保息固定
			$field['repaymentBank'] = $filter->filter(trim($this->_request->get('repayBank')));
			$field['title'] = $this->_configs['project']['productTitle']; //$filter->filter(trim($this->_request->get('title')));
			$field['code'] = date('YmdHis') . rand(1000, 9999);
			$field['amount'] = is_numeric(trim($this->_request->get('amount'))) ? trim($this->_request->get('amount')) : 0;
			$yearInterestRate = is_numeric(trim($this->_request->get('yearInterestRate'))) ? trim($this->_request->get('yearInterestRate')) : 0;
			$field['yearInterestRate'] = $yearInterestRate;
			$field['borrowUnit'] = $this->_configs['project']['borrowingUnitMin'];
			$field['amountMinUnit'] = $field['borrowUnit'];	// 最小投资份数
			$field['amountMaxUnit'] = $field['amount'] / $field['borrowUnit']; // 最大投资份数
			$field['amountUnit'] = $field['amountMaxUnit'];
			$field['startTime'] = time();												// 投资开始时间
			$field['endTime'] = strtotime($filter->filter(trim($this->_request->get('applyEndDate')))); // 投资截止时间
			$field['ticketEndTime'] = strtotime($filter->filter(trim($this->_request->get('ticketEndDate'))));	//项目到期时间
			$field['repayEndTime'] = strtotime($filter->filter(trim($this->_request->get('repayEndTime'))));	//最迟还款日期
			$field['deadline'] = (int)((($field['ticketEndTime'] - $field['startTime'])/86400) + 1);	   // 期限
			$field['notes'] = $filter->filter(trim($this->_request->get('notes')));
			$field['ticketCopyPath'] = $this->__uploadFile('ticketCopy', 'ticketCopy', $memberRow, array('imgWidth' => 210, 'imgHeight' => 280));
			$field['status'] = '1';
			$field['statusMessage'] = '';
			$field['statusUpdateTime'] = 0;
			$field['addTime'] = time();
			//var_dump($field);die();
			$this->_model->add($field);
			echo $this->view->message('提交成功，请等待审核！', $this->view->projectUrl(array('action'=>'in-progress'))) ;
			exit;
		}
	}
	
}