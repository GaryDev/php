<?php

/**
 * 用户控制器
 *
 * @author cdlei
 */

require_once 'CommonController.php';

class Admin_AdminController extends Admin_CommonController
{
    /**
     * 初始化函数
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_Admin();
        $this->groupModel = new Application_Model_AdminGroup();
        $this->view->title = "管理中心";
    }

    /**
     * 默认动作
     * 
     * @return void
     */
    public function indexAction()
    {   
        //设置变量
        $this->view->effectiveOnlineTime = $this->_configs['project']['admin']['effectiveOnlineTime'];
        
        //获取当前页码
        $pageSize = 20;
        $pageNo = intval($this->_request->get('pageNo'));
        if (empty($pageNo)) {
            $pageNo = 1;
        }

        //设置URL模板以及条件
        $urls = array();
        $wheres = array();

        $groupId = $this->_request->get('groupId');//组ID
        $this->view->groupId = $groupId;

        $keyword = trim($this->_request->get('keyword'));//关键字
        $this->view->keyword = $keyword;

        $searchType = $this->_request->get('searchType');//搜索类型
        $this->view->searchType = $searchType;

        if ($groupId != '') {
            $urls['groupId'] = intval($groupId);
            $wheres[] = "`groupId` = {$groupId}";
        }
        if ($keyword != '' && $searchType != '') {
            $urls['keyword'] = $keyword;
            $urls['searchType'] = $searchType;
            if ($searchType == 1) {//按用户名搜索
                $wheres[] = "(`userName` LIKE '" . addslashes($keyword) . "%' OR `code` LIKE '" . addslashes($keyword) . "%')";
            } else if ($searchType == 2) {//按姓名搜索
                $wheres[] = "u.`name` LIKE '" . addslashes($keyword) . "%'";
            }
        }
        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT u.*,ug.name as groupName FROM `{$this->_model->getTableName()}` u left join `{$this->groupModel->getTableName()}` ug on u.groupId=ug.id {$where} ORDER BY u.`id` ASC";
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
     * 添加动作
     * 
     * @return void
     */
    public function insertAction()
    {
        $userGroupObj = new Application_Model_AdminGroup();
        $this->view->userGroupRows = $userGroupObj->fetchAll();
        $row = $this->_model->fetchRow(NULL, "id desc"); 
        $this->view->defaultCode = !empty($row) ? $row['id'] + 1000 + 1 : 1001;

        if ($this->_request->isPost()) {
            $row = array();
            $filter = new Zend_Filter_StripTags();
            $row['userName'] = $filter->filter(trim($this->_request->getPost('userName')));
            $row['code'] = $filter->filter(trim($this->_request->getPost('code')));
            $row['status'] = $filter->filter(trim($this->_request->getPost('status')));
            $row['password'] = trim($this->_request->getPost('password'));
            $row['name'] = $filter->filter(trim($this->_request->getPost('name')));
            $row['groupId'] = $filter->filter(trim($this->_request->getPost('groupId')));
            $row['lastOnlineTime'] = 0;
            $row['qq'] = $filter->filter(trim($this->_request->getPost('qq')));
            $row['email'] = $filter->filter(trim($this->_request->getPost('email')));
            $row['description'] = $filter->filter(trim($this->_request->getPost('description')));
            if (strlen($row['userName']) > 50) {
                echo $this->view->message('用户名长度必须小于50个字符，请重新填写！') ;
                exit;
            }
            if (strlen($row['userName']) < 5) {
                echo $this->view->message('用户名长度不能小于5个字符，请重新填写！') ;
                exit;
            }
            if (!(preg_match("/^[a-zA-Z0-9]{2,20}$/", $row['userName']) || preg_match("/^[a-z]([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?$/i", $row['userName']))) {
                echo $this->view->message('用户名请填写英文字母、数字以及下划线，或填写EMAIL地址，请返回重新填写！') ;
                exit;
            }
            if ($this->_model->isExists($row['userName'])) {
                echo $this->view->message('用户名已经存在，请重新填写！') ;
                exit; 
            }
            if ($row['userName'] == $row['code']) {
                echo $this->view->message('工号不能和用户名相同！') ;
                exit;
            }
            if (!(preg_match("/^[a-zA-Z0-9]{2,20}$/", $row['code']))) {
                echo $this->view->message('工号请填写英文字母、数字以及下划线2-20个字符！') ;
                exit;
            }
            if ($this->_model->isExists($row['code'])) {
                echo $this->view->message('工号已经存在，请重新填写！') ;
                exit; 
            }
            if (strlen($row['password']) > 20 || strlen($row['password']) < 5) {
                echo $this->view->message('密码长度不在5-20范围内，请重新填写！') ;
                exit;
            }
            if (strlen($row['name']) == 0) {
                echo $this->view->message('姓名不能为空，请重新填写！') ;
                exit;
            }
            if (empty($row['groupId'])) {
                echo $this->view->message('没有选择此用户所在的组，请重新选择！') ;
                exit; 
            }
            $row['password'] = md5($row['password']);
            $this->_model->insert($row);
            echo $this->view->message('操作成功！', $this->view->projectUrl(array('action' => 'index'))) ;
            exit;
        }
    }

    /**
     * 更新动作
     * 
     * @return void
     */
    public function updateAction()
    {
        $id = intval($this->_request->get('id'));
        if (empty($id)) {
             throw new Exception('Invalid params!');
        }
        $this->view->row = $this->_model->fetchRow("`id` = {$id}"); 
        $backUrl = urldecode($this->_request->get('backUrl'));

        $userGroupObj = new Application_Model_AdminGroup();
        $this->view->userGroupRows = $userGroupObj->fetchAll();
        if ($this->_request->isPost()) {
            $row = array();
            $filter = new Zend_Filter_StripTags();
            $row['userName'] = $filter->filter(trim($this->_request->getPost('userName')));
            $row['code'] = $filter->filter(trim($this->_request->getPost('code')));
            $row['status'] = $filter->filter(trim($this->_request->getPost('status')));
            $password = trim($this->_request->getPost('password'));
            if ($password != '') {
                $row['password'] = md5($password);
            }
            $row['name'] = $filter->filter(trim($this->_request->getPost('name')));
            $row['groupId'] = $filter->filter(trim($this->_request->getPost('groupId')));
            $row['qq'] = $filter->filter(trim($this->_request->getPost('qq')));
            $row['email'] = $filter->filter(trim($this->_request->getPost('email')));
            $row['description'] = $filter->filter(trim($this->_request->getPost('description')));
            if (strlen($row['userName']) > 50) {
                echo $this->view->message('用户名长度必须小于50个字符，请重新填写！') ;
                exit;
            }
            if (strlen($row['userName']) < 5) {
                echo $this->view->message('用户名长度不能小于5个字符，请重新填写！') ;
                exit;
            }
            if (!(preg_match("/^[a-zA-Z0-9]{2,20}$/", $row['userName']) || preg_match("/^[a-z]([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?$/i", $row['userName']))) {
                echo $this->view->message('用户名请填写英文字母、数字以及下划线，或填写EMAIL地址，请返回重新填写！') ;
                exit;
            }
            if ($this->_model->isExists($row['userName'], $id)) {
                echo $this->view->message('用户名已经存在，请重新填写！') ;
                exit; 
            }
            if ($row['userName'] == $row['code']) {
                echo $this->view->message('工号不能和用户名相同！') ;
                exit;
            }
            if ($this->_model->isExists($row['code'], $id)) {
                echo $this->view->message('工号已经存在，请重新填写！') ;
                exit; 
            }
            if (strlen($password) > 20 || strlen($password) < 5 && strlen($password) > 1) {
                echo $this->view->message('密码长度不在5-20范围内，请重新填写！') ;
                exit;
            }
            if (strlen($row['name']) == 0) {
                echo $this->view->message('姓名不能为空，请重新填写！') ;
                exit;
            }
            if (empty($row['groupId'])) {
                echo $this->view->message('没有选择此用户所在的组，请重新选择！') ;
                exit; 
            }
            $this->_model->update($row, "`id` = {$id}");
            echo $this->view->message('操作成功！', $backUrl) ;
            exit;
        }
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
     * 修改自己的密码
     * 
     * @return void
     */
    public function updateSelfPasswordAction()
    {
        if ($this->_request->isPost()) {
            $row = array();
            $oldPassword = trim($this->_request->getPost('oldPassword'));
            $password = trim($this->_request->getPost('password'));
            $password2 = trim($this->_request->getPost('password2'));
            
            if (empty($oldPassword)) {
                echo $this->view->message('请输入原密码！') ;
                exit;
            }
            if (strlen($password) > 20 || strlen($password) < 5) {
                echo $this->view->message('新密码长度不在5-20范围内，请重新填写！') ;
                exit;
            }
            if ($password != $password2) {
                echo $this->view->message('确认新密码和新密码填写不一致，请重新填写！') ;
                exit;
            }
            if ($this->_model->isRight($this->_currentUserRow['userName'], $oldPassword) == 0) {
                echo $this->view->message('原密码填写不正确，请重新填写！') ;
                exit;  
            }
            $row['password'] = md5($password);
            $this->_model->update($row, "`id` = {$this->_currentUserRow['id']}");
            echo $this->view->message('操作成功！', $this->view->projectUrl(array('controller' => 'index', 'action' => 'main'))) ;
            exit;
        } 
    }
}