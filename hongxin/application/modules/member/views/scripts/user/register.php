<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<link rel="stylesheet" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/css/validationEngine.jquery.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/js/jquery.validationEngine-cn.js"></script>

<title>个人用户注册 - <?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>
<div class="mainbox">
	<div class="nytit3 mtop10" style="line-height:40px; height:40px;">
		<h3>创建一个新的帐号</h3>
	</div>
	<div class="nytxt3">
		<form id="userForm" name="userForm" method="post" action="">
			<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="biaoge">
				<tr>
					<td class="bgtd1">用户名：</td>
					<td class="bgtd2"><input name="userName" type="text" class="validate[length[5,20],callback[checkUserIsExists,1]] bginput1 " id="userName"/></td>
					<td class="color999">英文，数字和汉字的混合，长度5-20个字符</td>
				</tr>
				<tr>
					<td class="bgtd1">E-mail：</td>
					<td class="bgtd2"><input name="email" type="text" class="validate[custom[email],callback[checkEmailIsExists,1]] bginput1 " id="email"/></td>
					<td class="color999">格式：user@qq.com</td>
				</tr>
				<tr>
					<td class="bgtd1">注册类型：</td>
					<td class="bgtd2">
					<label><input type="radio" name="userType" id="userType" value="P" checked="checked" />个人</label>
					<label><input type="radio" name="userType" id="userType" value="E" />企业</label>
					</td>
				</tr>
				<tr>
					<td class="bgtd1">密码：</td>
					<td class="bgtd2"><input name="password" type="password" class="validate[length[6,30]] bginput1" id="password"/></td>
					<td class="color999">长度6-30个字符</td>
				</tr>
				<tr>
					<td class="bgtd1">确认密码：</td>
					<td class="bgtd2"><input name="password2" type="password" class="validate[required,confirm[password]] bginput1" id="password2"/></td>
					<td class="color999">请重新输入一次密码，已确认无误</td>
				</tr>

				<tr>
					<td class="bgtd1"></td>
					<td colspan="2" class="bgtd2">
						<label><input type="checkbox" name="agreement" id="agreement" class="validate[required]"/>
我已经阅读并同意此协议</label>
						<div style="height:200px; width:100%; overflow-y:scroll; overflow-x:hidden; border:#ccc solid 1px; padding:5px;"><?php echo $this->agreement;?></div>
					</td>
				</tr>

				<tr>
					<td class="bgtd1"></td>
					<td class="bgtd2"><input name="input" type="image" src="<?php echo $this->baseUrl;?>/files/default/images/tj.jpg" /></td>
					<td></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<div class="cl"></div>
<?php echo $this->render('footer.php');?>

<script language="javascript">
function checkUserIsExists(userName){
	checkResult = {'isRight':true, 'message':''};
	
	var reg = /^(\w|[\u4E00-\u9FA5])*$/; 
	if (!userName.match(reg)) { 
		checkResult = {'isRight':false, 'message':'* 用户名只允许为英文，数字和汉字的混合。'};
	} else if (userName != '') {
		var url = '<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'account-is-exists', 'accountType'=>'userName'));?>' + '?rand=' + Math.random();
		$.ajax({
			type: "POST",
			url: url,
			data: "account=" + userName,
			dataType: "html",
			async: false,
			success: function(data){
				if (data == 1) {
					checkResult = {'isRight':false, 'message':'* 此用户名已经被他人注册过了，请换一个。'};
				}
			} 
		});
	}
	return checkResult;
}

function checkmobileIsExists(number){
	checkResult = {'isRight':true, 'message':''};
	if (number != '') {
		var url = '<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'account-is-exists', 'accountType'=>'mobile'));?>' + '?rand=' + Math.random();
		$.ajax({
			type: "POST",
			url: url,
			data: "account=" + number,
			dataType: "html",
			async: false,
			success: function(data){
				if (data == 1) {
					checkResult = {'isRight':false, 'message':'* 此手机号已经被他人注册过了，请换一个。'};
				}
			} 
		});
	}
	return checkResult;
}

function checkEmailIsExists(address){
	checkResult = {'isRight':true, 'message':''};
	if (address != '') {
		var url = '<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'account-is-exists', 'accountType'=>'email'));?>' + '?rand=' + Math.random();
		$.ajax({
			type: "POST",
			url: url,
			data: "account=" + address,
			dataType: "html",
			async: false,
			success: function(data){
				if (data == 1) {
					checkResult = {'isRight':false, 'message':'* 此E-mail已经被他人注册过了，请换一个。'};
				}
			} 
		});
	}
	return checkResult;
}
</script>
</body>
</html>
