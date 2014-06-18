<?php

require 'CommonController.php';

class CessionController extends CommonController
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
	
	public function indexAction()
	{
		
	}
	
}