<?php

/**
 * 借款额度变化明细
 *
 * @author cdlei
 */

require 'CommonController.php';

class Member_BorrowingAvailableAmountDetailsController extends Member_CommonController
{
    /**
     * 初始化
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_MemberBorrowingAvailableAmountDetails();
    }

    /**
     * 提现记录列表
     * 
     * @return void
     */
    public function listAction()
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

        $vars['type'] = trim($this->_request->get('type'));
        if ($vars['type'] != '') {
            $wheres[] = "`type` = {$this->_model->getAdapter()->quote($vars['type'])}";
        }

        $wheres[] = "`userName` = {$this->_model->getAdapter()->quote(Application_Model_MemberLogin::getLoginedUserName())}";

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
     * 申请
     * 
     * @return void
     */
    public function applyAction()
    {
        $memberLoginModel = new Application_Model_MemberLogin();
        $memberBorrowingAvailableAmountDetailsModel = new Application_Model_MemberBorrowingAvailableAmountDetails();
        $memberRow = $memberLoginModel->getLoginedRow();
        if ($memberRow['borrowersStatus'] != 3) {
            echo $this->view->message('你的借贷资料还没通过审核，暂不能申请！', $this->view->projectUrl(array('controller'=>'user', 'action'=>'index'))) ;
            exit;
        }
        if ($memberRow['borrowingCreditIsOpen'] == 0 && $memberRow['borrowingRecommendIsOpen'] == 0) {
            echo $this->view->message('你的账户借款类型没有开启，请与管理员联系！', $this->view->projectUrl(array('controller'=>'user', 'action'=>'index'))) ;
            exit;
        }
        $creditAmount = $memberBorrowingAvailableAmountDetailsModel->getSurplusAmount($memberRow['userName'], 'credit');
        $recommendAmount = $memberBorrowingAvailableAmountDetailsModel->getSurplusAmount($memberRow['userName'], 'recommend');
        $this->view->creditAmount = $creditAmount;
        $this->view->recommendAmount = $recommendAmount;
        $this->view->memberRow = $memberRow;

        if ($this->_request->isPost()) {
            $amount = intval($this->_request->get('amount'));

            $filter = new Zend_Filter_StripTags();
            $field = array();
            $field['userName'] = Application_Model_MemberLogin::getLoginedUserName();
            $field['amount'] = $amount;
            $field['addTime'] = time();
            $field['status'] = '1';
            $field['statusLog'] = '';
            $field['type'] = $filter->filter(trim($this->_request->get('type')));
            $field['notes'] = $filter->filter(trim($this->_request->get('notes')));

            if ($amount <= 0) {
                echo $this->view->message('提交失败，金额填写错误。');
                exit;
            } else if ($this->_model->getIsNoCheck(Application_Model_MemberLogin::getLoginedUserName(), $field['type'])) {
                echo $this->view->message('提交失败，你有一条申请处于待审核状态。');
                exit;
            }
            $this->_model->add($field);
            echo $this->view->message('提交成功，请等待审核！');
            exit;
        }
    }

    /**
     * 检查申请VIP会员，返回json格式{'status':0, 'message':'成功'}
     * 
     * @return void
     */
    public function checkAction()
    {
        $type = trim($this->_request->get('type'));
        if ($this->_model->getIsNoCheck(Application_Model_MemberLogin::getLoginedUserName(), $type)) {
            $result = array('status'=>1, 'message'=>'提交失败，你有一条申请处于待审核状态。');
        } else {
            $result = array('status'=>0, 'message'=>'可以申请。');
        }
        $this->_helper->getHelper('Json')->sendJson($result);
    }
}