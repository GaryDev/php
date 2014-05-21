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
        <td class="content"><span class="description">当前位置：</span><a href="<?php echo $this->projectUrl(array('action'=>'index')) ;?>">客服列表</a> &gt; 添加</td>
    </tr>
</table>
<form action="" method="post" enctype="multipart/form-data" name="editorForm" id="editorForm">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
        	<td width="12%">工号：</td>
        	<td width="88%"><input name="code" type="text" class="input" id="code" size="50" maxlength="20" value="<?php echo $this->defaultCode;?>" />
英文字母、数字以及下划线，长度5-20个字符。</td>
       	</tr>
        <tr>
        	<td>状态：</td>
        	<td>
				<label><input name="status" type="radio" id="radio" value="1" checked="checked" /> 正常</label>
				<label><input type="radio" name="status" id="radio2" value="2" /> 关闭</label>			</td>
       	</tr>
        <tr>
            <td>姓名：</td>
            <td><input name="name" type="text" class="input" id="name" size="50" maxlength="50" />
                填写真实姓名。</td>
        </tr>
        <tr>
            <td>QQ：</td>
            <td><input name="qq" type="text" class="input" id="qq" size="50" maxlength="50" /></td>
        </tr>
        <tr>
            <td>E-mail：</td>
            <td><input name="email" type="text" class="input" id="email" size="50" maxlength="50" /></td>
        </tr>
        <tr>
            <td>电话：</td>
            <td><input name="tel" type="text" class="input" id="tel" size="50" maxlength="50" value=""/></td>
        </tr>
        <tr>
        	<td>照片：</td>
        	<td><input type="file" name="avatarPhoto" id="avatarPhoto" /></td>
       	</tr>
        <tr>
            <td>描述：</td>
            <td><textarea name="description" id="description" cols="50" rows="5" class="input inputCommonSize" ></textarea></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input name="submit" type="submit" id="submit" value="提交" class="button" /></td>
        </tr>
    </table>
</form>
</body>
</html>