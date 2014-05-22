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

        $formClass = $this->_request->get('formClass');

        //个人基本资料
        if ($this->_request->isPost() && $formClass == 'accountDetail') {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['name'] = $filter->filter(trim($this->_request->getPost('name')));
            $field['mobile'] = $filter->filter(trim($this->_request->getPost('mobile')));
            $field['idCardNumber'] = $filter->filter(trim($this->_request->getPost('idCardNumber')));
            $field['idCardAddress'] = $filter->filter(trim($this->_request->getPost('idCardAddress')));
            
            $memberLoginModel->update($field, "`userName` = '{$row['userName']}'");
            echo $this->view->message('个人基本资料修改成功！') ;
            exit;
        }

        //个人详细资料
        if ($this->_request->isPost() && $formClass == 'base') {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['userName'] = $row['userName'];
            $field['liveAddress'] = $filter->filter(trim($this->_request->getPost('liveAddress')));
            $field['livePost'] = $filter->filter(trim($this->_request->getPost('livePost')));
            $field['liveTelephone'] = $filter->filter(trim($this->_request->getPost('liveTelephone')));
            $field['marriageStatus'] = $filter->filter(trim($this->_request->getPost('marriageStatus')));
            $field['childrenStatus'] = $filter->filter(trim($this->_request->getPost('childrenStatus')));
            $field['education'] = $filter->filter(trim($this->_request->getPost('education')));
            $field['school'] = $filter->filter(trim($this->_request->getPost('school')));
            $field['major'] = $filter->filter(trim($this->_request->getPost('major')));
            $field['graduationTime'] = $filter->filter(trim($this->_request->getPost('graduationTime')));
            $field['company'] = $filter->filter(trim($this->_request->getPost('company')));
            $field['employeesNumber'] = intval($this->_request->getPost('employeesNumber'));
            $field['companyType'] = $filter->filter(trim($this->_request->getPost('companyType')));
            $field['companyIndustry'] = $filter->filter(trim($this->_request->getPost('companyIndustry')));
            $field['workCharacter'] = $filter->filter(trim($this->_request->getPost('workCharacter')));
            $field['workOffice'] = $filter->filter(trim($this->_request->getPost('workOffice')));
            $field['workTelephone'] = $filter->filter(trim($this->_request->getPost('workTelephone')));
            $field['companyAddress'] = $filter->filter(trim($this->_request->getPost('companyAddress')));
            $field['preTaxIncome'] = is_numeric($this->_request->getPost('preTaxIncome')) ? $this->_request->getPost('preTaxIncome') : 0;
            $field['entryTime'] = $filter->filter(trim($this->_request->getPost('entryTime')));
            $field['companyThatPeople'] = $filter->filter(trim($this->_request->getPost('companyThatPeople')));
            $field['companyThatPeopleMobile'] = $filter->filter(trim($this->_request->getPost('companyThatPeopleMobile')));
            $field['isHaveSocialInsurance'] = $filter->filter(trim($this->_request->getPost('isHaveSocialInsurance')));
            $field['socialInsuranceNum'] = $filter->filter(trim($this->_request->getPost('socialInsuranceNum')));
            if (empty($memberBaseRow)) {
                $memberBaseModel->insert($field);
            } else {
                $memberBaseModel->update($field, "`userName` = '{$row['userName']}'");
            }
            echo $this->view->message('个人详细资料修改成功！') ;
            exit;
        }

        //资产负债信息
        if ($this->_request->isPost() && $formClass == 'balance') {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['userName'] = $row['userName'];
            $field['houseType'] = $filter->filter(trim($this->_request->getPost('houseType')));
            $field['houseAddress'] = $filter->filter(trim($this->_request->getPost('houseAddress')));
            $field['houseArea'] = $filter->filter(trim($this->_request->getPost('houseArea')));
            $field['houseBuildTime'] = $filter->filter(trim($this->_request->getPost('houseBuildTime')));
            $field['houseOwnership1'] = $filter->filter(trim($this->_request->getPost('houseOwnership1')));
            $field['houseOwnership1Value'] = $filter->filter(trim($this->_request->getPost('houseOwnership1Value')));
            $field['houseOwnership2'] = $filter->filter(trim($this->_request->getPost('houseOwnership2')));
            $field['houseOwnership2Value'] = $filter->filter(trim($this->_request->getPost('houseOwnership2Value')));
            $field['houseMortgageBalanceAmount'] = is_numeric($this->_request->getPost('houseMortgageBalanceAmount')) ? $this->_request->getPost('houseMortgageBalanceAmount') : 0;
            $field['houseMortgageRepaymentAmount'] = is_numeric($this->_request->getPost('houseMortgageRepaymentAmount')) ? $this->_request->getPost('houseMortgageRepaymentAmount') : 0;
            $field['houseRentAddress'] = $filter->filter(trim($this->_request->getPost('houseRentAddress')));
            $field['houseRentAmount'] = is_numeric($this->_request->getPost('houseRentAmount')) ? $this->_request->getPost('houseRentAmount') : 0;
            $field['isHaveAuto'] = $filter->filter(trim($this->_request->getPost('isHaveAuto')));
            $field['autoBrandModel'] = $filter->filter(trim($this->_request->getPost('autoBrandModel')));
            $field['autoUsedTime'] = $filter->filter(trim($this->_request->getPost('autoUsedTime')));
            $field['autoDrivingLicense'] = $filter->filter(trim($this->_request->getPost('autoDrivingLicense')));
            $field['autoIsMortgage'] = $filter->filter(trim($this->_request->getPost('autoIsMortgage')));
            $field['autoMortgageBalanceAmount'] = is_numeric($this->_request->getPost('autoMortgageBalanceAmount')) ? $this->_request->getPost('autoMortgageBalanceAmount') : 0;
            $field['autoMortgageRepaymentAmount'] = is_numeric($this->_request->getPost('autoMortgageRepaymentAmount')) ? $this->_request->getPost('autoMortgageRepaymentAmount') : 0;
            $field['creditCardNum'] = intval($this->_request->getPost('creditCardNum'));
            $field['creditCardAmount'] = is_numeric($this->_request->getPost('creditCardAmount')) ? $this->_request->getPost('creditCardAmount') : 0;
            $field['creditCardUsedAmount'] = is_numeric($this->_request->getPost('creditCardUsedAmount')) ? $this->_request->getPost('creditCardUsedAmount') : 0;
            $field['creditCardIsHaveExpired'] = $filter->filter(trim($this->_request->getPost('creditCardIsHaveExpired')));
            $field['wageIncome'] = is_numeric($this->_request->getPost('wageIncome')) ? $this->_request->getPost('wageIncome') : 0;
            $field['otherIncome'] = is_numeric($this->_request->getPost('otherIncome')) ? $this->_request->getPost('otherIncome') : 0;
            $field['familyIncome'] = is_numeric($this->_request->getPost('familyIncome')) ? $this->_request->getPost('familyIncome') : 0;
            $field['numberOfFamilyMembers'] = intval($this->_request->getPost('numberOfFamilyMembers'));
            $field['liveCost'] = is_numeric($this->_request->getPost('liveCost')) ? $this->_request->getPost('liveCost') : 0;
            if (empty($memberBalanceRow)) {
                $memberBalanceModel->insert($field);
            } else {
                $memberBalanceModel->update($field, "`userName` = '{$row['userName']}'");
            }
            echo $this->view->message('资产负债信息修改成功！') ;
            exit;
        }

        //公司详细资料
        if ($this->_request->isPost() && $formClass == 'enterprise') {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['userName'] = $row['userName'];
            $field['industry'] = $filter->filter(trim($this->_request->getPost('industry')));
            $field['name'] = $filter->filter(trim($this->_request->getPost('name')));
            $field['createTime'] = $filter->filter(trim($this->_request->getPost('createTime')));
            $field['telephone'] = $filter->filter(trim($this->_request->getPost('telephone')));
            $field['premises'] = $filter->filter(trim($this->_request->getPost('premises')));
            $field['monthRent'] = $filter->filter(trim($this->_request->getPost('monthRent')));
            $field['leaseEndTime'] = $filter->filter(trim($this->_request->getPost('leaseEndTime')));
            $field['taxRegistrationCertificate'] = $filter->filter(trim($this->_request->getPost('taxRegistrationCertificate')));
            $field['businessLicenseNumber'] = $filter->filter(trim($this->_request->getPost('businessLicenseNumber')));
            $field['businessLicenseCopyPath'] = $this->__uploadFile('businessLicenseCopy', 'certificateCopy', $row,
            									array('path' => empty($memberEnterpriseRow) ? '' : $memberEnterpriseRow['businessLicenseCopyPath'],
            										'imgWidth' => 600, 'imgHeight' => 400));
            $field['organizationCode'] = $filter->filter(trim($this->_request->getPost('organizationCode')));
            $field['organizationCodeCopyPath'] = $this->__uploadFile('organizationCodeCopy', 'certificateCopy', $row,
            		array('path' => empty($memberEnterpriseRow) ? '' : $memberEnterpriseRow['organizationCodeCopyPath'],
            				'imgWidth' => 400, 'imgHeight' => 300));
            $field['licenseNumberBankAccount'] = $filter->filter(trim($this->_request->getPost('licenseNumberBankAccount')));
            $field['turnoverLastYear'] = $filter->filter(trim($this->_request->getPost('turnoverLastYear')));
            $field['employeesNumber'] = $filter->filter(trim($this->_request->getPost('employeesNumber')));
            $field['legalPersonName'] = $filter->filter(trim($this->_request->getPost('legalPersonName')));
            $field['legalPersonIDCard'] = $filter->filter(trim($this->_request->getPost('legalPersonIDCard')));
            $field['legalPersonIDCardCopyPath'] = $this->__uploadFile('legalPersonIDCardCopy', 'certificateCopy', $row,
            		array('path' => empty($memberEnterpriseRow) ? '' : $memberEnterpriseRow['legalPersonIDCardCopyPath'],
            				'imgWidth' => 400, 'imgHeight' => 300));
            if (empty($memberEnterpriseRow)) {
                $memberEnterpriseModel->insert($field);
            } else {
                $memberEnterpriseModel->update($field, "`userName` = '{$row['userName']}'");
            }
            echo $this->view->message('公司详细资料修改成功！') ;
            exit;
        }

        //联系方式
        if ($this->_request->isPost() && $formClass == 'contact') {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['userName'] = $row['userName'];
            $field['qq'] = $filter->filter(trim($this->_request->getPost('qq')));
            $field['msn'] = $filter->filter(trim($this->_request->getPost('msn')));
            $field['wangwang'] = $filter->filter(trim($this->_request->getPost('wangwang')));
            $field['contact1'] = $filter->filter(trim($this->_request->getPost('contact1')));
            $field['contact1Relationships'] = $filter->filter(trim($this->_request->getPost('contact1Relationships')));
            $field['contact1Telephone'] = $filter->filter(trim($this->_request->getPost('contact1Telephone')));
            $field['contact1Mobile'] = $filter->filter(trim($this->_request->getPost('contact1Mobile')));
            $field['contact2'] = $filter->filter(trim($this->_request->getPost('contact2')));
            $field['contact2Relationships'] = $filter->filter(trim($this->_request->getPost('contact2Relationships')));
            $field['contact2Telephone'] = $filter->filter(trim($this->_request->getPost('contact2Telephone')));
            $field['contact2Mobile'] = $filter->filter(trim($this->_request->getPost('contact2Mobile')));
            $field['contact3'] = $filter->filter(trim($this->_request->getPost('contact3')));
            $field['contact3Relationships'] = $filter->filter(trim($this->_request->getPost('contact3Relationships')));
            $field['contact3Telephone'] = $filter->filter(trim($this->_request->getPost('contact3Telephone')));
            $field['contact3Mobile'] = $filter->filter(trim($this->_request->getPost('contact3Mobile')));
            $field['contact4'] = $filter->filter(trim($this->_request->getPost('contact4')));
            $field['contact4Relationships'] = $filter->filter(trim($this->_request->getPost('contact4Relationships')));
            $field['contact4Telephone'] = $filter->filter(trim($this->_request->getPost('contact4Telephone')));
            $field['contact4Mobile'] = $filter->filter(trim($this->_request->getPost('contact4Mobile')));

            if (empty($memberContactRow)) {
                $memberContactModel->insert($field);
            } else {
                $memberContactModel->update($field, "`userName` = '{$row['userName']}'");
            }
            echo $this->view->message('联系方式修改成功！') ;
            exit;
        }

        //配偶资料
        if ($this->_request->isPost() && $formClass == 'spouse') {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['userName'] = $row['userName'];
            $field['name'] = $filter->filter(trim($this->_request->getPost('name')));
            $field['idCardNumber'] = $filter->filter(trim($this->_request->getPost('idCardNumber')));
            $field['idCardAddress'] = $filter->filter(trim($this->_request->getPost('idCardAddress')));
            $field['liveAddress'] = $filter->filter(trim($this->_request->getPost('liveAddress')));
            $field['preTaxIncome'] = $filter->filter(trim($this->_request->getPost('preTaxIncome')));
            $field['mobile'] = $filter->filter(trim($this->_request->getPost('mobile')));
            $field['company'] = $filter->filter(trim($this->_request->getPost('company')));
            $field['workOffice'] = $filter->filter(trim($this->_request->getPost('workOffice')));
            $field['workTelephone'] = $filter->filter(trim($this->_request->getPost('workTelephone')));
            $field['companyAddress'] = $filter->filter(trim($this->_request->getPost('companyAddress')));
            $field['employeesNumber'] = $filter->filter(trim($this->_request->getPost('employeesNumber')));

            if (empty($memberSpouseRow)) {
                $memberSpouseModel->insert($field);
            } else {
                $memberSpouseModel->update($field, "`userName` = '{$row['userName']}'");
            }
            echo $this->view->message('配偶资料修改成功！') ;
            exit;
        }

        //资料审查
        if ($this->_request->isPost() && $formClass == 'borrowersStatus') {
            $field = array();
            if ($row['borrowersStatus'] == '1' || $row['borrowersStatus'] == '4') {
                $field['borrowersStatus'] = '2';
                $field['initApproved'] = '2';
                $memberLoginModel->update($field, "`userName` = '{$row['userName']}'");
                echo $this->view->message('提交成功，我们会尽快审查你的资料。') ;
                exit;
            }
        }

        //资料审查
        if ($this->_request->isPost() && $formClass == 'lendersStatus') {
            $field = array();
            if ($row['lendersStatus'] == '1' || $row['lendersStatus'] == '4') {
                $field['lendersStatus'] = '2';
                $memberLoginModel->update($field, "`userName` = '{$row['userName']}'");
                echo $this->view->message('提交成功，我们会尽快审查你的资料。') ;
                exit;
            }
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
        if ($this->_request->isPost()) {
            $userName = trim($this->_request->getPost('userName'));
            $password = trim($this->_request->getPost('password'));
            $timeToLive = intval($this->_request->getPost('timeToLive'));
            $backUrl = trim($this->_request->get('backUrl')) != '' ? urldecode(trim($this->_request->get('backUrl'))) : NULL;

            $memberLoginModel = new Application_Model_MemberLogin();
            $status = $memberLoginModel->login($userName, $password, $timeToLive);
            if ($status == 1) {
                echo $this->view->message('用户名或密码错误！') ;
                exit;
            } else if ($status == 1) {
                echo $this->view->message('用户名或密码错误！') ;
                exit;
            } else if ($status == 2) {
                echo $this->view->message('你的帐号还没有激活！') ;
                exit;
            } else if ($status == 3) {
                echo $this->view->message('你的帐号已经关闭，如有问题请与管理员联系！') ;
                exit;
            } else {
                if (empty($backUrl)) {
                    redirect($this->view->projectUrl(array('module'=>'member', 'controller'=>'index', 'action'=>'index')));
                } else {
                    redirect($backUrl);
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
        redirect($this->view->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'login')));
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
        $time = intval($this->_request->get('time'));
        $code = trim($this->_request->get('code'));

        $returnUrl = $this->view->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'forgot-password'));
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
        }

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
    
    /**
     * 注册
     *
     * @return void
     */
    public function registerAction()
    {   
    	$textModel = new Application_Model_Text();
    	$this->view->agreement = $textModel->content(3);
    	
    	if ($this->_request->isPost()) {
    		$memberModel = new Application_Model_Member();
    		$filter = new Zend_Filter_StripTags();
    		$field = array();
    		$field['userName'] = trim($filter->filter($this->_request->getPost('userName')));
    		$field['password'] = $password2 = trim($this->_request->getPost('password'));
    		$field['email'] = trim($filter->filter($this->_request->getPost('email')));
    		$field['userType'] = $this->_request->getPost('userType');
    
    		$field['name'] = '';
    		$field['mobile'] = '';
    		$field['idCardNumber'] = '';
    		$field['idCardAddress'] = '';
    
    		$field['regTime'] = time();
    		$field['regIp'] = getClientIP();
    		$field['status'] = 1;
    		$field['borrowersStatus'] = 1;
    		$field['lendersStatus'] = 1;
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
    		if ($field['email'] == '') {
    			echo $this->view->message('邮件不能为空！') ;
    			exit;
    		}
    		if ($memberModel->emailIsExists($field['email'])) {
    			echo $this->view->message("邮件地址“{$field['email']}”已经存在，请重新填写！") ;
    			exit;
    		}
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