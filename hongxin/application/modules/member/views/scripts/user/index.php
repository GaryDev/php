<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<link rel="stylesheet" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/css/validationEngine.jquery.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/js/jquery.validationEngine-cn.js"></script>
<!--时间选择器-->
<script src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar.js"></script>
<script src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/lang/cn_utf8.js"></script>
<script src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-setup.js"></script>
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-blue.css" rel="stylesheet" />
<title>我的账户 - <?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>
<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px;">
  <tr>
    <td width="180" height="40" align="left" valign="top">
    	<?php echo $this->render('member-menu.php');?>
    </td>
    <td valign="top">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="subTab">
			<tr>
				<td><h3>账户信息</h3></td>
				<td align="right"></td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
			<tr>
				<td width="15%">用户名：</td>
				<td><?php echo $this->row['userName']?></td>
			</tr>
			<!--  
			<tr>
				<td>邮件：</td>
				<td><?php echo htmlspecialchars($this->row['email']);?></td>
			</tr>
			-->
		</table>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="subTab">
			<tr>
				<td><h3><?php echo $this->loginedUserType == 'C' ? '经办人' : '个人'; ?>基本资料<span style="color: red;">（*为必填项）</span></h3></td>
				<td align="left">&nbsp;</td>
			</tr>
		</table>
		<form id="mainForm" name="mainForm" method="post" enctype="multipart/form-data" action="">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
				<tr>
					<td width="15%"><font class="required-star">*</font>&nbsp;真实姓名：</td>
					<td><input name="userName" type="text" class="validate[required] input" id="userName" size="40" value="<?php echo htmlspecialchars($this->row['name']);?>" /></td>
				</tr>
				<tr>
					<td width="15%"><font class="required-star">*</font>&nbsp;手机号码：</td>
					<td><input name="mobile" type="text" class="validate[required,custom(mobileTelephone)] input" id="mobile" size="40" value="<?php echo htmlspecialchars($this->row['mobile']);?>" /></td>
				</tr>
				<tr>
					<td width="15%"><font class="required-star">*</font>&nbsp;身份证号码：</td>
					<td><input name="idCardNumber" type="text" class="validate[required] input" id="idCardNumber" size="40" value="<?php echo htmlspecialchars($this->row['idCardNumber']);?>" /></td>
				</tr>
				<?php if ($this->loginedUserType == 'P') { ?>
				<tr>
					<td width="15%">&nbsp;</td>
					<td>
					<input name="submit" type="submit" id="submit1" value="保存资料" class="btn" onclick="$('#formClass').val('accountDetail');" />
					</td>
				</tr>
				<?php } ?>
		</table><!--
		<input name="formClass" type="hidden" id="formClass" value="accountDetail" />
		</form>-->
		<?php if ($this->loginedUserType == 'C') { ?>
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="subTab">
					<tr>
						<td><h3>公司详细资料<span style="color: red;">（*为必填项）</span></h3></td>
						<td align="right"><div class="tabSwitch" tabFor="enterpriseDiv">展开</div></td>
					</tr>
				</table>
				<div id="enterpriseDiv">
				<!--  <form id="enterpriseForm" name="enterpriseForm" enctype="multipart/form-data" method="post" action=""> -->
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
						<tr>
							<td width="15%">公司类型：</td>
							<td width="35%"><select name="industry" id="industry">
									<option value="">-选择-</option>
									<?php
foreach($this->memberVars['industry'] as $key=>$value) {
?>
									<option value="<?php echo $key;?>" <?php echo @$this->memberEnterpriseRow['industry'] == $key ? ' selected="selected"' : '';?>><?php echo $value;?></option>
									<?php
}
?>
								</select>
							</td>
							<td width="15%"><font class="required-star">*</font>&nbsp;公司名称：</td>
							<td width="35%"><input type="text" class="validate[required] input" name="companyName" id="companyName" value="<?php echo isset($this->memberEnterpriseRow['name']) ? htmlspecialchars($this->memberEnterpriseRow['name']) : '';?>" /></td>
						</tr>
						<tr>
							<!--  
							<td width="15%">成立日期：</td>
							<td width="35%"><input type="text" readonly="readonly" class="input" name="createTime" id="createTime" value="<?php echo isset($this->memberEnterpriseRow['createTime']) ? htmlspecialchars($this->memberEnterpriseRow['createTime']) : '';?>" />
							<script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","firstDay":0,"showsTime":false,"showOthers":false,"inputField":"createTime","button":"createTime"});</script></td>
							-->
							<td width="15%"><font class="required-star">*</font>&nbsp;公司邮箱：</td>
							<td width="35%"><input type="text" class="validate[required] input" name="email" id="email" value="<?php echo isset($this->memberEnterpriseRow['email']) ? htmlspecialchars($this->memberEnterpriseRow['email']) : '';?>" /></td>
							<td width="15%"><font class="required-star">*</font>&nbsp;公司座机：</td>
							<td width="35%">
							<input type="text" class="validate[required] input" name="phoneDistrict" id="phoneDistrict" maxlength="4" style="width: 30px;" value="<?php echo isset($this->memberEnterpriseRow['phoneDistrict']) ? htmlspecialchars($this->memberEnterpriseRow['phoneDistrict']) : '';?>" />&nbsp;-&nbsp;
							<input type="text" class="validate[required] input" name="phoneNumber" id="phoneNumber" style="width: 195px;" value="<?php echo isset($this->memberEnterpriseRow['phoneNumber']) ? htmlspecialchars($this->memberEnterpriseRow['phoneNumber']) : '';?>" />
							<!-- <input type="text" class="validate[required] input" name="telephone" id="telephone" value="<?php echo isset($this->memberEnterpriseRow['telephone']) ? htmlspecialchars($this->memberEnterpriseRow['telephone']) : '';?>" /> -->
							</td>
						</tr>
						<tr>
							<td width="15%"><font class="required-star">*</font>&nbsp;公司地址：</td>
							<td width="35%"><input type="text" class="validate[required] input" name="address" id="address" value="<?php echo isset($this->memberEnterpriseRow['address']) ? htmlspecialchars($this->memberEnterpriseRow['address']) : '';?>" /></td>
							<td width="15%"><font class="required-star">*</font>&nbsp;公司邮编：</td>
							<td width="35%"><input type="text" class="validate[required] input" name="zipcode" id="zipcode" value="<?php echo isset($this->memberEnterpriseRow['zipcode']) ? htmlspecialchars($this->memberEnterpriseRow['zipcode']) : '';?>" /></td>
						</tr>
						<tr>
							<td width="15%"><font class="required-star">*</font>&nbsp;法定代表人姓名：</td>
							<td width="35%"><input type="text" class="validate[required] input" name="legalPersonName" id="legalPersonName" value="<?php echo isset($this->memberEnterpriseRow['legalPersonName']) ? htmlspecialchars($this->memberEnterpriseRow['legalPersonName']) : '';?>" /></td>
							<td width="15%"><font class="required-star">*</font>&nbsp;法定代表人身份证：</td>
							<td width="35%">(扫描件)<input type="file" name="legalPersonIDCardCopy" id="legalPersonIDCardCopy" value="<?php echo $this->memberEnterpriseRow['legalPersonIDCardCopyPath']; ?>" /></td>
							<!--  
							<td width="15%">法人身份证号码：</td>
							<td width="35%"><input type="text" class="input" name="legalPersonIDCard" id="legalPersonIDCard" value="<?php echo isset($this->memberEnterpriseRow['legalPersonIDCard']) ? htmlspecialchars($this->memberEnterpriseRow['legalPersonIDCard']) : '';?>" /></td></td>
							-->
						</tr>
						<tr>
							<td width="15%"><font class="required-star">*</font>&nbsp;经办人身份证：</td>
							<td width="35%">(扫描件)<input type="file" name="operatorCopy" id="operatorCopy" value="<?php echo $this->memberEnterpriseRow['operatorCopyPath']; ?>" /></td>
							<td width="15%"><font class="required-star">*</font>&nbsp;机构信用代码证：</td>
							<td width="35%">(扫描件)<input type="file" name="creditCopy" id="creditCopy" value="<?php echo $this->memberEnterpriseRow['creditCopyPath']; ?>" /></td>
						</tr>
						<tr>
							<td width="15%"><font class="required-star">*</font>&nbsp;营业执照：</td>
							<td width="35%">(扫描件)<input type="file" name="businessLicenseCopy" id="businessLicenseCopy" value="<?php echo $this->memberEnterpriseRow['businessLicenseCopyPath']; ?>" /></td>
							<td width="15%"><font class="required-star">*</font>&nbsp;组织机构代码证：</td>
							<td width="35%">(扫描件)<input type="file" name="organizationCodeCopy" id="organizationCodeCopy" value="<?php echo $this->memberEnterpriseRow['organizationCodeCopyPath']; ?>" /></td>
						</tr>
						<tr>
							<td width="15%"><font class="required-star">*</font>&nbsp;税务登记证：</td>
							<td width="35%">(扫描件)<input type="file" name="taxCopy" id="taxCopy" value="<?php echo $this->memberEnterpriseRow['taxCopyPath']; ?>" /></td>
							<td width="15%"><font class="required-star">*</font>&nbsp;银行开户许可证：</td>
							<td width="35%">(扫描件)<input type="file" name="bankCopy" id="bankCopy" value="<?php echo $this->memberEnterpriseRow['bankCopyPath']; ?>" /></td>
						</tr>
						<tr>
							<td width="15%">&nbsp;</td>
							<td colspan="3"><!--<input name="submit4" type="submit" id="submit4" value="保存" class="button" onclick="$('#formClass').val('enterprise');" />
							<!--  		<input name="formClass" type="hidden" id="formClass" value="enterprise" />--></td>
						</tr>
				</table>
				<!--  
				</form>
				<form id="statusForm" name="statusForm" method="post" action="">
				-->
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
					<?php if ($this->row['borrowersStatus'] == '4') { ?><tr><td colspan="2">您的资料未通过审核，请重新提交资料</td></tr><?php } ?>
					<tr>
						<td width="15%"><input type="submit" class="btn" id="approveBtn" value="保存资料 " /></td>
						<td><input type="checkbox" name="approveCheck" id="approveCBX" value="1" />&nbsp;提交审核</td>
						
					</tr>
					</table>
					<!--<input name="formClass" type="hidden" id="formClass" value="" />-->
				</div>
		<?php } ?>
		</form>
    </td>
  </tr>  
</table>

<?php echo $this->render('footer.php');?>

<script language="javascript">
$(".tabSwitch").click(function(){
	if ($(this).html() == '展开') {
		$("#" + $(this).attr('tabFor')).css('display', '');
		$(this).html('收缩');
	} else if ($(this).html() == '收缩') {
		$("#" + $(this).attr('tabFor')).css('display', 'none');
		$(this).html('展开');
	}
});
$(".tabSwitch").click();
$(".tabSwitch").each(function(){
	if ($(this).html() == '展开') {
		$("#" + $(this).attr('tabFor')).css('display', 'none');
	} else if ($(this).html() == '收缩') {
		$("#" + $(this).attr('tabFor')).css('display', '');
	}
});
<?php if ($this->loginedUserType == 'P') { ?>
var status = '<?php echo $this->row['lendersStatus'];?>';
if (status == '1') {
	$("input[type=submit]").show();
	$('input, select').attr('disabled', false);
} else {
	$("input[type=submit]").hide();
	$('input, select').attr('disabled', true);
}
<?php } ?>

<?php if ($this->loginedUserType == 'C') { ?>
var borrowersStatus = '<?php echo $this->row['borrowersStatus'];?>';
if (borrowersStatus == '1') {
	//$("#approveBtn").val('提交审核');
	$('input, select').attr('disabled', false);
} else if (borrowersStatus == '2'){
	//$("#approveBtn").attr('disabled', true);
	$("input[type=submit]").attr('disabled', true);
	$("#approveBtn").val('正在审核中');
	$("#approveCBX").parent().hide();
	$('input, select').attr('disabled', true);
} else if (borrowersStatus == '3'){
	//$("#approveBtn").attr('disabled', true);
	$("input[type=submit]").attr('disabled', true);
	$("#approveBtn").val('已审核通过');
	$("#approveCBX").parent().hide();
	$('input, select').attr('disabled', true);
} else if (borrowersStatus == '4'){
	//$("#approveBtn").val('审核未通过');
	//$("#approveCBX").parent().hide();
}
$('input:text', $("#baseDiv, #enterpriseDiv")).filter(function(){
	return this.id.indexOf("phone") == -1;
}).css("width", "80%");

$("#approveCBX").change(function(){
	if(this.checked) {
		$("#approveBtn").val('提交审核');
	} else {
		$("#approveBtn").val('保存资料');
	}
});

$("#mainForm").submit(function(){
	<?php if (empty($this->memberEnterpriseRow['legalPersonIDCardCopyPath'])): ?>
	if($("#legalPersonIDCardCopy").val() == "") {
		alert('请选择法定代表人身份证扫描件。');
		return false;
	} else if(!validateFileExt($("#legalPersonIDCardCopy").val())) {
		alert('法定代表人身份证扫描件格式不正确。');
		return false;
	}
	<?php endif; ?>
	<?php if (empty($this->memberEnterpriseRow['operatorCopyPath'])): ?>
	if($("#operatorCopy").val() == "") {
		alert('请选择经办人身份证扫描件。');
		return false;
	} else if(!validateFileExt($("#operatorCopy").val())) {
		alert('经办人身份证扫描件格式不正确。');
		return false;
	}
	<?php endif; ?>
	<?php if (empty($this->memberEnterpriseRow['creditCopyPath'])): ?>
	if($("#creditCopy").val() == "") {
		alert('请选择机构信用代码证扫描件。');
		return false;
	} else if(!validateFileExt($("#creditCopy").val())) {
		alert('机构信用代码证扫描件格式不正确。');
		return false;
	}
	<?php endif; ?>
	<?php if (empty($this->memberEnterpriseRow['businessLicenseCopyPath'])): ?>
	if($("#businessLicenseCopy").val() == "") {
		alert('请选择营业执照扫描件。');
		return false;
	} else if(!validateFileExt($("#businessLicenseCopy").val())) {
		alert('营业执照扫描件格式不正确。');
		return false;
	}
	<?php endif; ?>
	<?php if (empty($this->memberEnterpriseRow['organizationCodeCopyPath'])): ?>
	if($("#organizationCodeCopy").val() == "") {
		alert('请选择组织机构代码证扫描件。');
		return false;
	} else if(!validateFileExt($("#organizationCodeCopy").val())) {
		alert('组织机构代码证扫描件格式不正确。');
		return false;
	}
	<?php endif; ?>
	<?php if (empty($this->memberEnterpriseRow['taxCopyPath'])): ?>
	if($("#taxCopy").val() == "") {
		alert('请选择税务登记证扫描件。');
		return false;
	} else if(!validateFileExt($("#taxCopy").val())) {
		alert('税务登记证扫描件格式不正确。');
		return false;
	}
	<?php endif; ?>
	<?php if (empty($this->memberEnterpriseRow['bankCopyPath'])): ?>
	if($("#bankCopy").val() == "") {
		alert('请选择银行开户许可证扫描件。');
		return false;
	} else if(!validateFileExt($("#bankCopy").val())) {
		alert('银行开户许可证扫描件格式不正确。');
		return false;
	}
	<?php endif; ?>
	//return ($(".formError").size() == 0);
	//alert($.fn.submitValidation);
	return true;
});
<?php } ?>
</script>

</body>
</html>
