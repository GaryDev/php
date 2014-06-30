<?php

/**
 * 借款记录
 *
 * @author cdlei
 */

require_once 'CommonController.php';

class Admin_BorrowingController extends Admin_CommonController
{
    /**
     * 初始化函数
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_Borrowing();
        $this->view->title = "管理中心";
    }

    /**
     * 默认动作
     * 
     * @return void
     */
    public function indexAction()
    {   
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

        $vars['userName'] = trim($this->_request->get('userName'));
        $vars['code'] = trim($this->_request->get('code'));
        $vars['title'] = trim($this->_request->get('title'));
        $vars['status'] = intval($this->_request->get('status'));
        if ($vars['userName'] != '') {
            $wheres[] = "`userName` = '" . addslashes($vars['userName']) . "'";
        }
        if ($vars['code'] != '') {
            $wheres[] = "`code` = '" . addslashes($vars['code']) . "'";
        }
        if ($vars['title'] != '') {
            $wheres[] = "`title` LIKE '%" . addslashes($vars['title']) . "%'";
        }
        if ($vars['status']) {
            $wheres[] = "`status` = '{$vars['status']}'";
        }

        //设置URL模板
        $urls = $vars;
        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT * FROM `{$this->_model->getTableName()}` {$where} ORDER BY `id` desc";
        $dbPaginator = new Application_Model_DbPaginator($sql, $pageSize, $pageNo);
        $recordCount = $dbPaginator->getRecodCount();

        //获取分页html字符
        Zend_Loader::loadClass('Project_Paginator');
        $paginator = new Project_Paginator($recordCount, $pageSize, $pageNo);
        $paginator->urlTemplateContent = $urlTemplate;
        $rows = $dbPaginator->getRows();

        $borrowStatus = $this->_configs['project']['memberVars']['borrowStatus'];
        foreach($rows as $key=>$row) {
        	$row['pictureUrl'] = !empty($row['ticketCopyPath']) ? $this->_configs['project']['ticketCopyBaseUrl'] . $row['ticketCopyPath'] . '?' . rand(100, 999) : NULL;
        	$row['borrowStatus'] = $borrowStatus[$row['currentStatus']];
        	$row['amount'] = number_format($row['amount']);
        	$rows[$key] = $row;
        }
        
        //分配view(分页处理后的记录集以及分页HTML字符)
        $this->view->pageString = $paginator->getPageString();
        $this->view->rows = $rows;
        $urls['pageNo'] = $pageNo;
        $this->view->pageUrl = $this->view->projectUrl($urls);
        $this->view->vars = $vars;
    }
    
    
    /**
     * 修改
     *
     * @return void
     */
    public function approveAction()
    {
    	$id = intval($this->_request->get('id'));
    	$backUrl = urldecode($this->_request->get('backUrl'));
    
    	$row = $this->_model->fetchRow("`id` = {$id}");
    	if (empty($row)) {
    		echo $this->view->message('记录不存在，请返回重试！', $backUrl) ;
    		exit;
    	}
    	$row['statusLogRows'] = trim($row['statusLog']) != '' ? Zend_Json::decode($row['statusLog']) : array();
    
    	$popRow = $this->_model->getPopstar();
    	
    	$enterpriseModel = new Application_Model_MemberEnterprise();
    	$enterpriseRow = $enterpriseModel->fetchRow("`userName` = {$row['userName']}");
    	$row['enterpriseName'] = $enterpriseRow['name'];
    	
    	$row['pictureUrl'] = !empty($row['ticketCopyPath']) ? $this->_configs['project']['ticketCopyBaseUrl'] . $row['ticketCopyPath'] . '?' . rand(100, 999) : NULL;
    	
    	$borrowStatus = $this->_configs['project']['memberVars']['borrowStatus'];
    	$row['borrowStatus'] = $borrowStatus[$row['currentStatus']];
    	$row['amount'] = number_format($row['amount']);
    	$this->view->row = $row;
    	$this->view->popRow = $popRow;
    	$this->view->borrowingUnitMin = $this->_configs['project']['borrowingUnitMin'];
    	$this->view->backUrl = $backUrl;
    	
    	$act = $this->_request->get('act');
    	
    	if ($this->_request->isPost() && $act == 'changePic') {
    		$options = array('waterMark' => 1);
    		if (!empty($row['ticketCopyPath'])) {
    			$options['path'] = $row['ticketCopyPath'];
    		}
    		$field['ticketCopyPath'] = $this->__uploadFile('ticketCopy', 'ticketCopy', $options);
    		$this->_model->update($field, "`id` = {$id}");
    		echo $this->view->message('操作成功！');
    		exit;
    	}
    
    	if ($this->_request->isPost() && $act == 'updateStatus') {
    		$field = array();
    		$filter = new Zend_Filter_StripTags();
    		$field['status'] = $filter->filter(trim($this->_request->getPost('status')));
    		$field['statusMessage'] = $filter->filter(trim($this->_request->getPost('statusMessage')));
    		if ($field['status'] < $row['status']) {
    			echo $this->view->message('状态不能向前修改！') ;
    			exit;
    		} else if (($field['status'] != $row['status']) &&
    				(
    						($row['status'] == 1 && $field['status'] == 2) ||
    						($row['status'] == 2 && $field['status'] == 3) ||
    						(in_array($row['status'], array('1', '2')) && $field['status'] == 4) ||
    						(in_array($row['status'], array('2', '3')) && $field['status'] == 5)
    				)
    		){
    			$status = array('1'=>'已提交待审核', '2'=>'初审已通过', '3'=>'终审已通过', '4'=>'初审未通过', '5'=>'终审未通过');
    			$log = trim($row['statusLog']) != '' ? Zend_Json::decode($row['statusLog']) : array();
    			$log[] = array('previousStatus'=>$status[$row['status']], 'currentStatus'=>$status[$field['status']], 'user'=>$this->_currentUserRow['userName'], 'time'=>date('Y-m-d H:i:s'));
    			$field['statusLog'] = Zend_Json::encode($log);
    
    			if($field['status'] == 2) {
    				$field['currentStatus'] = 2;
    			} else if($field['status'] == 3) {
    				$field['currentStatus'] = 3;
    			} else if ($field['status'] == 4 || $field['status'] == 5) {
    				$field['currentStatus'] = 6;
    			}
    			$field['statusUpdateTime'] = time();
    			$this->_model->update($field, "`id` = {$id}");
    			if($field['status'] == 2) {
    				$this->_sendsms($row);
    			}
    		}
    
    		echo $this->view->message('操作成功！');
    		exit;
    	}
    	
    	if ($this->_request->isPost() && $act == 'complete') {
    		$orderModel = new Application_Model_Order();
    		$orderRow = $orderModel->fetchAll("`borrowCode` = '{$row['code']}' AND `ysbFreezeSeq` > 0");
    		if(!empty($orderRow)) {
    			foreach ($orderRow as $key=>$row) {
    				$toUserSeq = $this->_thawMoney($row);
    				if(!empty($toUserSeq)) {
    					$this->_model->update(array('status'=>21), "`id` = {$row['id']}");
    				}
    			}
    		}
    		$field = array();
    		$field['currentStatus'] = 4;
    		$field['amountUnit'] = 0;
    		$this->_model->update($field, "`id` = {$id}");
    		echo $this->view->message('操作成功！');
    		exit;
    	}
    	
    	if ($this->_request->isPost() && $act == 'repayment') {
    		$orderModel = new Application_Model_Order();
    		$orderRow = $orderModel->fetchAll("`borrowCode` = '{$row['code']}' AND `ysbFreezeSeq` > 0");
    		if(!empty($orderRow)) {
    			foreach ($orderRow as $key=>$row) {
    				$this->_model->update(array('status'=>22), "`id` = {$row['id']}");
    			}
    		}
    		$field = array();
    		$field['currentStatus'] = 5;
    		$this->_model->update($field, "`id` = {$id}");
    		echo $this->view->message('操作成功！');
    		exit;
    	}
    	
    	if ($this->_request->isPost() && $act == 'popstar') {
    		$field = array();
    		$filter = new Zend_Filter_StripTags();
    		$popstar = $filter->filter(trim($this->_request->getPost('popstar')));
    		$field['popStar'] = $popstar == '1' ? 'Y' : 'N';
    		$this->_model->update($field, "`id` = {$id}");
    		echo $this->view->message('操作成功！') ;
    		exit;
    	}
    }
    
    /**
     * 删除动作
     *
     * @return void
     */
    public function deleteAction()
    {
    	if ($this->_request->isPost()) {
    		$ids = $this->_request->getPost('selectId');
    		if (is_array($ids)) {
    			foreach($ids as $id) {
    				$this->_model->deleteById($id);
    			}
    		}
    	}
    	$backUrl = urldecode($this->_request->get('backUrl'));
    	//redirect($backUrl);
    	echo $this->view->message('删除成功！', $backUrl) ;
    	exit;
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
    
    private function _sendsms($row)
    {
    	$msg = '恭喜您，您的融资申请(编号：'. $row['code'] .')初审已通过，请携带相关资料原件到鉴丰进行终审，谢谢！';
    	$params = array(
    			'adminId'=> $this->_configs['project']['ysbVars']['smsId'],
    			'platform'=> $this->_configs['project']['ysbVars']['smsPlatform'],
    			'platformPwd'=> $this->_configs['project']['ysbVars']['smsPlatformPwd'],
    			'ssrc' => 0,
    			'mobiles' => $row['userName'],
    			'msg' => $msg,
    	);
    	//var_dump($params);die();
    	$client = new Zend_Http_Client();
    	$response = $client->setUri($this->_configs['project']['ysbVars']['url']['sms'])
    	->setMethod(Zend_Http_Client::POST)
    	->setParameterPost($params)
    	->request();
    	return $response->getBody();
    }
}