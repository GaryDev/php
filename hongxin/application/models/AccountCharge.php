<?php
/**
 * 会员充值
 *
 * @author cdlei
 */

class Application_Model_AccountCharge extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'account_charge';

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
     * 检查是否能通过审核
     * 
     * @param string $userName
     * @param int $startTime
     * @param int $endTime
     * @return 1/0
     */
    public function getExistsByTime($userName, $startTime, $endTime)
    {
        $sql = "SELECT COUNT(*) AS c FROM `{$this->getTableName()}` WHERE `userName` = {$this->getAdapter()->quote($userName)} AND NOT ({$startTime} >= `endTime` OR {$endTime} <= `startTime`) AND `status` <> '3'";
        $row = $this->getAdapter()->fetchRow($sql);
        $isExists = $row['c'] > 0 ? 1 : 0;
        return $isExists;  
    }

    /**
     * 提交
     * 
     * @param array $data
     * @return mixed
     */
    public function insert(array $data)
    {
        try{
            $this->getAdapter()->getConnection()->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $this->getAdapter()->query("start transaction;");

            if ($data['status'] == 2) {
                $accountDetailsModel = new Application_Model_AccountDetails();
                $accountDetailsData = array();
                $accountDetailsData['userName'] = $data['userName'];
                $accountDetailsData['amount'] = $data['amount'];
                $accountDetailsData['addTime'] = time();
                $accountDetailsData['type'] = 'account_charge';
                $accountDetailsData['notes'] = "充值";
                $accountDetailsModel->add($accountDetailsData);
            }
            $result = parent::insert($data);
            $this->getAdapter()->query("commit;");
        } catch (Exception $e) {
            $this->getAdapter()->query("rollback;");
            throw new Exception($e->getMessage());
        }
        return $result;
    }

    /**
     * 更改状态
     * 
     * @param array $data
     * @param array|string $where
     * @return mixed
     */
    public function update(array $data, $where)
    {
        try{
            $this->getAdapter()->getConnection()->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $this->getAdapter()->query("start transaction;");

            if (isset($data['status'])) {
                $row = $this->fetchRow($where);
                if (empty($row)) {
                    return false;
                }
                if ($data['status'] > $row['status']) {
                    if ($data['status'] == 2 && $row['status'] == 1) {
                        $accountDetailsModel = new Application_Model_AccountDetails();
                        $accountDetailsData = array();
                        $accountDetailsData['userName'] = $row['userName'];
                        $accountDetailsData['amount'] = $row['amount'];
                        $accountDetailsData['addTime'] = time();
                        $accountDetailsData['type'] = 'account_charge';
                        $accountDetailsData['notes'] = "充值";
                        $accountDetailsModel->add($accountDetailsData);
                    } else if ($data['status'] == 3 && $row['status'] == 2) {
                        $accountDetailsModel = new Application_Model_AccountDetails();
                        $accountDetailsData = array();
                        $accountDetailsData['userName'] = $row['userName'];
                        $accountDetailsData['amount'] = $row['amount'] * (-1);
                        $accountDetailsData['addTime'] = time();
                        $accountDetailsData['type'] = 'account_charge';
                        $accountDetailsData['notes'] = "充值作废，扣除金额";
                        $accountDetailsModel->add($accountDetailsData);
                    }
                }
            }
            $result = parent::update($data, $where);
            $this->getAdapter()->query("commit;");
        } catch (Exception $e) {
            $this->getAdapter()->query("rollback;");
            throw new Exception($e->getMessage());
        }
        return $result;
    }
}