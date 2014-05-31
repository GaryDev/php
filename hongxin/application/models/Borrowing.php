<?php
/**
 * 借款记录
 *
 * @author cdlei
 */

class Application_Model_Borrowing extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'borrowing';

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
     * 获取网站的费用
     *
     * @param string $userName
     * @param float $amount
     * @param string $type
     * @param integer $month
     * @param string $repaymentType
     * @return float
     */
    public function getFee($userName, $amount, $type, $month, $repaymentType)
    {
        $fee = NULL;
        if ($type == 'credit') {
            $fee = $amount * $month * 0.005;
        } else if ($type == 'recommend') {
            if ($month >= 1 && $month <= 4) {
                $fee = $amount * 0.02;
            } else if ($month >= 5 && $month <= 8) {
                $fee = $amount * 0.04;
            } else {
                $fee = $amount * 0.06;
            }
        }
        return $fee;
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
     * 获取是否可以申请
     *
     * @param string userName
     * @return 1/0
     */
    public function getBorrowSeq()
    {
    	$sql = "SELECT COUNT(*) AS `c` FROM `{$this->getTableName()}` WHERE `status` = '3'";
    	$row = $this->getAdapter()->fetchRow($sql);
    	if ($row['c'] > 0) {
    		return $row['c'] + 1;
    	} else {
    		return 1;
    	}
    }
    
    /**
     * 获取是否可以申请
     *
     * @param string userName
     * @return 1/0
     */
    public function getPopstar()
    {
        $sql = "SELECT * FROM `{$this->getTableName()}` WHERE `popStar` = 'Y' AND `status` = '3'";
        $row = $this->getAdapter()->fetchRow($sql);

        $data = isset($row['id']) ? $row : array('id' => 0);
        return $data;
    }

    /**
     * 添加
     *
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        $result = parent::insert($data);
        $code = 100000 + $result;
        parent::update(array('code'=>$code), "`id` = {$result}");
        return $result;
    }
    
    public function changeAmountUnit($code, $unit)
    {
    	if (!$code) return false;
    	$data = array('amountUnit' => $unit);
    	$where = "`code` = {$this->getAdapter()->quote($code)}";
    	parent::update($data, $where);
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
            //$borrowingDetailModel = new Application_Model_BorrowingDetail();
            //$repaymentModel = new Application_Model_Repayment();
            //$repaymentDetailModel = new Application_Model_RepaymentDetail();
            $time = time();
            if (isset($data['status'])) {
                $this->getAdapter()->getConnection()->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
                $this->getAdapter()->query("start transaction;");

                $row = $this->fetchRow($where);
                if (empty($row)) {
                    return false;
                }
                
                if($data['status'] == 3) {
	                $seq = $this->getBorrowSeq();
	                $data['title'] = str_replace("%", str_pad($seq, 4, '0', STR_PAD_LEFT), $row['title']);
                }
                
                /*
                if ($data['status'] > $row['status']) {
                    //借款完成审核中修改为还款中
                    if ($data['status'] == 4 && $row['status'] == 3) {
                        $accountDetailsModel = new Application_Model_AccountDetails();
                       //把投资人的投资金额转到借款人账户
                        $borrowingDetailRows = $borrowingDetailModel->fetchAll("`borrowingCode` = '{$row['code']}'");
                        foreach($borrowingDetailRows as $borrowingDetailRow) {
                            //扣除投资金额（投资人）
                            $accountDetailsData = array();
                            $accountDetailsData['userName'] = $borrowingDetailRow['userName'];
                            $accountDetailsData['amount'] = $borrowingDetailRow['amount'] * (-1);
                            $accountDetailsData['addTime'] = $time;
                            $accountDetailsData['type'] = 'loan';
                            $accountDetailsData['notes'] = "扣除投资金额";
                            $accountDetailsModel->add($accountDetailsData, 2);
 
                            //充值投资金额（借款人）
                            $accountDetailsData = array();
                            $accountDetailsData['userName'] = $row['userName'];
                            $accountDetailsData['amount'] = $borrowingDetailRow['amount'];
                            $accountDetailsData['addTime'] = $time;
                            $accountDetailsData['type'] = 'borrow';
                            $accountDetailsData['notes'] = "打入用户“{$borrowingDetailRow['userName']}”借款，借款编号“{$row['code']}”";
                            $accountDetailsModel->add($accountDetailsData);
                        }
                        //扣除借款人的手续费
                        $accountDetailsData = array();
                        $accountDetailsData['userName'] = $row['userName'];
                        $accountDetailsData['amount'] = $row['fee'] * (-1);
                        $accountDetailsData['addTime'] = $time;
                        $accountDetailsData['type'] = 'borrow_fee';
                        $accountDetailsData['notes'] = "扣除借款手续费，借款编号“{$row['code']}”";
                        $accountDetailsModel->add($accountDetailsData);
                        //设置当前时间为开始时间
                        $data['startTime'] = time();

                        //生成还款款记录
                        for($i = 1; $i <= $row['deadline']; $i++) {
                            $bx = self::fetchBx($row['amount'], $row['monthInterestRate'], $row['deadline'], $i, $row['repaymentType']);
                            $x = self::fetchX($row['amount'], $row['monthInterestRate'], $row['deadline'], $i, $row['repaymentType']);
                            $b = $bx - $x;
                            $repaymentField = array();
                            $repaymentField['borrowingCode'] = $row['code'];
                            $repaymentField['numberOfCycles'] = $i;
                            $repaymentField['principal'] = $b;//本金
                            $repaymentField['interest'] = $x;//利息
                            $repaymentField['currentCyclesRepaymentDeadline'] = strtotime(date('Y-m-d', $time)) + $i * 30 * 3600 *24;//当前还款截止时间
                            $repaymentField['status'] = '1';
                            $repaymentField['repaymentTime'] = 0;
                            $repaymentField['addTime'] = $time;
                            $repaymentModel->insert($repaymentField);

                            foreach($borrowingDetailRows as $borrowingDetailRow) {
                                $repaymentDetailField = array();
                                $repaymentDetailField['borrowingCode'] = $row['code'];
                                $repaymentDetailField['userName'] = $borrowingDetailRow['userName'];
                                $repaymentDetailField['borrowingDetailId'] = $borrowingDetailRow['id'];
                                $repaymentDetailField['numberOfCycles'] = $i;
                                $repaymentDetailField['principal'] = $b * ($borrowingDetailRow['amount'] / $row['amount']);
                                $repaymentDetailField['interest'] = $x * ($borrowingDetailRow['amount'] / $row['amount']);
                                $repaymentDetailModel->insert($repaymentDetailField);
                            }
                        }
                    }
                }*/
            }
            $result = parent::update($data, $where);
            $this->getAdapter()->query("commit;");
        } catch (Exception $e) {
            $this->getAdapter()->query("rollback;");
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 按类型获取指定某月的利息
     * $a = 借款金额
     * $i = 月利率
     * $N = 总月数
     * $n = 当前月数
     * $repaymentType = 类型
     *
     * @param integer $a
     * @param integer $i
     * @param integer $N
     * @param integer $n
     * @param integer $repaymentType
     * @return float
     */
    public static function fetchX($a, $i, $N, $n, $repaymentType)
    {
        if ($repaymentType == '1') {
            $bx = self::debxFetchX($a, $i, $N, $n);
        } else if ($repaymentType == '2') {
            $bx = $a * $i;
        }
        return $bx;
    }

    /**
     * 按类型获取指定某月的本金和利息
     * $a = 借款金额
     * $i = 月利率
     * $N = 总月数
     * $n = 当前月数
     * $repaymentType = 类型
     *
     * @param integer $a
     * @param integer $i
     * @param integer $N
     * @param integer $n
     * @param integer $repaymentType
     * @return float
     */
    public static function fetchBx($a, $i, $N, $n, $repaymentType)
    {
        if ($repaymentType == '1') {
            $bx = self::debxFetchBx($a, $i, $N);
        } else if ($repaymentType == '2') {
            $bx = $a / $N + ($a * $i);
        }
        return $bx;
    }

    /**
     * 按类型获取本息
     * $a = 借款金额
     * $i = 月利率
     * $N = 总月数
     * $repaymentType = 类型
     *
     * @param integer $a
     * @param integer $i
     * @param integer $N
     * @param integer $repaymentType
     * @return float
     */
    public static function fetchAllBx($a, $i, $N, $repaymentType)
    {
        if ($repaymentType == '1') {
            $allX = self::debxFetchAllBx($a, $i, $N);
        } else if ($repaymentType == '2') {
            $allX = $a + $a * $i * $N;
        }
        return $allX;
    }

    /**
     * 按类型获取利息
     * $a = 借款金额
     * $i = 月利率
     * $N = 总月数
     * $repaymentType = 类型
     *
     * @param integer $a
     * @param integer $i
     * @param integer $N
     * @param integer $repaymentType
     * @return float
     */
    public static function fetchAllX($a, $i, $N, $repaymentType)
    {
        if ($repaymentType == '1') {
            $allX = self::debxFetchAllX($a, $i, $N);
        } else if ($repaymentType == '2') {
            $allX = $a * $i * $N;
        }
        return $allX;
    }

    /**
     * 获取等额本息的利息
     * $a = 借款金额
     * $i = 月利率
     * $N = 总月数
     * $n = 当前月数
     *
     * @param integer $a
     * @param integer $i
     * @param integer $N
     * @param integer $n
     * @return float
     */
    public static function debxFetchAllX($a, $i, $N)
    {
        $allX = 0;
        for($moon = 1; $moon <= $N; $moon++) {
            $allX += self::debxFetchX($a, $i, $N, $moon);
        }
        return $allX;
    }

    /**
     * 获取等额本息的本息
     * $a = 借款金额
     * $i = 月利率
     * $N = 总月数
     * $n = 当前月数
     *
     * @param integer $a
     * @param integer $i
     * @param integer $N
     * @param integer $n
     * @return float
     */
    public static function debxFetchAllBx($a, $i, $N)
    {
        $allBx = 0;
        for($moon = 1; $moon <= $N; $moon++) {
            $allBx += self::debxFetchBx($a, $i, $N, $moon);
        }
        return $allBx;
    }

    /**
     * 获取等额本息的利息
     * $a = 借款金额
     * $i = 月利率
     * $N = 总月数
     * $n = 当前月数
     *
     * @param integer $a
     * @param integer $i
     * @param integer $N
     * @param integer $n
     * @return float
     */
    public static function debxFetchX($a, $i, $N, $n)
    {
        $x = self::debxFetchBx($a, $i, $N) - self::debxFetchB($a, $i, $N, $n);
        return $x;
    }

    /**
     * 获取等额本息的指定月数的本金
     * $a = 借款金额
     * $i = 月利率
     * $N = 总月数
     * $n = 当前月数
     * 
     * @param integer $a
     * @param integer $i
     * @param integer $N
     * @param integer $n
     * @return float
     */
    public static function debxFetchB($a, $i, $N, $n)
    {
        //每月应还的本金
        $b = $a * $i * pow(( 1 + $i ), $n - 1) / (pow(1 + $i, $N) - 1);
        return round($b, 2);
    }

    /**
     * 获取等额本息的本金和利息
     * $a = 借款金额
     * $i = 月利率
     * $N = 总月数
     *
     * @param integer $a
     * @param integer $i
     * @param integer $N
     * @return float
     */
    public static function debxFetchBx($a, $i, $N)
    {
        //每月应还的本息
        $bx = $a * $i * pow(( 1 + $i ), $N) / (pow(1 + $i, $N) - 1);
        return round($bx, 2);
    }

    /**
     * 获取等本等息的利息
     * $a = 借款金额
     * $i = 月利率
     *
     * @param integer $a
     * @param integer $i
     * @return float
     */
    public static function dbdxFetchInterest($a, $i)
    {
        $x = $a * $i;
        return round($x, 2);
    }

    /**
     * 借款者借入总金额
     * 
     * @param string userName
     * @return float
     */
    public function getBorrwingAmount($userName)
    {
        $borrowingModel = new Application_Model_Borrowing();
        $sql = "SELECT SUM(`amount`) AS a FROM `{$this->getTableName()}` WHERE `userName` = {$this->_db->quote($userName)}  AND `status` IN ('4', '5')";
        $row = $this->getAdapter()->fetchRow($sql);

        $data = isset($row['a']) ? $row['a'] : 0;
        return $data;
    }
}