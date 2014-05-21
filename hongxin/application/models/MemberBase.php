<?php
/**
 * 会员基本资料
 *
 * @author cdlei
 */

class Application_Model_MemberBase extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'member_base';

    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
}