<?php
/**
 * 通用控制器
 *
 * @author cdlei
 */

class CommonController extends Zend_Controller_Action
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
     * 初始化
     * 
     * @return void
     */
    public function init()
    {
        header("content-type:text/html; charset=utf-8");
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');   
        $viewRenderer->setView($this->view)->setViewSuffix('php');  

        //获取配置信息
        $this->_configModel = new Application_Model_Config();
        $this->_configs = $this->view->configs = $this->_configModel->getConfigs();

        //设置基本参数
        $this->view->baseUrl = $this->_configs['project']['baseUrl'];
        $this->view->master = $this->_configs['project']['admin']['master'];
        $this->view->systemName = $this->_configs['project']['systemName'];
        $this->view->module = $this->_request->getModuleName();
        $this->view->controller = $this->_request->getControllerName();
        $this->view->action = $this->_request->getActionName();
        
        //设置页面头部变量
        $this->view->title = $this->_configs['project']['siteTitle'];
        $this->view->keywords = $this->_configs['project']['siteKeywords'];
        $this->view->description = $this->_configs['project']['siteDescription'];
        $this->view->copyRight = $this->_configs['project']['copyRight'];

        //设置已登录的用户名
        $loginName = Application_Model_MemberLogin::getLoginedUserName();
        $loginModel = new Application_Model_MemberLogin();
        $loginRow = $loginModel->getLoginedRow();
        if(!empty($loginRow) && !empty($loginRow['name'])) {
        	$loginName = $loginRow['name'];
        }
        $this->view->loginedUserName = $loginName;

        //添加公共的视图文件路径
        $this->view->addScriptPath($this->_configs['resources']['view']['frontPublicScriptPath']);

        //获取系统共用模型
        $this->_cookieModel = new Application_Model_Cookie();
    }
}