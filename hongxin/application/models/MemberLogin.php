<?php
/**
 * 会员登录
 *
 * @author cdlei
 */

class Application_Model_MemberLogin extends Application_Model_Member
{
    /**
     * 登录过的用户名
     *
     * @var array
     */
    protected $_loginedRow;

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
     * 检查用户登录状态
     * 返回状态，0：正常，1：用户名或者密码错误，2：未激活，3：帐号关闭
     * 
     * @return integer
     */
    public function getLoginStatus()
    {
        $cookieModel = new Application_Model_Cookie();
        $userName = $cookieModel->getCookie('memberUserName');
        $password = $cookieModel->getCookie('memberPassword');
        $userType = $cookieModel->getCookie('memberUserType');
        $timeToLive = $cookieModel->getCookie('memberTimeToLive');
        $memberVisitId = $cookieModel->getCookie('memberVisitId');

        $row = $this->getLoginedRow();
        if (empty($row)) {
            $status = 1;
        //} else if ($row['status'] == 1) {
        //    $status = 2;
        } else if ($row['status'] == 3) {
            $status = 3;
        } else {
            $status = 0;
        }
        if ($status != 0) {
            $userName = NULL;
            $password = NULL;
            $userType = NULL;
            $timeToLive = 0;
        }
        $cookieModel->setCookie('memberUserName', $userName, time() + 3600 * 24 * $timeToLive);
        $cookieModel->setCookie('memberPassword', $password, time() + 3600 * 24 * $timeToLive);
        $cookieModel->setCookie('memberUserType', $userType, time() + 3600 * 24 * $timeToLive);
        $cookieModel->setCookie('memberTimeToLive', $timeToLive, time() + 3600 * 24 * $timeToLive);
        $cookieModel->setCookie('memberVisitId', $memberVisitId, time() + 3600 * 24 * $timeToLive);
        return $status;
    }

    /**
     * 获取已登录用户名
     * 
     * @return string
     */
    public static function getLoginedUserName()
    {
        $cookieModel = new Application_Model_Cookie();
        if ($cookieModel->getCookie('memberUserName') && $cookieModel->getCookie('memberPassword')) {
            $userName = $cookieModel->getCookie('memberUserName');
        } else {
            $userName = NULL;
        }
        return $userName;
    }
    
    /**
     * 获取已登录用户类型
     *
     * @return string
     */
    public static function getLoginedUserType()
    {
    	$cookieModel = new Application_Model_Cookie();
    	if ($cookieModel->getCookie('memberUserName') && $cookieModel->getCookie('memberPassword')) {
    		$userType = $cookieModel->getCookie('memberUserType');
    	} else {
    		$userType = NULL;
    	}
    	return $userType;
    }

    /**
     * 获取已登录 访问ID
     * 
     * @return string
     */
    public static function getLoginedUserVisitId()
    {
        $cookieModel = new Application_Model_Cookie();
        if ($cookieModel->getCookie('memberVisitId')) {
            $memberVisitId = $cookieModel->getCookie('memberVisitId');
        } else {
            $memberVisitId = NULL;
        }
        return $memberVisitId;
    }

    /**
     * 登录
     * 返回状态，0：登录成功，1：用户名或者密码错误，2：未激活，3：帐号关闭
     * 生存时间单位天
     * 
     * @param string $userName
     * @param string $password
     * @param integer $timeToLive
     * @return integer 
     */
    public function login($userName, $password, $timeToLive = 1)
    {
        $cookieModel = new Application_Model_Cookie();
        $memberVisitModel = new Application_Model_MemberVisit();
        $status = 1;
        $row = $this->fetchRow("(`userName` = '". addslashes($userName) ."') AND `password` = '". md5($password) ."'");
        if (empty($row)) {
            $status = 1;
        //} else if ($row['status'] == 1) {
        //    $status = 2;
        } else if ($row['status'] == 3) {
            $status = 3;
        } else {
            $status = 0;
            $cookieModel->setCookie('memberUserName', $row['userName'], time() + 3600 * 24 * $timeToLive);
            $cookieModel->setCookie('memberUserType', $row['userType'], time() + 3600 * 24 * $timeToLive);
            $cookieModel->setCookie('memberPassword', $password, time() + 3600 * 24 * $timeToLive);
            $cookieModel->setCookie('memberTimeToLive', $timeToLive, time() + 3600 * 24 * $timeToLive);            
            $memberVisitId = $memberVisitModel->insert(array('userName'=>$row['userName']));
            $cookieModel->setCookie('memberVisitId', $memberVisitId, time() + 3600 * 24 * $timeToLive);
        }
        return $status;
    }

    /**
     * 登出
     *
     * @return void 
     */
    public function logout()
    {
        $cookieModel = new Application_Model_Cookie();
        $cookieModel->setCookie('memberUserName', NULL, 0);
        $cookieModel->setCookie('memberUserType', NULL, 0);
        $cookieModel->setCookie('memberPassword', NULL, 0);
        $cookieModel->setCookie('memberTimeToLive', NULL, 0);
        $cookieModel->setCookie('memberVisitId', NULL, 0);
    }

    /**
     * 获取已登录的用户信息
     * 
     * @return array 
     */
    public function getLoginedRow()
    {
        $cookieModel = new Application_Model_Cookie();
        $userName = $cookieModel->getCookie('memberUserName');
        $password = $cookieModel->getCookie('memberPassword');
        if ($userName && $password) {
            if (empty($this->_loginedRow)) {
                $row = $this->fetchRow("`userName` = '". addslashes($userName) ."' AND `password` = '". md5($password) ."'");
                $this->_loginedRow = $row;
            }
        }
        return $this->_loginedRow;
    }
    
    /**
     * 判断用户资料是否填写完整
     * 返回状态，Y：完整，N：不完整
     * 
     * @return string
     */
    public function hasCompleteInfo($row, $memberEnterpriseRow)
    {
    	$infoComplete = 'Y';
    	switch ($row['userType']) {
    		case 'P':
    			if(empty($row['name']) || empty($row['mobile']) || empty($row['idCardNumber'])) {
    				$infoComplete = 'N';
    			}
    			break;
    		case 'C':
    			if(empty($row['name']) || 
    				empty($row['idCardNumber']) || 
    				empty($memberEnterpriseRow['legalPersonName']) ||
    				empty($memberEnterpriseRow['businessLicenseCopyPath']) ||
    				empty($memberEnterpriseRow['organizationCodeCopyPath']) ||
    				empty($memberEnterpriseRow['legalPersonIDCardCopyPath'])
            	) {
    				$infoComplete = 'N';
    			}
    			break;
    		default:
    			$infoComplete = 'N';
    			break;
    	}
    	return $infoComplete;
    }

}