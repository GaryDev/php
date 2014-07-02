<?php
require 'CommonController.php';

class AgreementController extends CommonController
{
	
	public function delegateAction()
	{
		if ($this->_request->isPost()) {
			$content = trim($this->_request->get('content'));
			$orderNo = trim($this->_request->get('orderNo'));
			$name = cword($content,'D'.$orderNo);
			$buffer = readfile($name);
			//Download file
			if(isset($HTTP_SERVER_VARS['HTTP_USER_AGENT']) and strpos($HTTP_SERVER_VARS['HTTP_USER_AGENT'],'MSIE'))
				Header('Content-Type: application/force-download');
			else
				Header('Content-Type: application/octet-stream');
			if(headers_sent())
				die('Some data has already been output to browser, can\'t send Word file');
			//Header('Content-Length: '.strlen($buffer));
			Header('Content-disposition: attachment; filename=委托协议.doc');
			echo $buffer;
			exit;
		} else {
			$code = trim($this->_request->get('code'));
			$orderModel = new Application_Model_Order();
			$row = $orderModel->getOrderInfo($code);
			
			$textModel = new Application_Model_Text();
			$content = $textModel->content(6);
			$content = sprintf($content, $row['buyerName'], $row['companyName'], 
					$row['companyName'], $row['notes'], $row['repaymentBank'],
					number_format($row['ticketAmount']),$row['repaymentBank'],date('Y-m-d', $row['ticketEndTime']),date('Y年m月d日', time()));
			$this->view->menuTitle = '委托协议';
			$this->view->content = $content;
			$this->view->orderNo = $code;
			$this->renderScript('agreement/agreement.php');
		}
	}
	
	public function loanAction() {
		if ($this->_request->isPost()) {
			$content = trim($this->_request->get('content'));
			$orderNo = trim($this->_request->get('orderNo'));
			$name = cword($content,'L'.$orderNo);
			$buffer = readfile($name);
			//var_dump(strlen($buffer)); die();
			//Download file
			if(isset($HTTP_SERVER_VARS['HTTP_USER_AGENT']) and strpos($HTTP_SERVER_VARS['HTTP_USER_AGENT'],'MSIE'))
				Header('Content-Type: application/force-download');
			else
				Header('Content-Type: application/octet-stream');
			if(headers_sent())
				die('Some data has already been output to browser, can\'t send Word file');
			//Header('Content-Length: '.strlen($buffer));
			Header('Content-disposition: attachment; filename=质押借款协议.doc');
			echo $buffer;
			exit;
		} else {
			$code = trim($this->_request->get('code'));
			$orderModel = new Application_Model_Order();
			$row = $orderModel->getOrderInfo($code);
			//var_dump($row); die();
			
			$textModel = new Application_Model_Text();
			$content = $textModel->content(5);
			$content = str_replace('%', '%%', $content);
			$content = str_replace('%%s', '%s', $content);
			$content = sprintf($content, $row['buyerName'], $row['idCardNumber'], 
					$row['buyUser'], $row['companyName'], $row['code'], $row['notes'],
					number_format($row['orderAmount']), number_format($row['benifit'], 2), $row['yearInterestRate'],
					date('Y年m月d日', $row['startTime']), date('Y年m月d日', $row['endTime']), date('Y年m月d日', $row['repayEndTime']),
					$row['repaymentBank'], number_format($row['ticketAmount']), $row['repaymentBank'], date('Y-m-d', $row['ticketEndTime']),
					$row['code'], rmb($row['orderAmount']), rmb($row['benifit']), date('Y年m月d日', $row['startTime']));
			
			$this->view->menuTitle = '质押借款协议';
			$this->view->content = $content;
			$this->view->orderNo = $code;
			$this->renderScript('agreement/agreement.php');
		}
	}

}