<?php

/**
 * 会员充值记录
 *
 * @author cdlei
 */

require_once 'CommonController.php';

class Admin_AccountChargeController extends Admin_CommonController
{
    /**
     * 初始化函数
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_AccountCharge();
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
        if ($vars['userName'] != '') {
            $wheres[] = "`userName` = '" . addslashes($vars['userName']) . "'";
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
        $id = intval($this->_request->get('id'));
        $backUrl = urldecode($this->_request->get('backUrl'));
    
        $row = $this->_model->fetchRow("`id` = {$id}"); 
        if (empty($row)) {
            echo $this->view->message('记录不存在，请返回重试！', $backUrl) ;
            exit;
        }
        $row['statusLogRows'] = trim($row['statusLog']) != '' ? Zend_Json::decode($row['statusLog']) : array();
        $this->view->row = $row;

        if ($this->_request->isPost()) {
            $field = array();
            $field['status'] = intval(trim($this->_request->getPost('status')));

            if ($field['status'] > $row['status']) {
                if ($field['status'] == 3) {
                    unset($field['startTime']);
                    unset($field['endTime']);
                }
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
     * 管理员充值
     * 
     * @return void
     */
    public function addAction()
    {
        if ($this->_request->isPost()) {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['userName'] = $filter->filter(trim($this->_request->getPost('userName')));
            $field['type'] = '3';
            $field['from'] = '客服充值';
            $field['serialNumber'] = '';
            $field['paymentTime'] = date('Y-m-d');
            $field['status'] = '2';
            $field['amount'] = intval(trim($this->_request->getPost('amount')));
            $field['addTime'] = time();
            $field['notes'] = $filter->filter(trim($this->_request->getPost('notes')));

            if ($field['userName'] == '') {
                echo $this->view->message('用户名不能为空！');
                exit;
            }
            $memberModel = new Application_Model_Member();
            if (!$memberModel->isExists($field['userName'])) {
                echo $this->view->message('用户名不存在！');
                exit;
            }
            if ($field['amount'] == 0) {
                echo $this->view->message('金额不能为0！');
                exit;
            }

            $status = array('1'=>'已提交待审核', '2'=>'已审核通过', '3'=>'已经审核未通过(作废)');
            $log = array();
            $log[] = array('previousStatus'=>$status['1'], 'currentStatus'=>$status[$field['status']], 'user'=>$this->_currentUserRow['userName'], 'time'=>date('Y-m-d H:i:s'));
            $field['statusLog'] = Zend_Json::encode($log);
            $this->_model->insert($field);
            echo $this->view->message('充值成功！', $this->view->projectUrl(array('action'=>'index')));
            exit;
        }
    }
}