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

        //分配view(分页处理后的记录集以及分页HTML字符)
        $this->view->pageString = $paginator->getPageString();
        $this->view->rows = $dbPaginator->getRows();
        $urls['pageNo'] = $pageNo;
        $this->view->pageUrl = $this->view->projectUrl($urls);
        $this->view->vars = $vars;
    }

    /**
     * 修改
     * 
     * @return void
     */
    public function updateAction()
    { 
        $id = intval($this->_request->get('id'));
        $backUrl = urldecode($this->_request->get('backUrl'));
        $borrowingDetailModel = new Application_Model_BorrowingDetail();
        $repaymentModel = new Application_Model_Repayment();
        $accountDetailsModel = new Application_Model_AccountDetails();

        $row = $this->_model->fetchRow("`id` = {$id}");
        if (empty($row)) {
            echo $this->view->message('记录不存在，请返回重试！', $backUrl) ;
            exit;
        }
        $row['statusLogRows'] = trim($row['statusLog']) != '' ? Zend_Json::decode($row['statusLog']) : array();
        $borrowingDetailRows = $borrowingDetailModel->fetchAll("`borrowingCode` = '{$row['code']}'", "id ASC");
        $repaymentRows = $repaymentModel->fetchAll("`borrowingCode` = '{$row['code']}'", "id ASC");

        //获取用户可用余额
        $surplusAvailableAmount = $accountDetailsModel->getSurplusAvailableAmount($row['userName']);
    
        //获取当最近一次应还款金额
        $currentRepaymentAmount = 0;
        foreach($repaymentRows as $repaymentRow) {
            if ($repaymentRow['status'] == '1') {
                $currentRepaymentAmount = $repaymentRow['principal'] + $repaymentRow['interest'];
                break;
            }
        }

        //获取总共未还金额
        $allNoRepaymentAmount = 0;
        foreach($repaymentRows as $repaymentRow) {
            if ($repaymentRow['status'] == '1') {
                $allNoRepaymentAmount += $repaymentRow['principal'] + $repaymentRow['interest'];
            }
        }

        $this->view->row = $row;
        $this->view->borrowingDetailRows = $borrowingDetailRows;
        $this->view->repaymentRows = $repaymentRows;
        $this->view->backUrl = $backUrl;
        $this->view->surplusAvailableAmount = $surplusAvailableAmount;
        $this->view->currentRepaymentAmount = $currentRepaymentAmount;
        $this->view->allNoRepaymentAmount = $allNoRepaymentAmount;

        if ($this->_request->isPost() && $this->_request->get('act') == 'updateStatus') {
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
                    ($row['status'] == 3 && $field['status'] == 4) ||
                    (in_array($row['status'], array('1', '2', '3')) && $field['status'] == 6)
                )
            ){
                $status = array('1'=>'已提交待审核', '2'=>'已审核借款中', '3'=>'借款完成审核中', '4'=>'还款中', '5'=>'还款完成', '6'=>'已经审核未通过(作废)');
                $log = trim($row['statusLog']) != '' ? Zend_Json::decode($row['statusLog']) : array();
                $log[] = array('previousStatus'=>$status[$row['status']], 'currentStatus'=>$status[$field['status']], 'user'=>$this->_currentUserRow['userName'], 'time'=>date('Y-m-d H:i:s'));
                $field['statusLog'] = Zend_Json::encode($log);

                $field['statusUpdateTime'] = time();
                $this->_model->update($field, "`id` = {$id}");
            }

            echo $this->view->message('操作成功！') ;
            exit;
        }

        if ($this->_request->isPost() && $this->_request->get('act') == 'repayment') {
            if ($row['status'] != '4') {
                echo $this->view->message('此标状态不在还款中。');
                exit;
            }
            $repaymentHowType = $this->_request->get('repaymentHowType');
            if ($repaymentHowType == '1') {//还完当前
                if ($currentRepaymentAmount > $surplusAvailableAmount) {
                    $from = 'site';
                } else {
                    $from = 'member';
                }
                $repaymentModel->repayment($row['userName'], $row['code'], $from, 0, $repaymentRows);
                echo $this->view->message('还款成功。');
                exit;
            } else if ($repaymentHowType == '2') {//还完所有
                if ($allNoRepaymentAmount > $surplusAvailableAmount && $surplusAvailableAmount > 0) {
                    echo $this->view->message('还款失败，用户的余额不足。');
                    exit;
                } 
                if ($allNoRepaymentAmount > $surplusAvailableAmount && $surplusAvailableAmount <= 0) {
                    $from = 'site';
                } else {
                    $from = 'member';
                }
                $repaymentModel->repayment($row['userName'], $row['code'], $from, 1, $repaymentRows);
                echo $this->view->message('你的所有借款已经还款完毕。');
                exit;
            }
        }
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
    	
    	
    	$this->view->row = $row;
    	$this->view->popRow = $popRow;
    	$this->view->borrowingUnitMin = $this->_configs['project']['borrowingUnitMin'];
    	$this->view->backUrl = $backUrl;
    
    	if ($this->_request->isPost() && $this->_request->get('act') == 'updateStatus') {
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
    			$status = array('1'=>'已提交待审核', '2'=>'初审已通过', '3'=>'终审已通过（融资中）', '4'=>'初审未通过', '5'=>'终审未通过');
    			$log = trim($row['statusLog']) != '' ? Zend_Json::decode($row['statusLog']) : array();
    			$log[] = array('previousStatus'=>$status[$row['status']], 'currentStatus'=>$status[$field['status']], 'user'=>$this->_currentUserRow['userName'], 'time'=>date('Y-m-d H:i:s'));
    			$field['statusLog'] = Zend_Json::encode($log);
    
    			$field['statusUpdateTime'] = time();
    			$this->_model->update($field, "`id` = {$id}");
    		}
    
    		echo $this->view->message('操作成功！') ;
    		exit;
    	}
    	
    	if ($this->_request->isPost() && $this->_request->get('act') == 'popstar') {
    		$field = array();
    		$filter = new Zend_Filter_StripTags();
    		$popstar = $filter->filter(trim($this->_request->getPost('popstar')));
    		$field['popStar'] = $popstar == '1' ? 'Y' : 'N';
    		$this->_model->update($field, "`id` = {$id}");
    		echo $this->view->message('操作成功！') ;
    		exit;
    	}
    }
}