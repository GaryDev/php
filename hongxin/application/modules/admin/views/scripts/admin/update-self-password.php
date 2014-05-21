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
        <td class="content"><span class="description">当前位置：</span>修改密码</td>
    </tr>
</table>
<form id="editorForm" name="editorForm" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
            <td width="12%">用户名：</td>
            <td width="88%"><?php echo $this->currentUserRow['userName'];?></td>
        </tr>
        <tr>
            <td>原密码：</td>
            <td><input name="oldPassword" type="password" class="input" id="oldPassword" size="50" maxlength="20" /> 
            长度5-20个字符。</td>
        </tr>
        <tr>
            <td>新密码：</td>
            <td><input name="password" type="password" class="input" id="password" size="50" maxlength="20" />
长度5-20个字符。</td>
        </tr>
        <tr>
            <td>确认新密码：</td>
            <td><input name="password2" type="password" class="input" id="password2" size="50" maxlength="20" />
请再输入一次新密码。</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input name="submit" type="submit" id="submit" value="提交" class="button" /></td>
        </tr>
    </table>
</form>
</body>
</html>