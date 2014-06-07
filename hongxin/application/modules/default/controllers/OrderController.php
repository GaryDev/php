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
		
		$memberRow = $memberLoginModel->getLoginedRow();
		$params = ysbPaymentParam($memberRow, $this->_configs['project']['ysbVars'], $row);
		
		$this->view->row = $row;
		$this->view->LoginedRow = $memberRow;
		$this->view->params  = $params;
		$this->view->ysburl  = $this->_configs['project']['ysbVars']['url']['payment'];
	}
	
	public function payNotifyAction()
	{
		if($this->_request->isPost()) {
    		$response = array(
    				'rspCode' => $this->_request->get('rspCode'),
    				'rspMsg' => $this->_request->get('rspMsg'),
    				'merchantId' => $this->_request->get('merchantId'),
    				'responseMode' => $this->_request->get('responseMode'),
    				'orderId' => $this->_request->get('orderId'),
    				'curType' => $this->_request->get('curType'),
    				'amount' => $this->_request->get('amount'),
    				'merchantKey' => $this->_configs['project']['ysbVars']['merchantKey'],
    		);
    		$backUrl = $this->view->projectUrl(array('controller'=> 'member', 'action'=>'index'));
    		if($this->_request->get('mac') == ysbMac($response))
    		{
    			//var_dump($response);die('Mac ==');
    			if($response['rspCode'] == '0000') {
    				if($response['responseMode'] == 1) {
    					//var_dump($response);die('responseMode == 1');
    					$orderRow = $this->_model->getOrderMemberInfo($response['orderId']);
    					$retry = 1;
    					$freeze_success = false;
    					do {
    						$freezeSeq = $this->_freezeMoney($orderRow);
    						if(!empty($freezeSeq) && $freezeSeq > 0) {
    							$this->_model->update(array('ysbFreezeSeq' => $freezeSeq), "`orderSN` = '{$response['orderId']}'");
    							echo $this->view->message('订单支付成功！', $backUrl, 1, 'window.opener=null;window.close();');
    							exit;
    						}
    						$retry = $retry + 1;
    					} while($retry > 3);
    					if(!$freeze_success) {
    						$rspCode = $this->_refundMoney($orderRow);
    						if(!empty($rspCode) && $rspCode == '0000') {
    							$this->_model->update(array('refundFlag' => 1), "`orderSN` = '{$response['orderId']}'");
    							echo $this->view->message('订单支付失败。充值资金已退回！', $backUrl, 3, 'window.opener=null;window.close();');
    							exit;
    						}
    					}
    				}
    				exit;
    			} else {
    				echo $this->view->message('订单支付失败。请重试！', $backUrl, 3, 'window.opener=null;window.close();');
    				exit;
    			}
    		} else {
    			echo $this->view->message('Mac校验出错。请重试！', $backUrl, 3, 'window.opener=null;window.close();');
    			exit;
    		}
    	}
    	exit;
	}
	
	public function paymentAction()
	{
		if($this->_request->isPost()) {
			$orderNo = trim($this->_request->get('orderId'));
			//var_dump($orderNo);die('paymentAction');
			$row = $this->_model->fetchRow("`orderSN` = '{$orderNo}'");
			if($row['ysbFreezeSeq'] > 0) {
				$this->_model->update(array('status' => 20), "`orderSN` = '{$orderNo}'");
			} else if($row['refundFlag'] == 1) {
				$this->_model->update(array('status' => 40), "`orderSN` = '{$orderNo}'");
			}
			redirect($this->view->projectUrl(array('controller'=> 'member', 'action'=>'index')));
		}
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
	
	private function _freezeMoney($orderRow)
	{
		$freezeSeq = NULL;
		$params = ysbFreezeParam($this->_configs['project']['ysbVars'], $orderRow);
		$client = new Zend_Http_Client();
		$response = $client->setUri($this->_configs['project']['ysbVars']['url']['freeze'])
					->setMethod(Zend_Http_Client::POST)
					->setParameterPost($params)
					->request();
		if($response->isSuccessful()) {
			$result = Zend_Json::decode($response->getBody());
			//var_dump($result);die('_freezeMoney');
			if(key_exists('rspCode', $result) && $result['rspCode'] == '0000') {
				$mac = $result['mac']; unset($result['mac']);
				if($mac == ysbMac($result)) {
					$freezeSeq = $result['freezeSeq'];
				} else {
					echo $this->view->message('Mac校验出错。请重试！', '', 3, 'window.opener=null;window.close();');
					exit;
				}
			} else {
				var_dump($result); die('_freezeMoney');
			}
		}
		return $freezeSeq;
	}
	
	private function _refundMoney($orderRow)
	{
		$rspCode = NULL;
		$params = ysbFreezeParam($this->_configs['project']['ysbVars'], $orderRow);
		$client = new Zend_Http_Client();
		$response = $client->setUri($this->_configs['project']['ysbVars']['url']['refund'])
					->setMethod(Zend_Http_Client::POST)
					->setParameterPost($params)
					->request();
		if($response->isSuccessful()) {
			$result = Zend_Json::decode($response->getBody());
			if(key_exists('rspCode', $result) && $result['rspCode'] == '0000') {
				$mac = $result['mac']; unset($result['mac']);
				if($mac == ysbMac($result)) {
					$rspCode = $result['rspCode'];
				} else {
					echo $this->view->message('Mac校验出错。请重试！', '', 3, 'window.opener=null;window.close();');
					exit;
				}
			} else {
				var_dump($result);die('_refundMoney');
			}
		}
		return $rspCode;
	}
	
}