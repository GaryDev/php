<?php

/**
 * 客服
 *
 * @author cdlei
 */

require_once 'CommonController.php';

class Admin_ServiceController extends Admin_CommonController
{
    /**
     * 初始化函数
     * 
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new Application_Model_Service();
        $this->view->title = "管理中心";
    }

    /**
     * 默认动作
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

        $code = trim($this->_request->get('code'));
        $this->view->code = trim($code);

        $name = trim($this->_request->get('name'));
        $this->view->name = $name;

        $qq = trim($this->_request->get('qq'));
        $this->view->qq = $qq;

        if ($code != '') {
            $wheres[] = "`code` = '" . addslashes($code) . "'";
            $urls['code'] = $code;
        }
        if ($name != '') {
            $wheres[] = "`name` = '" . addslashes($name) . "'";
            $urls['name'] = $name;
        }
        if ($qq != '') {
            $wheres[] = "`qq` = '" . addslashes($qq) . "'";
            $urls['qq'] = $qq;
        }
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

    /**
     * 添加动作
     * 
     * @return void
     */
    public function insertAction()
    {
        $row = $this->_model->fetchRow(NULL, "id desc"); 
        $this->view->defaultCode = !empty($row) ? $row['id'] + 1000 + 1 : 1001;
        $time = time();

        if ($this->_request->isPost()) {
            $row = array();
            $filter = new Zend_Filter_StripTags();
            $row['code'] = $filter->filter(trim($this->_request->getPost('code')));
            $row['status'] = $filter->filter(trim($this->_request->getPost('status')));
            $row['name'] = $filter->filter(trim($this->_request->getPost('name')));
            $row['qq'] = $filter->filter(trim($this->_request->getPost('qq')));
            $row['email'] = $filter->filter(trim($this->_request->getPost('email')));
            $row['tel'] = $filter->filter(trim($this->_request->getPost('tel')));
            $row['addUser'] = $this->_currentUserRow['userName'];
            $row['addTime'] = time();
            $row['description'] = $filter->filter(trim($this->_request->getPost('description')));

            //上传设置
            $uploadFileExtension = array('jpg', 'jpeg', 'png', 'gif');
            $maxSize = 1024 * 1024 * 2;

            $files = $_FILES;

            if (isset($files['avatarPhoto']) && $files['avatarPhoto']['error'] != 4) {
                if ($files['avatarPhoto']['error'] == 6) {
                    echo $this->view->message('上传临时文件夹错误，请与管理员联系！') ;
                    exit;
                } else if ($files['avatarPhoto']['error'] == 7) {
                    echo $this->view->message('上传不可写，请与管理员联系！') ;
                    exit;
                } else if ($files['avatarPhoto']['error'] != 0 && $files['avatarPhoto']['error'] != 4) {
                    echo $this->view->message('其他上传错误！') ;
                    exit;
                }
                if ($files['avatarPhoto']['size'] > $maxSize) {
                    echo $this->view->message("上传的文件必须小于" . sizeToString($maxSize) . "！") ;
                    exit;
                }

                //检查文件扩展名是否正确
                $extension = strtolower(substr(strrchr($files['avatarPhoto']['name'], "."), 1));
                if (!in_array($extension, $uploadFileExtension)) {
                    echo $this->view->message("上传文件只允许" . implode(',', $uploadFileExtension) . "格式的文件！") ;
                    exit;  
                }

                //记录入库
                $avatarDir = $this->_configs['project']['serviceAvatarBasePath'];
                $avatarPath = '/' . date('ymdHis', $time) . '.' . $extension;

                //保存文件
                createDirectory($avatarDir);//创建临时文件夹
                move_uploaded_file($files['avatarPhoto']['tmp_name'], $this->_configs['project']['serviceAvatarBasePath'] . $avatarPath);
                imageResize($this->_configs['project']['serviceAvatarBasePath'] . $avatarPath, 120, 120);
                $row['avatarPath'] = $avatarPath;
                
            }

            if (!(preg_match("/^[a-zA-Z0-9]{2,20}$/", $row['code']))) {
                echo $this->view->message('工号请填写英文字母、数字以及下划线2-20个字符！') ;
                exit;
            }
            if ($this->_model->codeIsExists($row['code'])) {
                echo $this->view->message('工号已经存在，请重新填写！') ;
                exit; 
            }
            if (strlen($row['name']) == 0) {
                echo $this->view->message('姓名不能为空，请重新填写！') ;
                exit;
            }
            $this->_model->insert($row);
            echo $this->view->message('操作成功！', $this->view->projectUrl(array('action' => 'index'))) ;
            exit;
        }
    }

    /**
     * 更新动作
     * 
     * @return void
     */
    public function updateAction()
    {
        $id = intval($this->_request->get('id'));
        if (empty($id)) {
             throw new Exception('Invalid params!');
        }
        $this->view->row = $userRow = $this->_model->fetchRow("`id` = {$id}"); 
        $backUrl = urldecode($this->_request->get('backUrl'));
        $time = time();

        if ($this->_request->isPost()) {
            $row = array();
            $filter = new Zend_Filter_StripTags();
            $row['code'] = $filter->filter(trim($this->_request->getPost('code')));
            $row['status'] = $filter->filter(trim($this->_request->getPost('status')));
            $row['name'] = $filter->filter(trim($this->_request->getPost('name')));
            $row['qq'] = $filter->filter(trim($this->_request->getPost('qq')));
            $row['email'] = $filter->filter(trim($this->_request->getPost('email')));
            $row['tel'] = $filter->filter(trim($this->_request->getPost('tel')));
            $row['description'] = $filter->filter(trim($this->_request->getPost('description')));

            //上传设置
            $uploadFileExtension = array('jpg', 'jpeg', 'png', 'gif');
            $maxSize = 1024 * 1024 * 2;

            $files = $_FILES;

            if (isset($files['avatarPhoto']) && $files['avatarPhoto']['error'] != 4) {
                if ($files['avatarPhoto']['error'] == 6) {
                    echo $this->view->message('上传临时文件夹错误，请与管理员联系！') ;
                    exit;
                } else if ($files['avatarPhoto']['error'] == 7) {
                    echo $this->view->message('上传不可写，请与管理员联系！') ;
                    exit;
                } else if ($files['avatarPhoto']['error'] != 0 && $files['avatarPhoto']['error'] != 4) {
                    echo $this->view->message('其他上传错误！') ;
                    exit;
                }
                if ($files['avatarPhoto']['size'] > $maxSize) {
                    echo $this->view->message("上传的文件必须小于" . sizeToString($maxSize) . "！") ;
                    exit;
                }

                //检查文件扩展名是否正确
                $extension = strtolower(substr(strrchr($files['avatarPhoto']['name'], "."), 1));
                if (!in_array($extension, $uploadFileExtension)) {
                    echo $this->view->message("上传文件只允许" . implode(',', $uploadFileExtension) . "格式的文件！") ;
                    exit;  
                }

                if (!empty($userRow['avatarPath'])) {
                    unlink($this->_configs['project']['serviceAvatarBasePath'] . $userRow['avatarPath']);
                }

                //记录入库
                $avatarDir = $this->_configs['project']['serviceAvatarBasePath'];
                $avatarPath = '/' . date('ymdHis', $time) . '.' . $extension;

                //保存文件
                createDirectory($avatarDir);//创建临时文件夹
                move_uploaded_file($files['avatarPhoto']['tmp_name'], $this->_configs['project']['serviceAvatarBasePath'] . $avatarPath);
                imageResize($this->_configs['project']['serviceAvatarBasePath'] . $avatarPath, 120, 120);
                $row['avatarPath'] = $avatarPath;
            }

            if ($this->_model->codeIsExists($row['code'], $id)) {
                echo $this->view->message('工号已经存在，请重新填写！') ;
                exit; 
            }
            if (strlen($row['name']) == 0) {
                echo $this->view->message('姓名不能为空，请重新填写！') ;
                exit;
            }

            $this->_model->update($row, "`id` = {$id}");
            echo $this->view->message('操作成功！', $backUrl) ;
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


    /**
     * 修改自己的密码
     * 
     * @return void
     */
    public function updateSelfPasswordAction()
    {
        if ($this->_request->isPost()) {
            $row = array();
            $oldPassword = trim($this->_request->getPost('oldPassword'));
            $password = trim($this->_request->getPost('password'));
            $password2 = trim($this->_request->getPost('password2'));
            
            if (empty($oldPassword)) {
                echo $this->view->message('请输入原密码！') ;
                exit;
            }
            if (strlen($password) > 20 || strlen($password) < 5) {
                echo $this->view->message('新密码长度不在5-20范围内，请重新填写！') ;
                exit;
            }
            if ($password != $password2) {
                echo $this->view->message('确认新密码和新密码填写不一致，请重新填写！') ;
                exit;
            }
            if ($this->_model->isRight($this->_currentUserRow['userName'], $oldPassword) == 0) {
                echo $this->view->message('原密码填写不正确，请重新填写！') ;
                exit;  
            }
            $row['password'] = md5($password);
            $this->_model->update($row, "`id` = {$this->_currentUserRow['id']}");
            echo $this->view->message('操作成功！', $this->view->projectUrl(array('controller' => 'index', 'action' => 'main'))) ;
            exit;
        } 
    }
}