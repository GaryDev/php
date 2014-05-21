<?php

/**
 * 登录控制器
 *
 * @author cdlei
 */

require 'CommonController.php';

class Admin_LoginController extends Admin_CommonController
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
        $this->view->title = "管理中心 - 请登录";
    }

    /**
     * 默认动作
     * 
     * @return void
     */
    public function indexAction()
    {
        $state = $this->loginInit();
        if (!($state == 1 || $state == 2)) {//如果不是无效COOKIE或者用户不存在
            redirect($this->view->projectUrl(array('controller' => 'index')));
            exit;
        }

        $backUrl = $this->_request->get('backUrl');
        $this->view->backUrl = $backUrl;

        if ($this->_request->isPost()) {
            $userName = trim($this->_request->getPost('userName'));
            $password = trim($this->_request->getPost('password'));
            $code = trim($this->_request->getPost('code'));
            if (!isset($_SESSION["{$this->_configs['project']['cookiePrefix']}_imageCode"])) {
                exit($this->view->message('验证码初始化错误，请返回重新填写！'));
            } else if ($code == '') {
                exit($this->view->message('请输入验证码！'));
            }else if ((strtoupper($code) !== $_SESSION["{$this->_configs['project']['cookiePrefix']}_imageCode"])) {
                $_SESSION["{$this->_configs['project']['cookiePrefix']}"] = '';
                echo $this->view->message('验证码错误，请返回重新填写！') ;
                exit;
            } else if (empty($userName) || empty($password)){
                echo $this->view->message('用户名和密码不能为空，请返回填写！') ;
                exit;
            } else {
                $adminModel = new Application_Model_Admin();
                $loginStatus = $adminModel->isRight($userName, $password);
                if ($loginStatus == 1) {
                    //初始化部分参数
                    $expireTime = time() + $this->_configs['project']['admin']['loginTimeoutTime'];
                    
                    //添加一个登录访问记录
                    $adminVisitModel = new Application_Model_AdminVisit();
                    $visitId = $adminVisitModel->insert(array('userName'=>$userName));

                    //更新当前登录的访问ID
                    $adminModel->update(array('visitId' => $visitId), "`userName` = '{$userName}'");

                    //设置登录的COOKIE
                    $this->_cookieModel->setCookie('currentUser', $userName, $expireTime);
                    $this->_cookieModel->setCookie('currentUserLastActiveTime', time(), $expireTime);
                    $this->_cookieModel->setCookie('currentUserVisitId', $visitId, $expireTime);

                    //跳转
                    if (!empty($backUrl)) {
                        $gotoUrl = urldecode($backUrl);
                    } else {
                        $gotoUrl = $this->view->projectUrl(array('controller' => 'index'));
                    }
                    redirect($gotoUrl);
                } else if ($loginStatus == 2){
                    $_SESSION["{$this->_configs['project']['cookiePrefix']}"] = '';
                    echo $this->view->message('账户被关闭！') ;
                    exit;   
                } else {
                    $_SESSION["{$this->_configs['project']['cookiePrefix']}"] = '';
                    echo $this->view->message('用户名或密码错误，请返回重新填写！') ;
                    exit;   
                }
            }
        }
    }

    /**
     * 更新在线信息，但不更新用户的COOKIE
     * 
     * @return void
     */
    public function updateOnLineAction()
    {
        $backData = array();
        $state = $this->loginInit();
        $backData['state'] = $state;
        $backData['effectiveTime'] = 0;

        if ($state == 0) {//如果用户COOKIE无效或者没有此用户
            //更新在线时间
            $adminVisitModel = new Application_Model_AdminVisit();
            $adminVisitModel->updateOnlineTime($this->_currentUserRow['visitId']);
            
            $backData['effectiveTime'] = $this->_cookieModel->getCookie('currentUserLastActiveTime') + $this->_configs['project']['admin']['loginTimeoutTime'] - time();
        }
        $this->_helper->getHelper('Json')->sendJson($backData);
    }

    /**
     * 退出动作
     * 
     * @return void
     */
    public function logoutAction()
    {
        $this->_cookieModel->setCookie('currentUser', '', time()-1);
        redirect($this->view->projectUrl(array('action' => 'index')));
    }
}