<?php

/**
 * 用户登录记录模型
 *
 * @author cdlei
 */

class Application_Model_AdminVisit extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'admin_visit';

    /**
     * 构造函数
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->effectiveOnlineTime = $this->_configs['project']['admin']['effectiveOnlineTime'];
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
     * 是否在线
     * @param  integer $lastTime
     * @param  integer $limitTime
     * 
     * @return integer
     */
    public function isOnline($lastTime)
    {
        $time = time();
        if ($lastTime + $this->effectiveOnlineTime < $time) {
            $isOnline = 0;
        } else {
            $isOnline = 1;
        }
        return $isOnline;
    }

    /**
     * 更新登录信息
     * @param  integer $userId
     * 
     * @return void
     */
    public function updateOnlineTime($userId)
    {
        $row = array();
        $row['lastOnlineTime'] = time();
        $this->update($row, "`id` = {$userId}");
    }
}