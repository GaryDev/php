<?php
/**
 * 通用控制器
 *
 * @author cdlei
 */

class Member_CommonController extends Zend_Controller_Action
{
    /**
     * 模型
     *
     * @var object
     */
    protected $_model;

    /**
     * 是否需要登录验证
     *
     * @var 1/0
     */
    protected $_isLoginCheck = 1;

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
        $this->view->loginedUserName = Application_Model_MemberLogin::getLoginedUserName();
        $this->view->loginedUserType = Application_Model_MemberLogin::getLoginedUserType();
        
        //添加公共的视图文件路径
        $this->view->addScriptPath($this->_configs['resources']['view']['frontPublicScriptPath']);

        //获取系统共用模型
        $this->_cookieModel = new Application_Model_Cookie();

        //是否登录验证
        $this->__loginCheck();

        //登录菜单
        $this->view->currentMenu = 'manage';
    }
    
    /**
     * 初始化
     * 
     * @return void
     */
    protected function __loginCheck()
    {
        if ($this->_isLoginCheck == 1) {
            $memberLoginModel = new Application_Model_MemberLogin();
            if ($memberLoginModel->getLoginStatus() != 0) {
                redirect($this->view->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'login')));
            }
            $memberVisitModel = new Application_Model_MemberVisit();
            $memberVisitModel->updateOnlineTime(Application_Model_MemberLogin::getLoginedUserName(), intval(Application_Model_MemberLogin::getLoginedUserVisitId()));
        }
    }
}