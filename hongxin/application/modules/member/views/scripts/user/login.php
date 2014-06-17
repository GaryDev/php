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
	<img src="<?php echo $this->baseUrl;?>/files/default/images/banner-<?php echo $this->banner; ?>.jpg" class="mtop10 lt" />
	<div class="nytit3 mtop10"><h3>用户登录</h3></div>
	<div class="nytxt3">
		<form id="userForm" name="userForm" method="post" action="">
			<table border="0" align="center" cellpadding="0" cellspacing="0"  class="table1">
				<tr>
					<td>用户名：</td>
					<td>
						<input name="userName" id="userName" type="text" class="table1_input1" />
						<a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'register'));?>">马上注册！</a>
					</td>
				</tr>
				<tr>
					<td>密&nbsp;&nbsp;码：</td>
					<td>
						<input name="password" id="password" type="password" class="table1_input1" />
						<a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'forgot-password'));?>">忘记密码？</a>
					</td>
				</tr>

				<tr>
					<td>有效期：</td>
					<td>
						<select name="timeToLive" id="timeToLive">
							<option value="1">1天</option>
							<option value="7">1个星期</option>
							<option value="30">1个月</option>
							<option value="180">半年</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>验证码：</td>
					<td>
					<input name="code" type="text" id="code" style="border:#2B4A99 solid 1px;" size="8" /> 
					<img src="<?php echo $this->projectUrl(array('module' => 'admin', 'controller' => 'image-code', 'action' => 'index', 'rand' => rand(100, 999)));?>" 
						name="codeImage" border="0" align="absmiddle" id="codeImage" onclick="$(this).attr('src', '<?php echo $this->projectUrl(array('module' => 'admin', 'controller' => 'image-code', 'action' => 'index', 'rand' => 1));?>' + Math.random());" style="text-decoration:underline; cursor:pointer;"/></td>
				</tr>
				<tr>
					<td></td>
					<td><input name="submit" value=" 登录 " tabindex="5" type="submit" class="btn" /></td>
				</tr>
			</table>
		</form>
	</div>	
</div>
<div class="cl"></div>
<?php echo $this->render('footer.php');?>
<script language="javascript">
var userInfo = '请输入手机号';
$("#userName").val(userInfo);
$("#userName").focus(function(){
	if (this.value == userInfo) {
		this.value = '';
	}
});
$("#userName").blur(function(){
	if (this.value == '') {
		this.value = userInfo;
	}
});

$("#userForm").submit(function(){
	if ($.trim($("#userName").val()) == '' || $.trim($("#userName").val()) == userInfo) {
		alert("请输入登录用户。");
		$("#userName").focus();
		return false;
	}
	if ($.trim($("#password").val()) == '') {
		alert("请输入登录密码。");
		$("#password").focus();
		return false;
	}
    if ($.trim($("#code").val()) == ''){
        alert("请填写验证码！");
        $("#code").focus();
        return false;
    }
});
</script>
</body>
</html>
