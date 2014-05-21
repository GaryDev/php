<?php

/**
 * 文本
 *
 * @author cdlei
 */

require_once 'CommonController.php';

class Admin_TextController extends Admin_CommonController
{
    /**
     * 初始化函数
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_Text();
        $this->view->title = "管理中心";
    }

    /**
     * 默认动作
     * 
     * @return void
     */
    public function indexAction()
    {   
        $time = time();
        $id = intval($this->_request->get('id'));

        if ($this->_request->isPost()) {
            $field = array();
            $filter = new Zend_Filter_StripTags();
            $field['title'] = $filter->filter(trim($this->_request->getPost('title')));
            $field['sort'] = intval($this->_request->getPost('sort'));
            $field['content'] = trim($this->_request->getPost('content'));

            if ($field['title'] == '') {
                echo $this->view->message('请填写标题！') ;
                exit;
            }
            $this->_model->update($field, "`id` = {$id}");
            echo $this->view->message('修改成功！') ;
            exit;
        }
        $sql = "SELECT * FROM `{$this->_model->getTableName()}`  ORDER BY `sort` ASC";
        $rows = $this->_model->getAdapter()->fetchAll($sql);

        $currentRow = array();
        foreach($rows as $row) {
            if ($row['id'] == $id) {
                $currentRow = $row;
                break;
            }
        }

        $this->view->row = $currentRow;
        $this->view->rows = $rows;
    }

    /**
     * 更新
     * 
     * @return void
     */
    public function insertAction()
    {

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
}