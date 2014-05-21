<?php

/**
 * 会员等级
 *
 * @author cdlei
 */

require_once 'CommonController.php';

class Admin_MemberGradeController extends Admin_CommonController
{
    /**
     * 初始化函数
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_MemberGrade();
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
        $vars['serviceCode'] = trim($this->_request->get('serviceCode'));
        $vars['status'] = intval($this->_request->get('status'));
        if ($vars['userName'] != '') {
            $wheres[] = "`userName` = '" . addslashes($vars['userName']) . "'";
        }
        if ($vars['serviceCode'] != '') {
            $wheres[] = "`serviceCode` = '" . addslashes($vars['serviceCode']) . "'";
        }
        if ($vars['status']) {
            $wheres[] = "`status` = '{$vars['status']}'";
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
    
        $row = $this->_model->fetchRow("`id` = {$id}"); 
        if (empty($row)) {
            echo $this->view->message('记录不存在，请返回重试！', $backUrl) ;
            exit;
        }
        $row['statusLogRows'] = trim($row['statusLog']) != '' ? Zend_Json::decode($row['statusLog']) : array();
        $this->view->row = $row;

        if ($this->_request->isPost()) {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['startTime'] = @strtotime($this->_request->getPost('startTime')) ? strtotime($this->_request->getPost('startTime')) : 0;
            $field['endTime'] = $field['startTime'] + 3600 * 24 * 365 * $row['year'];
            $field['status'] = intval(trim($this->_request->getPost('status')));

            if ($field['status'] > $row['status']) {
                if (empty($field['startTime']) && $row['status'] == 1) {
                    echo $this->view->message('请选择时间。') ;
                    exit;
                }
                if ($field['status'] == 3) {
                    unset($field['startTime']);
                    unset($field['endTime']);
                }
                $status = array('1'=>'已提交待审核', '2'=>'已审核通过', '3'=>'已经审核未通过(作废)');
                $log = trim($row['statusLog']) != '' ? Zend_Json::decode($row['statusLog']) : array();
                $log[] = array('previousStatus'=>$status[$row['status']], 'currentStatus'=>$status[$field['status']], 'user'=>$this->_currentUserRow['userName'], 'time'=>date('Y-m-d H:i:s'));
                $field['statusLog'] = Zend_Json::encode($log);
                if ($field['status'] == 2) {
                    if ($this->_model->getExistsByTime($row['userName'], $field['startTime'], $field['endTime'])) {
                        echo $this->view->message('修改失败，你选择的时间已经存在！') ;
                        exit;
                    }
                }
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
     * 获取时间，json格式返回
     * 
     * @return void
     */
    public function getTimeAction()
    {
        $startTime = trim($this->_request->get('startTime'));
        $year = intval(trim($this->_request->get('year')));
        $dateTime = date('Y-m-d H:i:s', @strtotime($startTime) + $year * 3600 * 24 * 365);
        echo $dateTime;
        exit;
    }
}