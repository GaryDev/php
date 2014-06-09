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
        $memberModel = new Application_Model_Member();
        $orderModel = new Application_Model_Order();

        $row = $memberLoginModel->getLoginedRow();
        
        $memberEnterpriseRow = array();
        if($row['userType'] == 'C') {
        	$memberEnterpriseModel = new Application_Model_MemberEnterprise();
        	$memberEnterpriseRow = $memberEnterpriseModel->fetchRow("`userName` = '{$row['userName']}'");
        }
        
        //判断用户资料是否填写完整
        $infoComplete = $memberLoginModel->hasCompleteInfo($row, $memberEnterpriseRow);

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
        	$text = $orderTypes[$orderRow['status']];
        	if(!empty($orderRow['reason'])) {
        		$text = $text . '(' . $orderRow['reason'] . ')';
        	}
        	$orderRow['statusText'] = $text;
        	$orderRows[$key] = $orderRow;
        }
        
        //$this->_queryBalance($row, 0);
        try {
        	$normalBalance = $this->_queryBalance($row, 1);
        	$freezeBalance = $this->_queryBalance($row, 2);
        	$balance = array(
        			'normal' => isset($normalBalance) ? $normalBalance : 0.00,
        			'freeze' => isset($freezeBalance) ? $freezeBalance : 0.00,
        	);
        } catch (Exception $e) {
            $balance = array(
        			'normal' => 0.00,
        			'freeze' => 0.00,
        	);
        }
        
        $totalOrder = $orderModel->getOrderTotal($row['userName'], 20, NULL, 'sum');
        
        $unpayRCount = $orderModel->getOrderTotal($row['userName'], 10, 'recommend');
        $paidRCount = $orderModel->getOrderTotal($row['userName'], 20, 'recommend');
        $returnRCount = $orderModel->getOrderTotal($row['userName'], 40, 'recommend');
        
        $unpayCCount = $orderModel->getOrderTotal($row['userName'], 10, 'credit');
        $paidCCount = $orderModel->getOrderTotal($row['userName'], 20, 'credit');
        $returnCCount = $orderModel->getOrderTotal($row['userName'], 40, 'credit');

        $this->view->infoComplete = $infoComplete;
        $this->view->memeberRow = $row;
        $this->view->memberEnterpriseRow = $memberEnterpriseRow;
        $this->view->orderRows = $orderRows;
        $this->view->balance = $balance;
        $this->view->totalOrderAmount = $totalOrder[0];
        $this->view->totalBenifit = $totalOrder[1];
        $this->view->unpayCount = array($unpayRCount, $unpayCCount);
        $this->view->paidCount = array($paidRCount, $paidCCount);
        $this->view->returnCount = array($returnRCount, $returnCCount);
    }
    
    private function _queryBalance($row, $type) {
    	$balance = 0.00;
    	$params = ysbQueryBalanceParam($row, $this->_configs['project']['ysbVars'], $type);
    	//var_dump('-----------------余额查询参数---------------');
    	//var_dump($params);
    	$client = new Zend_Http_Client();
    	$response = $client->setUri($this->_configs['project']['ysbVars']['url']['queryBalance'])
				    	->setMethod(Zend_Http_Client::POST)
				    	->setParameterPost($params)
				    	->request();
    	if($response->isSuccessful()) {
    		$result = Zend_Json::decode($response->getBody());
    		//var_dump('-----------------查询响应---------------');
    		//var_dump($result);
    		//if($type == 0) die();
    		if($result['rspCode'] == '0000') {
    			$balance = $result['data']['accountinfo'][0]['accountBalance'];
    		}
    	}
    	return $balance;
    }
    
}