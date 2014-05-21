<?php

/**
 * 系统目录模型
 *
 * @author cdlei
 */

class Application_Model_Catalog extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'catalog';

    /**
     * 构造函数
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 递归获取列表内容
     * 
     * @param  string $templateContent
     * @param  integer $parentId
     * @param  mixed $isDisplay
     * @param  mixed $noSystemUserIsDisplay
     * @param  integer $cardinalNumber
     * @param  integer $loopKey
     * 
     * @return string
     */
    public function getList($templateContent, $parentId = 0, $isDisplay = NULL, $noSystemUserIsDisplay = NULL, $cardinalNumber = 1, $loopKey = 1 )
    {
        $whereArray = array();
        $whereArray[] = "`parentId` = {$parentId}";
        if ($isDisplay === 0 || $isDisplay === 1) {
            $whereArray[] = "`isDisplay` = {$isDisplay}";
        }
        if ($noSystemUserIsDisplay === 0 || $noSystemUserIsDisplay === 1) {
            $whereArray[] = "`noSystemUserIsDisplay` = {$noSystemUserIsDisplay}";
        }
        $whereString = implode(' AND ', $whereArray);
        $rows = parent::fetchAll($whereString, "orderNumber");
        
        Zend_Loader::loadClass('Project_View_Helper_ProjectUrl');
        $projectUrl = new Project_View_Helper_ProjectUrl();
        $content = '';
        foreach ($rows as $n=>$row) {
            $temporarContent = $templateContent;
            preg_match_all("/\{%field:([\d\w_]+)%\/\}/", $temporarContent, $result);
            
            //处理其他的url请求
            $requestParamsArray = array();
            if (!empty($row['requestParams'])) {
                $paramsArray = explode('&', $row['requestParams']);
                foreach($paramsArray as $params) {
                   $array = explode('=', $params);
                   @$requestParamsArray[$array[0]] = $array[1];
                }
            }
            
            foreach ($result[1] as $key => $field) {
                if (isset($row[$field])) {
                    $value = $row[$field];
                } else if ($field == 'loopKey') {
                    $value = $loopKey;
                } else if ($field == 'loopKeys') {
                    $value = $cardinalNumber * $loopKey;
                } else if ($field == 'url') {
                    if (!empty($row['module']) && !empty($row['controller']) && !empty($row['action'])) {
                        $urlArray = array('module' => $row['module'], 'controller' => $row['controller'], 'action' => $row['action']);
                        $urlArray = array_merge($urlArray, $requestParamsArray);
                        $value = $projectUrl->projectUrl($urlArray);
                    } else {
                        $value = '';
                    }
                } else if ($field == 'key') {
                    $value = $n;
                } else {
                    $value = '';
                }
                $temporarContent = str_replace($result[0][$key], $value, $temporarContent);
            }
            $content .= $temporarContent;
            if ($this->getChildrenNumber($row['id'], $isDisplay, $noSystemUserIsDisplay) > 0) {
                $loopKeyTemporary = $loopKey+1;
                $content .= $this->getList($templateContent, $row['id'], $isDisplay, $noSystemUserIsDisplay, $cardinalNumber, $loopKeyTemporary);
            }
        }
        return $content;
    }

    /**
     * 递归获取列表内容(管理)
     * 
     * @param  string $templateContent
     * @param  integer $parentId
     * @param  array $ids
     * @param  mixed $isDisplay
     * @param  integer $cardinalNumber
     * @param  integer $loopKey
     * @param  array $parentIds
     * 
     * @return string
     */
    public function getCatalogList($templateContent, $parentId = 0, $ids, $isDisplay = NULL, $cardinalNumber = 1, $loopKey = 1, $parentIds = array())
    {
        $whereArray = array();
        $whereArray[] = "`parentId` = {$parentId}";
        $whereArray[] = "`noSystemUserIsDisplay` = 1";
        if ($isDisplay === 0 || $isDisplay === 1) {
            $whereArray[] = "`isDisplay` = {$isDisplay}";
        }
        $whereString = implode(' AND ', $whereArray);
        $rows = parent::fetchAll($whereString, "orderNumber");
        
        Zend_Loader::loadClass('Project_View_Helper_ProjectUrl');
        $projectUrl = new Project_View_Helper_ProjectUrl();
        $content = '';
        foreach ($rows as $n=>$row) {
            $parentIdsTemporary = $parentIds;
            $parentIdsTemporary[] = $row['id'];
            $temporarContent = $templateContent;
            preg_match_all("/\{%field:([\d\w_]+)%\/\}/", $temporarContent, $result);
            
            //处理其他的url请求
            $requestParamsArray = array();
            if (!empty($row['requestParams'])) {
                $paramsArray = explode('&', $row['requestParams']);
                foreach($paramsArray as $params) {
                   $array = explode('=', $params);
                   @$requestParamsArray[$array[0]] = $array[1];
                }
            }
            
            foreach ($result[1] as $key => $field) {
                if (isset($row[$field])) {
                    $value = $row[$field];
                } else if ($field == 'loopKey') {
                    $value = $loopKey;
                } else if ($field == 'loopKeys') {
                    $value = $cardinalNumber * $loopKey;
                } else if ($field == 'key') {
                    $value = $n;
                } else if ($field == 'url') {
                    if (!empty($row['module']) && !empty($row['controller']) && !empty($row['action'])) {
                        $urlArray = array('module' => $row['module'], 'controller' => $row['controller'], 'action' => $row['action']);
                        $urlArray = array_merge($urlArray, $requestParamsArray);
                        $value = $projectUrl->projectUrl($urlArray);
                    } else {
                        $value = '';
                    }
                } else if ($field == 'catalogCheckBox') {
                    $checkedString = in_array($row['id'], $ids) ? 'checked' : '';
                    $value = "<input type=\"checkbox\" id=\"catalog_" . implode('_', $parentIdsTemporary) . "\" name=\"catalogId[]\" value=\"{$row['id']}\" {$checkedString} />";
                } else if ($field == 'parentIds'){
                    $value = implode('_', $parentIdsTemporary);
                } else {
                    $value = '';
                }
                $temporarContent = str_replace($result[0][$key], $value, $temporarContent);
            }
            $content .= $temporarContent;
            if ($this->getChildrenNumber($row['id'], $isDisplay, 1) > 0) {
                $loopKeyTemporary = $loopKey+1;
                $content .= $this->getCatalogList($templateContent, $row['id'], $ids, $isDisplay, $cardinalNumber, $loopKeyTemporary, $parentIdsTemporary);
            }
        }
        return $content;
    }


    /**
     * 递归获取授权列表内容(点击)
     * 
     * @param  string $templateContent
     * @param  integer $parentId
     * @param  array $ids
     * @param  mixed $isDisplay
     * @param  integer $cardinalNumber
     * @param  integer $loopKey
     * @param  array $parentIds
     * 
     * @return string
     */
    public function getAccessAllowCatalogList($templateContent, $parentId = 0, $ids, $isDisplay = NULL, $cardinalNumber = 1, $loopKey = 1, $parentIds = array())
    {
        $whereArray = array();
        $whereArray[] = "`parentId` = {$parentId}";
        $whereArray[] = "`noSystemUserIsDisplay` = 1";
        $whereArray[] = !empty($ids) ? "`id` in (" . implode(',', $ids) . ")" : ' 1=2 ';
        
        if ($isDisplay === 0 || $isDisplay === 1) {
            $whereArray[] = "`isDisplay` = {$isDisplay}";
        }
        $whereString = implode(' AND ', $whereArray);
        $rows = parent::fetchAll($whereString, "orderNumber");
        
        Zend_Loader::loadClass('Project_View_Helper_ProjectUrl');
        $projectUrl = new Project_View_Helper_ProjectUrl();
        $content = '';
        foreach ($rows as $n=>$row) {
            $parentIdsTemporary = $parentIds;
            $parentIdsTemporary[] = $row['id'];
            $temporarContent = $templateContent;
            preg_match_all("/\{%field:([\d\w_]+)%\/\}/", $temporarContent, $result);

            //处理其他的url请求
            $requestParamsArray = array();
            if (!empty($row['requestParams'])) {
                $paramsArray = explode('&', $row['requestParams']);
                foreach($paramsArray as $params) {
                   $array = explode('=', $params);
                   @$requestParamsArray[$array[0]] = $array[1];
                }
            }

            foreach ($result[1] as $key => $field) {
                if (isset($row[$field])) {
                    $value = $row[$field];
                } else if ($field == 'loopKey') {
                    $value = $loopKey;
                } else if ($field == 'loopKeys') {
                    $value = $cardinalNumber * $loopKey;
                } else if ($field == 'key') {
                    $value = $n;
                } else if ($field == 'url') {
                    if (!empty($row['module']) && !empty($row['controller']) && !empty($row['action'])) {
                        $urlArray = array('module' => $row['module'], 'controller' => $row['controller'], 'action' => $row['action']);
                        $urlArray = array_merge($urlArray, $requestParamsArray);
                        $value = $projectUrl->projectUrl($urlArray);
                    } else {
                        $value = '';
                    }
                } else if ($field == 'linkName') {
                    if (!empty($row['module']) && !empty($row['controller']) && !empty($row['action'])) {
                        $urlArray = array('module' => $row['module'], 'controller' => $row['controller'], 'action' => $row['action']);
                        $urlArray = array_merge($urlArray, $requestParamsArray);
                        $value = "<a href=\"{$projectUrl->projectUrl($urlArray)}\" target=\"{$row['target']}\">{$row['name']}</a>";
                    } else {
                        $value = $row['name'];
                    }
                } else if ($field == 'parentIds'){
                    $value = implode('_', $parentIdsTemporary);
                } else if ($field == 'children') {
                    if ($this->getChildrenNumber($row['id'], $isDisplay, 1) > 0) {
                        $loopKeyTemporary = $loopKey+1;
                        $value = $this->getAccessAllowCatalogList($templateContent, $row['id'], $ids, $isDisplay, $cardinalNumber, $loopKeyTemporary, $parentIdsTemporary);
                    } else {
                        $value = '';
                    }
                } else {
                    $value = '';
                }
                $temporarContent = str_replace($result[0][$key], $value, $temporarContent);
            }
            $content .= $temporarContent;

        }
        return $content;
    }

    /**
     * 获取子类的个数
     * 
     * @param  integer $parentId
     * 
     * @return integer
     */
    public function getChildrenNumber($parentId, $isDisplay = NULL, $noSystemUserIsDisplay = NULL)
    {
        $whereArray = array();
        $whereArray[] = "`parentId` = {$parentId}";
        if ($isDisplay === 0 || $isDisplay === 1) {
            $whereArray[] = "`isDisplay` = {$isDisplay}";
        }
        if ($noSystemUserIsDisplay === 0 || $noSystemUserIsDisplay === 1) {
            $whereArray[] = "`noSystemUserIsDisplay` = {$noSystemUserIsDisplay}";
        }
        $whereString = implode(' AND ', $whereArray);
        $whereString = $whereString != '' ? " WHERE {$whereString} " : '';
        $sql = "SELECT count(*) AS c FROM `{$this->getTableName()}` {$whereString}";
        $row = $this->_db->fetchRow($sql);
        return $row['c'];
    }

    /**
     * 删除自己及子类
     * 
     * @param  integer $id
     * 
     * @return integer
     */
    public function delete($id)
    {
        $rows = $this->fetchAll("`parentId` = {$id}");
        foreach ($rows as $row) {
            $this->delete($row['id']);
        }
        parent::delete("`id` = {$id}");
    }
    
    /**
     * 递归更新显示属性
     * 
     * @param  integer $id
     * @param  integer $isDisplay
     * @param  integer $noSystemUserIsDisplay
     * 
     * @return integer
     */
    public function updateDisplayParams($id, $isDisplay, $noSystemUserIsDisplay)
    {
        $row = $this->_db->fetchRow("SELECT `parentId` FROM `{$this->getTableName()}` WHERE `id` = {$id}");
        if (empty($row)) {
            exit;
        }
        if ($noSystemUserIsDisplay == 0) {
            $isDisplay = 0;
        }
        if ($isDisplay == 1) {//如果可以显示
            $this->updateToParent($row['parentId'], array('isDisplay'=>$isDisplay, 'noSystemUserIsDisplay'=>$noSystemUserIsDisplay));//父目录全部显示
        } else if ($isDisplay == 0) {
            $this->updateToChildren($id, array('isDisplay'=>$isDisplay));//子目录全部不显示
            if ($noSystemUserIsDisplay == 1) {
                $this->updateToParent($row['parentId'], array('noSystemUserIsDisplay'=>$noSystemUserIsDisplay));//子目录全部不显示
            } else if ($noSystemUserIsDisplay == 0) {
                $this->updateToChildren($id, array('noSystemUserIsDisplay'=>$noSystemUserIsDisplay));//子目录全部不显示
            }
        }
    }

    /**
     * 递归更新(向父目录更新)
     * 
     * @param  integer $parentId
     * @param  array $updateRow
     * 
     * @return void
     */
    public function updateToParent($parentId, $updateRow)
    {
        $number = parent::update($updateRow, "`id` = {$parentId}");
        if ($number>0) {
            $row = $this->_db->fetchRow("SELECT `parentId` FROM `{$this->getTableName()}` WHERE `id` = {$parentId}");
            if ($row['parentId'] != 0) {
                $this->updateToParent($row['parentId'], $updateRow);
            }
        }
    }

    /**
     * 递归更新(向子目录更新)
     * 
     * @param  integer $parentId
     * @param  array $updateRow
     * 
     * @return void
     */
    public function updateToChildren($parentId, $updateRow)
    {
        $number = parent::update($updateRow, "`parentId` = {$parentId}");
        if ($number>0) {
            $rows = $this->_db->fetchAll("SELECT `id` FROM `{$this->getTableName()}` WHERE `parentId` = {$parentId}");
            foreach($rows as $row) {
                $this->updateToChildren($row['id'], $updateRow);
            }
        }
    }

    /**
     * 通过获取当前类别和所有父类记录集
     * 
     * @param  integer $id
     * @param  array $fieldArray
     * 
     * @return array
     */
    public function getParentRows($id, $fieldArray = array('*'))
    {
        $rows = array();
        $field = '';
        if (in_array('*', $fieldArray)) {
            $field = '*';
            $fieldArray = array('*');
        } else {
            if (!in_array('parentId', $fieldArray)) {
                $fieldArray[] = 'parentId';
            }
            $field = '`' . implode('`, `', $fieldArray) . '`';
        }
        $row = $this->_db->fetchRow("SELECT {$field} FROM `{$this->getTableName()}` WHERE `id` = {$id}");
        if (!empty($row)) {
            $rows[] = $row;
            if ($row['parentId'] != 0) {
                $rows[] = $this->getParentRows($row['parentId'], $fieldArray);
            }
        }
        return $rows;
    }

    /**
     * 获取权限控制是否存在
     * 
     * @param  string $module
     * @param  string $controller
     * @param  string $action
     * @param  integer $id
     * 
     * @return integer
     */
    public function accessControlIsExists($module, $controller, $action, $id = 0)
    {
        $where = '';
        $where .= ' WHERE `module` = ' . $this->_db->quote($module) . ' AND `controller` = ' . $this->_db->quote($controller) . ' AND `action` = ' . $this->_db->quote($action);
        $where .= $id != 0 ? " AND `id` <> {$id}" : '';
        
        $sql = "SELECT count(*) AS c FROM `{$this->getTableName()}` {$where}";
        $row = $this->_db->fetchRow($sql);
        $isExists = $row['c'] > 0 ? 1 : 0;
        return $isExists;  
    }

    /**
     * 此访问权限是否被允许
     * 
     * @param  string $module
     * @param  string $controller
     * @param  string $action
     * 
     * @return array
     */
    public function getAccessControlRow($module, $controller, $action)
    {
        $where = '';
        $where .= ' WHERE `module` = ' . $this->_db->quote($module) . ' AND `controller` = ' . $this->_db->quote($controller) . ' AND `action` = ' . $this->_db->quote($action);
        
        $sql = "SELECT `id` FROM `{$this->getTableName()}` {$where}";
        $row = $this->_db->fetchRow($sql);
        
        return $row;  
    }
}