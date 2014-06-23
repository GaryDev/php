<?php

/**
 * 会员
 *
 * @author cdlei
 */

require_once 'CommonController.php';

class Admin_MemberController extends Admin_CommonController
{
    /**
     * 初始化函数
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_Member();
        $this->view->title = "管理中心";
    }

    /**
     * 默认动作
     * 
     * @return void
     */
    public function indexAction()
    {   
        //获取当前页码
        $pageSize = 20;
        $pageNo = intval($this->_request->get('pageNo'));
        if (empty($pageNo)) {
            $pageNo = 1;
        }

        //设置URL模板以及条件
        $urls = array();
        $wheres = array();
        $vars = array();

        $vars['userName'] = trim($this->_request->get('userName'));
        $vars['mobile'] = trim($this->_request->get('mobile'));
        $vars['email'] = trim($this->_request->get('email'));
        $vars['status'] = intval($this->_request->get('status'));
        if ($vars['userName'] != '') {
            $wheres[] = "`userName` = '" . addslashes($vars['userName']) . "'";
        }
        if ($vars['mobile'] != '') {
            $wheres[] = "`mobile` = '" . addslashes($vars['mobile']) . "'";
        }
        if ($vars['email'] != '') {
            $wheres[] = "`email` = '" . addslashes($vars['email']) . "'";
        }
        if ($vars['status']) {
            $wheres[] = "`status` = '{$vars['status']}'";
        }
        
        $vars['type'] = trim($this->_request->get('type'));
        if($vars['type'] != '') {
        	$wheres[] = "`userType` = '" . addslashes($vars['type']) . "'";
        }

        //设置URL模板
        $urls = $vars;
        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT * FROM `{$this->_model->getTableName()}` {$where} ORDER BY `id` desc";
        $dbPaginator = new Application_Model_DbPaginator($sql, $pageSize, $pageNo);
        $recordCount = $dbPaginator->getRecodCount();

        //获取分页html字符
        Zend_Loader::loadClass('Project_Paginator');
        $paginator = new Project_Paginator($recordCount, $pageSize, $pageNo);
        $paginator->urlTemplateContent = $urlTemplate;
        $rows = $dbPaginator->getRows();
        
        foreach($rows as $key=>$row) {
            if (!empty($row['avatarPath'])) {
                $row['avatarUrl'] = $this->_configs['project']['memberAvatarBaseUrl'] . $row['avatarPath'];
            } else {
                $row['avatarUrl'] = $this->_configs['project']['memberAvatarDefaultUrl'];
            }
            $rows[$key] = $row;
        }

        //分配view(分页处理后的记录集以及分页HTML字符)
        $this->view->pageString = $paginator->getPageString();
        $this->view->rows = $rows;
        $urls['pageNo'] = $pageNo;
        $this->view->pageUrl = $this->view->projectUrl($urls);
        $this->view->vars = $vars;
    }

    /**
     * 更新
     * 
     * @return void
     */
    public function updateAction()
    {
        $id = intval($this->_request->get('id'));
        $backUrl = urldecode($this->_request->get('backUrl'));

        $memberBalanceModel = new Application_Model_MemberBalance();
        $memberBaseModel = new Application_Model_MemberBase();
        $memberContactModel = new Application_Model_MemberContact();
        $memberEnterpriseModel = new Application_Model_MemberEnterprise();
        $memberSpouseModel = new Application_Model_MemberSpouse();

        $row = $this->_model->fetchRow("`id` = {$id}"); 
        if (empty($row)) {
            echo $this->view->message('记录不存在，请返回重试！', $backUrl) ;
            exit;
        }
        $row['borrowersStatusLogRows'] = trim($row['borrowersStatusLog']) != '' ? Zend_Json::decode($row['borrowersStatusLog']) : array();
        $row['lendersStatusLogRows'] = trim($row['lendersStatusLog']) != '' ? Zend_Json::decode($row['lendersStatusLog']) : array();
        $row['bankStatusLogRows'] = trim($row['bankStatusLog']) != '' ? Zend_Json::decode($row['bankStatusLog']) : array();
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

        $formClass = $this->_request->get('formClass');
        //账户信息
        if ($this->_request->isPost() && $formClass == 'account') {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['status'] = $filter->filter(trim($this->_request->getPost('status')));
            $field['email'] = $filter->filter(trim($this->_request->getPost('email')));
            $field['password'] = trim($this->_request->getPost('password'));

            if ($field['email'] == '') {
                echo $this->view->message('邮件不能为空！') ;
                exit;
            }
            if ($field['password'] == '') {
                unset($field['password']);
            } else {
                $field['password'] = md5($field['password']);
            }
            if ($this->_model->emailIsExists($field['email'], $id)) {
                echo $this->view->message("邮件地址“{$field['email']}”已经存在，请重新填写！") ;
                exit; 
            }
            $this->_model->update($field, "`id` = {$id}");
            echo $this->view->message('账户信息修改成功！', $backUrl) ;
            exit;
        }

        //银行帐号
        if ($this->_request->isPost() && $formClass == 'bank') {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['bankType'] = $filter->filter(trim($this->_request->getPost('bankType')));
            $field['bankSubbranch'] = $filter->filter(trim($this->_request->getPost('bankSubbranch')));
            $field['bankAccount'] = trim($this->_request->getPost('bankAccount'));

            $field['bankStatus'] = $filter->filter(trim($this->_request->getPost('bankStatus')));

            if ($field['bankStatus'] != $row['bankStatus']) {
                $status = array('1'=>'未提交', '2'=>'待审核', '3'=>'已审核通过', '4'=>'已审核未通过');
                $log = trim($row['bankStatusLog']) != '' ? Zend_Json::decode($row['bankStatusLog']) : array();
                $log[] = array('previousStatus'=>$status[$row['bankStatus']], 'currentStatus'=>$status[$field['bankStatus']], 'user'=>$this->_currentUserRow['userName'], 'time'=>date('Y-m-d H:i:s'));
                $field['bankStatusLog'] = Zend_Json::encode($log);
            }

            $this->_model->update($field, "`id` = {$id}");
            echo $this->view->message('银行帐号修改成功！') ;
            exit;
        }

        //状态信息
        if ($this->_request->isPost() && $formClass == 'borrowersStatus') {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['borrowersStatus'] = $filter->filter(trim($this->_request->getPost('borrowersStatus')));
            $field['borrowingCreditIsOpen'] = $this->_request->getPost('borrowingCreditIsOpen') != NULL ? '1' : '0';
            $field['borrowingRecommendIsOpen'] = $this->_request->getPost('borrowingRecommendIsOpen') != NULL ? '1' : '0';
            
            if ($field['borrowersStatus'] != $row['borrowersStatus']) {
                $status = array('1'=>'未提交', '2'=>'待审核', '3'=>'已审核通过', '4'=>'已审核未通过');
                $log = trim($row['borrowersStatusLog']) != '' ? Zend_Json::decode($row['borrowersStatusLog']) : array();
                $log[] = array('previousStatus'=>$status[$row['borrowersStatus']], 'currentStatus'=>$status[$field['borrowersStatus']], 'user'=>$this->_currentUserRow['userName'], 'time'=>date('Y-m-d H:i:s'));
                $field['borrowersStatusLog'] = Zend_Json::encode($log);
            }

            $this->_model->update($field, "`id` = {$id}");
            echo $this->view->message('借贷资料审核修改成功！') ;
            exit;
        }

        //状态信息
        if ($this->_request->isPost() && $formClass == 'lendersStatus') {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['lendersStatus'] = $filter->filter(trim($this->_request->getPost('lendersStatus')));

            if ($field['lendersStatus'] != $row['lendersStatus']) {
                $status = array('1'=>'未提交', '2'=>'待审核', '3'=>'已审核通过', '4'=>'已审核未通过');
                $log = trim($row['lendersStatusLog']) != '' ? Zend_Json::decode($row['lendersStatusLog']) : array();
                $log[] = array('previousStatus'=>$status[$row['lendersStatus']], 'currentStatus'=>$status[$field['lendersStatus']], 'user'=>$this->_currentUserRow['userName'], 'time'=>date('Y-m-d H:i:s'));
                $field['lendersStatusLog'] = Zend_Json::encode($log);
            }

            $this->_model->update($field, "`id` = {$id}");
            echo $this->view->message('投资资料审核修改成功！') ;
            exit;
        }

        //个人基本资料
        if ($this->_request->isPost() && $formClass == 'accountDetail') {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['name'] = $filter->filter(trim($this->_request->getPost('name')));
            $field['gender'] = $filter->filter(trim($this->_request->getPost('gender')));
            $field['birthday'] = $filter->filter(trim($this->_request->getPost('birthday')));
            $field['mobile'] = $filter->filter(trim($this->_request->getPost('mobile')));
            $field['idCardNumber'] = $filter->filter(trim($this->_request->getPost('idCardNumber')));
            $field['idCardAddress'] = $filter->filter(trim($this->_request->getPost('idCardAddress')));

            if (!preg_match("|^[\d]{4}-[\d]{1,2}-[\d]{1,2}$|", $field['birthday'])) {
                echo $this->view->message('出生日期格式填写错误！') ;
                exit;
            }
            
            $this->_model->update($field, "`id` = {$id}");
            echo $this->view->message('个人基本资料修改成功！', $backUrl) ;
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

        //私营企业主资料
        if ($this->_request->isPost() && $formClass == 'enterprise') {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['userName'] = $row['userName'];
            $field['industry'] = $filter->filter(trim($this->_request->getPost('industry')));
            $field['name'] = $filter->filter(trim($this->_request->getPost('name')));
            $field['createTime'] = $filter->filter(trim($this->_request->getPost('createTime')));
            $field['premises'] = $filter->filter(trim($this->_request->getPost('premises')));
            $field['monthRent'] = $filter->filter(trim($this->_request->getPost('monthRent')));
            $field['leaseEndTime'] = $filter->filter(trim($this->_request->getPost('leaseEndTime')));
            $field['taxRegistrationCertificate'] = $filter->filter(trim($this->_request->getPost('taxRegistrationCertificate')));
            $field['businessLicenseNumber'] = $filter->filter(trim($this->_request->getPost('businessLicenseNumber')));
            $field['organizationCode'] = $filter->filter(trim($this->_request->getPost('organizationCode')));
            $field['licenseNumberBankAccount'] = $filter->filter(trim($this->_request->getPost('licenseNumberBankAccount')));
            $field['turnoverLastYear'] = $filter->filter(trim($this->_request->getPost('turnoverLastYear')));
            $field['employeesNumber'] = $filter->filter(trim($this->_request->getPost('employeesNumber')));

            if (empty($memberEnterpriseRow)) {
                $memberEnterpriseModel->insert($field);
            } else {
                $memberEnterpriseModel->update($field, "`userName` = '{$row['userName']}'");
            }
            echo $this->view->message('私营企业主资料修改成功！') ;
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
    }
    
    public function approveAction()
    {
    	$id = intval($this->_request->get('id'));
    	$backUrl = urldecode($this->_request->get('backUrl'));
    	
    	$memberBalanceModel = new Application_Model_MemberBalance();
    	$memberBaseModel = new Application_Model_MemberBase();
    	$memberContactModel = new Application_Model_MemberContact();
    	$memberEnterpriseModel = new Application_Model_MemberEnterprise();
    	$memberSpouseModel = new Application_Model_MemberSpouse();
    	
    	$row = $this->_model->fetchRow("`id` = {$id}");
    	if (empty($row)) {
    		echo $this->view->message('记录不存在，请返回重试！', $backUrl) ;
    		exit;
    	}
    	$row['borrowersStatusLogRows'] = trim($row['borrowersStatusLog']) != '' ? Zend_Json::decode($row['borrowersStatusLog']) : array();
    	$row['bankStatusLogRows'] = trim($row['bankStatusLog']) != '' ? Zend_Json::decode($row['bankStatusLog']) : array();
    	$memberBalanceRow = $memberBalanceModel->fetchRow("`userName` = '{$row['userName']}'");
    	$memberBaseRow = $memberBaseModel->fetchRow("`userName` = '{$row['userName']}'");
    	$memberContactRow = $memberContactModel->fetchRow("`userName` = '{$row['userName']}'");
    	$memberEnterpriseRow = $memberEnterpriseModel->fetchRow("`userName` = '{$row['userName']}'");
    	
    	$certificateUrl = $this->_configs['project']['certificateCopyBaseUrl'];
    	if (!empty($memberEnterpriseRow['legalPersonIDCardCopyPath'])) {
    		$memberEnterpriseRow['legalPersonIDCardCopyUrl'] = $certificateUrl . $memberEnterpriseRow['legalPersonIDCardCopyPath'];
    	}
    	if (!empty($memberEnterpriseRow['businessLicenseCopyPath'])) {
    		$memberEnterpriseRow['businessLicenseCopyUrl'] = $certificateUrl . $memberEnterpriseRow['businessLicenseCopyPath'];
    	}
    	if (!empty($memberEnterpriseRow['organizationCodeCopyPath'])) {
    		$memberEnterpriseRow['organizationCodeCopyUrl'] = $certificateUrl . $memberEnterpriseRow['organizationCodeCopyPath'];
    	}
    	if (!empty($memberEnterpriseRow['operatorCopyPath'])) {
    		$memberEnterpriseRow['operatorCopyUrl'] = $certificateUrl . $memberEnterpriseRow['operatorCopyPath'];
    	}
    	if (!empty($memberEnterpriseRow['creditCopyPath'])) {
    		$memberEnterpriseRow['creditCopyUrl'] = $certificateUrl . $memberEnterpriseRow['creditCopyPath'];
    	}
    	if (!empty($memberEnterpriseRow['taxCopyPath'])) {
    		$memberEnterpriseRow['taxCopyUrl'] = $certificateUrl . $memberEnterpriseRow['taxCopyPath'];
    	}
    	if (!empty($memberEnterpriseRow['bankCopyPath'])) {
    		$memberEnterpriseRow['bankCopyUrl'] = $certificateUrl . $memberEnterpriseRow['bankCopyPath'];
    	}
    	
    	$memberSpouseRow = $memberSpouseModel->fetchRow("`userName` = '{$row['userName']}'");
    	
    	$this->view->memberVars = $this->_configs['project']['memberVars'];
    	$this->view->row = $row;
    	$this->view->memberBalanceRow = $memberBalanceRow;
    	$this->view->memberBaseRow = $memberBaseRow;
    	$this->view->memberContactRow = $memberContactRow;
    	$this->view->memberEnterpriseRow = $memberEnterpriseRow;
    	$this->view->memberSpouseRow = $memberSpouseRow;
    
    	$formClass = $this->_request->get('formClass');
    	//状态信息
    	if ($this->_request->isPost() && $formClass == 'borrowersStatus') {
    		$field = array();
    		$filter = new Zend_Filter_StripTags();
    		$status = $filter->filter(trim($this->_request->getPost('borrowersStatus')));
    		$field['borrowersStatus'] = $status;
    		if ($field['borrowersStatus'] != $row['borrowersStatus']) {
    			$status = array('1'=>'未提交', '2'=>'审核中', '3'=>'审核通过', '4'=>'审核未通过');
    			$log = trim($row['borrowersStatusLog']) != '' ? Zend_Json::decode($row['borrowersStatusLog']) : array();
    			$log[] = array('previousStatus'=>$status[$row['borrowersStatus']], 'currentStatus'=>$status[$field['borrowersStatus']], 'user'=>$this->_currentUserRow['userName'], 'time'=>date('Y-m-d H:i:s'));
    			$json = Zend_Json::encode($log);
    			$field['borrowersStatusLog'] = $json;
    		}
    	
    		$this->_model->update($field, "`id` = {$id}");
    		echo $this->view->message('资料审核成功！') ;
    		exit;
    	}
    	
    }
    
    public function viewAction()
    {
    	$id = intval($this->_request->get('id'));
    	$backUrl = urldecode($this->_request->get('backUrl'));
    	 
    	$memberBalanceModel = new Application_Model_MemberBalance();
    	$memberBaseModel = new Application_Model_MemberBase();
    	$memberContactModel = new Application_Model_MemberContact();
    	$memberEnterpriseModel = new Application_Model_MemberEnterprise();
    	$memberSpouseModel = new Application_Model_MemberSpouse();
    	 
    	$row = $this->_model->fetchRow("`id` = {$id}");
    	if (empty($row)) {
    		echo $this->view->message('记录不存在，请返回重试！', $backUrl) ;
    		exit;
    	}
    	$row['borrowersStatusLogRows'] = trim($row['borrowersStatusLog']) != '' ? Zend_Json::decode($row['borrowersStatusLog']) : array();
    	$row['finalApprovedLogRows'] = trim($row['finalApprovedLog']) != '' ? Zend_Json::decode($row['finalApprovedLog']) : array();
    	$row['bankStatusLogRows'] = trim($row['bankStatusLog']) != '' ? Zend_Json::decode($row['bankStatusLog']) : array();
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
    }

    /**
     * 删除动作
     * 
     * @return void
     */
    public function deleteAction()
    {
        if ($this->_request->isPost()) {
            $ids = $this->_request->getPost('selectId');
            if (is_array($ids)) {
                foreach($ids as $id) {
                    $this->_model->deleteById($id);
                }
            }
        }
        $backUrl = urldecode($this->_request->get('backUrl'));
        //redirect($backUrl);
        echo $this->view->message('会员删除成功！', $backUrl) ;
        exit;
    }
}