<?php

require 'CommonController.php';

class GuideController extends CommonController
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
	
	public function indexAction()
	{
		$this->view->menuTitle = '新手指引 ';
	}
}