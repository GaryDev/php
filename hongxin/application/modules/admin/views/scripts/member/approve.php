<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/admin/css/public.css" rel="stylesheet"/>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/admin/scripts/load.js"></script>

<!--时间选择器-->
<script src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar.js"></script>
<script src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/lang/cn_utf8.js"></script>
<script src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-setup.js"></script>
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-blue.css" rel="stylesheet" />

<title><?php echo $this->title;?></title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="navigation">
    <tr>
        <td class="content"><span class="description">当前位置：</span><a href="<?php echo $this->projectUrl(array('action'=>'index', 'type'=>'E')) ;?>">会员列表</a> &gt; 查看企业资料</td>
    </tr>
</table>
<form id="accountForm" name="accountForm" method="post" action="">
	<h3>账户信息</h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
            <td width="15%">用户名：</td>
            <td><?php echo $this->row['userName']?></td>
        </tr>
        <tr>
			<td>邮件：</td>
        	<td><?php echo htmlspecialchars($this->row['email']);?></td>
       	</tr>
    </table>
</form>

<form id="statusForm" name="statusForm" method="post" action="">
	<input name="formClass" type="hidden" id="formClassStatus" value="borrowersStatus" />
	<h3>资料审核</h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
        	<td width="15%">审核状态：</td>
        	<td>
				<label><input class="borrowersStatus" type="radio" name="borrowersStatus" id="radio" value="2" <?php echo $this->row['borrowersStatus'] == 2 ? ' checked' : '';?> />
				审核中</label>
				<label><input class="borrowersStatus" type="radio" name="borrowersStatus" id="radio" value="3" <?php echo $this->row['borrowersStatus'] == 3 ? ' checked' : '';?> />
				审核通过</label>
				<label><input class="borrowersStatus" type="radio" name="borrowersStatus" id="radio" value="4" <?php echo $this->row['borrowersStatus'] == 4 ? ' checked' : '';?> />
				审核未通过</label>
				<input name="borrowersStatusStatusSubmit" type="submit" id="borrowersStatusStatusSubmit" value="保存" class="button" />
			</td>
       	</tr>
    </table>
</form>

<h3>经办人基本资料</h3>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
	<form id="accountDetailForm" name="accountDetailForm" method="post" action="">
		<tr>
			<td width="15%">真实姓名：</td>
			<td><?php echo htmlspecialchars($this->row['name']);?></td>
		</tr>
		<!--  
		<tr>
			<td>性别：</td>
			<td><label>
				<input type="radio" name="gender" id="gender" value="男" disabled="disabled" <?php echo $this->row['gender'] == '男' ? ' checked' : '';?>/>
				男 </label>
					<label>
						<input type="radio" name="gender" id="gender" value="女" disabled="disabled" <?php echo $this->row['gender'] == '女' ? ' checked' : '';?>/>
						女 </label>
					<label>
						<input type="radio" name="gender" id="gender" value="未知" disabled="disabled" <?php echo $this->row['gender'] == '未知' ? ' checked' : '';?>/>
						未知 </label>			</td>
		</tr>
		<tr>
			<td>出生日期：</td>
			<td>
				<input name="birthday" type="text" class="input" id="birthday" size="40" value="<?php echo htmlspecialchars($this->row['birthday']);?>" />格式：2011-7-8
				
			</td>
		</tr>
		-->
		<tr>
			<td width="15%">手机号码：</td>
			<td><input name="mobile" type="text" class="input" id="mobile" size="40" value="<?php echo htmlspecialchars($this->row['mobile']);?>" /></td>
		</tr>
 
		<tr>
			<td width="15%">身份证号码：</td>
			<td><input name="idCardNumber" type="text" class="input" id="idCardNumber" size="40" value="<?php echo htmlspecialchars($this->row['idCardNumber']);?>" /></td>
		</tr>
		<!-- 
		<tr>
			<td width="15%">身份证住址：</td>
			<td><input name="idCardAddress" type="text" class="input" id="idCardAddress" size="40" value="<?php echo htmlspecialchars($this->row['idCardAddress']);?>" /></td>
		</tr>
		-->
	</form>
</table>
<!--  
<h3>个人详细资料</h3>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
	<form id="baseForm" name="baseForm" method="post" action="">
		<tr>
			<td width="15%">现居住地址：</td>
			<td width="35%"><input name="liveAddress" type="text" class="input" id="liveAddress" value="<?php echo isset($this->memberBaseRow['liveAddress']) ? htmlspecialchars($this->memberBaseRow['liveAddress']) : '';?>" size="30" /></td>
			<td width="15%">居住地邮编：</td>
			<td width="35%"><input name="livePost" type="text" class="input" id="livePost" value="<?php echo isset($this->memberBaseRow['livePost']) ? htmlspecialchars($this->memberBaseRow['livePost']) : '';?>" maxlength="6" /></td>
		</tr>
		<tr>
			<td width="15%">居住地电话：</td>
			<td width="35%"><input type="text" class="input" name="liveTelephone" id="liveTelephone" value="<?php echo isset($this->memberBaseRow['liveTelephone']) ? htmlspecialchars($this->memberBaseRow['liveTelephone']) : '';?>" maxlength="20" /></td>
			<td width="15%">&nbsp;</td>
			<td width="35%">&nbsp;</td>
		</tr>
		<tr>
			<td width="15%">婚姻状况：</td>
			<td width="35%">
				<select name="marriageStatus" id="marriageStatus">
					<option value="">-选择-</option>
<?php
foreach($this->memberVars['marriageStatus'] as $key=>$value) {
?>
					<option value="<?php echo $key;?>" <?php echo @$this->memberBaseRow['marriageStatus'] == $key ? ' selected="selected"' : '';?>><?php echo $value;?></option>
<?php
}
?>
				</select>
			</td>
			<td width="15%">子女状况：</td>
			<td width="35%">
				<select name="childrenStatus" id="childrenStatus">
					<option value="">-选择-</option>
<?php
foreach($this->memberVars['childrenStatus'] as $key=>$value) {
?>
					<option value="<?php echo $key;?>" <?php echo @$this->memberBaseRow['childrenStatus'] == $key ? ' selected="selected"' : '';?>><?php echo $value;?></option>
<?php
}
?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="15%">最高学历：</td>
			<td width="35%">
				<select name="education" id="education">
					<option value="">-选择-</option>
<?php
foreach($this->memberVars['education'] as $key=>$value) {
?>
					<option value="<?php echo $key;?>" <?php echo @$this->memberBaseRow['education'] == $key ? ' selected="selected"' : '';?>><?php echo $value;?></option>
<?php
}
?>
				</select>
			</td>
			<td width="15%">最高学历学校：</td>
			<td width="35%"><input type="text" class="input" name="school" id="school" value="<?php echo isset($this->memberBaseRow['school']) ? htmlspecialchars($this->memberBaseRow['school']) : '';?>" /></td>
		</tr>
		<tr>
			<td width="15%" class="bd">专业：</td>
			<td width="35%" class="bd"><input type="text" class="input" name="major" id="major" value="<?php echo isset($this->memberBaseRow['major']) ? htmlspecialchars($this->memberBaseRow['major']) : '';?>" /></td>
			<td width="15%" class="bd">毕业时间：</td>
			<td width="35%" class="bd"><input type="text" class="input" name="graduationTime" id="graduationTime" value="<?php echo isset($this->memberBaseRow['graduationTime']) ? htmlspecialchars($this->memberBaseRow['graduationTime']) : '';?>" maxlength="10" /></td>
		</tr>
	</form>
</table>
-->
<h3>公司详细资料</h3>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
	<form id="enterpriseForm" name="enterpriseForm" method="post" action="">
		<tr>
			<td width="15%">公司类型：</td>
			<td width="35%">
				<select name="industry" id="industry">
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
			<td width="35%"><input type="text" class="input" name="createTime" id="createTime" value="<?php echo isset($this->memberEnterpriseRow['createTime']) ? htmlspecialchars($this->memberEnterpriseRow['createTime']) : '';?>" /></td>
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
			<td width="15%">法定代表人姓名：</td>
			<td width="35%"><input type="text" class="input" name="legalPersonName" id="legalPersonName" value="<?php echo isset($this->memberEnterpriseRow['legalPersonName']) ? htmlspecialchars($this->memberEnterpriseRow['legalPersonName']) : '';?>" /></td>
			<td width="15%">法定代表人身份证：</td>
			<td width="35%"><?php if(isset($this->memberEnterpriseRow['legalPersonIDCardCopyUrl'])) {?><a href="<?php echo $this->memberEnterpriseRow['legalPersonIDCardCopyUrl']; ?>" target="_blank">查看</a></td><?php } else { echo '未上传'; }?></td>
		</tr>
		<tr>
			<td width="15%">营业执照：</td>
			<td width="35%"><?php if(isset($this->memberEnterpriseRow['businessLicenseCopyUrl'])) {?><a href="<?php echo $this->memberEnterpriseRow['businessLicenseCopyUrl']; ?>" target="_blank">查看</a><?php } else { echo '未上传'; }?></td>
			<td width="15%">组织机构代码证：</td>
			<td width="35%"><?php if(isset($this->memberEnterpriseRow['organizationCodeCopyUrl'])) {?><a href="<?php echo $this->memberEnterpriseRow['organizationCodeCopyUrl']; ?>" target="_blank">查看</a><?php } else { echo '未上传'; }?></td>
		</tr>
	</form>
</table>

<script language="javascript">
$("input[type=text], select").attr("disabled", true);
</script>
</body>
</html>