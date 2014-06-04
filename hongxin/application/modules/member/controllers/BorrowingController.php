<?php

/**
 * 借款
 *
 * @author cdlei
 */

require 'CommonController.php';

class Member_BorrowingController extends Member_CommonController
{
    /**
     * 初始化
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_Borrowing();
    }

    /**
     * 投标中列表
     * 
     * @return void
     */
    public function inProgressAction()
    {
        //获取当前页码
        $pageSize = 15;
        $pageNo = intval($this->_request->get('pageNo'));
        if (empty($pageNo)) {
            $pageNo = 1;
        }

        //设置URL模板以及条件
        $urls = array();
        $wheres = array();
        $vars = array();

        $vars['code'] = trim($this->_request->get('code'));
        if ($vars['code'] != '') {
            $wheres[] = "`code` = {$this->_model->getAdapter()->quote($vars['code'])}";
        }

        $wheres[] = "`userName` = {$this->_model->getAdapter()->quote(Application_Model_MemberLogin::getLoginedUserName())}";
        $wheres[] = "`status` IN ('1', '2', '3')";

        $urls = $vars;
        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT * FROM `{$this->_model->getTableName()}` {$where} ORDER BY `id` DESC";
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
        $this->view->vars = $vars;
    }

    /**
     * 还款中列表
     * 
     * @return void
     */
    public function inProgressRepaymentAction()
    {
        //获取当前页码
        $pageSize = 15;
        $pageNo = intval($this->_request->get('pageNo'));
        if (empty($pageNo)) {
            $pageNo = 1;
        }

        //设置URL模板以及条件
        $urls = array();
        $wheres = array();
        $vars = array();

        $vars['code'] = trim($this->_request->get('code'));
        if ($vars['code'] != '') {
            $wheres[] = "`code` = {$this->_model->getAdapter()->quote($vars['code'])}";
        }

        $wheres[] = "`userName` = {$this->_model->getAdapter()->quote(Application_Model_MemberLogin::getLoginedUserName())}";
        $wheres[] = "`status` IN ('4')";

        $urls = $vars;
        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT * FROM `{$this->_model->getTableName()}` {$where} ORDER BY `id` DESC";
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
        $this->view->vars = $vars;
    }

    /**
     * 成功/作废列表
     * 
     * @return void
     */
    public function completeCancelAction()
    {
        //获取当前页码
        $pageSize = 15;
        $pageNo = intval($this->_request->get('pageNo'));
        if (empty($pageNo)) {
            $pageNo = 1;
        }

        //设置URL模板以及条件
        $urls = array();
        $wheres = array();
        $vars = array();

        $vars['code'] = trim($this->_request->get('code'));
        if ($vars['code'] != '') {
            $wheres[] = "`code` = {$this->_model->getAdapter()->quote($vars['code'])}";
        }

        $wheres[] = "`userName` = {$this->_model->getAdapter()->quote(Application_Model_MemberLogin::getLoginedUserName())}";
        $wheres[] = "`status` IN ('5', '6')";

        $urls = $vars;
        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT * FROM `{$this->_model->getTableName()}` {$where} ORDER BY `id` DESC";
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
        $this->view->vars = $vars;
    }

    /**
     * 查看借款信息
     * 
     * @return void
     */
    public function viewAction()
    {
        $borrowingDetailModel = new Application_Model_BorrowingDetail();
        $accountDetailsModel = new Application_Model_AccountDetails();
        $repaymentModel = new Application_Model_Repayment();

        $code = trim($this->_request->get('code'));

        $row = $this->_model->fetchRow("`userName` = {$this->_model->getAdapter()->quote(Application_Model_MemberLogin::getLoginedUserName())} AND `code` = {$this->_model->getAdapter()->quote($code)}");
        if (empty($row)) {
            echo $this->view->message('记录不存在，请返回重试！', $this->view->projectUrl(array('controller'=>'index', 'action'=>'index'))) ;
            exit;
        }
        $borrowingDetailRows = $borrowingDetailModel->fetchAll("`borrowingCode` = '{$row['code']}'", "id ASC");
        $repaymentRows = $repaymentModel->fetchAll("`borrowingCode` = '{$row['code']}'", "id ASC");

        //获取用户可用余额
        $surplusAvailableAmount = $accountDetailsModel->getSurplusAvailableAmount(Application_Model_MemberLogin::getLoginedUserName());

        //获取当最近一次应还款金额
        $currentRepaymentAmount = 0;
        foreach($repaymentRows as $repaymentRow) {
            if ($repaymentRow['status'] == '1') {
                $currentRepaymentAmount = $repaymentRow['principal'] + $repaymentRow['interest'];
                break;
            }
        }

        //获取总共未还金额
        $allNoRepaymentAmount = 0;
        foreach($repaymentRows as $repaymentRow) {
            if ($repaymentRow['status'] == '1') {
                $allNoRepaymentAmount += $repaymentRow['principal'] + $repaymentRow['interest'];
            }
        }

        $this->view->row = $row;
        $this->view->borrowingUnitMin = $this->_configs['project']['borrowingUnitMin'];
        $this->view->borrowingDetailRows = $borrowingDetailRows;
        $this->view->repaymentRows = $repaymentRows;
        $this->view->surplusAvailableAmount = $surplusAvailableAmount;
        $this->view->currentRepaymentAmount = $currentRepaymentAmount;
        $this->view->allNoRepaymentAmount = $allNoRepaymentAmount;

        if ($this->_request->isPost()) {
            if ($row['status'] != '4') {
                echo $this->view->message('此标状态不在还款中。');
                exit;
            }
            $repaymentHowType = $this->_request->get('repaymentHowType');
            if ($repaymentHowType == '1') {//还完当前
                if ($currentRepaymentAmount > $surplusAvailableAmount) {
                    echo $this->view->message('还款失败，你的余额不足。');
                    exit;
                } else {
                    $repaymentModel->repayment(Application_Model_MemberLogin::getLoginedUserName(), $code, $from = 'member', 0, $repaymentRows);
                    echo $this->view->message('还款成功。');
                    exit;
                }
            } else if ($repaymentHowType == '2') {//还完所有
                if ($allNoRepaymentAmount > $surplusAvailableAmount) {
                    echo $this->view->message('还款失败，你的余额不足。');
                    exit;
                } else {
                    $repaymentModel->repayment(Application_Model_MemberLogin::getLoginedUserName(), $code, $from = 'member', 1, $repaymentRows);
                    echo $this->view->message('你的所有借款已经还款完毕。');
                    exit;
                }
            }
        }
    }

    /**
     * 填写借款表单
     * 
     * @return void
     */
    public function applyAction()
    {
        $memberLoginModel = new Application_Model_MemberLogin();
        //$memberBorrowingAvailableAmountDetailsModel = new Application_Model_MemberBorrowingAvailableAmountDetails();
        
        $memberType = Application_Model_MemberLogin::getLoginedUserType();
        if ($memberType != 'C') {
            echo $this->view->message('您是个人会员，不能发布融资信息！', $this->view->projectUrl(array('module'=>'default', 'controller'=>'borrowing', 'action'=>'index')));
            exit;
        }
        
        $memberRow = $memberLoginModel->getLoginedRow();
        if ($memberRow['borrowersStatus'] != 3) {
            echo $this->view->message('你的资料还没通过审核，暂不能申请！', $this->view->projectUrl(array('controller'=>'user', 'action'=>'index'))) ;
            exit;
        }
        /*
        if ($memberRow['borrowingCreditIsOpen'] == 0 && $memberRow['borrowingRecommendIsOpen'] == 0) {
            echo $this->view->message('你的账户借款类型没有开启，请与管理员联系！', $this->view->projectUrl(array('controller'=>'user', 'action'=>'index'))) ;
            exit;
        }
        

        //费用列表
        $creditFeeList = array();
        for($i = 1; $i <= 12; $i++){
            $creditFeeList[$i] = $this->_model->getFee(Application_Model_MemberLogin::getLoginedUserName(), 1, 'credit', $i, '1');
        }
        $recommendFeeList = array();
        for($i = 1; $i <= 12; $i++){
            $recommendFeeList[$i] = $this->_model->getFee(Application_Model_MemberLogin::getLoginedUserName(), 1, 'recommend', $i, '2');
        }

        //获取额度
        $creditAmount = $memberBorrowingAvailableAmountDetailsModel->getSurplusAmount(Application_Model_MemberLogin::getLoginedUserName(), 'credit');
        $recommendAmount = $memberBorrowingAvailableAmountDetailsModel->getSurplusAmount(Application_Model_MemberLogin::getLoginedUserName(), 'recommend');
*/
        //获取是否没有审核过的
        $isNoCheck = false; //$this->_model->getIsNoCheck(Application_Model_MemberLogin::getLoginedUserName());
        /*if ($isNoCheck) {
        	echo $this->view->message('你尚未审核的申请，暂不能提交新的申请。！', $this->view->projectUrl(array('controller'=>'user', 'action'=>'index'))) ;
        	exit;
        }*/
        

        $this->view->banks = explode(",", $this->_configs['project']['bankTypes']);
        //$this->view->maxYearRate = $this->_configs['project']['pbcYearRate'] * 4;//最大年利率
        $this->view->maxYearRate = $this->_configs['project']['pbcYearRate']; //参考年利率
        //$this->view->borrowingMin = $this->_configs['project']['borrowingMin'];//单笔借款最少金额
        $this->view->memberRow = $memberRow;
        //$this->view->creditFeeList = $creditFeeList;//信用借款费用列表
        //$this->view->recommendFeeList = $recommendFeeList;//推荐借款费用列表
        //$this->view->creditAmount = $creditAmount;//用户信用借款最大额度
        //$this->view->recommendAmount = $recommendAmount;//用户推荐借款最大额度
        //$this->view->borrowingUnitEnterMax1 = $this->_configs['project']['borrowingUnitEnterMax1'];//投标限额-最小填写
        //$this->view->borrowingUnitEnterMax2 = $this->_configs['project']['borrowingUnitEnterMax2'];//投标限额-最大填写
        //$this->view->isNoCheck = $isNoCheck;

        if ($this->_request->isPost() && !$isNoCheck) {
            $filter = new Zend_Filter_StripTags();
            $field = array();
            $field['userName'] = Application_Model_MemberLogin::getLoginedUserName();
            $field['type'] = 'recommend';
            $field['repaymentType'] = 3;	//保息固定
			$field['repaymentBank'] = $filter->filter(trim($this->_request->get('repayBank')));
            $field['title'] = $this->_configs['project']['productTitle']; //$filter->filter(trim($this->_request->get('title')));
            $field['code'] = date('YmdHis') . rand(1000, 9999);
            $field['amount'] = is_numeric(trim($this->_request->get('amount'))) ? trim($this->_request->get('amount')) : 0;
            $yearInterestRate = is_numeric(trim($this->_request->get('yearInterestRate'))) ? trim($this->_request->get('yearInterestRate')) : 0;
            $field['yearInterestRate'] = $yearInterestRate;
            $field['borrowUnit'] = $this->_configs['project']['borrowingUnitMin'];
            $field['amountMinUnit'] = $field['borrowUnit'];	// 最小投资份数
            $field['amountMaxUnit'] = $field['amount'] / $field['borrowUnit']; // 最大投资份数
            $field['amountUnit'] = $field['amountMaxUnit'];
            $field['startTime'] = time();												// 募集开始时间
            $field['endTime'] = strtotime($filter->filter(trim($this->_request->get('applyEndDate')))); // 募集截止时间
            $field['ticketEndTime'] = strtotime($filter->filter(trim($this->_request->get('ticketEndDate'))));	//项目到期时间
            $field['repayEndTime'] = strtotime($filter->filter(trim($this->_request->get('repayEndTime'))));	//最迟还款日期
            $field['deadline'] = (int)((($field['ticketEndTime'] - $field['startTime'])/86400) + 1);	   // 期限
            $field['notes'] = $filter->filter(trim($this->_request->get('notes')));
            $field['ticketCopyPath'] = $this->__uploadFile('ticketCopy', 'ticketCopy', $memberRow, array('imgWidth' => 210, 'imgHeight' => 280));
            $field['status'] = '1';
            $field['statusMessage'] = '';
            $field['statusUpdateTime'] = 0;
            $field['addTime'] = time();
            //var_dump($field);die();
            $this->_model->add($field);
            echo $this->view->message('提交成功，请等待审核！', $this->view->projectUrl(array('action'=>'in-progress'))) ;
            exit;
        }
    }

    /**
     * 获取费用
     * 
     * @return void
     */
    public function getFeeAction()
    {
        $amount = is_numeric(trim($this->_request->get('amount'))) ? trim($this->_request->get('amount')) : 0;
        $type = trim($this->_request->get('type'));
        $month = trim($this->_request->get('month'));
        $repaymentType = trim($this->_request->get('repaymentType'));

        $fee = $this->_model->getFee(Application_Model_MemberLogin::getLoginedUserName(), $amount, $type, $month, $repaymentType);
        echo $fee;
        exit;
    }
}