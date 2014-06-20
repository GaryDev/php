<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryLayer/layer.min.js"></script>
<link rel="stylesheet" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/css/validationEngine.jquery.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/js/jquery.validationEngine-cn.js"></script>

<title>找回密码 - <?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>
<div class="mainbox">
	<img src="<?php echo $this->baseUrl;?>/files/default/images/banner-member.jpg" class="mtop10 lt" />
	<div class="nytit3 mtop10"><h3>找回密码</h3></div>
	<div class="nytxt3">
		<form id="userForm" name="userForm" method="post" action="<?php echo $this->projectUrl(array('action'=>'mail-modify-password'));?>">
			<table width="100%" border="0" style="margin-top:20px;" class="table1">
				<tr>
					<td width="28%" height="30" align="right">手机号：</td>
					<td width="72%" height="30"><input name="userName" type="text" id="userName" value="" style="width:200px;" class="validate[required, custom(mobileTelephone)] input" /></td>
				</tr>
				<tr>
					<td height="30" align="right">短信验证码：</td>
					<td height="30"><input name="smscode" type="text" class="validate[required, callback[checkSmsCode,1]] input" id="smscode"/>
					<input type="button" id="btnSms" value="获取验证码" /></td>
				</tr>
				<tr>
					<td height="30" align="right">新密码：</td>
					<td height="30"><input name="password" type="password" class="validate[length[6,30]] input" id="password" value="" size="30" /></td>
				</tr>
				<tr>
					<td height="30" align="right">确认新密码：</td>
					<td height="30"><input name="password2" type="password" class="validate[required, confirm[password]] input" id="password2" value="" size="30" /></td>
				</tr>
				<!--  
				<tr>
					<td height="30" align="right">验证码：</td>
					<td height="30">
					<input name="imgCode" type="text" id="imgCode" class="validate[required,callback[checkImgCode,1]]" size="8" /> 
					<img src="<?php echo $this->projectUrl(array('module' => 'admin', 'controller' => 'image-code', 'action' => 'index', 'rand' => rand(100, 999)));?>" 
						name="codeImg" border="0" align="absmiddle" id="codeImg" onclick="refreshCode(this);" style="text-decoration:underline; cursor:pointer;"/></td>
				</tr>
				-->
				<tr>
					<td height="30">&nbsp;</td>
					<td height="30"><input type="submit" name="button" id="button" value="确定" class="btn" />
					</td>
				</tr>
			</table>
		</form>
	</div>	
</div>
<div class="cl"></div>
<?php echo $this->render('footer.php');?>
<script language="javascript">

function checkSmsCode(mcode){
	checkResult = {'isRight':true, 'message':''};
	if (mcode != '') {
		var url = '<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'check-smscode'));?>' + '?rand=' + Math.random();
		$.ajax({
			type: "POST",
			url: url,
			data: "mcode=" + mcode,
			async: false,
			success: function(data){
				if(data == 1) {
					checkResult = {'isRight':false, 'message':'* 验证码已经过期，请重新获取。'};
					$("#smscode").val('')
				} else if (data == 2) {
					checkResult = {'isRight':false, 'message':'* 此验证码无效，请重新输入。'};
				} else if (data == -1) {
					checkResult = {'isRight':false, 'message':'* 请获取验证码。'};
				}
			} 
		});
	}
	return checkResult;
}

function checkImgCode(mcode){
	checkResult = {'isRight':true, 'message':''};
	if (mcode != '') {
		var url = '<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'check-imgcode'));?>' + '?rand=' + Math.random();
		$.ajax({
			type: "POST",
			url: url,
			data: "code=" + mcode,
			async: false,
			success: function(data){ 
				if(data != 1) {
					checkResult = {'isRight':false, 'message':'* 验证码错误，请重新填写。'};
					$("#imgCode").val('');
					$("#imgCode").focus();
					//refreshCode('#codeImg');
				}
			} 
		});
	}
	return checkResult;
}

var wait=120;
function time(o)
{
	if (wait == 0) {
		o.removeAttribute("disabled");
		o.value="获取验证码";
		wait = 120;
	} else {
		if($("#userName").val() != "" && $("#userName").val().match(/^1[358][0-9]{9}$/)) {
			if(wait == 120) {
				var url = '<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'sendsms'));?>' + '?rand=' + Math.random();
				$.ajax({
					type: "POST",
					url: url,
					data: "mobile=" + $("#userName").val(),
					async: false,
					success: function(data){ } 
				});
				document.getElementById("smscode").focus();
			}
			o.setAttribute("disabled", true);
			o.value=wait + "秒后重新获取";
			wait--;
			setTimeout(function() {
				time(o)
			},
			1000)
		} else {
			alert("请输入正确的手机号！");
		}
	}
}

$("#btnSms").click(function(){
	if($("#userName").val() != "" && $("#userName").val().match(/^1[358][0-9]{9}$/)) {
		popupWindow("图片校验","<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'imgcode'));?>", ['300px','120px']);
		//$(".xubox_close").hide();
	} else {
		alert("请输入正确的手机号！");
	}
});

function verifyCode() {
	if ($.trim($("#code").val()) == ''){
        alert("请填写验证码！");
        $("#code").focus();
        return false;
    }
	var url = '<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'check-imgcode'));?>' + '?rand=' + Math.random();
	$.ajax({
		type: "POST",
		url: url,
		data: "code=" + $("#code").val(),
		async: false,
		success: function(data){ 
			if(data == 1) {
				$(".xubox_close").click();
				//refreshCode('#codeImg');
				time(document.getElementById("btnSms"));
			} else {
				alert('验证码错误，请重新填写！');
				$("#code").val('');
				$("#code").focus();
				refreshCode('#codeImage');
			}
		} 
	});
}

function refreshCode(o) {
	$(o).attr('src', '<?php echo $this->projectUrl(array('module' => 'admin', 'controller' => 'image-code', 'action' => 'index', 'rand' => 1));?>' + Math.random());
}
</script>
</body>
</html>
