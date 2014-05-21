<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/admin/css/public.css" rel="stylesheet"/>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/admin/scripts/load.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl;?>/files/editor/ckeditor.js"></script>
<title><?php echo $this->title;?></title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="navigation">
    <tr>
        <td class="content"><span class="description">当前位置：</span><a href="<?php echo $this->projectUrl(array('action'=>'index', 'classId'=>$this->classId)) ;?>">信息列表</a> &gt; 添加信息</td>
    </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
	<tr>
		<td align="center"><b>添加成功</b></td>
	</tr>
	<tr>
		<td>你可以选择操作：<a href="<?php echo $this->projectUrl(array('action'=>'index', 'classId'=>$this->classId)) ;?>">返回列表</a> <a href="<?php echo $this->projectUrl(array('action'=>'insert', 'classId'=>$this->classId)) ;?>">继续添加</a></td>
	</tr>
</table>
</body>
</html>