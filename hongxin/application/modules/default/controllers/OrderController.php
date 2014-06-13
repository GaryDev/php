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
		$benifitDay = (int)((($row['ticketEndTime'] - $row['endTime'])/86400));
		
		$this->view->row = $row;
		$this->view->benifitDay = $benifitDay;
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
			//$field['benifit'] = $field['orderAmount'] * ($row['yearInterestRate']/100) * ($row['deadline']/365);
			$field['benifit'] = $field['orderAmount'] * ($row['yearInterestRate']/100) * ($benifitDay/365);
			
			$id = $this->_model->add($field);
			if($id > 0)
			{
				$remaining = $row['amountUnit'] - $field['orderQty'];
				$borrowingModel->changeAmountUnit($code, $remaining);
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
    			//var_dump('-----------------充值响应---------------');
    			//var_dump($response);
    			if($response['rspCode'] == '0000') {
    				if($response['responseMode'] == 1) {
    					//var_dump($response);//die('responseMode == 1');
    					$orderRow = $this->_model->getOrderMemberInfo($response['orderId']);
    					$retry = 1;
    					$freeze_success = false;
    					do {
    						$freezeSeq = $this->_freezeMoney($orderRow);
    						//die();
    						if(!empty($freezeSeq) && $freezeSeq > 0) {
    							//var_dump($freezeSeq);die('$freezeSeq');
    							$this->_model->update(array('ysbFreezeSeq' => $freezeSeq), "`orderSN` = '{$response['orderId']}'");
    							echo $this->view->message('资金冻结成功！', $backUrl, 1, 'window.opener=null;window.close();');
    							exit;
    						}
    						$retry = $retry + 1;
    					} while($retry <= 3);
    					if(!$freeze_success) {
    						$rspCode = $this->_refundMoney($orderRow);
    						if(!empty($rspCode) && $rspCode == '0000') {
    							//var_dump($rspCode);die('$rspCode');
    							$this->_model->update(array('refundFlag' => 1), "`orderSN` = '{$response['orderId']}'");
    							echo $this->view->message('资金冻结失败。充值资金已退回！', $backUrl, 3, 'window.opener=null;window.close();');
    							exit;
    						}
    					}
    				}
    				exit;
    			} else {
    				echo $this->view->message('资金冻结失败。请重试！', $backUrl, 3, 'window.opener=null;window.close();');
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
			$row = $this->_model->fetchRow("`orderSN` = '{$orderNo}'");
			if($row['ysbFreezeSeq'] > 0) {
				$this->_model->update(array('status' => 20), "`orderSN` = '{$orderNo}'");
				// 判断是否满标
				$this->_verifyBorrowComplete($row['borrowCode']);
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
	
	private function _verifyBorrowComplete($code) {
		$borrowingModel = new Application_Model_Borrowing();
		$borrowRow = $borrowingModel->fetchRow("`code` = '{$code}'");
		if($borrowRow['amountUnit'] == 0) {
			$orderRow = $this->_model->fetchAll("`borrowCode` = '{$code}'");
			foreach ($orderRow as $key=>$row) {
				$this->_thawMoney($row);
			}
			/*
			$benifitDay = (int)((($borrowRow['ticketEndTime'] - time())/86400));
			$expr = 'orderAmount * ('.$borrowRow['yearInterestRate'].'/100) * ('.$benifitDay.'/365)';
			$this->_model->update(array('benifit'=>new Zend_Db_Expr($expr)), "`borrowCode` = '{$code}' AND status IN(10, 20)");
			*/
		}
	}
	
	private function _thawMoney($orderRow) {
		$toUserSeq = NULL;
		$params = ysbThawParam($this->_configs['project']['ysbVars'], $orderRow, 1);
		//var_dump('-----------------解冻参数---------------');
		//var_dump($params);
		$client = new Zend_Http_Client();
		$response = $client->setUri($this->_configs['project']['ysbVars']['url']['thaw'])
					->setMethod(Zend_Http_Client::POST)
					->setParameterPost($params)
					->request();
		if($response->isSuccessful()) {
			$result = Zend_Json::decode($response->getBody());
			//var_dump('-----------------解冻响应---------------');
			//var_dump($result);
			if(key_exists('rspCode', $result) && $result['rspCode'] == '0000') {
				$verify = array(
						'rspCode' => $result['rspCode'],
						'rspMsg' => $result['rspMsg'],
						'merchantId' => $result['merchantId'],
						'orderId' => $result['orderId'],
						'toUserSeq' => $result['toUserSeq'],
						'toUserFeeSeq' => $result['toUserFeeSeq'],
						'fromUserAcctId' => $result['fromUserAcctId'],
						'fromUserAcctBal' => $result['fromUserAcctBal'],
						'toUserAcctId' => $result['toUserAcctId'],
						'toUserAcctBal' => $result['toUserAcctBal'],
						'merchantKey' => $this->_configs['project']['ysbVars']['merchantKey'],
				);
				if($result['mac'] == ysbMac($verify)) {
					$toUserSeq = $result['toUserSeq'];
				} else {
					echo $this->view->message('Mac校验出错。请重试！', '', 3, 'window.opener=null;window.close();');
					exit;
					//die('_thawMoney');
				}
			}
		}
		return $toUserSeq;
	}
	
	private function _freezeMoney($orderRow)
	{
		$freezeSeq = NULL;
		$params = ysbFreezeParam($this->_configs['project']['ysbVars'], $orderRow);
		//var_dump('-----------------冻结参数---------------');
		//var_dump($params);
		$client = new Zend_Http_Client();
		$response = $client->setUri($this->_configs['project']['ysbVars']['url']['freeze'])
					->setMethod(Zend_Http_Client::POST)
					->setParameterPost($params)
					->request();
		if($response->isSuccessful()) {
			$result = Zend_Json::decode($response->getBody());
			//var_dump('-----------------冻结响应---------------');
			//var_dump($result);
			if(key_exists('rspCode', $result) && $result['rspCode'] == '0000') {
				$verify = array(
					'rspCode' => $result['rspCode'],
					'rspMsg' => $result['rspMsg'],
					'merchantId' => $result['merchantId'],
					'orderId' => $result['orderId'],
					'curType' => $result['curType'],
					'amount' => $result['amount'],
					'freezeSeq' => $result['freezeSeq'],
					'merchantKey' => $this->_configs['project']['ysbVars']['merchantKey'],
				);
				if($result['mac'] == ysbMac($verify)) {
					$freezeSeq = $result['freezeSeq'];
				} else {
					echo $this->view->message('Mac校验出错。请重试！', '', 3, 'window.opener=null;window.close();');
					exit;
					//die('_freezeMoney');
				}
			}
		}
		return $freezeSeq;
	}
	
	private function _refundMoney($orderRow)
	{
		$rspCode = NULL;
		$params = ysbFreezeParam($this->_configs['project']['ysbVars'], $orderRow);
		//var_dump('-----------------退款---------------');
		//var_dump($params);
		$client = new Zend_Http_Client();
		$response = $client->setUri($this->_configs['project']['ysbVars']['url']['refund'])
					->setMethod(Zend_Http_Client::POST)
					->setParameterPost($params)
					->request();
		if($response->isSuccessful()) {
			$result = Zend_Json::decode($response->getBody());
			//var_dump($result);
			if(key_exists('rspCode', $result) && $result['rspCode'] == '0000') {
				$verify = array(
					'rspCode' => $result['rspCode'],
					'rspMsg' => $result['rspMsg'],
					'merchantId' => $result['merchantId'],
					'userId' => $orderRow['buyerId'],
					'orderId' => $result['orderId'],
					'oriOrderId' => $orderRow['orderSN'],
					'curType' => $result['curType'],
					'amount' => $result['amount'],
					'merchantKey' => $this->_configs['project']['ysbVars']['merchantKey'],
				);
				if($result['mac'] == ysbMac($verify)) {
					$rspCode = $result['rspCode'];
				} else {
					echo $this->view->message('Mac校验出错。请重试！', '', 3, 'window.opener=null;window.close();');
					exit;
					//die('_refundMoney');
				}
			}
		}
		return $rspCode;
	}
	
}