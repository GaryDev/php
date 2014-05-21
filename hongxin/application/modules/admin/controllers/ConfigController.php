<?php

/**
 * 配置控制器
 *
 * @author cdlei
 */

require 'CommonController.php';

class Admin_ConfigController extends Admin_CommonController
{
    /**
     * 初始化
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_Config();
    }

    /**
     * 默认动作
     * 
     * @return void
     */
    public function indexAction()
    {
        $this->view->dataModels = $this->_model->getAllCanWriteConfigModels();
        $this->view->data = $this->_model->getCanWriteConfigs();
        if ($this->_request->isPost()) {
            $row = array();
            $filter = new Zend_Filter_StripTags();
            foreach($this->view->dataModels as $name => $model) {
                if ($model['dataType'] == 'number') {
                    $row[$name] = is_numeric($this->_request->getPost($name)) ? $this->_request->getPost($name) : intval($this->_request->getPost($name));
                } else {
                    if ($model['inputType'] == 'editor') {
                        $row[$name] = trim($this->_request->getPost($name));
                    } else if ($model['inputType'] == 'checkbox') {
                        $row[$name] = $this->_request->getPost($name);
                        if (is_array($row[$name])) {
                            $row[$name] = addslashes(implode(',', $row[$name]));
                        }
                    } else {
                        $row[$name] = $filter->filter(trim($this->_request->getPost($name)));
                    }
                }
            }
            $this->_model->updateCanWriteConfigs($row);
            echo $this->view->message('操作成功！', $this->view->projectUrl()) ;
            exit;
        }
    }

    /**
     * 默认动作
     * 
     * @return void
     */
    public function phpinfoAction()
    {
        
    }
}