<?php
require 'CommonController.php';

class OrderController extends CommonController
{
	
	public function init()
	{
		parent::init();
		$this->_model = new Application_Model_Order();
	}
	
	public function createAction()
	{
		$code = trim($this->_request->get('code'));
		$borrowingModel = new Application_Model_Borrowing();
		$memberLoginModel = new Application_Model_MemberLogin();
		
		$borrowingSelect = $borrowingModel->select(false)
				->setIntegrityCheck(false)
				->from(array('b'=>$borrowingModel->getTableName()), array('*'))
				->where("`b`.`code` = {$borrowingModel->getAdapter()->quote($code)}");
		
		$row = $borrowingModel->fetchRow($borrowingSelect);
		if (empty($row)) {
			echo $this->view->message('记录不存在，请返回重试！', $this->view->projectUrl(array('action'=>'index'))) ;
			exit;
		}
		/*
		if ($row['amountUnit'] == 0) {
			echo $this->view->message('份额不足，请返回重试！', $this->view->projectUrl(array('module'=>'default', 'controller'=>'borrowing', 'action'=>'view', 'code'=>$code)));
			exit;
		}*/
		
		$this->view->row = $row;
		$this->view->LoginedRow = $memberLoginModel->getLoginedRow();
		
		if ($this->_request->isPost())
		{
			$filter = new Zend_Filter_StripTags();
			$field = array();
			
			$field['sellUser'] = $row['userName'];
			$field['buyUser'] = Application_Model_MemberLogin::getLoginedUserName();
			$field['borrowCode'] = $row['code'];
			$field['status'] = 10;
			$field['addTime'] = time();
			$field['orderUnit'] = $row['borrowUnit'];
			$field['orderQty'] = $filter->filter(trim($this->_request->get('orderQty')));
			$field['orderAmount'] = $field['orderUnit'] * $field['orderQty'];
			$field['benifit'] = $field['orderAmount'] * ($row['yearInterestRate']/100) * ($row['deadline']/365);
			
			$id = $this->_model->add($field);
			if($id > 0)
			{
				$borrowingModel->changeAmountUnit($code, $row['amountUnit'] - $field['orderQty']);
			}
			echo $this->view->message('订单提交成功！', $this->view->projectUrl(array('action'=>'checkout', 'orderId'=>$id))) ;
			exit;
		}
	}
	
	public function checkoutAction()
	{
		$id = trim($this->_request->get('orderId'));
		$borrowingModel = new Application_Model_Borrowing();
		$memberLoginModel = new Application_Model_MemberLogin();
		
		$orderSelect = $this->_model->select(false)
				->setIntegrityCheck(false)
				->from(array('o'=>$this->_model->getTableName()), array('*'))
				->joinLeft(array('b'=>$borrowingModel->getTableName()), "`o`.`borrowCode` = `b`.`code`", array('title'))
				->where("`o`.`id` = {$id}");
		
		$row = $this->_model->fetchRow($orderSelect);
		
		$this->view->row = $row;
		$this->view->LoginedRow = $memberLoginModel->getLoginedRow();
	}
	
	public function cancelAction()
	{
		$orderNo = trim($this->_request->get('orderNo'));
		if ($this->_request->isPost())
		{
			$field = array();
			$field['status'] = 30;
			$field['reason'] = '用户取消';
			$this->_model->update($field, "`orderSN` = '{$orderNo}'");
			echo $this->view->message('订单取消成功！', $this->view->projectUrl(array('controller'=>'member', 'action'=>'index'))) ;
			exit;
		}
	}
	
}