<?php

/**
 * 通用模型
 *
 * @author cdlei
 */

class Application_Model_Common extends Zend_Db_Table
{
    /**
     * db对象
     *
     * @var object
     */
    protected $_db;

    /**
     * 表前缀
     *
     * @var string
     */
    protected $_dbTablePrefix;

    /**
     * 表名(用来继承覆盖)
     *
     * @var string
     */
    protected $_name;

    /**
     * 配置
     *
     * @var array
     */
    protected $_configs;

    /**
     * 配置模型对象
     *
     * @var object
     */
    protected $_configModel;

    /**
     * 构造函数
     * 
     * @return void
     */
    public function __construct() {
        $this->_configModel = new Application_Model_Config();
        $this->_configs = $this->_configModel->getConfigs();
        $this->_db = Zend_Registry::get('db');
        $this->_dbTablePrefix = $this->_configs['resources']['db']['prefix'];
        $this->_name = $this->_dbTablePrefix . $this->_name;
        parent::__construct();
    }

    /**
     * 获取表名
     * 
     * @return void
     */
    public function getTableName() {
        return $this->_name;
    }

    /**
     * 获取表前缀
     * 
     * @return void
     */
    public function getTablePrefix() {
        return $this->_dbTablePrefix;
    }

    /**
     * 重载获取所有，以数组返回
     * 
     * @return array
     */
    public function fetchAll($where = NULL, $order = NULL, $count = NULL, $offset = NULL) {
        $rowsSet = parent::fetchAll($where, $order, $count, $offset);
        $rows = $rowsSet->toArray();
        return $rows;
    }

    /**
     * 重载获取单一记录，以数组返回
     * 
     * @return array
     */
    public function fetchRow($where = NULL, $order = NULL) {
        $rowSet = parent::fetchRow($where, $order);
        $row = $rowSet != NULL ? $rowSet->toArray() : $rowSet;
        return $row;
    }
}