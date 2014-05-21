<?php

/**
 * 用户访问控制器
 *
 * @author cdlei
 */

require_once 'CommonController.php';

class Admin_AdminVisitController extends Admin_CommonController
{
    /**
     * 初始化函数
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_AdminVisit();
        $this->view->effectiveOnlineTime = $this->_model->effectiveOnlineTime;
        $this->view->title = "管理中心";
    }

    /**
     * 默认动作
     * 
     * @return void
     */
    public function indexAction()
    {
        
    }

    /**
     * 列表动作
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

        $keyword = trim($this->_request->get('keyword'));//关键字
        $this->view->keyword = $keyword;
        
        $searchType = $this->_request->get('searchType');//搜索类型
        $this->view->searchType = $searchType;

        if ($keyword != '' && $searchType != '') {
            $urls['keyword'] = $keyword;
            $urls['searchType'] = $searchType;
            if ($searchType == 1) {//按用户名搜索
                $wheres[] = "`userName` LIKE '" . addslashes($keyword) . "%'";
            } else if ($searchType == 2) {//按IP
                $wheres[] = "`ip` LIKE '" . addslashes($keyword) . "%'";
            }
        }

        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT * FROM `{$this->_model->getTableName()}` {$where} ORDER BY `lastOnlineTime` DESC";
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
        redirect($backUrl);
    }

    /**
     * 在线情况
     * 
     * @return integer
     */
    public function isOnlineAction()
    {
        $visitIds = $this->_request->get('visitIds');
        if (empty($visitIds)) {
            exit('No params!');
        }
        $onlineTime = $this->_model->effectiveOnlineTime;
        $rows = $this->_model->fetchAll("`id` in ({$visitIds})");
        $data = array();
        foreach($rows as $row) {
            if (isset($row['lastOnlineTime'])) {
                $isOnline = $this->_model->isOnline($row['lastOnlineTime']);
            } else {
                $isOnline = -1;
            }
            $data["id{$row['id']}"]['isOnline'] = $isOnline;
            $data["id{$row['id']}"]['ip'] = $row['ip'];
            $data["id{$row['id']}"]['time'] = $row['time'];
            $data["id{$row['id']}"]['lastOnlineTime'] = $row['lastOnlineTime'];
            $data["id{$row['id']}"]['visitLong'] = timeToString($row['lastOnlineTime'] - $row['time']);
        }
        $this->_helper->getHelper('Json')->sendJson($data);
    }

    /**
     * 在线情况(供首页AJAX调用)
     * 
     * @return integer
     */
    public function ajaxListAction()
    {
        $this->view->rows = $this->_model->fetchAll('1=1', 'lastOnlineTime DESC', 10, 0);
    }
}