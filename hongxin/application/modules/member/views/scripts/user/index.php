<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
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
		<form id="accountForm" name="accountForm" method="post" action="">
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
		</form>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="subTab">
			<tr>
				<td><h3>个人基本资料</h3></td>
				<td align="right"></td>
			</tr>
		</table>
		<form id="accountDetailForm" name="accountDetailForm" method="post" action="">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
				<tr>
					<td width="15%">真实姓名：</td>
					<td><input name="name" type="text" class="input" id="name" size="40" value="<?php echo htmlspecialchars($this->row['name']);?>" /></td>
				</tr>
				<tr>
					<td width="15%">手机号码：</td>
					<td><input name="mobile" type="text" class="input" id="mobile" size="40" value="<?php echo htmlspecialchars($this->row['mobile']);?>" /></td>
				</tr>
				<tr>
					<td width="15%">身份证号码：</td>
					<td><input name="idCardNumber" type="text" class="input" id="idCardNumber" size="40" value="<?php echo htmlspecialchars($this->row['idCardNumber']);?>" /></td>
				</tr>
				<?php if ($this->loginedUserType == 'P'): ?>
				<tr>
					<td width="15%">&nbsp;</td>
					<td>
					<input name="submit" type="submit" id="submit1" value="保存" class="button" />
					<?php if(empty($this->row['ysbId']) && (!empty($this->row['name']) && (!empty($this->row['idCardNumber'])))): ?>
					<input name="identifyBtn" type="button" id="identifyBtn" value="去验证身份并开通支付账号" class="button" />
					<?php endif; ?>
					</td>
				</tr>
				<?php endif; ?>
		</table>
		<input name="formClass" type="hidden" id="formClass" value="accountDetail" />
		</form>
		<?php if ($this->loginedUserType == 'C') { ?>
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="subTab">
					<tr>
						<td><h3>公司详细资料</h3></td>
						<td align="right"><div class="tabSwitch" tabFor="enterpriseDiv">展开</div></td>
					</tr>
				</table>
				<div id="enterpriseDiv">
					<form id="enterpriseForm" name="enterpriseForm" enctype="multipart/form-data" method="post" action="">
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
							<td width="15%">公司名称：</td>
							<td width="35%"><input type="text" class="input" name="name" id="name" value="<?php echo isset($this->memberEnterpriseRow['name']) ? htmlspecialchars($this->memberEnterpriseRow['name']) : '';?>" /></td>
						</tr>
						<tr>
							<td width="15%">成立日期：</td>
							<td width="35%"><input type="text" readonly="readonly" class="input" name="createTime" id="createTime" value="<?php echo isset($this->memberEnterpriseRow['createTime']) ? htmlspecialchars($this->memberEnterpriseRow['createTime']) : '';?>" />
							<script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","firstDay":0,"showsTime":false,"showOthers":false,"inputField":"createTime","button":"createTime"});</script></td>
							<td width="15%">公司座机：</td>
							<td width="35%"><input type="text" class="input" name="telephone" id="telephone" value="<?php echo isset($this->memberEnterpriseRow['telephone']) ? htmlspecialchars($this->memberEnterpriseRow['telephone']) : '';?>" /></td>
						</tr>
						<!--  
						<tr>
							<td width="15%">组织机构代码证号码：</td>
							<td width="35%"><input type="text" class="input" name="organizationCode" id="organizationCode" value="<?php echo isset($this->memberEnterpriseRow['organizationCode']) ? htmlspecialchars($this->memberEnterpriseRow['organizationCode']) : '';?>" /></td>
							<td width="15%">银行开户许可证号码：</td>
							<td width="35%"><input type="text" class="input" name="licenseNumberBankAccount" id="licenseNumberBankAccount" value="<?php echo isset($this->memberEnterpriseRow['licenseNumberBankAccount']) ? htmlspecialchars($this->memberEnterpriseRow['licenseNumberBankAccount']) : '';?>" /></td>
						</tr>
						-->
						<tr>
							<td width="15%">法人姓名：</td>
							<td width="35%"><input type="text" class="input" name="legalPersonName" id="legalPersonName" value="<?php echo isset($this->memberEnterpriseRow['legalPersonName']) ? htmlspecialchars($this->memberEnterpriseRow['legalPersonName']) : '';?>" /></td>
							<td width="15%">法人身份证：</td>
							<td width="35%">(扫描件)<input type="file" name="legalPersonIDCardCopy" id="legalPersonIDCardCopy" /></td>
							<!--  
							<td width="15%">法人身份证号码：</td>
							<td width="35%"><input type="text" class="input" name="legalPersonIDCard" id="legalPersonIDCard" value="<?php echo isset($this->memberEnterpriseRow['legalPersonIDCard']) ? htmlspecialchars($this->memberEnterpriseRow['legalPersonIDCard']) : '';?>" /></td></td>
							-->
						</tr>
						<tr>
							<td width="15%">营业执照：</td>
							<td width="35%">(扫描件)<input type="file" name="businessLicenseCopy" id="businessLicenseCopy" /></td>
							<td width="15%">组织机构代码证：</td>
							<td width="35%">(扫描件)<input type="file" name="organizationCodeCopy" id="organizationCodeCopy" /></td>
						</tr>
						<tr>
							<td width="15%">&nbsp;</td>
							<td colspan="3"><input name="submit4" type="submit" id="submit4" value="保存" class="button" />
									<input name="formClass" type="hidden" id="formClass" value="enterprise" /></td>
						</tr>
				</table>
				</form>
				<form id="statusForm" name="statusForm" method="post" action="">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
					<tr>
						<td><input type="submit" class="btn" id="approveBtn" value="提交审核"/></td>
					</tr>
					</table>
					<input name="formClass" type="hidden" id="formClass" value="<?php echo $this->loginedUserType == 'C' ? 'borrowersStatus' : 'lendersStatus'; ?>" />
				</form>
				</div>
		<?php } ?>
		<?php if(empty($this->row['ysbId']) && (!empty($this->row['name']) && (!empty($this->row['idCardNumber'])))): ?>
			<form id="identifyForm" name="identifyForm" method="post" action="<?php echo $this->ysburl; ?>" target="_blank">
			<?php foreach ($this->params as $n=>$p): ?>
				<input type="hidden" name="<?php echo $n; ?>" value="<?php echo $p; ?>" />
			<?php endforeach; ?>
			</form>
		<?php endif;?>
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
var lendersStatus = '<?php echo $this->row['lendersStatus'];?>';
if (lendersStatus == '1') {
	$("#approveBtn").val('提交审核');
	$('input, select').attr('disabled', false);
} else if (lendersStatus == '2'){
	//$("#approveBtn").attr('disabled', true);
	$("input[type=submit]").attr('disabled', true);
	$("#approveBtn").val('正在审核中');
	$('input, select').attr('disabled', true);
} else if (lendersStatus == '3'){
	//$("#approveBtn").attr('disabled', true);
	$("input[type=submit]").attr('disabled', true);
	$("#approveBtn").val('已审核通过');
	$('input, select').attr('disabled', true);
} else if (lendersStatus == '4'){
	$("#approveBtn").val('审核未通过');
}
<?php } ?>

<?php if ($this->loginedUserType == 'C') { ?>
var borrowersStatus = '<?php echo $this->row['borrowersStatus'];?>';
if (borrowersStatus == '1') {
	$("#approveBtn").val('提交审核');
	$('input, select').attr('disabled', false);
} else if (borrowersStatus == '2'){
	//$("#approveBtn").attr('disabled', true);
	$("input[type=submit]").attr('disabled', true);
	$("#approveBtn").val('正在审核中');
	$('input, select').attr('disabled', true);
} else if (borrowersStatus == '3'){
	//$("#approveBtn").attr('disabled', true);
	$("input[type=submit]").attr('disabled', true);
	$("#approveBtn").val('已审核通过');
	$('input, select').attr('disabled', true);
} else if (borrowersStatus == '4'){
	$("#approveBtn").val('审核未通过');
}
$('input:text', $("#baseDiv, #enterpriseDiv")).css("width", "80%");
<?php } ?>

$("#identifyBtn").click(function(){
	$("#identifyForm").submit();
});
</script>

</body>
</html>
