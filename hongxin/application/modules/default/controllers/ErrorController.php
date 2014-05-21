<?php
/**
 * Error controller
 *
 * @uses       Zend_Controller_Action
 * @package    QuickStart
 * @subpackage Controller
 * @author dalei.chen
 */

class ErrorController  extends Zend_Controller_Action
{
    /**
     * error
     *
     * @return void
     */
    public function errorAction()
    {
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');   
        $viewRenderer->setView($this->view)->setViewSuffix('php');

        $errors = $this->_getParam('error_handler');

        switch ($errors->type) { 
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = '很抱歉，此页面没有找到，请<a href="javascript:location.href = location.href;">刷新</a>重试或返回<a href="' . $this->view->projectUrl(array('module'=>'default', 'controller'=>'index', 'action'=>'index')) . '" target="_parent">首页</a>。';
                break;

            default:
                // application error 
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = '很抱歉，程序出现一个错误，请<a href="javascript:location.href = location.href;">刷新</a>重试或返回<a href="' . $this->view->projectUrl(array('module'=>'default', 'controller'=>'index', 'action'=>'index')) . '" target="_parent">首页</a>。';
                //$this->view->message = 'Application error';
                break;
        }

        if ($this->_getParam('test')) {
            $this->view->message = $errors->exception;
        }

        $this->view->exception = $errors->exception;
        $this->view->request   = $errors->request;
    }
}