<?php
/**
 * 文本管理
 *
 * @author cdlei
 */

class Application_Model_Text extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'text';

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
     * 获取内容
     *
     * @param integer $id
     * @return string
     */
    public function content($id)
    {
        $row = $this->fetchRow("`id` = '{$id}'");
        if (!empty($row)) {
            return $row['content'];
        } else {
            return NULL;
        }
    }

    /**
     * 通过ID删除记录
     *
     * @param integer $id
     * @return void
     */
    public function deleteById($id)
    {
        $this->delete("`id` = '{$id}'");
    }

    /**
     * 通过ID删除记录
     *
     * @param array $ids
     * @return int
     */
    public function deleteByIds(array $ids)
    {
        if (empty($ids)) {
            return false;
        }
        return $this->delete("`id` IN (". implode(',', $ids)  .")");
    }
}