<?php

/**
 * 客服
 *
 * @author cdlei
 */

require 'CommonController.php';

class ServiceController extends CommonController
{
    /**
     * 初始化
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_Service();
    }

    /**
     * 客服列表
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
        $wheres[] = "`status` = '1'";

        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT * FROM `{$this->_model->getTableName()}` {$where} ORDER BY `id` ASC";
        $dbPaginator = new Application_Model_DbPaginator($sql, $pageSize, $pageNo);
        $recordCount = $dbPaginator->getRecodCount();

        Zend_Loader::loadClass('Project_Paginator');
        $paginator = new Project_Paginator($recordCount, $pageSize, $pageNo);
        $paginator->urlTemplateContent = $urlTemplate;
        $rows = $dbPaginator->getRows();

        foreach($rows as $key=>$row) {
            if (!empty($row['avatarPath'])) {
                $row['avatarUrl'] = $this->_configs['project']['serviceAvatarBaseUrl'] . $row['avatarPath'];
            } else {
                $row['avatarUrl'] = $this->_configs['project']['serviceAvatarDefaultUrl'];
            }
            $rows[$key] = $row;
        }
        
        //分配view(分页处理后的记录集以及分页HTML字符)
        $this->view->pageString = $paginator->getPageString();
        $this->view->rows = $rows;
        $urls['pageNo'] = $pageNo;
        $this->view->pageUrl = $this->view->projectUrl($urls);
    }
}