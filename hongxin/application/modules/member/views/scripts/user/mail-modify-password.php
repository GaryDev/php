<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<link rel="stylesheet" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/css/validationEngine.jquery.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/js/jquery.validationEngine-cn.js"></script>

<title>用户登录 - <?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>
<div class="mainbox">
	<img src="<?php echo $this->baseUrl;?>/files/default/images/950x160.jpg" class="mtop10 lt" />
	<div class="nytit3 mtop10"><h3>找回密码</h3></div>
	<div class="nytxt3">
		<form id="userForm" name="userForm" method="post" action="">
			<table width="100%" border="0" style="margin-top:20px;">
				<tr>
					<td width="28%" height="30" align="right">用户名：</td>
					<td width="72%" height="30"><?php echo $this->userName;?></td>
				</tr>
				<tr>
					<td width="28%" height="30" align="right">新密码：</td>
					<td width="72%" height="30"><input name="password" type="text" id="password" value="" style="width:200px;" /></td>
				</tr>
				<tr>
					<td height="30" align="right">确认新密码：</td>
					<td height="30"><input name="password2" type="text" id="password2" value="" style="width:200px;" />
					</td>
				</tr>
				<tr>
					<td height="30">&nbsp;</td>
					<td height="30"><input type="submit" name="button" id="button" value="修改密码" class="button" />
					</td>
				</tr>
			</table>
		</form>
	</div>	
</div>
<div class="cl"></div>
<?php echo $this->render('footer.php');?>
<script language="javascript">

$("#userForm").submit(function(){
	if ($.trim($("#password").val()) == '') {
		alert("请输入密码。");
		$("#password").focus();
		return false;
	}
	if ($.trim($("#password").val()).length < 5) {
		alert("密码长度必须大于5位。");
		$("#password").focus();
		return false;
	}
	if ($.trim($("#password2").val()) == '') {
		alert("请输入确认密码。");
		$("#password2").focus();
		return false;
	}
	if ($.trim($("#password2").val()) != $.trim($("#password").val())) {
		alert("确认密码输入错误。");
		$("#password2").focus();
		return false;
	}
});
</script>
</body>
</html>
