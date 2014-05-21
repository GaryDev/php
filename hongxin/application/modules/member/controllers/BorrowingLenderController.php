<?php

/**
 * 借出的款
 *
 * @author cdlei
 */

require 'CommonController.php';

class Member_BorrowingLenderController extends Member_CommonController
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
        $borrowingDetailModel = new Application_Model_BorrowingDetail();

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

        $wheres[] = "
            `code` IN (
                SELECT `borrowingCode` FROM `{$borrowingDetailModel->getTableName()}`
                WHERE `userName` = {$this->_model->getAdapter()->quote(Application_Model_MemberLogin::getLoginedUserName())}
            )
        ";
        $wheres[] = "`status` IN ('2', '3')";

        $urls = $vars;
        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT * FROM `{$this->_model->getTableName()}` {$where} ORDER BY `id` DESC";
        $dbPaginator = new Application_Model_DbPaginator($sql, $pageSize, $pageNo, 2);
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
     * 成功列表
     * 
     * @return void
     */
    public function completeAction()
    {
        $borrowingDetailModel = new Application_Model_BorrowingDetail();
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

        $wheres[] = "
            `code` IN (
                SELECT `borrowingCode` FROM `{$borrowingDetailModel->getTableName()}`
                WHERE `userName` = {$this->_model->getAdapter()->quote(Application_Model_MemberLogin::getLoginedUserName())}
            )
        ";
        $wheres[] = "`status` IN ('4', '5')";

        $urls = $vars;
        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT * FROM `{$this->_model->getTableName()}` {$where} ORDER BY `id` DESC";
         $dbPaginator = new Application_Model_DbPaginator($sql, $pageSize, $pageNo, 2);
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
     * 取消列表
     * 
     * @return void
     */
    public function cancelAction()
    {
        $borrowingDetailModel = new Application_Model_BorrowingDetail();
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

        $wheres[] = "
            `code` IN (
                SELECT `borrowingCode` FROM `{$borrowingDetailModel->getTableName()}`
                WHERE `userName` = {$this->_model->getAdapter()->quote(Application_Model_MemberLogin::getLoginedUserName())}
            )
        ";
        $wheres[] = "`status` IN ('6')";

        $urls = $vars;
        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT * FROM `{$this->_model->getTableName()}` {$where} ORDER BY `id` DESC";
         $dbPaginator = new Application_Model_DbPaginator($sql, $pageSize, $pageNo, 2);
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
     * 取消列表
     * 
     * @return void
     */
    public function viewAction()
    {
        $borrowingModel = new Application_Model_BorrowingDetail();
        $repaymentModel = new Application_Model_Repayment();
        $repaymentDetailModel = new Application_Model_RepaymentDetail();

        $code = trim($this->_request->get('code'));

        $row = $this->_model->fetchRow("`code` = {$this->_model->getAdapter()->quote($code)}");
        if (empty($row)) {
            echo $this->view->message('记录不存在，请返回重试！', $this->view->projectUrl(array('controller'=>'index', 'action'=>'index'))) ;
            exit;
        }
        $select = $repaymentDetailModel->select(false)
                 ->setIntegrityCheck(false)
                 ->from(array('rd'=>$repaymentDetailModel->getTableName()), array('*'))
                 ->joinLeft(array('r'=>$repaymentModel->getTableName()), "(`r`.`borrowingCode` = `rd`.`borrowingCode` AND `r`.`numberOfCycles` = `rd`.`numberOfCycles`)", array('status', 'repaymentTime', 'addTime', 'currentCyclesRepaymentDeadline'))
                 ->order('rd.id ASC')
                 ->where("`rd`.`userName` = {$this->_model->getAdapter()->quote(Application_Model_MemberLogin::getLoginedUserName())} AND `rd`.`borrowingCode` = '{$row['code']}'")
                 ;
        
        $repaymentDetailRows = $repaymentDetailModel->fetchAll($select);


        $this->view->row = $row;
        $this->view->repaymentDetailRows = $repaymentDetailRows;

    }
    
}