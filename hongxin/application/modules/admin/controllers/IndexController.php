<?php

/**
 * 索引控制器
 *
 * @author cdlei
 */

require 'CommonController.php';

class Admin_IndexController extends Admin_CommonController
{
    /**
     * 初始化
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->view->title = $this->_configs['project']['systemName'] . ' - 管理中心';
    }

    /**
     * 默认动作
     * 
     * @return void
     */
    public function indexAction()
    {
        $this->view->effectiveOnlineTime = $this->_configs['project']['admin']['effectiveOnlineTime'];
    }

    /**
     * 左框架动作
     * 
     * @return void
     */
    public function leftAction()
    {
        $catalogModel = new Application_Model_Catalog();
        $templateContent = '
            <div id="catalog_{%field:parentIds%/}" class="catalogStyle_{%field:parentId%/} _catalog" style="padding-left:25px;">
                <div onmouseover="if (document.getElementById(\'children_{%field:id%/}\').innerHTML!=\'\'){this.style.cursor=\'pointer\';}" onclick="switchDisplay(\'children_{%field:id%/}\')">{%field:linkName%/}</div>
                <span id="children_{%field:id%/}" style="display:none;">{%field:children%/}</span>
            </div>
        ';
        $this->view->catalogList = $catalogModel->getAccessAllowCatalogList($templateContent, 0, explode(',', $this->_currentUserRow['catalogs']), 1, 23, 0);
    }

    /**
     * 右框架动作
     * 
     * @return void
     */
    public function mainAction()
    {
        $commonModel = new Application_Model_Common();
        $versionRow = $commonModel->getAdapter()->fetchRow("SELECT VERSION() AS v");
        $this->view->mysqlVersion = $versionRow['v'];
        $this->view->uploadInfo = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : '--';
        $dbSize = 0;
        $dbSizeRows = $commonModel->getAdapter()->fetchAll("SHOW TABLE STATUS LIKE '{$commonModel->getTablePrefix()}%'");
        foreach($dbSizeRows as $dbSizeRow) {
            $dbSize += $dbSizeRow['Data_length'] + $dbSizeRow['Index_length'];
        }
        $this->view->dbSize = $dbSize ? sizeToString($dbSize) : '--';
        unset($commonModel);
    }

    /**
     * 右框架动作
     * 
     * @return void
     */
    public function loginAction()
    {
        
    }
}