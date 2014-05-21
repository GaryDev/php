<?php
/**
 * 档案
 *
 * @author cdlei
 */

class Application_Model_Archives extends Application_Model_Common
{
    /**
     * 表名
     *
     * @var string
     */
    protected $_name= 'archives';

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
     * 获取上传文件内部物理路径
     * 
     * @param  integer $id
     * @return string
     */
    public function getFilePath($id)
    {
        $id = strlen($id) < 9 ? str_repeat('0', 9 - strlen($id)) . $id : $id;

        $len = strlen($id);
        $dir3 = substr($id, -3);
        $dir2 = substr($id, -6, 3);
        $dir1 = substr($id, $len*(-1), $len - 6);
        $path = "/archives/{$dir1}/{$dir2}/{$dir3}";
        return $path;
    }

    /**
     * 获取上传文件URL路径
     * 
     * @param  integer $id
     * @return string
     */
    public function getFileUrl($id)
    {
        $id = strlen($id) < 9 ? str_repeat('0', 9 - strlen($id)) . $id : $id;

        $len = strlen($id);
        $dir3 = substr($id, -3);
        $dir2 = substr($id, -6, 3);
        $dir1 = substr($id, $len*(-1), $len - 6);
        $path = "/archives/{$dir1}/{$dir2}/{$dir3}";
        return $path;
    }

    /**
     * 获取临时文件文件物理路径
     * 
     * @param  string $directoryName
     * @return string
     */
    public function getTemporaryFilePath($directoryName)
    {
        $path = "/archives/temporary/{$directoryName}";
        return $path;
    }

    /**
     * 获取临时文件文件物理路径
     * 
     * @param  string $directoryName
     * @return string
     */
    public function getTemporaryFileUrl($directoryName)
    {
        $path = "/archives/temporary/{$directoryName}";
        return $path;
    }

    /**
     * 通过ID删除记录
     *
     * @param integer $id
     * @return void
     */
    public function deleteById($id)
    {
        $row = $this->fetchRow("`id` = {$id}");
        if (!empty($row)) {
            $archivesPath = $this->_configs['project']['uploadPath'] . $this->getFilePath($row['id']);
            if (is_dir($archivesPath)) {
                deleteDirectory($archivesPath);
            }
            $this->delete("`id` = '{$id}'");
        }
    }
}