<?php

/**
 * 首页控制器
 *
 * @author cdlei
 */

require 'CommonController.php';

class IndexController extends CommonController
{
    /**
     * 初始化
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
    }

    /**
     * 默认动作
     * 
     * @return void
     */
    public function indexAction()
    {
        $borrowingModel = new Application_Model_Borrowing();
        $memberModel = new Application_Model_Member();
        $archivesModel = new Application_Model_Archives();
        $repaymentModel = new Application_Model_Repayment();
        $borrowingModel = new Application_Model_Borrowing();
        $time = time();
        $ticketUrl = $this->_configs['project']['ticketCopyBaseUrl'];

        //正在借款中的
        $borrowingSelect = $borrowingModel->select(false)
                 ->setIntegrityCheck(false)
                 ->from(array('b'=>$borrowingModel->getTableName()), array('borrowedAmount'=>new Zend_Db_Expr('get_borrowed_amount(`b`.`code`)'), '*'))
                 ->joinLeft(array('m'=>$memberModel->getTableName()), "`b`.`userName` = `m`.`userName`", "avatarPath")
                 ->order('b.yearInterestRate DESC')
                 ->order('b.amountUnit ASC')
                 ->where("`b`.`status` = '3' AND b.amountUnit > 0 ")
                 ->limit(7);
        $borrowingRows = $borrowingModel->fetchAll($borrowingSelect);
        foreach($borrowingRows as $key=>$row) {
        	$row['borrowedCount'] = $row['amountMaxUnit'] - $row['amountUnit'];
            $row['percent'] = floor($row['borrowedCount'] / $row['amountMaxUnit'] * 100);
            $borrowingRows[$key] = $row;
        }
        
        // 明星产品
        $popRow = $borrowingModel->getPopstar();
        if($popRow['id'] > 0) {
        	$popRow['borrowedCount'] = $popRow['amountMaxUnit'] - $popRow['amountUnit'];
        	$popRow['percent'] = floor($popRow['borrowedCount'] / $popRow['amountMaxUnit'] * 100);
        	if (!empty($popRow['ticketCopyPath'])) {
        		$popRow['ticketCopyUrl'] = $ticketUrl . $popRow['ticketCopyPath'];
        	}
        	$popRow['remainDay'] = (int)((($popRow['endTime'] - time())/86400) + 1);
        }
        
        // 即将满标
        $doneRow = $borrowingModel->getAlmostDone();
        if($doneRow['id'] > 0)
        {
        	$doneRow['borrowedCount'] = $doneRow['amountMaxUnit'] - $doneRow['amountUnit'];
        	$doneRow['percent'] = floor($doneRow['borrowedCount'] / $doneRow['amountMaxUnit'] * 100);
        	if (!empty($doneRow['ticketCopyPath'])) {
        		$doneRow['ticketCopyUrl'] = $ticketUrl . $doneRow['ticketCopyPath'];
        	}
        	$doneRow['remainDay'] = (int)((($doneRow['endTime'] - time())/86400) + 1);
        }

        //网站活动
        $archivesSelect = $archivesModel->select(false)
                 ->setIntegrityCheck(false)
                 ->from(array($archivesModel->getTableName()), array('id', 'title', 'isLink', 'linkUrl', 'picture', 'updateTime'))
                 ->order(array('orderNumber DESC', 'id desc'))
                 ->where("`classId` = 4 AND `status` = '1'");
        $actRows = $archivesModel->fetchAll($archivesSelect);
        foreach($actRows as $key=>$row) {
            $row['pictureUrl'] = !empty($row['picture']) ? $this->_configs['project']['uploadUrl'] . $archivesModel->getFileUrl($row['id']) . $row['picture'] : NULL;
            $actRows[$key] = $row;
        }

        //行业咨询
        $archivesSelect = $archivesModel->select(false)
                 ->setIntegrityCheck(false)
                 ->from(array($archivesModel->getTableName()), array('id', 'title', 'isLink', 'linkUrl', 'picture', 'updateTime', 'content'))
                 ->order(array('orderNumber DESC', 'id desc'))
                 ->where("`classId` = 2 AND `status` = '1'")
                 ->limit("7");
        $archives1Rows = $archivesModel->fetchAll($archivesSelect);
        foreach($archives1Rows as $key=>$row) {
            $row['pictureUrl'] = !empty($row['picture']) ? $this->_configs['project']['uploadUrl'] . $archivesModel->getFileUrl($row['id']) . $row['picture'] : NULL;
            $archives1Rows[$key] = $row;
        }

        //理财课堂
        $archivesSelect = $archivesModel->select(false)
                 ->setIntegrityCheck(false)
                 ->from(array($archivesModel->getTableName()), array('id', 'title', 'isLink', 'linkUrl', 'picture', 'updateTime', 'content'))
                 ->order(array('orderNumber DESC', 'id desc'))
                 ->where("`classId` = 3 AND `status` = '1'")
                 ->limit("7");
        $archives2Rows = $archivesModel->fetchAll($archivesSelect);
        foreach($archives2Rows as $key=>$row) {
            $row['pictureUrl'] = !empty($row['picture']) ? $this->_configs['project']['uploadUrl'] . $archivesModel->getFileUrl($row['id']) . $row['picture'] : NULL;
            $archives2Rows[$key] = $row;
        }

        //网站公告
        $archivesSelect = $archivesModel->select(false)
                 ->setIntegrityCheck(false)
                 ->from(array($archivesModel->getTableName()), array('id', 'title', 'isLink', 'linkUrl', 'picture', 'updateTime', 'content'))
                 ->order(array('orderNumber DESC', 'id desc'))
                 ->where("`classId` = 1 AND `status` = '1'")
                 ->limit("5");
        $archives3Rows = $archivesModel->fetchAll($archivesSelect);
        foreach($archives3Rows as $key=>$row) {
            $row['pictureUrl'] = !empty($row['picture']) ? $this->_configs['project']['uploadUrl'] . $archivesModel->getFileUrl($row['id']) . $row['picture'] : NULL;
            $archives3Rows[$key] = $row;
        }

        //友情链接
        $archivesSelect = $archivesModel->select(false)
                 ->setIntegrityCheck(false)
                 ->from(array($archivesModel->getTableName()), array('id', 'title', 'isLink', 'linkUrl', 'picture', 'updateTime', 'content'))
                 ->order(array('orderNumber DESC', 'id desc'))
                 ->where("`classId` = 5 AND `status` = '1'")
                 ->limit("7");
        $archives4Rows = $archivesModel->fetchAll($archivesSelect);
        foreach($archives4Rows as $key=>$row) {
            $row['pictureUrl'] = !empty($row['picture']) ? $this->_configs['project']['uploadUrl'] . $archivesModel->getFileUrl($row['id']) . $row['picture'] : NULL;
            $archives4Rows[$key] = $row;
        }
        
        //媒体报道
        $archivesSelect = $archivesModel->select(false)
        ->setIntegrityCheck(false)
        ->from(array($archivesModel->getTableName()), array('id', 'title', 'isLink', 'linkUrl', 'picture', 'updateTime', 'content'))
        ->order(array('orderNumber DESC', 'id desc'))
        ->where("`classId` = 6 AND `status` = '1'")
        ->limit("7");
        $archives5Rows = $archivesModel->fetchAll($archivesSelect);
        foreach($archives5Rows as $key=>$row) {
        	$row['pictureUrl'] = !empty($row['picture']) ? $this->_configs['project']['uploadUrl'] . $archivesModel->getFileUrl($row['id']) . $row['picture'] : NULL;
        	$archives5Rows[$key] = $row;
        }

        $this->view->borrowingRows = $borrowingRows;
        $this->view->actRows = $actRows;
        $this->view->popRow = $popRow;
        $this->view->doneRow = $doneRow;
        $this->view->archives1Rows = $archives1Rows;
        $this->view->archives2Rows = $archives2Rows;
        $this->view->archives3Rows = $archives3Rows;
        $this->view->archives4Rows = $archives4Rows;
        $this->view->archives5Rows = $archives5Rows;
    }
}