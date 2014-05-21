<?php

/**
 * 客服
 *
 * @author cdlei
 */

class Application_Model_Service extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'service';

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
     * 删除用户
     * @param  integer $id
     * 
     * @return integer
     */
    public function deleteById($id)
    {
        $row = $this->fetchRow("`id` = {$id}");
        if (!empty($row)) {
            $avatarPath = $this->_configs['project']['serviceAvatarBasePath'] . $row['avatarPath'];
            if (is_file($avatarPath)) {
                unlink($avatarPath);
            }
            $this->delete("`id` = '{$id}'");
        }
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
}