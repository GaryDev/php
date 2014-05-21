<?php

/**
 * 验证码
 *
 * @author cdlei
 */

require 'CommonController.php';

class Admin_ImageCodeController extends Admin_CommonController
{
    /**
     * 初始化
     * 
     * @return void
     */
    public function init()
    {
        $this->_loginIsCheck = 0;
        parent::init();
    }

    /**
     * 默认动作
     * 
     * @return void
     */
    public function indexAction()
    {
        Zend_Loader::loadClass('Project_ImageCode');
        header("Content-type: image/png");
        
        $fonts = array(0 => 'sustainableAmazon.ttf');
        
        $imageCode = new Project_ImageCode();
        $imageCode->setLength(4);
        $imageCode->setFontSize(10);
        $imageCode->setFontFilePath(APPLICATION_PATH . '/../library/Project/fonts/GOTHICBI.TTF');
        $imageCode->setWidth(70);
        $imageCode->setHeight(22);
        $imageCode->setFontSize(13);
        $code = $imageCode->paint();
        $_SESSION["{$this->_configs['project']['cookiePrefix']}_imageCode"] = $code;
        exit;
    }
}