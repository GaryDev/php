<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/admin/css/login.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/admin/scripts/load.js"></script>
<script language="javascript">
function loginCheck()
{
    if ($.trim($("#userName").val()) == ''){
        alert("请填写用户名！");
        $("#userName").focus();
        return false;
    }
    if ($.trim($("#password").val()) == ''){
        alert("请填写密码！");
        $("#password").focus();
        return false;
    }
    if ($.trim($("#code").val()) == ''){
        alert("请填写验证码！");
        $("#code").focus();
        return false;
    }
}
</script>
<title><?php echo $this->title;?></title>
</head>

<body>
<div id="main">
	<div id="title"><?php echo $this->systemName;?></div>
	<div id="login">
		<form id="loginForm" name="loginForm" method="post" action="" onsubmit="return loginCheck();">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="30" align="right">用户名：</td>
					<td height="30"><input name="userName" type="text" id="userName" style="border:#2B4A99 solid 1px; width:150px;" /></td>
				</tr>
				<tr>
					<td height="30" align="right">密码：</td>
					<td height="30"><input name="password" type="password" id="password"  style="border:#2B4A99 solid 1px; width:150px;" /></td>
				</tr>
				<tr>
					<td height="30" align="right">验证码：</td>
					<td height="30"><input name="code" type="text" id="code"  style="border:#2B4A99 solid 1px;" size="8" /> <img src="<?php echo $this->projectUrl(array('controller' => 'image-code', 'rand' => rand(100, 999)));?>" name="codeImage" border="0" align="absmiddle" id="codeImage" onclick="$('#codeImage').attr('src', '<?php echo $this->projectUrl(array('controller' => 'image-code', 'action' => 'index', 'rand' => 1));?>' + Math.random());" style="text-decoration:underline; cursor:pointer;"/></td>
				</tr>
				<tr>
					<td height="30" align="right">&nbsp;</td>
					<td height="30" align="left"><input name="loginBtn" type="submit" id="loginBtn" value="登 陆" class="buttom"/></td>
				</tr>
			</table>
		</form>
	</div>
	<div style="clear:both"></div>
</div>
</body>
</html>