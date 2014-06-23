<?php

/**
 * 用户
 *
 * @author cdlei
 */

require 'CommonController.php';

class Member_UserController extends Member_CommonController
{
    /**
     * 初始化
     * 
     * @return void
     */
    public function init()
    {
        $this->_isLoginCheck = 0;
        parent::init();
    }

    /**
     * 默认动作
     * 
     * @return void
     */
    public function indexAction()
    {
        $this->_isLoginCheck = 1;
        $this->__loginCheck();
        $memberLoginModel = new Application_Model_MemberLogin();
        $this->view->row  = $row = $memberLoginModel->getLoginedRow();

        $memberBalanceModel = new Application_Model_MemberBalance();
        $memberBaseModel = new Application_Model_MemberBase();
        $memberContactModel = new Application_Model_MemberContact();
        $memberEnterpriseModel = new Application_Model_MemberEnterprise();
        $memberSpouseModel = new Application_Model_MemberSpouse();

        $row = $memberLoginModel->getLoginedRow(); 
        if (empty($row)) {
            echo $this->view->message('记录不存在，请返回重试！', '') ;
            exit;
        }
        $memberBalanceRow = $memberBalanceModel->fetchRow("`userName` = '{$row['userName']}'");
        $memberBaseRow = $memberBaseModel->fetchRow("`userName` = '{$row['userName']}'");
        $memberContactRow = $memberContactModel->fetchRow("`userName` = '{$row['userName']}'");
        $memberEnterpriseRow = $memberEnterpriseModel->fetchRow("`userName` = '{$row['userName']}'");
        $memberSpouseRow = $memberSpouseModel->fetchRow("`userName` = '{$row['userName']}'");

        $this->view->memberVars = $this->_configs['project']['memberVars'];
        $this->view->row = $row;
        $this->view->memberBalanceRow = $memberBalanceRow;
        $this->view->memberBaseRow = $memberBaseRow;
        $this->view->memberContactRow = $memberContactRow;
        $this->view->memberEnterpriseRow = $memberEnterpriseRow;
        $this->view->memberSpouseRow = $memberSpouseRow;
        $this->view->memberGrade = $memberLoginModel->getCurrentMemberGrade($row['userName']);
        $this->view->memberAmount = $memberLoginModel->getCurrentMemberAmount($row['userName']);
        
        //$formClass = $this->_request->get('formClass');
        //if ($this->_request->isPost()) {var_dump($formClass); die();}
        $approveCheck = $this->_request->get('approveCheck');
        $approveCheck = !empty($approveCheck) ? $approveCheck : '0';

        //个人基本资料
        if ($this->_request->isPost()) {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['name'] = $filter->filter(trim($this->_request->getPost('userName')));
            $field['mobile'] = $filter->filter(trim($this->_request->getPost('mobile')));
            $field['idCardNumber'] = $filter->filter(trim($this->_request->getPost('idCardNumber')));
            $field['idCardAddress'] = $filter->filter(trim($this->_request->getPost('idCardAddress')));
            
            $memberLoginModel->update($field, "`userName` = '{$row['userName']}'");
            if($row['userType'] == 'P') {
	            echo $this->view->message('个人基本资料修改成功！') ;
	            exit;
            }
        }

        //公司详细资料
        if ($this->_request->isPost() && $row['userType'] == 'C') {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['userName'] = $row['userName'];
            $field['industry'] = $filter->filter(trim($this->_request->getPost('industry')));
            $field['name'] = $filter->filter(trim($this->_request->getPost('companyName')));
            $field['createTime'] = $filter->filter(trim($this->_request->getPost('createTime')));
            $field['telephone'] = $filter->filter(trim($this->_request->getPost('telephone')));
            $field['premises'] = $filter->filter(trim($this->_request->getPost('premises')));
            $field['monthRent'] = $filter->filter(trim($this->_request->getPost('monthRent')));
            $field['leaseEndTime'] = $filter->filter(trim($this->_request->getPost('leaseEndTime')));
            $field['taxRegistrationCertificate'] = $filter->filter(trim($this->_request->getPost('taxRegistrationCertificate')));
            $field['businessLicenseNumber'] = $filter->filter(trim($this->_request->getPost('businessLicenseNumber')));
            
            $field['businessLicenseCopyPath'] = $this->__uploadFile('businessLicenseCopy', 'certificateCopy', $row,
            									array('path' => empty($memberEnterpriseRow) ? '' : $memberEnterpriseRow['businessLicenseCopyPath']));
            $field['organizationCode'] = $filter->filter(trim($this->_request->getPost('organizationCode')));
            
            $field['organizationCodeCopyPath'] = $this->__uploadFile('organizationCodeCopy', 'certificateCopy', $row,
            		array('path' => empty($memberEnterpriseRow) ? '' : $memberEnterpriseRow['organizationCodeCopyPath']));

            $field['licenseNumberBankAccount'] = $filter->filter(trim($this->_request->getPost('licenseNumberBankAccount')));
            $field['turnoverLastYear'] = $filter->filter(trim($this->_request->getPost('turnoverLastYear')));
            $field['employeesNumber'] = $filter->filter(trim($this->_request->getPost('employeesNumber')));
            $field['legalPersonName'] = $filter->filter(trim($this->_request->getPost('legalPersonName')));
            $field['legalPersonIDCard'] = $filter->filter(trim($this->_request->getPost('legalPersonIDCard')));
            
            $field['legalPersonIDCardCopyPath'] = $this->__uploadFile('legalPersonIDCardCopy', 'certificateCopy', $row,
            		array('path' => empty($memberEnterpriseRow) ? '' : $memberEnterpriseRow['legalPersonIDCardCopyPath']));
            
            $field['address'] = $filter->filter(trim($this->_request->getPost('address')));
            $field['zipcode'] = $filter->filter(trim($this->_request->getPost('zipcode')));
            $field['email'] = $filter->filter(trim($this->_request->getPost('email')));
            $field['operatorCopyPath'] = $this->__uploadFile('operatorCopy', 'certificateCopy', $row,
            		array('path' => empty($memberEnterpriseRow) ? '' : $memberEnterpriseRow['operatorCopyPath']));
            $field['creditCopyPath'] = $this->__uploadFile('creditCopy', 'certificateCopy', $row,
            		array('path' => empty($memberEnterpriseRow) ? '' : $memberEnterpriseRow['creditCopyPath']));
            $field['taxCopyPath'] = $this->__uploadFile('taxCopy', 'certificateCopy', $row,
            		array('path' => empty($memberEnterpriseRow) ? '' : $memberEnterpriseRow['taxCopyPath']));
            $field['bankCopyPath'] = $this->__uploadFile('bankCopy', 'certificateCopy', $row,
            		array('path' => empty($memberEnterpriseRow) ? '' : $memberEnterpriseRow['bankCopyPath']));
            
            if (empty($memberEnterpriseRow)) {
                $memberEnterpriseModel->insert($field);
            } else {
                $memberEnterpriseModel->update($field, "`userName` = '{$row['userName']}'");
            }
            //echo $this->view->message('公司详细资料修改成功！') ;
            //exit;
        }

        //资料审查
        if ($this->_request->isPost() && $row['userType'] == 'C' && $approveCheck == '1') {
            $field = array();
            if ($row['borrowersStatus'] == '1' || $row['borrowersStatus'] == '4') {
                $field['borrowersStatus'] = '2';
                $memberLoginModel->update($field, "`userName` = '{$row['userName']}'");
                echo $this->view->message('提交成功，我们会尽快审查你的资料。') ;
                exit;
            }
        } else if($this->_request->isPost() && $row['userType'] == 'C' && $approveCheck != '1') {
        	echo $this->view->message('公司资料保存成功！') ;
        	exit;
        }

    }
    
    public function identifyNotifyAction()
    {
    	if($this->_request->isPost()) {
    		$response = array(
    				'rspCode' => $this->_request->get('rspCode'),
    				'rspMsg' => $this->_request->get('rspMsg'),
    				'orderId' => $this->_request->get('orderId'),
    				'userId' => $this->_request->get('userId'),
    				'ysbUserId' => $this->_request->get('ysbUserId'),
    				'merchantKey' => $this->_configs['project']['ysbVars']['merchantKey'],
    		);
    		$backUrl = $this->view->projectUrl(array('controller'=> 'member', 'action'=>'index'));
    		if($this->_request->get('mac') == ysbMac($response))
    		{
    			if($response['rspCode'] == '0000') {
    				$memberLoginModel = new Application_Model_MemberLogin();
    				$userName = Application_Model_MemberLogin::getLoginedUserName();
    				$userType = Application_Model_MemberLogin::getLoginedUserType();
    				$field = array(
    						'ysbUserId' => $response['userId'],
    						'status' => '2',
    				);
    				if($userType == 'P') {
    					$field['lendersStatus'] = '3';
    				}
    				/*
    				if($userType == 'C') {
    					$field['borrowersStatus'] = '3';
    				} elseif($userType == 'P') {
    					$field['lendersStatus'] = '3';
    				}*/
    				$memberLoginModel->update($field, "`userName` = '{$userName}'");
    				echo $this->view->message('身份验证成功！', $backUrl, 1, 'window.opener=null;window.close();');
    				exit;
    			} else {
    				echo $this->view->message('身份验证失败。请重试！', $backUrl, 3, 'window.opener=null;window.close();');
    				exit;
    			}
    		} else {
    			echo $this->view->message('Mac校验出错。请重试！', $backUrl, 3, 'window.opener=null;window.close();');
    			exit;
    		}
    	}
    	exit;
    }
    
    public function identifyAction()
    {
    	$memberLoginModel = new Application_Model_MemberLogin();
    	$row = $memberLoginModel->getLoginedRow();
    	if($this->_request->isPost()) {
    		if($row['status'] == '2') {
		    	$userName = Application_Model_MemberLogin::getLoginedUserName();
		    	$field = array(
		    		'name' => $this->_request->get('name'),
		    		'idCardNumber' => $this->_request->get('idNum'),
		    	);
		    	$memberLoginModel->update($field, "`userName` = '{$userName}'");
    		}
	    	redirect($this->view->projectUrl(array('controller'=> 'index', 'action'=>'index')));
    	} else {
	    	$params = ysbRegisterParam($row, $this->_configs['project']['ysbVars']);
	    	$this->view->row = $row;
	    	$this->view->params  = $params;
	    	$this->view->ysburl  = $this->_configs['project']['ysbVars']['url']['register'];
    	}
    }

    /**
     * 头像上传
     * 
     * @return void
     */
    public function avatarUploadAction()
    {
        $this->_isLoginCheck = 1;
        $this->__loginCheck();
        $memberLoginModel = new Application_Model_MemberLogin();
        $this->view->userRow  = $userRow = $memberLoginModel->getLoginedRow();

        if (!empty($userRow['avatarPath'])) {
            $avatarUrl = $this->_configs['project']['memberAvatarBaseUrl'] . $userRow['avatarPath'];
        } else {
            $avatarUrl = $this->_configs['project']['memberAvatarDefaultUrl'];
        }
        $this->view->avatarUrl = $avatarUrl;

        if ($this->_request->isPost()) {
            $avatarPath = $this->__uploadFile('avatarPhoto', 'memberAvatar', $userRow, array('path' => $userRow['avatarPath']));
            if (!empty($avatarPath)) {
                $memberLoginModel->update(array('avatarPath'=>$avatarPath), "`id` = {$userRow['id']}");
                echo $this->view->message("上传成功。") ;
                exit;  
            }
        }
    }

    /**
     * 修改密码
     * 
     * @return void
     */
    public function modifyPasswordAction()
    {
        $this->_isLoginCheck = 1;
        $this->__loginCheck();
        $memberLoginModel = new Application_Model_MemberLogin();
        $this->view->row  = $row = $memberLoginModel->getLoginedRow();

        if ($this->_request->isPost()) {
            $oldPassword = trim($this->_request->getPost('oldPassword'));
            $password = trim($this->_request->getPost('password'));
            $password2 = intval($this->_request->getPost('password2'));
            if ($oldPassword == '') {
                echo $this->view->message('原密码不能为空！') ;
                exit;
            }
            if ($password == '') {
                echo $this->view->message('新密码不能为空！') ;
                exit;
            }
            if (strlen($password) > 20 || strlen($password) < 5) {
                echo $this->view->message('新密码长度必须是5-20位！') ;
                exit;
            }
            if ($password != $password2) {
                echo $this->view->message('确认新密码输入不匹配！') ;
                exit;
            }
            if (md5($oldPassword) != $row['password']) {
                echo $this->view->message('原密码输入错误，请重新输入！') ;
                exit;
            }
            $memberLoginModel->update(array('password'=>md5($password)), "`id` = {$row['id']}");
            echo $this->view->message('密码修改成功，请重新登录！', $this->view->projectUrl(array('action'=>'logout'))) ;
            exit;
        }
    }

    /**
     * 登录
     * 
     * @return void
     */
    public function loginAction()
    {
        $from = $this->_request->get('from');
    	if(empty($from)) {
        	$this->view->banner = 'member';
        } else {
        	$this->view->banner = $from;
        }
    	
    	if ($this->_request->isPost()) {
            $userName = trim($this->_request->getPost('userName'));
            $password = trim($this->_request->getPost('password'));
            $code = trim($this->_request->getPost('code'));
            $timeToLive = intval($this->_request->getPost('timeToLive'));
            $backUrl = trim($this->_request->get('backUrl')) != '' ? urldecode(trim($this->_request->get('backUrl'))) : NULL;

            if (!isset($_SESSION["{$this->_configs['project']['cookiePrefix']}_imageCode"])) {
            	exit($this->view->message('验证码初始化错误，请返回重新填写！'));
            } else if ($code == '') {
            	exit($this->view->message('请输入验证码！'));
            }else if ((strtoupper($code) !== $_SESSION["{$this->_configs['project']['cookiePrefix']}_imageCode"])) {
            	$_SESSION["{$this->_configs['project']['cookiePrefix']}"] = '';
            	echo $this->view->message('验证码错误，请返回重新填写！') ;
            	exit;
            }
            
            $memberLoginModel = new Application_Model_MemberLogin();
            $status = $memberLoginModel->login($userName, $password, $timeToLive);
            if ($status == 1) {
                echo $this->view->message('用户名或密码错误！') ;
                exit;
            } else if ($status == 1) {
                echo $this->view->message('用户名或密码错误！') ;
                exit;
            //} else if ($status == 2) {
            //    echo $this->view->message('你的帐号还没有激活！') ;
            //    exit;
            } else if ($status == 3) {
                echo $this->view->message('你的帐号已经关闭，如有问题请与管理员联系！') ;
                exit;
            } else {
                if (empty($backUrl)) {
                    redirect($this->view->projectUrl(array('module'=>'member', 'controller'=>'index', 'action'=>'index')));
                } else {
                	$port = $_SERVER['SERVER_PORT'] == '80' ? '' : ":{$_SERVER['SERVER_PORT']}";
                    redirect("http://{$_SERVER['SERVER_NAME']}{$port}/" . $backUrl);
                }
            }
        }
    }

    /**
     * 登出
     * 
     * @return void
     */
    public function logoutAction()
    {
        $memberLoginModel = new Application_Model_MemberLogin();
        $memberLoginModel->logout();
        redirect($this->view->projectUrl(array('module'=>'default', 'controller'=>'index', 'action'=>'index')));
    }

    /**
     * 发送激活邮件
     * 
     * @return void
     */
    public function sendActiveMailAction()
    {
        if ($this->_request->isPost()) {
            $userName = trim($this->_request->getPost('userName'));
            $mobile = trim($this->_request->getPost('mobile'));
            $email = trim($this->_request->getPost('email'));

            $memberModel = new Application_Model_Member();
            $row = $memberModel->fetchRow("`userName` = '". addslashes($userName) ."'");
            if (!preg_match("/^[a-z0-9]([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?$/i", $email)) {
                echo $this->view->message('E-mail地址填写错误！') ;
                exit;
            } else if (empty($row)) {
                echo $this->view->message('用户名不存在，请检查是否输入错误！') ;
                exit;
            } else if ($row['mobile'] != $mobile) {
                echo $this->view->message('你输入的用户名和手机号不是同一个用户！') ;
                exit;
            } else if ($row['status'] != 1) {
                echo $this->view->message('你的账户是已经激活状态！') ;
                exit;
            } else {
                //生成设置激活的邮件
                $port = $_SERVER['SERVER_PORT'] == '80' ? '' : ":{$_SERVER['SERVER_PORT']}";
                $time = time();

                $url = "http://{$_SERVER['SERVER_NAME']}{$port}" . $this->view->projectUrl(array('action'=>'active', 'userName'=>$userName, 'time'=>$time, 'code'=>md5("{$userName}{$row['password']}{$time}{$this->_configs['project']['authKey']}")));
                $mailModel = new Application_Model_Mail();
                $content = "
                     尊敬的用户：<br/>
                     你好！<br/><br/>
                     根据您于 [" . date("Y-m-d H:i:s") . "] 提交的请求，本邮件将引导您激活你的帐号。<br/>
                     如本次“激活”的请求是您本人提交，<a href=\"{$url}\">请点此激活帐号</a>（本链接仅一次有效）。<br/>
                     如果上面的链接无法点击，您可以复制以下链接粘贴到浏览器的地址栏内，然后按“回车”激活帐号：<br/>
                     {$url}
                     <br/><br/>
                     如有任何问题您都可以登录 {$_SERVER['SERVER_NAME']} 与我们的客服联系！";
                $mailModel->send($email, '帐号激活，请勿回复', $content);
                if ($mailModel->getSendStaus() != 0) {
                    echo $this->view->message('发送失败！<br/>错误如下：' . $mailModel->getSendInfo()) ;
                    exit;
                } else {
                    echo $this->view->message('发送成功！') ;
                    exit;
                }
            }
        }
    }

    /**
     * 激活账户
     * 
     * @return void
     */
    public function activeAction()
    {
        $userName = trim($this->_request->get('userName'));
        $time = intval($this->_request->get('time'));
        $code = trim($this->_request->get('code'));

        $returnUrl = $this->view->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'send-active-mail'));
        if (empty($userName)) {
            echo $this->view->message('用户名不能为空！', $returnUrl) ;
            exit;
        } else if (empty($time)) {
            echo $this->view->message('时间参数错误！', $returnUrl) ;
            exit;
        } else if (time() - $time > 3600){
            echo $this->view->message('此链接已经失效，请重新发送！', $returnUrl) ;
            exit;
        } 

        $memberModel = new Application_Model_Member();
        $row = $memberModel->fetchRow("`userName` = '". addslashes($userName) ."'");
        if (empty($row)) {
            echo $this->view->message('用户名不存在，请检查是否输入错误！', $returnUrl) ;
            exit;
        } else if ($code != md5("{$userName}{$row['password']}{$time}{$this->_configs['project']['authKey']}")) {
            echo $this->view->message('验证错误！', $returnUrl) ;
            exit;
        } else if ($row['status'] != 1) {
            echo $this->view->message('失败，你的帐号已经激活过了！', $this->view->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'login'))) ;
            exit;
        } else {
            $status = 2;
            $memberModel->update(array('status'=>$status), "`userName` = '". addslashes($userName) ."'");
            echo $this->view->message('激活成功，请登录！', $this->view->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'login'))) ;
            exit;
        }
    }

    /**
     * 修改密码
     * 
     * @return void
     */
    public function forgotPasswordAction()
    {
        if ($this->_request->isPost()) {
            $userName = trim($this->_request->getPost('userName'));
            $mobile = trim($this->_request->getPost('mobile'));
            $email = trim($this->_request->getPost('email'));

            $memberModel = new Application_Model_Member();
            $row = $memberModel->fetchRow("`userName` = '". addslashes($userName) ."'");
            if (empty($row)) {
                echo $this->view->message('用户名不存在，请检查是否输入错误！') ;
                exit;
            } else if ($row['email'] != $email) {
                echo $this->view->message('你输入的E-mail地址错误！') ;
                exit;
            } else {
                //生成设置密码的邮件
                $port = $_SERVER['SERVER_PORT'] == '80' ? '' : ":{$_SERVER['SERVER_PORT']}";
                $time = time();

                $url = "http://{$_SERVER['SERVER_NAME']}{$port}" . $this->view->projectUrl(array('action'=>'mail-modify-password', 'userName'=>$userName, 'time'=>$time, 'code'=>md5("{$userName}{$row['password']}{$time}{$this->_configs['project']['authKey']}")));
                $mailModel = new Application_Model_Mail();
                $content = "
                     尊敬的用户：<br/>
                     你好！<br/><br/>
                     根据您于 [" . date("Y-m-d H:i:s") . "] 提交的请求，本邮件将引导您重新设置帐号：{$userName} 的登录密码。<br/>
                     如本次“找回密码”的请求是您本人提交，<a href=\"{$url}\">请点此设置新密码</a>（本链接仅一次有效）。<br/>
                     如果上面的链接无法点击，您可以复制以下链接粘贴到浏览器的地址栏内，然后按“回车”键设置新密码：<br/>
                     {$url}
                     <br/><br/>
                     本次发送有效期为1个小时，如有任何问题您都可以登录 {$_SERVER['SERVER_NAME']} 与我们的客服联系！";
                $mailModel->send($email, '找回密码，请勿回复', $content);
                if ($mailModel->getSendStaus() != 0) {
                    echo $this->view->message('发送失败！<br/>错误如下：' . $mailModel->getSendInfo()) ;
                    exit;
                } else {
                    echo $this->view->message('发送成功！') ;
                    exit;
                }
            }
        }
    }

    /**
     * 激活邮件修改密码
     * 
     * @return void
     */
    public function mailModifyPasswordAction()
    {
        $userName = trim($this->_request->get('userName'));
        $returnUrl = $this->view->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'forgot-password'));
        //$time = intval($this->_request->get('time'));
        //$code = trim($this->_request->get('code'));
/*
        if (empty($userName)) {
            echo $this->view->message('用户名不能为空！', $returnUrl) ;
            exit;
        } else if (empty($time)) {
            echo $this->view->message('时间参数错误！', $returnUrl) ;
            exit;
        } else if (time() - $time > 3600){
            echo $this->view->message('此链接已经失效，请重新发送！', $returnUrl) ;
            exit;
        }
*/
        $memberModel = new Application_Model_Member();
        $row = $memberModel->fetchRow("`userName` = '". addslashes($userName) ."'");
        if (empty($row)) {
            echo $this->view->message('用户名不存在，请检查是否输入错误！', $returnUrl) ;
            exit;
        }/* else if ($code != md5("{$userName}{$row['password']}{$time}{$this->_configs['project']['authKey']}")) {
            echo $this->view->message('验证错误！', $returnUrl) ;
            exit;
        }*/

        if ($this->_request->isPost()) {
            $password = trim($this->_request->get('password'));
            if ($password == '') {
                echo $this->view->message('密码不能为空！') ;
                exit;
            } else if (md5($password) == $row['password']) {
                echo $this->view->message('新密码不能和原密码相同！') ;
                exit;
            } else {
                $memberModel->update(array('password'=>md5($password)), "`userName` = '". addslashes($userName) ."'");
                echo $this->view->message('修改成功！', $this->view->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'login'))) ;
                exit;
            }
        }
        $this->view->userName = $userName;
    }

    /**
     * 账号是否存在
     * 
     * @return void
     */
    public function accountIsExistsAction() 
    {
        $memberModel = new Application_Model_Member();
        $account = trim($this->_request->get('account'));
        $accountType = trim($this->_request->get('accountType'));

        $status = NULL;
        if ($accountType == 'userName' && !empty($account)) {
            $status = $memberModel->isExists($account);
        } else if ($accountType == 'email' && !empty($account)) {
            $status = $memberModel->emailIsExists($account);
        } else if ($accountType == 'mobile' && !empty($account)) {
            $status = $memberModel->mobileIsExists($account);
        }
        echo Zend_Json::encode($status);
        exit;
    }
    
    public function sendsmsAction()
    {
    	$mobile = trim($this->_request->get('mobile'));
    	$code = rand(100000, 999999);
    	$this->_sendsms($mobile, $code);
    	$_SESSION['smscode'] = $code;
    	$_SESSION['smstime'] = date("Y-m-d H:i:s");
    	exit;
    }
    
    private function _sendsms($mobile, $code)
    {
    	$params = array(
    		'adminId'=> $this->_configs['project']['ysbVars']['smsId'],
    		'platform'=> $this->_configs['project']['ysbVars']['smsPlatform'],
    		'platformPwd'=> $this->_configs['project']['ysbVars']['smsPlatformPwd'],
    		'ssrc' => 0,
    		'mobiles' => $mobile,
    		'msg' => '短信验证码：'.$code,
    	);
    	$client = new Zend_Http_Client();
    	$response = $client->setUri($this->_configs['project']['ysbVars']['url']['sms'])
	    	->setMethod(Zend_Http_Client::POST)
	    	->setParameterPost($params)
	    	->request();
    	if($response->isSuccessful()) {
    		$result = Zend_Json::decode($response->getBody());
    	}
    }
    
    public function checkSmscodeAction()
    {
    	$mcode = trim($this->_request->get('mcode'));
    	$status = 0;
    	if(!isset($_SESSION['smstime']) || !isset($_SESSION['smscode'])) {
    		$status = -1;
    	} else if (isset($_SESSION['smstime']) && (strtotime ( $_SESSION ['smstime'] ) + 120) < time ()) {
			session_destroy ();
			unset ( $_SESSION );
			$status = 1;
		} else if (isset($_SESSION['smscode']) && $mcode != $_SESSION['smscode']) {
			$status = 2;
		}
    	echo Zend_Json::encode($status);
    	exit;
    }
    
    public function checkLoginAction()
    {
    	$memberLoginModel = new Application_Model_MemberLogin();
    	$status = $memberLoginModel->getLoginStatus();
    	if($status == 0) {
    		$row = $memberLoginModel->getLoginedRow();
    		if($row['status'] == 1) {
    			$status = -1;
    		} else if($row['userType'] == 'C') {
    			$status = 2;
    		}
    	}
    	echo Zend_Json::encode($status);
    	exit;
    }
    
    public function getMacAction()
    {
    	$params = array(
    		'merchantId' => $this->_request->get('merchantId'),
    		'userType' => $this->_request->get('userType'),
    		'orderId' => $this->_request->get('orderId'),
    		'orderTime' => $this->_request->get('orderTime'),
    		'name' => $this->_request->get('name'),
    		'idNum' => $this->_request->get('idNum'),
    		'mobilePhoneNum' => $this->_request->get('mobilePhoneNum'),
    		'merchantKey' => $this->_request->get('merchantKey'),
    	);
    	$mac = ysbMac($params);
    	echo Zend_Json::encode($mac);
    	exit;
    }
    
    public function imgcodeAction() { }
    
    public function checkImgcodeAction()
    {
    	$code = trim($this->_request->getPost('code'));
    	$ok = 0;
    	if ((strtoupper($code) === $_SESSION["{$this->_configs['project']['cookiePrefix']}_imageCode"])) {
    		$ok = 1;
    	} else {
    		$_SESSION["{$this->_configs['project']['cookiePrefix']}"] = '';
    	}
    	echo Zend_Json::encode($ok);
    	exit;
    }
    
    /**
     * 注册
     *
     * @return void
     */
    public function registerAction()
    {   
    	$textModel = new Application_Model_Text();
    	$this->view->agreement = $textModel->content(3);
    	
    	$from = $this->_request->get('from');
    	if(empty($from)) {
    		$this->view->from = 'member';
    	} else {
    		$this->view->from = $from;
    	}
    	
    	if ($this->_request->isPost()) {
    		$memberModel = new Application_Model_Member();
    		$filter = new Zend_Filter_StripTags();
    		$field = array();
    		$field['userName'] = trim($filter->filter($this->_request->getPost('userName')));
    		$field['password'] = $password2 = trim($this->_request->getPost('password'));
    		$field['email'] = trim($filter->filter($this->_request->getPost('email')));
    		$field['userType'] = $this->_request->getPost('userType');
    		
    		$field['name'] = '';
    		$field['mobile'] = $field['userName'];
    		$field['idCardNumber'] = '';
    		$field['idCardAddress'] = '';
    
    		$field['regTime'] = time();
    		$field['regIp'] = getClientIP();
    		$field['status'] = 1;
    		$field['borrowersStatus'] = 1;
    		$field['lendersStatus'] = 1;
    		
    		/*
    		if ((strtotime ( $_SESSION ['smstime'] ) + 60) < time ()) {
    			session_destroy ();
    			unset ( $_SESSION );
    			echo $this->view->message('验证码已过期！') ;
    			exit;
    		}*/    		
    		
    		if ($field['userName'] == '') {
    			echo $this->view->message('用户名不能为空！') ;
    			exit;
    		}
    		if (strlen($field['userName']) < 5 || strlen($field['userName']) > 20) {
    			echo $this->view->message('用户名长度必须是5-20个字符！') ;
    			exit;
    		}
    		if (preg_match("/[^\x80-\xff\w]/", $field['userName'])) {
    			echo $this->view->message('用户名必须由英文字母、数字和汉字组成！') ;
    			exit;
    		}
    		if ($memberModel->isExists($field['userName'])) {
    			echo $this->view->message("用户名“{$field['userName']}”已经存在，请重新填写！") ;
    			exit;
    		}
    		
    		/*
    		if ($field['email'] == '') {
    			echo $this->view->message('邮件不能为空！') ;
    			exit;
    		}
    		if ($memberModel->emailIsExists($field['email'])) {
    			echo $this->view->message("邮件地址“{$field['email']}”已经存在，请重新填写！") ;
    			exit;
    		}
    		*/
    		if ($field['password'] == '') {
    			echo $this->view->message('密码不能为空！') ;
    			exit;
    		}
    		if (strlen($field['password']) > 30 || strlen($field['password']) < 6) {
    			echo $this->view->message('密码长度必须是6-30位！') ;
    			exit;
    		}
    
    		$field['password'] = md5($field['password']);
    		$memberModel->insert($field);
    /*
    		//生成设置激活的邮件
    		$port = $_SERVER['SERVER_PORT'] == '80' ? '' : ":{$_SERVER['SERVER_PORT']}";
    		$time = time();
    
    		$url = "http://{$_SERVER['SERVER_NAME']}{$port}" . $this->view->projectUrl(array('action'=>'active', 'userName'=>$field['userName'], 'time'=>$time, 'code'=>md5("{$field['userName']}{$field['password']}{$time}{$this->_configs['project']['authKey']}")));
    		$mailModel = new Application_Model_Mail();
    		$content = "
                 尊敬的用户：<br/>
                 你好！<br/><br/>
                 根据您于 [" . date("Y-m-d H:i:s") . "] 提交的注册请求，本邮件将引导您激活你的帐号。<br/>
                     如本次“激活”的请求是您本人提交，<a href=\"{$url}\">请点此激活帐号</a>（本链接仅一次有效）。<br/>
                     如果上面的链接无法点击，您可以复制以下链接粘贴到浏览器的地址栏内，然后按“回车”激活帐号：<br/>
                     {$url}
                     <br/><br/>
                     如有任何问题您都可以登录 {$_SERVER['SERVER_NAME']} 与我们的客服联系！";
                     $mailModel->send($field['email'], '帐号激活，请勿回复', $content);
                     $successUrl = $this->view->projectUrl(array('action'=>'login'));
                     if ($mailModel->getSendStaus() != 0) {
                     	echo $this->view->message('注册成功，激活邮件发送失败！<br/>错误如下：' . $mailModel->getSendInfo(), $successUrl) ;
                     	exit;
                     } else {
                     	echo $this->view->message('注册成功，激活邮件已经发送到你的邮箱，请注意查收！', $successUrl) ;
                     	exit;
                     }
     */
    		$successUrl = $this->view->projectUrl(array('action'=>'login'));
    		echo $this->view->message('注册成功，请登录！', $successUrl) ;
    		exit;
    	}
    }

    /**
     * 注册用户协议
     * 
     * @return void
     */
    public function agreementAction()
    {
        $textModel = new Application_Model_Text();
        $this->view->content = $textModel->content(3);
    }

    /**
     * 银行帐号
     * 
     * @return void
     */
    public function bankAction()
    {
        $this->view->bankTypes = explode(',', $this->_configs['project']['bankTypes']);
        
        $this->_isLoginCheck = 1;
        $this->__loginCheck();
        $memberLoginModel = new Application_Model_MemberLogin();
        $this->view->row  = $row = $memberLoginModel->getLoginedRow();

        if ($this->_request->isPost() && ($row['bankStatus'] == 1 || $row['bankStatus'] == 4)) {
            $memberModel = new Application_Model_Member();
            $filter = new Zend_Filter_StripTags();
            $field = array();
            $field['bankType'] = $filter->filter(trim($this->_request->getPost('bankType')));
            $field['bankAccount'] = $filter->filter(trim($this->_request->getPost('bankAccount')));
            $field['bankSubbranch'] = $filter->filter(trim($this->_request->getPost('bankSubbranch')));
            $field['bankStatus'] = '2';
 
            if ($field['bankType'] == '') {
                echo $this->view->message('银行名称不能为空！') ;
                exit;
            }
            if ($field['bankSubbranch'] == '') {
                echo $this->view->message('开户支行不能为空！') ;
                exit;
            }
            if ($field['bankAccount'] == '') {
                echo $this->view->message('银行帐号不能为空！') ;
                exit;
            }

            $memberModel->update($field, "`id` = {$row['id']}");

            echo $this->view->message('修改成功！') ;
            exit;
        }
    }

    /**
     * 用户登录记录
     * 
     * @return void
     */
    public function loginListAction()
    {
        $this->_isLoginCheck = 1;
        $this->__loginCheck();

        $memberVisitModel = new Application_Model_MemberVisit();

        //获取当前页码
        $pageSize = 15;
        $pageNo = intval($this->_request->get('pageNo'));
        if (empty($pageNo)) {
            $pageNo = 1;
        }

        //设置URL模板以及条件
        $urls = array();
        $wheres = array();

        $wheres[] = "`userName` = {$memberVisitModel->getAdapter()->quote(Application_Model_MemberLogin::getLoginedUserName())}";

        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT * FROM `{$memberVisitModel->getTableName()}` {$where} ORDER BY `lastOnlineTime` DESC";
        $dbPaginator = new Application_Model_DbPaginator($sql, $pageSize, $pageNo);
        $recordCount = $dbPaginator->getRecodCount();

        //获取分页html字符

        Zend_Loader::loadClass('Project_Paginator');
        $paginator = new Project_Paginator($recordCount, $pageSize, $pageNo);
        $paginator->urlTemplateContent = $urlTemplate;

        //分配view(分页处理后的记录集以及分页HTML字符)
        $this->view->pageString = $paginator->getPageString();
        $this->view->rows = $dbPaginator->getRows();
        $urls['pageNo'] = $pageNo;
        $this->view->pageUrl = $this->view->projectUrl($urls);
    }

    /**
     * 申请VIP会员
     * 
     * @return void
     */
    public function applyVipAction()
    {
        $this->_isLoginCheck = 1;
        $this->__loginCheck();

        $memberGradeModel = new Application_Model_MemberGrade();
        $adminModel = new Application_Model_Admin();
        $memberLoginModel = new Application_Model_MemberLogin();
        $rows = $memberGradeModel->fetchAll("`userName` = '" . addslashes(Application_Model_MemberLogin::getLoginedUserName()) . "'", 'id DESC');
        $this->view->rows = $rows;
        $this->view->vipPrice = $this->_configs['project']['vipPrice'];

        $row = $memberLoginModel->getLoginedRow();
        if (!($row['borrowersStatus'] == 3 || $row['lendersStatus'] == 3)) {
            echo $this->view->message('你的资料还没有被审核，暂不能申请VIP会员。', $this->view->projectUrl(array('action'=>'index')));
            exit;
        }
        if ($this->_request->isPost()) {
            $filter = new Zend_Filter_StripTags();
            $serviceCode = $filter->filter(trim($this->_request->get('serviceCode')));
            $year = intval(trim($this->_request->get('year')));
            $result = $memberGradeModel->getIsCanApply($row['userName'], $year, $serviceCode);

            if ($result['status'] != 0) {
                echo $this->view->message($result['message']);
                exit;
            } else {
                $field = array();
                $field['userName'] = $row['userName'];
                $field['status'] = '1';
                $field['statusLog'] = '';
                $field['grade'] = '1';
                $field['price'] = $this->_configs['project']['vipPrice'];
                $field['year'] = $year;
                $field['startTime'] = 0;
                $field['endTime'] = 0;
                $field['serviceCode'] = $serviceCode;
                $field['addTime'] = time();
                $memberGradeModel->insert($field);
                echo $this->view->message('申请成功，请等待审核。');
                exit;
            }
        }
        
    }

    /**
     * 检查申请VIP会员，返回json格式{'status':0, 'message':'成功'}
     * 
     * @return void
     */
    public function checkApplyVipAction()
    {
        $this->_isLoginCheck = 1;
        $this->__loginCheck();

        $memberLoginModel = new Application_Model_MemberLogin();
        $memberGradeModel = new Application_Model_MemberGrade();
        $row = $memberLoginModel->getLoginedRow();

        $filter = new Zend_Filter_StripTags();
        $serviceCode = $filter->filter(trim($this->_request->get('serviceCode')));
        $year = intval(trim($this->_request->get('year')));
        $result = $memberGradeModel->getIsCanApply($row['userName'], $year, $serviceCode);
        $this->_helper->getHelper('Json')->sendJson($result);
    }
    
}