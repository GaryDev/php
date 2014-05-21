<?php

/**
 * 编辑器上传
 *
 * @author cdlei
 */

class Application_Model_EditorUpload
{
    /**
     * 配置
     *
     * @var array
     */
    protected $_configs;

    /**
     * 允许的文件类型
     *
     * @var array
     */
    protected $_fileType = array('jpg', 'jpeg', 'png', 'gif');

    /**
     * 构造函数
     * 
     * @return void
     */
    public function __construct()
    {
        $config = new Application_Model_Config();
        $this->_configs = $config->getConfigs();
    }

    /**
     * 上传
     * 
     * @param  string $uploadPath
     * @param  string $uploadUrl
     * @param  integer $isWaterMark
     * @param  array $resize
     * 
     * @return string
     */
    public function upload($uploadPath, $uploadUrl, $editorFuncNum, $isWaterMark, $resize = array())
    {
        $uploadFileExtension = $this->_fileType;
        $minSize = 1024;
        $maxSize = 1024 * 1024 * 2;

        $defaultMonthDirectory = date('Y-m');
        if (!empty($uploadPath)) {
            $uploadPath = $this->_configs['project']['uploadPath'] . $uploadPath;
        } else {
            $uploadPath = $this->_configs['project']['uploadPath'] . '/' . $defaultMonthDirectory;
        }

        if (!empty($uploadUrl)) {
            $uploadUrl = $this->_configs['project']['uploadUrl'] . $uploadUrl;
        } else {
            $uploadUrl = $this->_configs['project']['uploadUrl'] . '/' . $defaultMonthDirectory;
        }

        $files = $_FILES;

        //检查商上传错误
        if (!isset($files['upload'])) {
            echo $this->mkHtml($editorFuncNum, '', '没有上传！');
            exit;
        }
        if ($files['upload']['error'] == 4) {
            echo $this->mkHtml($editorFuncNum, '', '请选择一个文件再上传！');
            exit;
        } else if ($files['upload']['error'] == 6) {
            echo $this->mkHtml($editorFuncNum, '', '上传临时文件夹错误，请与管理员联系！');
            exit;
        } else if ($files['upload']['error'] == 7) {
            echo $this->mkHtml($editorFuncNum, '', '上传不可写，请与管理员联系！');
            exit;
        } else if ($files['upload']['error'] != 0) {
            echo $this->mkHtml($editorFuncNum, '', '其他上传错误，请与管理员联系！');
            exit;
        }

        //检查文件大小是否正确
        if ($files['upload']['size'] < $minSize) {
            echo $this->mkHtml($editorFuncNum, '', "上传的文件必须大于" . sizeToString($minSize) . "！");
            exit; 
        } else if ($files['upload']['size'] > $maxSize) {
            echo $this->mkHtml($editorFuncNum, '', "上传的文件必须小于" . sizeToString($maxSize) . "！");
            exit;    
        }

        //检查文件扩展名是否正确
        $extension = strtolower(substr(strrchr($files['upload']['name'], "."), 1));
        if (!in_array($extension, $uploadFileExtension)) {
            echo $this->mkHtml($editorFuncNum, '', "上传文件只允许" . implode(',', $uploadFileExtension) . "格式的文件！");
            exit;    
        }
        
        if (@is_dir($uploadPath) === false) {//自动创建文件夹
            createDirectory($uploadPath);
        }

        //保存文件
        $file = time() . rand(1000, 9999) . '.' . $extension;
        move_uploaded_file($files['upload']['tmp_name'], $uploadPath . '/' . $file);

        if (isset($resize['width']) || isset($resize['height'])) {
            imageResize($uploadPath . '/' . $file, $resize['width'], $resize['height']);
        }
        if ($isWaterMark == 1) {
            //$waterMarkFile = PUBLIC_PATH . '/files/publicFiles/images/logoWater.png';
            //imageWaterMark($uploadPath . '/' . $file, $waterMarkFile, -30, -30);
        }
        echo $this->mkHtml($editorFuncNum, "{$uploadUrl}/{$file}");
        exit;
    }

    /**
     * 写html
     * 
     * @param  string $fn
     * @param  string $fileUrl
     * @param  string $message
     * @return string
     */
    public function mkHtml($fn, $fileUrl, $message = '')
    {
        if ($message != '') {
            $messageParams = ",'{$message}'";
        } else {
            $messageParams = '';
        }
        $str='
            <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/html4/loose.dtd">
            <html>
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset = utf-8">
            <title>上传</title>
            </head>
            
            <body><script type="text/javascript">' . "window.parent.CKEDITOR.tools.callFunction({$fn}, '{$fileUrl}'{$messageParams});" . '</script></body>
            </html>
        ';
        return $str;
    }


    /**
     * 设置上传的文件类型
     * 
     * @param  array $fileType
     * @return void
     */
    public function setFileType($fileType)
    {
        $this->_fileType = $fileType;
    }
}