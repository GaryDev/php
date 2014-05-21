<?php
/**
 * 提现
 *
 * @author cdlei
 */

class Application_Model_AccountWithdrawals extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'account_withdrawals';

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
     * 获取是否可以申请
     * 
     * @param string userName
     * @return 1/0
     */
    public function getIsNoCheck($userName)
    {
        $sql = "SELECT COUNT(*) AS `c` FROM `{$this->getTableName()}` WHERE `userName` = {$this->_db->quote($userName)} AND `status` = '1'";
        $row = $this->getAdapter()->fetchRow($sql);
        if ($row['c'] > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * 提交申请
     * 
     * @param array $data
     * @return mixed
     */
    public function insert(array $data)
    {
        try{
            $this->getAdapter()->getConnection()->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $this->getAdapter()->query("start transaction;");

            $accountDetailsModel = new Application_Model_AccountDetails();
            $accountDetailsModel->addLockAmount($data['userName'], $data['amount'], 'account_withdrawals', '冻结（提现金额）');
            $accountDetailsModel->addLockAmount($data['userName'], $data['fee'], 'account_withdrawals_fee', '冻结（提现手续费）');
            $data['status'] = 1;
            $result = parent::insert($data);
            $this->getAdapter()->query("commit;");
        } catch (Exception $e) {
            $this->getAdapter()->query("rollback;");
            throw new Exception($e->getMessage());
        }
        return $result;
    }

    /**
     * 更改申请状态
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
                    if ($data['status'] == 2) {
                        $accountDetailsModel = new Application_Model_AccountDetails();

                        //扣除提现金额
                        $accountDetailsData = array();
                        $accountDetailsData['userName'] = $row['userName'];
                        $accountDetailsData['amount'] = $row['amount'] * (-1);
                        $accountDetailsData['addTime'] = time();
                        $accountDetailsData['type'] = 'account_withdrawals';
                        $accountDetailsData['notes'] = "扣除提现金额";
                        $accountDetailsModel->add($accountDetailsData, 2);

                        //扣除提现金额费用
                        $accountDetailsModel = new Application_Model_AccountDetails();
                        $accountDetailsData = array();
                        $accountDetailsData['userName'] = $row['userName'];
                        $accountDetailsData['amount'] = $row['fee']  * (-1);
                        $accountDetailsData['addTime'] = time();
                        $accountDetailsData['type'] = 'account_withdrawals_fee';
                        $accountDetailsData['notes'] = "扣除提现手续费";
                        $accountDetailsModel->add($accountDetailsData, 2);
                    } else if ($data['status'] == 3 && $row['status'] == 1) {
                        //返还冻结金额到可用金额
                        $accountDetailsModel = new Application_Model_AccountDetails();
                        $accountDetailsModel->addLockAmount($row['userName'], $row['amount'] * (-1), 'account_withdrawals', '解除冻结（提现金额）');
                        $accountDetailsModel->addLockAmount($row['userName'], $row['fee'] * (-1), 'account_withdrawals_fee', '解除冻结（提现手续费）');
                    } else if ($data['status'] == 3 && $row['status'] == 2) {
                        $accountDetailsModel = new Application_Model_AccountDetails();

                        //返还提现金额
                        $accountDetailsData = array();
                        $accountDetailsData['userName'] = $row['userName'];
                        $accountDetailsData['amount'] = $row['amount'];
                        $accountDetailsData['addTime'] = time();
                        $accountDetailsData['type'] = 'account_withdrawals';
                        $accountDetailsData['notes'] = "退还已扣除的提现金额";
                        $accountDetailsModel->add($accountDetailsData);

                        //返还提现手续费
                        $accountDetailsData = array();
                        $accountDetailsData['userName'] = $row['userName'];
                        $accountDetailsData['amount'] = $row['fee'];
                        $accountDetailsData['addTime'] = time();
                        $accountDetailsData['type'] = 'account_withdrawals_fee';
                        $accountDetailsData['notes'] = "退还已扣除的提现手续费";
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