<?php

class Application_Model_Order extends Application_Model_Common
{
	/**
	 * 表名
	 *
	 * @var string
	 */
	protected $_name= 'order';

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
	 * 添加
	 *
	 * @param array $data
	 * @return mixed
	 */
	public function add(array $data)
	{
		$data['orderSN'] = $this->_gen_order_sn();
		$result = parent::insert($data);
		return $result;
	}
	
	public function getOrderTotal($userName, $status, $type, $fetchType='count')
	{
		if($fetchType == 'sum') {
			$fetch = array('Sum(orderAmount) AS ta, Sum(benifit) AS tb');
		} else {
			$fetch = array('COUNT(*) AS c');
		}
		$borrowingModel = new Application_Model_Borrowing();
		$orderSelect = $this->select(false)
			->setIntegrityCheck(false)
			->from(array('o'=>$this->getTableName()), $fetch)
			->joinInner(array('b'=>$borrowingModel->getTableName()), "`o`.`borrowCode` = `b`.`code`")
			->where("`o`.`buyUser` = {$this->getAdapter()->quote($userName)}")
			->where("`o`.`status` = {$status}");
		if(!empty($type)) {
			$orderSelect->where("`b`.`type` = {$this->getAdapter()->quote($type)}");
		}
        $row = $this->getAdapter()->fetchRow($orderSelect);
        if($fetchType == 'sum') {
        	$return = array($row['ta'], $row['tb']);
        } else {
        	$return = $row['c'];
        }
        return $return;
	}
	
	public function getOrderMemberInfo($orderSn) {
		$memberModel = new Application_Model_Member();
		$orderSelect = $this->select(false)
			->setIntegrityCheck(false)
			->from(array('o'=>$this->getTableName()), array('*'))
			->joinInner(array('s'=>$memberModel->getTableName()), "`o`.`sellUser` = `s`.`userName`", array('ysbUserId as sellerId'))
			->joinInner(array('b'=>$memberModel->getTableName()), "`o`.`buyUser` = `b`.`userName`", array('ysbUserId as buyerId'))
			->where("`o`.`orderSN` = {$this->getAdapter()->quote($orderSn)}");
		$row = $this->getAdapter()->fetchRow($orderSelect);
		return $row;
	}
	
	/**
	 *    生成订单号
	 *
	 *    @return    string
	 */
	private function _gen_order_sn()
	{
		/* 选择一个随机的方案 */
		$order_sn = randomSerial();
	
		$orders = $this->fetchRow('orderSN=' . $order_sn);
		if (empty($orders))
		{
			/* 否则就使用这个订单号 */
			return $order_sn;
		}
	
		/* 如果有重复的，则重新生成 */
		return $this->_gen_order_sn();
	}
	
}