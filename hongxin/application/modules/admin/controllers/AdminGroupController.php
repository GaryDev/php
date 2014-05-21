<?php

/**
 * 用户组控制器
 *
 * @author cdlei
 */

require_once 'CommonController.php';

class Admin_AdminGroupController extends Admin_CommonController
{
    /**
     * 初始化函数
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_AdminGroup();
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
        
        //设置URL模板
        $urls = array();
        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $sql = "SELECT * FROM `{$this->_model->getTableName()}` ORDER BY `id` ASC";
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
     * 权限，用户列表
     * 
     * @return void
     */
    public function grantUserListAction()
    {   
        //获取当前页码
        $pageSize = 20;
        $pageNo = intval($this->_request->get('pageNo'));
        if (empty($pageNo)) {
            $pageNo = 1;
        }
        
        //设置URL模板
        $urls = array();
        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $sql = "SELECT * FROM `{$this->_model->getTableName()}` ORDER BY `id` ASC";
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
        if ($this->_request->isPost()) {
            $row = array();
            $filter = new Zend_Filter_StripTags();
            $row['name'] = $filter->filter(trim($this->_request->getPost('name')));
            $row['description'] = $filter->filter(trim($this->_request->getPost('description')));
            if (strlen($row['name']) > 50) {
                echo $this->view->message('名称长度必须小于50个字符，请重新填写！') ;
                exit;
            }
            if (strlen($row['name']) < 1) {
                echo $this->view->message('名称不能为空，请重新填写！') ;
                exit;
            }
            if ($this->_model->isExists($row['name'])) {
                echo $this->view->message('名称已经存在，请重新填写！') ;
                exit; 
            }
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
        if ($this->_request->isPost()) {
            $row = array();
            $filter = new Zend_Filter_StripTags();
            $row['name'] = $filter->filter(trim($this->_request->getPost('name')));
            $row['description'] = $filter->filter(trim($this->_request->getPost('description')));
            if (strlen($row['name']) > 50) {
                echo $this->view->message('用户名长度必须小于50个字符！') ;
                exit;
            }
            if (strlen($row['name']) < 1) {
                echo $this->view->message('名称不能为空！') ;
                exit;
            }
            if ($this->_model->isExists($row['name'], $id)) {
                echo $this->view->message('名称已经存在，请重新填写！') ;
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
     * 查看管理权限
     * 
     * @return void
     */
    public function catalogAction()
    {
        $groupId = intval($this->_request->get('groupId'));
        if (empty($groupId)) {
            throw new Exception('Invalid params!');
        }
        
        //保存授权
        if ($this->_request->isPost()) {
            $ids= $this->_request->getPost('catalogId');
            if (is_array($ids)) {
                $updateRow = array('catalogs'=>implode(',', $ids));
            } else {
                $updateRow = array('catalogs'=>'');
            }
            $this->_model->update($updateRow, "`id` = {$groupId}");
            echo $this->view->message('操作成功！', $this->view->projectUrl(array('groupId' => $groupId))) ;
            exit;
        }

        $userGroupRow = $this->_model->fetchRow("`id` = {$groupId}");
        $this->view->userGroupRow = $userGroupRow;
        if (empty($userGroupRow)) {
            redirect($this->view->projectUrl(array('action' => 'index')));
        }
        $catalogModel = new Application_Model_Catalog();
        $templateContent = '
            <tr class="dataLine" id="line_{%field:parentIds%/}">
                <td align="left" style="padding-left:{%field:loopKeys%/}px;" id="name{%field:parentIds%/}"><div style="padding-left:50px;">{%field:name%/} {%field:catalogCheckBox%/}</div></td>
            </tr>
            <script language="javascript">isDisplay("{%field:id%/}", {%field:isDisplay%/});</script>
        ';
        $ids = explode(',', $userGroupRow['catalogs']);
        $this->view->catalogList = $catalogModel->getCatalogList($templateContent, 0, $ids, NULL, 50, 0);
    }
}