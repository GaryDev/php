<?php

require 'CommonController.php';

class Member_OrderController extends Member_CommonController
{
	/**
	 * 初始化
	 *
	 * @return void
	 */
	public function init()
	{
		parent::init();
		$this->_model = new Application_Model_Order();
	}
	
	public function indexAction()
	{
		//获取当前页码
		$pageSize = 15;
		$pageNo = intval($this->_request->get('pageNo'));
		if (empty($pageNo)) {
			$pageNo = 1;
		}
		
		//设置URL模板以及条件
		$urls = array();
		$vars = array();
		
		$vars['status'] = trim($this->_request->get('status'));
		$urls = $vars;
		$urls['pageNo'] = '{page}';
		$urlTemplate = $this->view->projectUrl($urls);
		
		$borrowingModel = new Application_Model_Borrowing();
		$orderTypes = $this->_configs['project']['memberVars']['orderType'];
		
		$orderSelect = $this->_model->select(false)
			->setIntegrityCheck(false)
			->from(array('o'=>$this->_model->getTableName()), array('*'))
			->joinLeft(array('b'=>$borrowingModel->getTableName()), "`o`.`borrowCode` = `b`.`code`", array('title'))
			->where("`o`.`buyUser` = {$this->_model->getAdapter()->quote(Application_Model_MemberLogin::getLoginedUserName())}");
		if ($vars['status'] != '') {
			$orderSelect->where("`o`.`status` = {$vars['status']}");
		}
		$orderSelect->order('o.addTime DESC');
		
		//获取总页数以及记录
		$sql = $orderSelect->assemble();
		$dbPaginator = new Application_Model_DbPaginator($sql, $pageSize, $pageNo);
		$recordCount = $dbPaginator->getRecodCount();
		
		//获取分页html字符
		Zend_Loader::loadClass('Project_Paginator');
		$paginator = new Project_Paginator($recordCount, $pageSize, $pageNo);
		$paginator->urlTemplateContent = $urlTemplate;
		
		$this->view->orderStatus = $orderTypes;
		$this->view->vars = $vars;
		//分配view(分页处理后的记录集以及分页HTML字符)
		$this->view->pageString = $paginator->getPageString();
		$this->view->rows = $dbPaginator->getRows();
		$urls['pageNo'] = $pageNo;
		$this->view->pageUrl = $this->view->projectUrl($urls);
		
	}
}