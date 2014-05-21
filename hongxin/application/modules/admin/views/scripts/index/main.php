<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/admin/css/public.css" rel="stylesheet"/>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/admin/scripts/load.js"></script>
<title><?php echo $this->title;?></title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="navigation">
    <tr>
        <td class="content"><span class="description">当前位置：系统信息</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <tr>
        <td>系统名称：</td>
        <td><?php echo $this->systemName;?></td>
    </tr>
    <tr>
        <td>服务器名称：</td>
        <td><?php echo $_SERVER['SERVER_NAME'];?></td>
    </tr>
    <tr>
        <td>服务器软件：</td>
        <td><?php echo $_SERVER['SERVER_SOFTWARE'];?></td>
    </tr>
    <tr>
        <td>数据库版本：</td>
        <td><?php echo $this->mysqlVersion;?></td>
    </tr>
    <tr>
        <td>数据库当前大小：</td>
        <td><?php echo $this->dbSize;?></td>
    </tr>
    <tr>
        <td>上传最大许可：</td>
        <td><?php echo $this->uploadInfo;?></td>
    </tr>

</table>
</body>
</html>