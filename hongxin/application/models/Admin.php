<?php

/**
 * 用户组模型
 *
 * @author cdlei
 */

class Application_Model_Admin extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'admin';

    /**
     * 构造函数
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 通过组ID删除用户
     * @param  integer $groupId
     * 
     * @return integer
     */
    public function deleteByGroup($groupId)
    {
        parent::delete("`groupId` = {$groupId}");
    }


    /**
     * 删除用户
     * @param  integer $id
     * 
     * @return integer
     */
    public function deleteById($id)
    {
        parent::delete("`id` = {$id}");
    }

    /**
     * 检查用户名和工号是否存在
     * @param  string $name
     * @param  integer $id
     * 
     * @return integer
     */
    public function isExists($name, $id = 0)
    {
        $where = $id == 0 ? " WHERE (`userName` = {$this->_db->quote($name)} OR `code` = {$this->_db->quote($name)}) " : " WHERE (`userName` = {$this->_db->quote($name)} OR `code` = {$this->_db->quote($name)}) AND `id` <> {$id}";
        $sql = "SELECT count(*) AS c FROM `{$this->getTableName()}` {$where}";
        $row = $this->_db->fetchRow($sql);
        $isExists = $row['c'] > 0 ? 1 : 0;
        return $isExists;  
    }

    /**
     * 检查工号是否存在
     * @param  string $code
     * @param  integer $id
     * 
     * @return integer
     */
    public function codeIsExists($code, $id = 0)
    {
        $where = $id == 0 ? " WHERE `code` = {$this->_db->quote($code)} " : " WHERE `code` = {$this->_db->quote($code)} AND `id` <> {$id}";
        $sql = "SELECT count(*) AS c FROM `{$this->getTableName()}` {$where}";
        $row = $this->_db->fetchRow($sql);
        $isExists = $row['c'] > 0 ? 1 : 0;
        return $isExists;  
    }

    /**
     * 获取指定组的记录数
     * @param  string $groupId
     * 
     * @return integer
     */
    public function getNumberByGroup($groupId)
    {
        $where = " WHERE `groupId` = {$groupId} " ;
        $sql = "SELECT count(*) AS c FROM `{$this->getTableName()}` {$where}";
        $row = $this->_db->fetchRow($sql);
        return $row['c'];  
    }

    /**
     * 用户名和密码是否正确
     * @param  string $userName
     * @param  string $password
     * 
     * @return integer
     */
    public function isRight($userName, $password)
    {
        $row = $this->_db->fetchRow("SELECT `password`, `status` FROM `{$this->getTableName()}` WHERE `userName` = " . $this->_db->quote($userName));

        if (isset($row['password'])) {
            if ($row['password'] == md5($password)) {
                if ($row['status'] == '2') {
                    $isRight = 2;
                } else {
                    $isRight = 1;
                }
            } else {
                $isRight = 0;
            }
        } else {
            $isRight = 0;
        }
        return $isRight;
    }
}