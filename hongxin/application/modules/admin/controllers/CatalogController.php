<?php

/**
 * 菜单控制器
 *
 * @author cdlei
 */

require_once 'CommonController.php';

class Admin_CatalogController extends Admin_CommonController
{
    /**
     * 初始化函数
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_Catalog();
        $this->view->title = "管理中心";
    }

    /**
     * 默认动作
     * 
     * @return void
     */
    public function indexAction()
    {
        //排序
        $ids = $this->_request->get('id');
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $row = array();
                $row['orderNumber'] = $this->_request->get("orderNumber{$id}");
                $this->_model->update($row, "`id` = {$id}");
            }
            redirect($this->view->projectUrl(array('action'=>'index')));
        }

        $templateContent = '
            <tr class="dataLine">
                <td width="8%" align="center"><input name="selectId[]" type="checkbox" id="selectId_{%field:loopKey%/}_{%field:key%/}" value="{%field:id%/}" /><input name="id[]" type="hidden" id="id_{%field:loopKey%/}_{%field:key%/}" value="{%field:id%/}"></td>
                <td align="left" style="padding-left:{%field:loopKeys%/}px;" id="name{%field:id%/}"><div style="padding-left:50px;">{%field:name%/} <a href="{%field:url%/}" target="_blank">{%field:url%/}</a></div></td>
                <td align="center"><input name="orderNumber{%field:id%/}" type="text" id="orderNumber{%field:id%/}" size="5" maxlength="10" value="{%field:orderNumber%/}" class="input"></td>
                <td align="center" id="isDisplay{%field:id%/}">&nbsp;</td>
                <td align="center" id="noSystemUserIsDisplay{%field:id%/}">&nbsp;</td>
                <td width="20%" align="center"><a href="javascript:insertChild({%field:id%/});">加子目录</a> <a href="javascript:update({%field:id%/});">修改</a> <a href="javascript:deleteSelfAndChidren({%field:id%/});">删除</a></td>
            </tr>
            <script language="javascript">isDisplay("{%field:id%/}", {%field:isDisplay%/});noSystemUserIsDisplay("{%field:id%/}", {%field:noSystemUserIsDisplay%/});</script>
        ';
        $this->view->listContent = $this->_model->getList($templateContent, 0, NULL, NULL, 50, 0);
    }

    /**
     * 添加动作
     * 
     * @return void
     */
    public function insertAction()
    {
        $parentId = intval($this->_request->get('parentId'));
        if (!empty($parentId)) {
            $this->view->parentRow = $this->_model->fetchRow("`id` = {$parentId}"); 
        } else {
            $this->view->parentRow = array(); 
        }
        
        if ($this->_request->isPost()) {
            $row = array();
            $filter = new Zend_Filter_StripTags();
            $row['name'] = $filter->filter(trim($this->_request->getPost('name')));
            $row['isDisplay'] = intval($this->_request->getPost('isDisplay'));
            $row['noSystemUserIsDisplay'] = intval($this->_request->getPost('noSystemUserIsDisplay'));
            $haveAccessControl = $this->_request->getPost('haveAccessControl');
            $row['module'] = $filter->filter(trim($this->_request->getPost('module')));
            $row['module'] = str_replace('.', '-', $row['module']);
            $row['controller'] = $filter->filter(trim($this->_request->getPost('controller')));
            $row['controller'] = str_replace('.', '-', $row['controller']);
            $row['action'] = $filter->filter(trim($this->_request->getPost('action')));
            $row['requestParams'] = $filter->filter(trim($this->_request->getPost('requestParams')));
            $row['target'] = $filter->filter(trim($this->_request->getPost('target')));
            $row['action'] = str_replace('.', '-', $row['action']);
            $row['parentId'] = $parentId;
            $row['orderNumber'] = intval($this->_request->getPost('orderNumber'));
            $row['description'] = $filter->filter(trim($this->_request->getPost('description')));
            if (empty($row['name'])) {
                echo $this->view->message('名称不能为空，请返回填写！') ;
                exit;
            }
            if ($haveAccessControl == 1) {//如果需要权限验证，必须填写模块、控制器、动作名
                if (empty($row['module']) || empty($row['controller']) || empty($row['action'])) {
                    echo $this->view->message('访问地址权限验证信息三项必须填写完整！') ;
                    exit;
                }
                if ($this->_model->accessControlIsExists($row['module'], $row['controller'], $row['action']) == 1) {
                    echo $this->view->message('访问地址权限验证项已经存在，请返回重新填写！') ;
                    exit; 
                }
            } else {
                $row['module'] = '';
                $row['controller'] = '';
                $row['action'] = '';
            }

            $this->_model->insert($row);
            $maxIdRow = $this->_model->getAdapter()->fetchRow("SELECT MAX(`id`) as id FROM {$this->_model->getTableName()}");
            $id = $maxIdRow['id'];
            $this->_model->updateDisplayParams($id, $row['isDisplay'], $row['noSystemUserIsDisplay']);
            echo $this->view->message('操作成功！', $this->view->projectUrl(array('action'=>'index'))) ;
            exit;
        }
    }

    /**
     * 修改动作
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
        if ($this->view->row['parentId'] != 0) {
            $this->view->parentRow = $this->_model->fetchRow("`id` = {$this->view->row['parentId']}");
        } else {
            $this->view->parentRow = array();
        }
        
        if ($this->_request->isPost()) {
            $row = array();
            $filter = new Zend_Filter_StripTags();
            $row['name'] = $filter->filter(trim($this->_request->getPost('name')));
            $row['isDisplay'] = intval($this->_request->getPost('isDisplay'));
            $row['noSystemUserIsDisplay'] = intval($this->_request->getPost('noSystemUserIsDisplay'));
            $haveAccessControl = $this->_request->getPost('haveAccessControl');
            $row['module'] = $filter->filter(trim($this->_request->getPost('module')));
            $row['module'] = str_replace('.', '-', $row['module']);
            $row['controller'] = $filter->filter(trim($this->_request->getPost('controller')));
            $row['controller'] = str_replace('.', '-', $row['controller']);
            $row['action'] = $filter->filter(trim($this->_request->getPost('action')));
            $row['action'] = str_replace('.', '-', $row['action']);
            $row['requestParams'] = $filter->filter(trim($this->_request->getPost('requestParams')));
            $row['target'] = $filter->filter(trim($this->_request->getPost('target')));
            //$row['parentId'] = $parentId;
            $row['orderNumber'] = intval($this->_request->getPost('orderNumber'));
            $row['description'] = $filter->filter(trim($this->_request->getPost('description')));
            if (empty($row['name'])) {
                echo $this->view->message('名称不能为空，请返回填写！') ;
                exit;
            }
            if ($haveAccessControl == 1) {//如果需要权限验证，必须填写模块、控制器、动作名
                if (empty($row['module']) || empty($row['controller']) || empty($row['action'])) {
                    echo $this->view->message('访问地址权限验证信息三项必须填写完整！') ;
                    exit;
                }
                if ($this->_model->accessControlIsExists($row['module'], $row['controller'], $row['action'], $id) == 1) {
                    echo $this->view->message('访问地址权限验证项已经存在，请返回重新填写！') ;
                    exit; 
                }
            } else {
                $row['module'] = '';
                $row['controller'] = '';
                $row['action'] = '';
            }

            $this->_model->update($row, "`id` = {$id}");
            $this->_model->updateDisplayParams($id, $row['isDisplay'], $row['noSystemUserIsDisplay']);
            echo $this->view->message('操作成功！', $this->view->projectUrl(array('action'=>'index'))) ;
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
        if (is_string($this->_request->get('id'))) {
            $id = intval($this->_request->get('id'));
            $this->_model->delete($id);
        } else if ($this->_request->isPost()) {
            $ids = $this->_request->getPost('selectId');
            if (is_array($ids)) {
                foreach($ids as $id) {
                    $this->_model->delete($id);
                }
            }
        }
        redirect($this->view->projectUrl(array('action'=>'index')));
        exit;
    }
}