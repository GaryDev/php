<?php
/**
 * 借款额度变化明细
 *
 * @author cdlei
 */

class Application_Model_MemberBorrowingAvailableAmountDetails extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'member_borrowing_available_amount_details';

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
     * 获取剩余可用金额
     *
     * @param string $userName
     * @param string $type
     * @return float
     */
    public function getSurplusAmount($userName, $type)
    {
        $amountRow = $this->getAdapter()->fetchRow("SELECT get_current_member_borrowing_available_amount({$this->getAdapter()->quote($userName)}, {$this->getAdapter()->quote($type)}) AS `data`;");
        return $amountRow['data'];
    }

    /**
     * 添加借款明细记录
     * 
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        $row = $this->getAdapter()->fetchRow("SELECT `surplusAmount`, `status` FROM `{$this->getTableName()}` WHERE `id` IN (SELECT MAX(`id`) FROM `{$this->getTableName()}` WHERE `status` <> '3' AND`userName` = '". addslashes($data['userName']) ."' AND `type` = '". addslashes($data['type']) ."')");
        if (!empty($row)) {
            if ($row['status'] == 1) {
                throw new Zend_Exception('当前有一条申请未审核你不能添加。');
            }
            $data['surplusAmount'] = $row['surplusAmount'] + $data['amount'];
        } else {
            $data['surplusAmount'] = $data['amount'];
        }
        return parent::insert($data);
    }

    /**
     * 获取是否可以申请
     * 
     * @param string userName
     * @param string $type
     * @return 1/0
     */
    public function getIsNoCheck($userName, $type)
    {
        $sql = "SELECT COUNT(*) AS `c` FROM `{$this->getTableName()}` WHERE `userName` = {$this->_db->quote($userName)} AND `status` = '1' AND `type` = '{$type}'";
        $row = $this->getAdapter()->fetchRow($sql);
        if ($row['c'] > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}