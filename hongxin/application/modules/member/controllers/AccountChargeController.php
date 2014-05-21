<?php

/**
 * 账户充值
 *
 * @author cdlei
 */

require 'CommonController.php';

class Member_AccountChargeController extends Member_CommonController
{
    /**
     * 初始化
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_AccountCharge();
    }

    /**
     * 充值记录列表
     * 
     * @return void
     */
    public function listAction()
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

        $wheres[] = "`userName` = {$this->_model->getAdapter()->quote(Application_Model_MemberLogin::getLoginedUserName())}";

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
    }

    /**
     * 申请充值
     * 
     * @return void
     */
    public function addAction()
    {
        $this->view->bankTypes = explode(',', $this->_configs['project']['bankTypes']);
        $accountChargeModel = new Application_Model_AccountCharge();
        if ($this->_request->isPost()) {
            $filter = new Zend_Filter_StripTags();
            $field = array();
            $field['userName'] = Application_Model_MemberLogin::getLoginedUserName();
            $field['from'] = $filter->filter(trim($this->_request->get('from')));
            $field['serialNumber'] = $filter->filter(trim($this->_request->get('serialNumber')));
            $field['paymentTime'] = $filter->filter(trim($this->_request->get('paymentTime')));
            $field['status'] = '1';
            $field['statusLog'] = '';
            $field['amount'] = intval($this->_request->get('amount'));
            $field['addTime'] = time();
            $field['notes'] = $filter->filter(trim($this->_request->get('notes')));

            if ($field['from'] == '') {
                echo $this->view->message('银行不能为空！') ;
                exit;
            }
            if ($field['paymentTime'] == '') {
                echo $this->view->message('汇款时间不能为空！') ;
                exit;
            }
            if ($field['amount'] <= 0) {
                echo $this->view->message('汇款金额填写错误！') ;
                exit;
            }
            $accountChargeModel->insert($field);
            echo $this->view->message('提交成功，请等待审核！');
            exit;
        }
    }
}