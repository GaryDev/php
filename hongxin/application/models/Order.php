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