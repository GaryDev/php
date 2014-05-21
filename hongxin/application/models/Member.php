<?php
/**
 * 会员
 *
 * @author cdlei
 */

class Application_Model_Member extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'member';

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
     * 检查用户名是否存在
     * 
     * @param  string $name
     * @param  integer $id
     * @return 1/0
     */
    public function isExists($name, $id = 0)
    {
        $where = $id == 0 ? " WHERE `userName` = {$this->_db->quote($name)} " : " WHERE `userName` = {$this->_db->quote($name)} AND `id` <> {$id}";
        $sql = "SELECT count(*) AS c FROM `{$this->getTableName()}` {$where}";
        $row = $this->_db->fetchRow($sql);
        $isExists = $row['c'] > 0 ? 1 : 0;
        return $isExists;  
    }

    /**
     * 检查电子邮件地址是否存在
     * 
     * @param  string $address
     * @param  integer $id
     * @return 1/0
     */
    public function emailIsExists($address, $id = 0)
    {
        $where = $id == 0 ? " WHERE `email` = {$this->_db->quote($address)} " : " WHERE `email` = {$this->_db->quote($address)} AND `id` <> {$id}";
        $sql = "SELECT count(*) AS c FROM `{$this->getTableName()}` {$where}";
        $row = $this->_db->fetchRow($sql);
        $isExists = $row['c'] > 0 ? 1 : 0;
        return $isExists;  
    }

    /**
     * 检查手机号是否存在
     * 
     * @param  string $number
     * @param  integer $id
     * @return 1/0
     */
    public function mobileIsExists($number, $id = 0)
    {
        $where = $id == 0 ? " WHERE `mobile` = {$this->_db->quote($number)} " : " WHERE `mobile` = {$this->_db->quote($number)} AND `id` <> {$id}";
        $sql = "SELECT count(*) AS c FROM `{$this->getTableName()}` {$where}";
        $row = $this->_db->fetchRow($sql);
        $isExists = $row['c'] > 0 ? 1 : 0;
        return $isExists;  
    }

    /**
     * 获取当前可用金额
     * 
     * @param  string $userName
     * @return float
     */
    public function getCurrentMemberAmount($userName)
    {
        $sql = "SELECT get_current_member_amount({$this->_db->quote($userName)}) AS `amount`";
        $row = $this->_db->fetchRow($sql);
        return $row['amount'];
    }

    /**
     * 获取当前等级
     * 
     * @param  string $userName
     * @return int
     */
    public function getCurrentMemberGrade($userName)
    {
        $where = " WHERE `userName` = {$this->_db->quote($userName)} ";
        $sql = "SELECT get_current_member_grade({$this->_db->quote($userName)}) AS `grade`";
        $row = $this->_db->fetchRow($sql);
        return $row['grade'];
    }

    /**
     * 获取当前客服信息
     * 
     * @param  string $userName
     * @return array
     */
    public function getMemberGradeServiceRow($userName)
    {
        $memberGradeModel = new Application_Model_MemberGrade();
        $serviceModel = new Application_Model_Service();
        $time = time();
        $sql = "SELECT `g`.`grade`, `s`.`name`, `s`.`code`, `s`.`avatarPath`, `s`.`email`, `s`.`qq`
                FROM `{$memberGradeModel->getTableName()}` AS `g`
                LEFT JOIN `{$serviceModel->getTableName()}` AS `s` ON `g`.`serviceCode` = `s`.`code`
                WHERE 
                    `g`.`userName` = {$this->_db->quote($userName)}
                    AND {$time} >= `g`.`startTime`
                    AND {$time} <= `g`.`endTime`
                    AND `g`.`status` = '2'
                    AND `s`.`status` = '1'";
        $row = $this->_db->fetchRow($sql);
        return $row;
    }

    /**
     * 通过ID删除记录
     *
     * @param integer $id
     * @return void
     */
    public function deleteById($id)
    {
        $row = $this->fetchRow("`id` = {$id}");
        if (!empty($row)) {
            $avatarPath = $this->_configs['project']['memberAvatarBasePath'] . $row['avatarPath'];
            if (is_file($avatarPath)) {
                unlink($avatarPath);
            }
            $this->delete("`id` = '{$id}'");
        }
    }
}