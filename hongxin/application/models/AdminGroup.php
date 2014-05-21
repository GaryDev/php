<?php

/**
 * 用户组模型
 *
 * @author cdlei
 */
class Application_Model_AdminGroup extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name = 'admin_group';

    /**
     * 构造函数
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->adminModel = new Application_Model_Admin();
    }

    /**
     * 删除用户组
     * @param  integer $id
     * 
     * @return integer
     */
    public function deleteById($id)
    {
        parent::delete("`id` = {$id}");
        $this->adminModel->deleteByGroup($id);
    }

    /**
     * 检查是否存在
     * @param  string $name
     * @param  integer $id
     * 
     * @return integer
     */
    public function isExists($name, $id = 0)
    {
        $where = $id == 0 ? " WHERE `name` = {$this->_db->quote($name)} " : " WHERE `name` = {$this->_db->quote($name)} AND `id` <> {$id}";
        $sql = "SELECT count(*) AS c FROM `{$this->getTableName()}` {$where}";
        $row = $this->_db->fetchRow($sql);
        $isExists = $row['c'] > 0 ? 1 : 0;
        return $isExists;  
    }
}