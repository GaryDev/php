<?php
/**
 * 还贷记录
 *
 * @author cdlei
 */

class Application_Model_Repayment extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'repayment';

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
     * 还款（当前）
     * 返回还款期数
     * 
     * @param string $userName
     * @param string $code
     * @param member/site $from
     * @param 1/0 $isAll
     * @param array $repaymentRows
     * @return int
     */
    public function repayment($userName, $code, $from = 'member', $isAll = 0, $repaymentRows = array())
    {
        if (empty($repaymentRows)) {
            $repaymentRows = $this->fetchAll("`code` = {$this->getAdapter()->quote($code)}", "`id ASC");
        }
        if (!in_array($from, array('member', 'site'))) {
            return false;
        }

        $repaymentDetailModel = new Application_Model_repaymentDetail();
        $accountDetailsModel = new Application_Model_AccountDetails();
        $time = time();
        $paid = false;
        $paidNum = 0;
        $noPayNum = 0;
        try{
            foreach($repaymentRows as $repaymentRow) {
                if ($repaymentRow['status'] == '1' && (($paid == false && $isAll == 0) || $isAll == 1)) {
                    $this->getAdapter()->getConnection()->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
                    $this->getAdapter()->query("start transaction;");

                    //扣除还款人账户金额
                    $amount = $repaymentRow['principal'] + $repaymentRow['interest'];
                    $accountDetailsData = array();
                    $accountDetailsData['userName'] = $userName;
                    $accountDetailsData['amount'] = $amount * (-1);
                    $accountDetailsData['addTime'] = $time;
                    $accountDetailsData['type'] = $from == 'member' ? 'repayment' : 'repayment_site';
                    $accountDetailsData['notes'] = "编号为“{$code}”借款，第{$repaymentRow['numberOfCycles']}期还款" . ($from == 'site' ? '（网站垫付）' : '');
                    $accountDetailsModel->add($accountDetailsData);

                    //打入投资人的收益
                    $repaymentDetailRows = $repaymentDetailModel->fetchAll("`borrowingCode` = '{$code}' AND `numberOfCycles` = '{$repaymentRow['numberOfCycles']}'");
                    foreach($repaymentDetailRows as $repaymentDetailRow) {
                        $amount = $repaymentDetailRow['principal'] + $repaymentDetailRow['interest'];
                        $accountDetailsData = array();
                        $accountDetailsData['userName'] = $repaymentDetailRow['userName'];
                        $accountDetailsData['amount'] = $amount;
                        $accountDetailsData['addTime'] = $time;
                        $accountDetailsData['type'] = 'income';
                        $accountDetailsData['notes'] = "编号为“{$code}”借款，第{$repaymentDetailRow['numberOfCycles']}期还款" . ($from == 'site' ? '（网站垫付）' : '');
                        $accountDetailsModel->add($accountDetailsData);
                    }

                    //更改还款状态
                    //还款状态，$status，1：未还，2：正常还款，3：延期还款，4：网站垫付
                    if ($from == 'site'){
                        $status = 4;
                    } else if ($time > $repaymentRow['currentCyclesRepaymentDeadline']) {
                        $status = 3;
                    } else {
                        $status = 2;
                    }
                    parent::update(array('status'=>$status, 'repaymentTime'=>$time), "`id` = {$repaymentRow['id']}");
                    $paidNum++;
                    $paid = true;
                } else if ($repaymentRow['status'] == '1') {
                    $noPayNum++;
                }
            }

            //如果所有期已全部还完
            if ($noPayNum == 0) {
                $borrowingModel = new Application_Model_Borrowing();
                $borrowingModel->update(array('status'=>'5', 'statusUpdateTime'=>$time), "`code` = {$this->getAdapter()->quote($code)}");
            }
            $this->getAdapter()->query("commit;");
        } catch (Exception $e) {
            $this->getAdapter()->query("rollback;");
            throw new Exception($e->getMessage());
        }

        return $paidNum;
    }

    /**
     * 借款者未还本金和利息
     * 
     * @param string userName
     * @return array
     */
    public function getNoRepaymentAmounts($userName)
    {
        $borrowingModel = new Application_Model_Borrowing();
        $sql = "SELECT SUM(`r`.`principal`) AS p, SUM(`r`.`interest`) AS i 
            FROM `{$this->getTableName()}` AS `r`
            INNER JOIN `{$borrowingModel->getTableName()}` AS b ON(b.`code` = r.`borrowingCode`)
            WHERE b.`userName` = {$this->_db->quote($userName)} AND b.`status` = '4' AND `r`.`status` IN ('1')
         ";
        $row = $this->getAdapter()->fetchRow($sql);

        $data['principal'] = isset($row['p']) ? $row['p'] : 0;//本金
        $data['interest'] = isset($row['i']) ? $row['i'] : 0;//利息
        return $data;
    }

    /**
     * 借款者已还本金和利息
     * 
     * @param string userName
     * @return array
     */
    public function getRepaymentAmounts($userName)
    {
        $borrowingModel = new Application_Model_Borrowing();
        $sql = "SELECT SUM(`r`.`principal`) AS p, SUM(`r`.`interest`) AS i 
            FROM `{$this->getTableName()}` AS `r`
            INNER JOIN `{$borrowingModel->getTableName()}` AS b ON(b.`code` = r.`borrowingCode`)
            WHERE b.`userName` = {$this->_db->quote($userName)} AND b.`status` = '4' AND `r`.`status` IN ('2', '3', '4')
         ";
        $row = $this->getAdapter()->fetchRow($sql);

        $data['principal'] = isset($row['p']) ? $row['p'] : 0;//本金
        $data['interest'] = isset($row['i']) ? $row['i'] : 0;//利息
        return $data;
    }
}