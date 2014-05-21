<?php

/**
 * 用户等级
 *
 * @author cdlei
 */

class Application_Model_MemberGrade extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'member_grade';

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
     * @param int $year
     * @param string $serviceCode
     * @return array
     */
    public function getIsCanApply($userName, $year, $serviceCode)
    {
        $accountDetailsModel = new Application_Model_AccountDetails();
        $serviceModel = new Application_Model_Service();
        $amount = $accountDetailsModel->getSurplusAvailableAmount($userName);
        $vipAmount = $year * $this->_configs['project']['vipPrice'];

        $result = array();
        if ($year < 1) {
            $result = array('status'=>2, 'message'=>'必须选择申请年限');
        } else if (!$serviceModel->codeIsExists($serviceCode)) {
            $result = array('status'=>4, 'message'=>'你输入的客服编号不存在');
        } else {
            $sql = "SELECT `status` FROM `{$this->getTableName()}` WHERE `userName` = {$this->_db->quote($userName)} AND `status` = '1'";
            $row = $this->getAdapter()->fetchRow($sql);
            if (!empty($row)) {
                $result = array('status'=>5, 'message'=>'你至少有一条申请处于待审核状态，暂时还不能提交新的申请');
            } else {
                $time = time();
                $sql = "SELECT `status` FROM `{$this->getTableName()}` WHERE `userName` = {$this->getAdapter()->quote($userName)} AND {$time} >= `startTime` AND {$time} <= `endTime` AND `status` <> '3'";
                $row = $this->getAdapter()->fetchRow($sql);
                if (!empty($row)) {
                    $result = array('status'=>6, 'message'=>'你的申请已经提交过了，请不要重复申请');
                } else {
                    $result = array('status'=>0, 'message'=>'可以申请');
                }
            }
        }
        return $result;  
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
            $accountDetailsModel->addLockAmount($data['userName'], $data['price'] * $data['year'], 'buy_vip', '冻结（VIP年费）');
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
                        //扣除VIP费用
                        $accountDetailsModel = new Application_Model_AccountDetails();
                        $accountDetailsData = array();
                        $accountDetailsData['userName'] = $row['userName'];
                        $accountDetailsData['amount'] = $row['price'] * $row['year'] * (-1);
                        $accountDetailsData['addTime'] = time();
                        $accountDetailsData['type'] = 'buy_vip';
                        $accountDetailsData['notes'] = "扣除VIP会员年费（{$row['year']}年）";
                        $accountDetailsModel->add($accountDetailsData, 2);
                    } else if ($data['status'] == 3 && $row['status'] == 1) {
                        //返还冻结金额到可用金额
                        $accountDetailsModel = new Application_Model_AccountDetails();
                        $accountDetailsModel->addLockAmount($row['userName'], $row['price'] * $row['year'] * (-1), 'buy_vip', '解除冻结（VIP年费）');
                    } else if ($data['status'] == 3 && $row['status'] == 2) {
                        //返还VIP费用到可用金额
                        $accountDetailsModel = new Application_Model_AccountDetails();
                        $accountDetailsData = array();
                        $accountDetailsData['userName'] = $row['userName'];
                        $accountDetailsData['amount'] = $row['price'] * $row['year'];
                        $accountDetailsData['addTime'] = time();
                        $accountDetailsData['type'] = 'buy_vip';
                        $accountDetailsData['notes'] = "退还已扣除的VIP会员年费（{$row['year']}年）";
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