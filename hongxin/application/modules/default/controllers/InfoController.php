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
     
    public function ruleAction()
    {
        $this->view->menuTitle = '借贷规则 ';
        $textModel = new Application_Model_Text();
        $this->view->content = $textModel->content(4);
        $this->renderScript('info/info.php');
    }*/

    /**
     * 网站资费
     * 
     * @return void
     
    public function priceAction()
    {
        $this->view->menuTitle = '网站资费 ';
        $textModel = new Application_Model_Text();
        $this->view->content = $textModel->content(5);
        $this->renderScript('info/info.php');
    }*/

    /**
     * 隐私政策
     * 
     * @return void
     */
    public function policyAction()
    {
        $this->view->menuTitle = '隐私政策 ';
        $textModel = new Application_Model_Text();
        $this->view->content = $textModel->content(4);
        $this->renderScript('info/info.php');
    }
    
    /**
     * 会员注册协议
     *
     * @return void
     */
    public function agreementAction()
    {
    	$this->view->menuTitle = '会员注册协议 ';
    	$textModel = new Application_Model_Text();
    	$this->view->content = $textModel->content(3);
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
        $this->view->content = $textModel->content(5);
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
    	$this->view->content = $textModel->content(6);
    	$this->renderScript('info/info.php');
    }
    
    /**
     * 安全保障
     *
     * @return void
     */
    public function safeAction()
    {
    	$this->view->menuTitle = '安全保障 ';
    	$textModel = new Application_Model_Text();
    	$this->view->content = $textModel->content(7);
    	$this->renderScript('info/info.php');
    }

}