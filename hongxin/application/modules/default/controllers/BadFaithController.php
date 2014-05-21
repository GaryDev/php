<?php

/**
 * 会员
 *
 * @author cdlei
 */

require 'CommonController.php';

class BadFaithController extends CommonController
{
    /**
     * 初始化
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_Member();
    }

    /**
     * 逾期黑名单
     * 
     * @return void
     */
    public function indexAction()
    {
        $repaymentModel = new Application_Model_Repayment();
        $borrowingModel = new Application_Model_Borrowing();
        $time = time();

        //获取当前页码
        $pageSize = 20;
        $pageNo = intval($this->_request->get('pageNo'));
        if (empty($pageNo)) {
            $pageNo = 1;
        }

        //设置URL模板以及条件
        $urls = array();
        $wheres = array();
        $vars = array();

        $wheres[] = "
            `userName` IN (
                    SELECT `b`.`userName` FROM `{$repaymentModel->getTableName()}` AS `r`
                        LEFT JOIN `{$borrowingModel->getTableName()}` AS `b` ON `r`.`borrowingCode` = `b`.`code`
                        WHERE `r`.`status` IN ('3', '4') OR  `r`.`currentCyclesRepaymentDeadline` < {$time}
                        GROUP BY `b`.`userName`
             )
        ";

        //设置URL模板
        $urls = $vars;
        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT * FROM `{$this->_model->getTableName()}` {$where} ORDER BY `id` desc";
        $dbPaginator = new Application_Model_DbPaginator($sql, $pageSize, $pageNo, 2);
        $recordCount = $dbPaginator->getRecodCount();

        //获取分页html字符
        Zend_Loader::loadClass('Project_Paginator');
        $paginator = new Project_Paginator($recordCount, $pageSize, $pageNo);
        $paginator->urlTemplateContent = $urlTemplate;
        $rows = $dbPaginator->getRows();

        foreach($rows as $key=>$row) {
            if (!empty($row['avatarPath'])) {
                $row['avatarUrl'] = $this->_configs['project']['memberAvatarBaseUrl'] . $row['avatarPath'];
            } else {
                $row['avatarUrl'] = $this->_configs['project']['memberAvatarDefaultUrl'];
            }
            $rows[$key] = $row;
        }

        //分配view(分页处理后的记录集以及分页HTML字符)
        $this->view->pageString = $paginator->getPageString();
        $this->view->rows = $rows;
        $urls['pageNo'] = $pageNo;
        $this->view->pageUrl = $this->view->projectUrl($urls);
        $this->view->vars = $vars;
    }
}