<?php

/**
 * 借款额度变化明细
 *
 * @author cdlei
 */

require 'CommonController.php';

class Admin_MemberBorrowingAvailableAmountDetailsController extends Admin_CommonController
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
    public function indexAction()
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
        $vars['userName'] = trim($this->_request->get('userName'));
        if ($vars['type'] != '') {
            $wheres[] = "`type` = {$this->_model->getAdapter()->quote($vars['type'])}";
        }
        if ($vars['userName'] != '') {
            $wheres[] = "`userName` = {$this->_model->getAdapter()->quote($vars['userName'])}";
        }

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
     * 更新
     * 
     * @return void
     */
    public function updateAction()
    {
        $time = time();
        $memberModel = new Application_Model_Member();
        $id = intval($this->_request->get('id'));
        $backUrl = urldecode($this->_request->get('backUrl'));

        $row = $this->_model->fetchRow("`id` = {$id}"); 
        if (empty($row)) {
            echo $this->view->message('记录不存在，请返回重试！', $backUrl) ;
            exit;
        }
        $row['statusLogRows'] = trim($row['statusLog']) != '' ? Zend_Json::decode($row['statusLog']) : array();
        $memberRow = $memberModel->fetchRow("`userName` = {$memberModel->getAdapter()->quote($row['userName'])}");
        $this->view->row = $row;
        $this->view->memberRow = $memberRow;

        if ($this->_request->isPost()) {
            $filter = new Zend_Filter_StripTags();
            $field = array();
            $field['status'] = intval(trim($this->_request->getPost('status')));

            if ($field['status'] > $row['status'] && !($field['status'] == '3' && $row['status'] == '2')) {
                $status = array('1'=>'已提交待审核', '2'=>'已审核通过', '3'=>'已经审核未通过(作废)');
                $log = trim($row['statusLog']) != '' ? Zend_Json::decode($row['statusLog']) : array();
                $log[] = array('previousStatus'=>$status[$row['status']], 'currentStatus'=>$status[$field['status']], 'user'=>$this->_currentUserRow['userName'], 'time'=>date('Y-m-d H:i:s'));
                $field['statusLog'] = Zend_Json::encode($log);

                $this->_model->update($field, "`id` = {$id}");
                echo $this->view->message('状态修改成功！') ;
                exit;
            } else {
                echo $this->view->message('状态没有被修改！') ;
                exit;
            }
        }
    }

    /**
     * 添加
     * 
     * @return void
     */
    public function addAction()
    {
        if ($this->_request->isPost()) {
            $amount = intval($this->_request->get('amount'));
            $userName = trim($this->_request->get('userName'));
            $type = trim($this->_request->get('type'));

            $filter = new Zend_Filter_StripTags();
            $field = array();
            $field['userName'] = Application_Model_MemberLogin::getLoginedUserName();
            $field['amount'] = $amount;
            $field['addTime'] = time();
            $field['status'] = '2';
            $field['statusLog'] = Zend_Json::encode(array(0=>array('previousStatus'=>'', 'currentStatus'=>'已审核通过', 'user'=>$this->_currentUserRow['userName'], 'time'=>date('Y-m-d H:i:s'))));
            $field['type'] = $type;
            $field['notes'] = $filter->filter(trim($this->_request->get('notes')));

            if ($amount <= 0) {
                echo $this->view->message('提交失败，金额填写错误。');
                exit;
            }
            $memberModel = new Application_Model_Member();
            $memberRow = $memberModel->fetchRow("`userName` = " . $memberModel->getAdapter()->quote($userName));
            if (empty($memberRow)) {
                echo $this->view->message('提交失败，会员用户名不存在！');
                exit;
            } else if ($memberRow['borrowersStatus'] != 3) {
                echo $this->view->message('借贷资料还没通过审核，暂不能添加！');
                exit;
            } else if ($memberRow['borrowersStatus'] != 3) {
                echo $this->view->message('借贷资料还没通过审核，暂不能添加！');
                exit;
            } else if ($memberRow['borrowingCreditIsOpen'] == 0 && $memberRow['borrowingRecommendIsOpen'] == 0) {
                echo $this->view->message('账户借款类型没有开启！');
                exit;
            } else if ($this->_model->getIsNoCheck($userName, $type)) {;
                echo $this->view->message('提交失败，你有一条申请处于待审核状态！');
                exit;
            } else {
                $this->_model->add($field);
                echo $this->view->message('添加成功！');
                exit;
            }
        }
    }

    /**
     * 检查申请VIP会员，返回json格式{'status':0, 'message':'成功'}
     * 
     * @return void
     */
    public function checkAction()
    {
        $memberModel = new Application_Model_Member();
        $type = trim($this->_request->get('type'));
        $userName = trim($this->_request->get('userName'));

        $memberRow = $memberModel->fetchRow("`userName` = " . $memberModel->getAdapter()->quote($userName));
        if (empty($memberRow)) {
            $result = array('status'=>1, 'message'=>'提交失败，会员用户名不存在！');
        } else if ($memberRow['borrowersStatus'] != 3) {
            $result = array('status'=>2, 'message'=>'借贷资料还没通过审核，暂不能添加！');
        } else if ($memberRow['borrowersStatus'] != 3) {
            $result = array('status'=>3, 'message'=>'借贷资料还没通过审核，暂不能添加！');
        } else if ($memberRow['borrowingCreditIsOpen'] == 0 && $memberRow['borrowingRecommendIsOpen'] == 0) {
            $result = array('status'=>4, 'message'=>'账户借款类型没有开启！');
        } else if ($this->_model->getIsNoCheck($userName, $type)) {
            $result = array('status'=>5, 'message'=>'提交失败，你有一条申请处于待审核状态！');
        } else {
            $creditAmount = $this->_model->getSurplusAmount($userName, 'credit');
            $recommendAmount = $this->_model->getSurplusAmount($userName, 'recommend');
            $result = array('status'=>0, 'message'=>'可以添加。');
            if ($memberRow['borrowingCreditIsOpen'] == 1) {
                $result['creditAmount'] = $creditAmount;
            }
            if ($memberRow['borrowingRecommendIsOpen'] == 1) {
                $result['recommendAmount'] = $recommendAmount;
            }
        }
        $this->_helper->getHelper('Json')->sendJson($result);
    }
}