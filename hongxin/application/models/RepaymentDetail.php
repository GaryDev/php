<?php
/**
 * 还款明细记录（放贷人收益）
 *
 * @author cdlei
 */

class Application_Model_RepaymentDetail extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'repayment_detail';

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
     * 投资者待收本金和利息
     * 
     * @param string userName
     * @return array
     */
    public function getNoRepaymentAmounts($userName)
    {
        $repaymentModel = new Application_Model_Repayment();
        $sql = "SELECT SUM(`rd`.`principal`) AS p, SUM(`rd`.`interest`) AS i 
            FROM `{$this->getTableName()}` AS `rd`
            LEFT JOIN `{$repaymentModel->getTableName()}` AS r ON(rd.`borrowingCode` = r.`borrowingCode` AND rd.`numberOfCycles` = r.`numberOfCycles`)
            WHERE rd.`userName` = {$this->_db->quote($userName)} AND r.`status` = '1'";
        $row = $this->getAdapter()->fetchRow($sql);

        $data['principal'] = isset($row['p']) ? $row['p'] : 0;//本金
        $data['interest'] = isset($row['i']) ? $row['i'] : 0;//利息
        return $data;
    }

    /**
     * 投资者已收本金和利息
     * 
     * @param string userName
     * @return array
     */
    public function getRepaymentAmounts($userName)
    {
        $repaymentModel = new Application_Model_Repayment();
        $sql = "SELECT SUM(`rd`.`principal`) AS p, SUM(`rd`.`interest`) AS i 
            FROM `{$this->getTableName()}` AS `rd`
            LEFT JOIN `{$repaymentModel->getTableName()}` AS r ON(rd.`borrowingCode` = r.`borrowingCode` AND rd.`numberOfCycles` = r.`numberOfCycles`)
            WHERE rd.`userName` = {$this->_db->quote($userName)} AND r.`status` IN ('2', '3', '4')";
        $row = $this->getAdapter()->fetchRow($sql);

        $data['principal'] = isset($row['p']) ? $row['p'] : 0;//本金
        $data['interest'] = isset($row['i']) ? $row['i'] : 0;//利息
        return $data;
    }
}