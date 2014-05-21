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

        //正在借款中的
        $borrowingSelect = $borrowingModel->select(false)
                 ->setIntegrityCheck(false)
                 ->from(array('b'=>$borrowingModel->getTableName()), array('borrowedAmount'=>new Zend_Db_Expr('get_borrowed_amount(`b`.`code`)'), '*'))
                 ->joinLeft(array('m'=>$memberModel->getTableName()), "`b`.`userName` = `m`.`userName`", "avatarPath")
                 ->order('b.addTime DESC')
                 ->where("`b`.`status`  IN('1', '2')")
                 ->limit(8);
        $borrowingRows = $borrowingModel->fetchAll($borrowingSelect);
        foreach($borrowingRows as $key=>$row) {
            if (!empty($row['avatarPath'])) {
                $row['avatarUrl'] = $this->_configs['project']['memberAvatarBaseUrl'] . $row['avatarPath'];
            } else {
                $row['avatarUrl'] = $this->_configs['project']['memberAvatarDefaultUrl'];
            }
            $row['schedule'] = round($row['borrowedAmount'] / $row['amount'] * 100, 1);
            $borrowingRows[$key] = $row;
        }

        //完成借款
        $borrowingSelect = $borrowingModel->select(false)
                 ->setIntegrityCheck(false)
                 ->from(array('b'=>$borrowingModel->getTableName()), array('borrowedAmount'=>new Zend_Db_Expr('get_borrowed_amount(`b`.`code`)'), '*'))
                 ->joinLeft(array('m'=>$memberModel->getTableName()), "`b`.`userName` = `m`.`userName`", "avatarPath")
                 ->order('b.addTime DESC')
                 ->where("`b`.`status`  IN( '4')")
                 ->limit(3);
        $borrowingCompleteRows = $borrowingModel->fetchAll($borrowingSelect);
        foreach($borrowingCompleteRows as $key=>$row) {
            if (!empty($row['avatarPath'])) {
                $row['avatarUrl'] = $this->_configs['project']['memberAvatarBaseUrl'] . $row['avatarPath'];
            } else {
                $row['avatarUrl'] = $this->_configs['project']['memberAvatarDefaultUrl'];
            }
            $row['schedule'] = round($row['borrowedAmount'] / $row['amount'] * 100, 1);
            $borrowingCompleteRows[$key] = $row;
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

        //借款资讯
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

        //投资理财
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
        $this->view->borrowingCompleteRows = $borrowingCompleteRows;
        $this->view->actRows = $actRows;
        $this->view->archives1Rows = $archives1Rows;
        $this->view->archives2Rows = $archives2Rows;
        $this->view->archives3Rows = $archives3Rows;
        $this->view->archives4Rows = $archives4Rows;
        $this->view->archives5Rows = $archives5Rows;
    }
}