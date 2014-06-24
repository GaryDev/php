<?php

/**
 * 信息
 *
 * @author cdlei
 */

require 'CommonController.php';

class ArchivesController extends CommonController
{
    /**
     * 初始化
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_Archives();
    }

    /**
     * 列表
     * 
     * @return void
     */
    public function indexAction()
    {
        $archivesClassModel = new Application_Model_ArchivesClass();

        //获取当前页码
        $pageSize = 10;
        $pageNo = intval($this->_request->get('pageNo'));
        if (empty($pageNo)) {
            $pageNo = 1;
        }

        //设置URL模板以及条件
        $urls = array();
        $wheres = array();
        $vars = array();

        $vars['title'] = trim($this->_request->get('title'));
        $vars['classId'] = intval($this->_request->get('classId'));

        if (empty($vars['classId'])) {
            //echo $this->view->message('没有传递分类ID！', $this->view->projectUrl(array('controller'=>'index', 'action'=>'index')));
            //exit;
        	$vars['classId'] = 3;
        }
        $archivesClassRow = $archivesClassModel->fetchRow("`id` = {$vars['classId']}");
        if (empty($archivesClassRow)) {
            echo $this->view->message('分类不存在！', $this->view->projectUrl(array('controller'=>'index', 'action'=>'index')));
            exit;
        }

        $wheres[] = "`status` = '1'";
        $wheres[] = "`classId` = {$vars['classId']}";
        if ($vars['title'] != '') {
            $wheres[] = "`title` LIKE '%" . addslashes($vars['title']) . "%'";
        }

        //设置URL模板
        $urls = $vars;
        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT `id`, `title`, `isLink`, `linkUrl`, `picture`, `updateTime` FROM `{$this->_model->getTableName()}` {$where} ORDER BY `orderNumber` DESC, `id` DESC";
        $dbPaginator = new Application_Model_DbPaginator($sql, $pageSize, $pageNo);
        $recordCount = $dbPaginator->getRecodCount();

        //获取分页html字符
        Zend_Loader::loadClass('Project_Paginator');
        $paginator = new Project_Paginator($recordCount, $pageSize, $pageNo);
        $paginator->urlTemplateContent = $urlTemplate;
        $rows = $dbPaginator->getRows();

        foreach($rows as $key=>$row) {
            $row['pictureUrl'] = !empty($row['picture']) ? $this->_configs['project']['uploadUrl'] . $this->_model->getFileUrl($row['id']) . $row['picture'] . '?' . rand(100, 999) : NULL;
            $rows[$key] = $row;
        }

        //分配view(分页处理后的记录集以及分页HTML字符)
        $this->view->pageString = $paginator->getPageString();
        $this->view->rows = $rows;
        $urls['pageNo'] = $pageNo;
        $this->view->pageUrl = $this->view->projectUrl($urls);
        $this->view->vars = $vars;
        $this->view->archivesClassRow = $archivesClassRow;
        switch ($vars['classId']) {
        	case 3:
	        	$this->view->subTitle = '理财课堂';
	        	break;
        	case 2:
        		$this->view->subTitle = '行业资讯';
        		break;
        	case 6:
	        	$this->view->subTitle = '媒体报道';
	        	break;
        }
    }

    /**
     * 内容
     * 
     * @return void
     */
    public function viewAction()
    {
        $id = intval($this->_request->get('id'));
        $archivesClassModel = new Application_Model_ArchivesClass();
        $select = $this->_model->select(false)
         ->setIntegrityCheck(false)
         ->from(array('a'=>$this->_model->getTableName()), array('*'))
         ->joinLeft(array('ac'=>$archivesClassModel->getTableName()), "`a`.`classId` = `ac`.`id`", array('className'=>'name'))
         ->where("`a`.`id` = {$id} AND `a`.`status` = '1'");

        $row = $this->_model->fetchRow($select);
        if (empty($row)) {
            echo $this->view->message('记录不存在！', $this->view->projectUrl(array('controller'=>'index', 'action'=>'index')));
            exit;
        }
        $this->view->row = $row;
    }
}