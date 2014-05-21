<?php

/**
 * 档案
 *
 * @author cdlei
 */

require_once 'CommonController.php';

class Admin_ArchivesController extends Admin_CommonController
{
    /**
     * 初始化函数
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_Archives();
        $this->view->title = "管理中心";
    }

    /**
     * 默认动作
     * 
     * @return void
     */
    public function indexAction()
    {   
        $archivesClassModel = new Application_Model_ArchivesClass();

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

        $vars['title'] = trim($this->_request->get('title'));
        $vars['classId'] = intval($this->_request->get('classId'));
        $vars['status'] = intval($this->_request->get('status'));
        if ($vars['title'] != '') {
            $wheres[] = "`title` LIKE '%" . addslashes($vars['title']) . "%'";
        }
        if (!empty($vars['classId'])) {
            $wheres[] = "`classId` = {$vars['classId']}";
        }
        if ($vars['status']) {
            $wheres[] = "`status` = '{$vars['status']}'";
        }

        //设置URL模板
        $urls = $vars;
        $urls['pageNo'] = '{page}';
        $urlTemplate = $this->view->projectUrl($urls);

        //获取总页数以及记录
        $where = count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) . ' ' : '';
        $sql = "SELECT `a`.*, `ac`.`name` AS `className` FROM `{$this->_model->getTableName()}` AS `a` 
            LEFT JOIN `{$archivesClassModel->getTableName()}` AS `ac` ON (`a`.`classId` = `ac`.`id`) 
            {$where} ORDER BY `a`.`orderNumber` DESC, `a`.`id` DESC";
        $dbPaginator = new Application_Model_DbPaginator($sql, $pageSize, $pageNo);
        $recordCount = $dbPaginator->getRecodCount();

        //获取分页html字符
        Zend_Loader::loadClass('Project_Paginator');
        $paginator = new Project_Paginator($recordCount, $pageSize, $pageNo);
        $paginator->urlTemplateContent = $urlTemplate;
        $rows = $dbPaginator->getRows();

        $archivesClassRows = $archivesClassModel->fetchAll(NULL, "orderNumber DESC");

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
        $this->view->archivesClassRows = $archivesClassRows;
    }

    /**
     * 添加
     * 
     * @return void
     */
    public function insertAction()
    {
        $temporarySpace = $this->_request->get('temporarySpace');
        $time = time();
        if (trim($this->_request->get('temporarySpace')) == '') {
            redirect($this->view->url(array('temporarySpace'=>date('YmdHis', $time) . rand(1000, 9999))));
        }
        $classId = intval($this->_request->get('classId'));

        $archivesClassModel = new Application_Model_ArchivesClass();
        $archivesClassRows = $archivesClassModel->fetchAll(NULL, "orderNumber DESC");

        $this->view->temporarySpace = $temporarySpace;
        $this->view->classId = $classId;
        $this->view->archivesClassRows = $archivesClassRows;

        if ($this->_request->isPost()) {
            $field = array();
            $field['classId'] = intval($this->_request->getPost('classId'));
            $field['isLink'] = $this->_request->getPost('isLink') != NULL ? 1 : 0;
            $field['linkUrl'] = trim($this->_request->getPost('linkUrl'));
            $field['status'] = trim($this->_request->getPost('status'));
            $field['title'] = htmlspecialchars(trim($this->_request->getPost('title')));
            $field['picture'] = '';
            $field['content'] = preg_replace("/<[\/]{0,1}(script|iframe|frame).*?>/i", '', trim($this->_request->getPost('content')));
            $field['addTime'] = $time;
            $field['updateTime'] = $time;
            $field['orderNumber'] = 0;

            if (strlen($field['title']) < 1) {
                echo $this->view->message('标题，不能为空！', 'javascript:history.go(-1);') ;
                exit;
            }
            if ($field['classId'] == 0) {
                echo $this->view->message('请选择一个分类！', 'javascript:history.go(-1);') ;
                exit;
            }

            //上传图片
            $uploadFileExtension = array('jpg', 'jpeg', 'png', 'gif');
            $maxSize = 1024 * 1024 * 1;

            $files = $_FILES;
            $picture = '';
            if (isset($files['picture']) && $files['picture']['error'] != 4) {
                if ($files['picture']['error'] == 6) {
                    echo $this->view->message('上传临时文件夹错误，请与管理员联系！', 'javascript:history.go(-1);') ;
                    exit;
                } else if ($files['picture']['error'] == 7) {
                    echo $this->view->message('上传不可写，请与管理员联系！', 'javascript:history.go(-1);') ;
                    exit;
                } else if ($files['picture']['error'] != 0 && $files['picture']['error'] != 4) {
                    echo $this->view->message('其他上传错误！', 'javascript:history.go(-1);') ;
                    exit;
                }
                if ($files['picture']['size'] > $maxSize) {
                    echo $this->view->message("上传的文件必须小于" . sizeToString($maxSize) . "！", 'javascript:history.go(-1);') ;
                    exit;
                }

                //检查文件扩展名是否正确
                $extension = strtolower(substr(strrchr($files['picture']['name'], "."), 1));
                if (!in_array($extension, $uploadFileExtension)) {
                    echo $this->view->message("上传文件只允许" . implode(',', $uploadFileExtension) . "格式的文件！", 'javascript:history.go(-1);') ;
                    exit;  
                }
                $picture = '/' . $time . rand(1000, 9999) . '.' . $extension;
            }

            //插入
            $id = $this->_model->insert($field);

            //替换临时文件夹里的内容
            $relativeTemporaryFileUrl = $this->_model->getTemporaryFileUrl($temporarySpace);
            $relativeFileUrl = $this->_model->getFileUrl($id);
            $temporaryFilePath = $this->_configs['project']['uploadPath'] . $this->_model->getTemporaryFilePath($temporarySpace);
            $filePath = $this->_configs['project']['uploadPath'] . $this->_model->getFilePath($id);

            $updateField = array();
            if (!empty($picture)) {
                createDirectory($filePath);
                move_uploaded_file($files['picture']['tmp_name'], $filePath . $picture);
                $updateField['picture'] = $picture;
            }
            if (is_dir($temporaryFilePath)) {
                createDirectory($filePath);//创建文件夹
                moveFiles($temporaryFilePath, $filePath);//移动临时文件夹中的文件
                deleteDirectory($temporaryFilePath);//删除临时文件夹
                $updateField['content'] = str_replace($relativeTemporaryFileUrl, $relativeFileUrl, $field['content']);
            }
            if (!empty($updateField)) {
                $this->_model->update($updateField, "`id` = {$id}");
            }
            redirect($this->view->url(array('action'=>'insert-success', 'classId'=>$field['classId'], 'successId'=>$id)));
        }
    }

    /**
     * 添加成功
     * 
     * @return void
     */
    public function insertSuccessAction()
    {
        $classId = $this->_request->get('classId');
        $successId = $this->_request->get('successId');
        $this->view->classId = $classId;
        $this->view->successId = $successId;
    }
    
    /**
     * 更新
     * 
     * @return void
     */
    public function updateAction()
    {
        $time = time();
        $id = intval($this->_request->get('id'));
        $backUrl = trim($this->_request->get('backUrl')) != '' ? urldecode($this->_request->get('backUrl')) : $this->view->url();

        $row = $this->_model->fetchRow("`id` = {$id}"); 
        if (empty($row)) {
            echo $this->view->message('记录不存在，请返回重试！', $backUrl) ;
            exit;
        }
        $row['pictureUrl'] = !empty($row['picture']) ? $this->_configs['project']['uploadUrl'] . $this->_model->getFileUrl($id) . $row['picture'] . '?' . rand(100, 999) : NULL;

        $archivesClassModel = new Application_Model_ArchivesClass();
        $archivesClassRows = $archivesClassModel->fetchAll(NULL, "orderNumber DESC");

        $this->view->row = $row;
        $this->view->backUrl = $backUrl;
        $this->view->archivesClassRows = $archivesClassRows;

        if ($this->_request->isPost()) {
            $field = array();
            $field['classId'] = intval($this->_request->getPost('classId'));
            $field['isLink'] = $this->_request->getPost('isLink') != NULL ? 1 : 0;
            $field['linkUrl'] = trim($this->_request->getPost('linkUrl'));
            $field['status'] = trim($this->_request->getPost('status'));
            $field['title'] = htmlspecialchars(trim($this->_request->getPost('title')));
            $field['content'] = preg_replace("/<[\/]{0,1}(script|iframe|frame).*?>/i", '', trim($this->_request->getPost('content')));
            $field['updateTime'] = @strtotime(trim($this->_request->getPost('updateTime')));
            $filePath = $this->_configs['project']['uploadPath'] . $this->_model->getFilePath($id);

            if (strlen($field['title']) < 1) {
                echo $this->view->message('标题，不能为空！', 'javascript:history.go(-1);') ;
                exit;
            }
            if ($field['classId'] == 0) {
                echo $this->view->message('请选择一个分类！', 'javascript:history.go(-1);') ;
                exit;
            }

            //上传图片
            $uploadFileExtension = array('jpg', 'jpeg', 'png', 'gif');
            $maxSize = 1024 * 1024 * 1;

            $files = $_FILES;
            $picture = '';
            if (isset($files['picture']) && $files['picture']['error'] != 4) {
                if ($files['picture']['error'] == 6) {
                    echo $this->view->message('上传临时文件夹错误，请与管理员联系！', 'javascript:history.go(-1);') ;
                    exit;
                } else if ($files['picture']['error'] == 7) {
                    echo $this->view->message('上传不可写，请与管理员联系！', 'javascript:history.go(-1);') ;
                    exit;
                } else if ($files['picture']['error'] != 0 && $files['picture']['error'] != 4) {
                    echo $this->view->message('其他上传错误！', 'javascript:history.go(-1);') ;
                    exit;
                }
                if ($files['picture']['size'] > $maxSize) {
                    echo $this->view->message("上传的文件必须小于" . sizeToString($maxSize) . "！", 'javascript:history.go(-1);') ;
                    exit;
                }

                //检查文件扩展名是否正确
                $extension = strtolower(substr(strrchr($files['picture']['name'], "."), 1));
                if (!in_array($extension, $uploadFileExtension)) {
                    echo $this->view->message("上传文件只允许" . implode(',', $uploadFileExtension) . "格式的文件！", 'javascript:history.go(-1);') ;
                    exit;  
                }
                if (empty($row['picture'])) {
                    $field['picture'] = '/' . $time . rand(1000, 9999) . '.' . $extension;
                } else {
                    $field['picture'] = $row['picture'];
                    if (is_file($filePath . $row['picture'])) {
                        unlink($filePath . $row['picture']);
                    }
                }
                createDirectory($filePath);
                move_uploaded_file($files['picture']['tmp_name'], $filePath  . $field['picture']);
            }
            if (!isset($field['picture']) && !empty($row['picture']) && $this->_request->getPost('deletePicture') !== NULL) {
                @unlink($filePath  . $row['picture']);
                $field['picture'] = '';
            }

            //更新
            $this->_model->update($field, "`id` = {$id}");
            echo $this->view->message('操作成功。', $backUrl) ;
            exit;
        }
    }

    /**
     * 编辑器上传
     * 
     * @return void
     */
    public function editorUploadAction()
    {
        $id = intval($this->_request->get('id'));
        $temporarySpace = $this->_request->get('temporarySpace');
        $fileType = $this->_request->get('fileType');
        $fileType = in_array($fileType, array('picture', 'attachment')) ? $fileType : 'picture';

        if (!empty($id)) {
            $contentCategoryUplodPath = $this->_model->getFilePath($id) . '/editor';
            $contentCategoryUplodUrl = $this->_model->getFileUrl($id) . '/editor';
        } else if (!empty($temporarySpace)) {
            $contentCategoryUplodPath = $this->_model->getTemporaryFilePath($temporarySpace) . '/editor';
            $contentCategoryUplodUrl = $this->_model->getTemporaryFileUrl($temporarySpace) . '/editor'; 
        } else {
            exit("没有上传路径！");
        }

        $editorUploadObj = new Application_Model_EditorUpload();
        if ($fileType == 'picture') {
            $editorUploadObj->setFileType(explode(',', 'gif,jpg,jpeg,png'));
        } else {
            $editorUploadObj->setFileType(explode(',', 'gif,jpg,jpeg,png'));
        }

        $editorFuncNum = $this->_request->get('CKEditorFuncNum');
        $editorUploadObj->upload($contentCategoryUplodPath, $contentCategoryUplodUrl, $editorFuncNum, $isWaterMark = 0, array('width'=>700, 'height'=>0));
    }

    /**
     * 修改排序动作
     * 
     * @return void
     */
    public function setOrderAction()
    { 
        //排序
        $ids = $this->_request->get('id');
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $row = array();
                $row['orderNumber'] = intval($this->_request->get("orderNumber{$id}"));
                $this->_model->update($row, "`id` = {$id}");
            }
        }
        $backUrl = urldecode($this->_request->get('backUrl'));
        redirect($backUrl);
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