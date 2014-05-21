<?php
/**
 * 账户明细
 *
 * @author cdlei
 */

class Application_Model_AccountDetails extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'account_details';

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
     * @return float
     */
    public function getSurplusAvailableAmount($userName)
    {
        $amountRow = $this->getAdapter()->fetchRow("SELECT get_current_member_amount({$this->getAdapter()->quote($userName)}) AS `data`;");
        return $amountRow['data'];
    }

    /**
     * 获取剩金额（可用和锁）
     *
     * @param string $userName
     * @return array
     */
    public function getSurplusAmounts($userName)
    {
        $amountRow = $this->getAdapter()->fetchRow("SELECT get_current_member_amount_json({$this->getAdapter()->quote($userName)}) AS `data`;");
        $amounts = Zend_Json::decode($amountRow['data']);
        return $amounts;
    }

    /**
     * 添加账户明细记录
     * type=1：从可用金额扣除，type=2：从冻结金额扣除
     * 
     * @param array $data
     * @param 1/2 $type
     * @return mixed
     */
    public function add(array $data, $type = 1)
    {
        $type == 1 ? 1 : 2;
        $row = $this->getAdapter()->fetchRow("SELECT `surplusAvailableAmount`, `surplusLockAmount` FROM `{$this->getTableName()}` WHERE `id` IN (SELECT MAX(`id`) FROM `{$this->getTableName()}` WHERE `userName` = '". addslashes($data['userName']) ."')");
        if (!empty($row)) {
            if ($type == 1) {
                $data['surplusAvailableAmount'] = $row['surplusAvailableAmount'] + $data['amount'];
                $data['surplusLockAmount'] = $row['surplusLockAmount'];
            } else {
                $data['surplusAvailableAmount'] = $row['surplusAvailableAmount'];
                $data['surplusLockAmount'] = $row['surplusLockAmount'] + $data['amount'];
            }
        } else {
            $data['surplusAvailableAmount'] = $data['amount'];
            $data['surplusLockAmount'] = 0;
        }
        return parent::insert($data);
    }

    /**
     * 添加冻结用户账户金额
     * 
     * @param string $userName
     * @param float $amount
     * @param string $type
     * @param string $notes
     * @return void
     */
    public function addLockAmount($userName, $amount, $type, $notes)
    {
        $row = $this->getAdapter()->fetchRow("SELECT * FROM `{$this->getTableName()}` WHERE `id` IN (SELECT MAX(`id`) FROM `{$this->getTableName()}` WHERE `userName` = '". addslashes($userName) ."')");

        if (isset($row['id'])) {
            $accountDetailsData = array();
            $accountDetailsData['userName'] = $userName;
            $accountDetailsData['amount'] = 0;
            $accountDetailsData['lockAmount'] = $amount;
            $accountDetailsData['surplusAvailableAmount'] = $row['surplusAvailableAmount'] - $amount;
            $accountDetailsData['surplusLockAmount'] = $row['surplusLockAmount'] + $amount;
            $accountDetailsData['addTime'] = time();
            $accountDetailsData['type'] = $type;
            $accountDetailsData['notes'] = $notes;
            parent::insert($accountDetailsData, "`id` = {$row['id']}");
        }
    }

    /**
     * 获取总金额
     *
     * @param string $userName
     * @param string $type
     * @return float
     */
    public function getTotalAmount($userName, $type)
    {
        $sql = "SELECT SUM(`amount`) AS d FROM `{$this->getTableName()}` WHERE `userName` = {$this->_db->quote($userName)} AND `type` = {$this->_db->quote($type)}";
        $row = $this->getAdapter()->fetchRow($sql);
        $amount = isset($row['d']) ? $row['d'] : 0;
        return $amount;
    }
}