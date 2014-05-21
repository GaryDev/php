<?php

/**
 * 通用控制器
 *
 * @author cdlei
 */

class Common_CommonController extends Zend_Controller_Action
{
    /**
     * 模型
     *
     * @var object
     */
    protected $_model;

    /**
     * 系统模型对象
     *
     * @var object
     */
    protected $_cookieModel;

    /**
     * 当前用户记录
     *
     * @var array
     */
    protected $_configs = NULL;

    /**
     * 初始化
     * 
     * @return void
     */
    public function init()
    {
        header("content-type:text/html; charset=utf-8");
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');   
        $viewRenderer->setView($this->view)->setViewSuffix('php');

        $this->_configModel = new Application_Model_Config();
        $this->_configs = $this->_configModel->getConfigs();

        $this->view->baseUrl = $this->_configs['project']['baseUrl'];
        $this->view->master = $this->_configs['project']['admin']['master'];
        $this->view->systemName = $this->_configs['project']['systemName'];
        $this->view->module = $this->_request->getModuleName();
        $this->view->controller = $this->_request->getControllerName();
        $this->view->action = $this->_request->getActionName();

        $this->_cookieModel = new Application_Model_Cookie();
    }
}