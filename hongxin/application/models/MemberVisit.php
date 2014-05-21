<?php

/**
 * 用户登录记录模型
 *
 * @author cdlei
 */

class Application_Model_MemberVisit extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'member_visit';

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
     * 添加登录记录
     * @param  array $row
     * 
     * @return integer
     */
    public function insert(array $row)
    {
        $time = time();
        $row['time'] = $time;
        $row['lastOnlineTime'] = $time;
        $row['ip'] = getClientIP();
        return parent::insert($row);
    }

    /**
     * 删除
     * @param  integer $id
     * 
     * @return integer
     */
    public function deleteById($id)
    {
        parent::delete("`id` = {$id}");
    }

    /**
     * 更新登录信息
     * @param  string $userName
     * @param  integer $visitId
     * 
     * @return void
     */
    public function updateOnlineTime($userName, $visitId)
    {
        $row = array();
        $row['lastOnlineTime'] = time();
        $this->update($row, "`userName` = '". addslashes($userName) ."' AND `id` = {$visitId}");
    }
}