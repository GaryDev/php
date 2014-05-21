<?php

/**
 * 分页模型
 *
 * @author cdlei
 */

class Application_Model_DbPaginator extends Application_Model_Common
{
    /**
     * 查询的sql
     *
     * @var string
     */
    protected $_sql = '';

    /**
     * 总数
     *
     * @var integer
     */
    protected $_recordCount;

    /**
     * 每页条数
     *
     * @var integer
     */
    protected $_pageSize;

    /**
     * 总页数
     *
     * @var integer
     */
    protected $_pageCount;

    /**
     * 当前页数
     *
     * @var integer
     */
    protected $_currentPage;

    /**
     * 构造函数
     * 
     * @param  string $sql
     * @param  integer $pageSize
     * @param  integer $currentPage
     * @param  1/2 $countType
     * @return void
     */
    public function __construct($sql, $pageSize = null, $currentPage = 0, $countType = 1)
    {
        parent::__construct();
        $sql = preg_replace("|^SELECT ([\s\S]+) LIMIT ([\d],)[ ]*$|i", "SELECT $1", $sql);
        if ($countType == 1) {
            $numSql = preg_replace("|^SELECT [\s\S]+ FROM (.+?)|i", "SELECT COUNT(*) as c FROM $1", $sql);
        } else {
            $numSql = "SELECT COUNT(*) as c FROM ({$sql}) AS T";
        }
        $row = $this->_db->fetchRow($numSql);
        $this->_sql = $sql;
        $this->_recordCount = $row['c'];
        $this->_pageSize = $pageSize === null ? $this->_recordCount : $pageSize;
        $this->_currentPage = intval($currentPage);
        $this->_pageCount = ceil($this->_recordCount/$this->_pageSize);
        if ($currentPage > $this->_pageCount ) {
            $this->_currentPage = $this->_pageCount;
        }
        if ($currentPage < 1) {
            $this->_currentPage = 1;
        }
    }

    /**
     * 获取记录
     * 
     * @return void
     */
    public function getRows()
    {
        $selectSql = $this->getPageSql();
        $rows = $this->_db->fetchAll($selectSql);
        return $rows;
    }

    /**
     * 获取总记录数
     * 
     * @return integer
     */
    public function getRecodCount()
    {
        return $this->_recordCount;
    }

    /**
     * 获取总页数
     * 
     * @return integer
     */
    public function getPageCount()
    {
        return $this->_pageCount;
    }

    /**
     * 获取分页后的limit SQL
     * 
     * @return string
     */
    public function getPageSql()
    {
        $limitStart = ($this->_currentPage - 1) * $this->_pageSize;
        if ($limitStart < 0) {
            $limitStart = 0;
        }
        $limitNum = $this->_pageSize;
        if ($limitStart + $this->_pageSize > $this->_recordCount) {
            $limitNum = $this->_recordCount;
        }
        $selectSql = $this->_sql . " LIMIT  {$limitStart}, $limitNum";
        return $selectSql;
    }
}
