<?php

/**
 * 信息
 *
 * @author cdlei
 */

require 'CommonController.php';

class InfoController extends CommonController
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
     * 关于我们
     * 
     * @return void
     */
    public function aboutAction()
    {
        $this->view->menuTitle = '关于我们';
        $textModel = new Application_Model_Text();
        $this->view->content = $textModel->content(2);
        $this->renderScript('info/info.php');
    }

    /**
     * 联系我们
     * 
     * @return void
     */
    public function contactAction()
    {
        $this->view->menuTitle = '联系我们 ';
        $textModel = new Application_Model_Text();
        $this->view->content = $textModel->content(1);
        $this->renderScript('info/info.php');
    }

    /**
     * 借贷规则
     * 
     * @return void
     */
    public function ruleAction()
    {
        $this->view->menuTitle = '借贷规则 ';
        $textModel = new Application_Model_Text();
        $this->view->content = $textModel->content(4);
        $this->renderScript('info/info.php');
    }

    /**
     * 网站资费
     * 
     * @return void
     */
    public function priceAction()
    {
        $this->view->menuTitle = '网站资费 ';
        $textModel = new Application_Model_Text();
        $this->view->content = $textModel->content(5);
        $this->renderScript('info/info.php');
    }

    /**
     * 法律政策
     * 
     * @return void
     */
    public function legalPolicyAction()
    {
        $this->view->menuTitle = '法律政策 ';
        $textModel = new Application_Model_Text();
        $this->view->content = $textModel->content(6);
        $this->renderScript('info/info.php');
    }

    /**
     * 合作伙伴
     * 
     * @return void
     */
    public function partnersAction()
    {
        $this->view->menuTitle = '合作伙伴 ';
        $textModel = new Application_Model_Text();
        $this->view->content = $textModel->content(8);
        $this->renderScript('info/info.php');
    }
    
    /**
     * 信息公告
     *
     * @return void
     */
    public function noticeAction()
    {
    	$this->view->menuTitle = '信息公告 ';
    	$textModel = new Application_Model_Text();
    	$this->view->content = $textModel->content(9);
    	$this->renderScript('info/info.php');
    }
    
    /**
     * 新手指引
     *
     * @return void
     */
    public function guideAction()
    {
    	$this->view->menuTitle = '新手指引 ';
    	$textModel = new Application_Model_Text();
    	$this->view->content = $textModel->content(10);
    	$this->renderScript('info/info.php');
    }

}