<?php
/**
 * 放贷明细
 *
 * @author cdlei
 */

class Application_Model_BorrowingDetail extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'borrowing_detail';

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

            $accountDetailsModel = new Application_Model_AccountDetails();
            $accountDetailsModel->addLockAmount($data['userName'], $data['amount'], 'loan', '冻结（投资金额）');
            $result = parent::insert($data);

            //检查是否满标
            $borrowingModel = new Application_Model_Borrowing();
            $borrowingRow = $borrowingModel->fetchRow("`code` = " . $borrowingModel->getAdapter()->quote($data['borrowingCode']));
            $borrowedRow = $borrowingModel->_db->fetchRow("SELECT get_borrowed_amount(" . $borrowingModel->getAdapter()->quote($data['borrowingCode']) . ") AS `borrowedAmount`");
            if (!empty($borrowingRow) && !empty($borrowedRow)) {
                if ($borrowingRow['amount'] <= $borrowedRow['borrowedAmount']) {
                    $borrowingModel->update(array('status'=>'3'), "`code` = " . $borrowingModel->getAdapter()->quote($data['borrowingCode']));
                }
            }
            $this->getAdapter()->query("commit;");
        } catch (Exception $e) {
            $this->getAdapter()->query("rollback;");
            throw new Exception($e->getMessage());
        }
        return $result;
    }

    /**
     * 投资者借出总金额
     * 
     * @param string userName
     * @return float
     */
    public function getBorrwingDetailAmount($userName)
    {
        $borrowingModel = new Application_Model_Borrowing();
        $sql = "SELECT SUM(`amount`) AS a FROM `{$this->getTableName()}` WHERE `userName` = {$this->_db->quote($userName)}";
        $row = $this->getAdapter()->fetchRow($sql);

        $data = isset($row['a']) ? $row['a'] : 0;
        return $data;
    }
}