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
            $status = $memberLoginModel->getLoginStatus();
            if ($status != 0) {
            	$from = $this->_request->getActionName() == 'apply' ? 'borrowing' : 'member';
                redirect($this->view->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'login', 'from'=>$from)));
            }
            $memberVisitModel = new Application_Model_MemberVisit();
            $memberVisitModel->updateOnlineTime(Application_Model_MemberLogin::getLoginedUserName(), intval(Application_Model_MemberLogin::getLoginedUserVisitId()));
        }
    }
    
    protected function __uploadFile($fieldName, $type, $userRow, $options=array())
    {
    	$defalut = array('path' => '', 'imgWidth' => 80, 'imgHeight' => 80, 'waterMark'=>0);
    	$options = array_merge($defalut, $options);
    	 
    	//上传设置
    	$uploadFileExtension = array('jpg', 'jpeg', 'png', 'gif');
    	$maxSize = 1024 * 1024 * 1;
    	$configBasePath = $type . 'BasePath';
    	$files = $_FILES;
    	$path = '';
    	if (isset($files[$fieldName]) && $files[$fieldName]['error'] != 4) {
    		if ($files[$fieldName]['error'] == 6) {
    			echo $this->view->message('上传临时文件夹错误，请与管理员联系！') ;
    			exit;
    		} else if ($files[$fieldName]['error'] == 7) {
    			echo $this->view->message('上传不可写，请与管理员联系！') ;
    			exit;
    		} else if ($files[$fieldName]['error'] != 0 && $files[$fieldName]['error'] != 4) {
    			echo $this->view->message('其他上传错误！') ;
    			exit;
    		}
    		if ($files[$fieldName]['size'] > $maxSize) {
    			echo $this->view->message("上传的文件必须小于" . sizeToString($maxSize) . "！") ;
    			exit;
    		}
    		 
    		//检查文件扩展名是否正确
    		$extension = strtolower(substr(strrchr($files[$fieldName]['name'], "."), 1));
    		if (!in_array($extension, $uploadFileExtension)) {
    			echo $this->view->message("上传文件只允许" . implode(',', $uploadFileExtension) . "格式的文件！") ;
    			exit;
    		}
    		 
    		if (!empty($options['path'])) {
    			unlink($this->_configs['project'][$configBasePath] . $options['path']);
    		}
    		 
    		//记录入库
    		$row = array();
    		$folder = date('Y-m-d');
    		$dir = $this->_configs['project'][$configBasePath] . '/' . $folder;
    		$path = '/' . $folder . '/' . date('YmdHis') . rand(1000, 9999) . '.' . $extension;
    		 
    		//保存文件
    		createDirectory($dir);//创建临时文件夹
    		move_uploaded_file($files[$fieldName]['tmp_name'], $this->_configs['project'][$configBasePath] . $path);
    		imageResize($this->_configs['project'][$configBasePath] . $path, $options['imgWidth'], $options['imgHeight']);
    		
    		if($options['waterMark'] == 1) {
	    		$waterMarkFile = PUBLIC_PATH . '/files/publicFiles/images/logoWater.png';
	    		imageWaterMark($this->_configs['project'][$configBasePath] . $path, $waterMarkFile, -20, 0);
	    		imageWaterMark($this->_configs['project'][$configBasePath] . $path, $waterMarkFile, 0, 50);
	    		imageWaterMark($this->_configs['project'][$configBasePath] . $path, $waterMarkFile, -20, 150);
    		}
    	}
    	return $path;
    }
}