<?php

/**
 * 通用控制器
 *
 * @author cdlei
 */

class Admin_CommonController extends Zend_Controller_Action
{
    /**
     * 模型
     *
     * @var object
     */
    protected $_model;

    /**
     * 是否需要检查登录
     *
     * @var integer
     */
    protected $_loginIsCheck = 1;

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
    protected $_currentUserRow;

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
        if ($this->_loginIsCheck == 1) {
            $state = $this->loginInit();
            if ($state == 1 || $state == 2) {//如果用户COOKIE无效或者没有此用户
                echo '<html><body><script language="javascript">window.open("' . $this->view->projectUrl(array('controller'=>'login', 'action'=>'index')) . '", "_top", "");</script></body></html>';
                exit; 
            } else if ($state == 3){//如果在其他地方登录
                //$backUrl = urlencode($this->view->url());
                echo '<html><body><script language="javascript">window.open("' . $this->view->projectUrl(array('controller'=>'login', 'action'=>'logout')) . '", "_top", "");</script></body></html>';
                exit;
            } else if ($state == 4){//如果没有访问权限
                exit("操作失败：权限不足，如有任何疑问请与管理员联系！");
            } else {
                //更新在线时间
                $adminVisitModel = new Application_Model_AdminVisit();
                $adminVisitModel->updateOnlineTime($this->_currentUserRow['visitId']);

                //更新登录COOKIE
                $expireTime = time() + $this->_configs['project']['admin']['loginTimeoutTime'];
                $this->_cookieModel->setCookie('currentUser', $this->_currentUserRow['userName'], $expireTime);
                $this->_cookieModel->setCookie('currentUserLastActiveTime', time(), $expireTime);
                $this->_cookieModel->setCookie('currentUserVisitId', $this->_currentUserRow['visitId'], $expireTime);
            }
        }
    }

    /**
     * 初始化登录信息
     * return 1：用户的COOKIE不存在或者不合法
     * return 2：用户不存在
     * return 3：此用户已在其他地方登录
     * return 4：此页面没有访问权限
     * return 0：成功
     * 
     * @return integer
     */
    public function loginInit()
    {
        //查找COOK是否存在
        $currentUser = $this->_cookieModel->getCookie('currentUser');
        $currentUserLastActiveTime = $this->_cookieModel->getCookie('currentUserLastActiveTime');
        $currentUserVisitId = $this->_cookieModel->getCookie('currentUserVisitId');
        if (empty($currentUser) || empty($currentUserLastActiveTime) || empty($currentUserVisitId)) {//如果没有找到用户的COOKIE信息
            return 1;
        }

        //检查用户是否存在
        $adminModel = new Application_Model_Admin();
        $adminGroupModel = new Application_Model_AdminGroup();
        $currentUserRow = $adminModel->getAdapter()->fetchRow("SELECT u.*, ug.`name` AS groupName, ug.`catalogs` FROM `{$adminModel->getTableName()}` AS u LEFT JOIN `{$adminGroupModel->getTableName()}` AS ug on u.groupId = ug.`id` WHERE u.`userName` = '{$currentUser}' AND `u`.`status` = '1'");
        if (empty($currentUserRow)) {//如果此用户信息为空
            return 2;
        }

        //检查用户是否在其他地方登录
        if ($currentUserVisitId != $currentUserRow['visitId']) {
            return 3;
        }

        //用类属性保存登录信息
        $this->_currentUserRow = $currentUserRow;
        $this->view->currentUserRow = $currentUserRow;

        //验证当前用户是否具有当前页面的访问权限
        $catalogModel = new Application_Model_Catalog();
        $module = str_replace('.', '-', $this->_request->getModuleName());
        $controller = str_replace('.', '-', $this->_request->getControllerName());
        $action = str_replace('.', '-', $this->_request->getActionName());
         
        $catalogRow = $catalogModel->getAccessControlRow($module, $controller, $action);
        if (empty($catalogRow)) {
            $accessIsAllow = 1;
        } else {
            $catalogIds = explode(',', $currentUserRow['catalogs']);
            if (in_array($catalogRow['id'], $catalogIds)) {
                 $accessIsAllow = 1;
            } else {
                $accessIsAllow = 0;
            }
        }
        if ($accessIsAllow == 0 && $this->_configs['project']['admin']['master'] != $currentUserRow['userName']) {
            return 4;
        }
        return 0;
    }
    
    protected function __uploadFile($fieldName, $type, $options=array())
    {
    	$defalut = array('path' => '', 'imgWidth' => 0, 'imgHeight' => 0, 'waterMark'=>0);
    	$options = array_merge($defalut, $options);
    
    	//上传设置
    	$uploadFileExtension = array('jpg', 'jpeg', 'png', 'gif');
    	$maxSize = 1024 * 1024 * 1;
    	$maxSize = $maxSize * 2;
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
    		if($options['imgWidth'] > 0 && $options['imgHeight'] > 0) {
    			imageResize($this->_configs['project'][$configBasePath] . $path, $options['imgWidth'], $options['imgHeight']);
    		}
    		if($options['waterMark'] == 1) {
    			$waterMarkFile = PUBLIC_PATH . '/files/publicFiles/images/logoWater.png';
    			imageWaterMark($this->_configs['project'][$configBasePath] . $path, $waterMarkFile, -20, 0);
    			//imageWaterMark($this->_configs['project'][$configBasePath] . $path, $waterMarkFile, 0, 50);
    			imageWaterMark($this->_configs['project'][$configBasePath] . $path, $waterMarkFile, -20, 150);
    		}
    	} else {
    		$path = $options['path'];
    	}
    	return $path;
    }
}