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
        <td class="content"><span class="description">当前位置：</span><a href="<?php echo $this->projectUrl(array('action'=>'index')) ;?>">会员列表</a> &gt; 修改会员信息</td>
    </tr>
</table>
<form id="accountForm" name="accountForm" method="post" action="">
	<h3>账户信息</h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
            <td>用户名：</td>
            <td><?php echo $this->row['userName']?></td>
        </tr>
        <tr>
			<td>状态：</td>
        	<td><label>
        		<input type="radio" name="status" id="radio2" value="1" <?php echo $this->row['status'] == 1 ? ' checked' : '';?> />
        		未激活</label>
					<label>
						<input type="radio" name="status" id="radio2" value="2" <?php echo $this->row['status'] == 2 ? ' checked' : '';?> />
						已激活</label>
					<label>
						<input type="radio" name="status" id="radio2" value="3" <?php echo $this->row['status'] == 3 ? ' checked' : '';?> />
						帐号关闭</label></td>
        </tr>

        <tr>
			<td>邮件：</td>
        	<td><input name="email" type="text" class="input" id="email" size="40" value="<?php echo htmlspecialchars($this->row['email']);?>" /></td>
       	</tr>
        <tr>
        	<td>新密码：</td>
        	<td><input name="password" type="text" class="input" id="password" size="40" value="" />不修改请留空</td>
       	</tr>
        <tr>
        	<td width="15%">&nbsp;</td>
        	<td><input name="submit" type="submit" id="submit" value="修改" class="button" />
       		<input name="formClass" type="hidden" id="formClass" value="account" /></td>
       	</tr>
    </table>
</form>

<h3>个人基本资料</h3>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
	<form id="accountDetailForm" name="accountDetailForm" method="post" action="">
		<tr>
			<td width="15%">真实姓名：</td>
			<td><input name="name" type="text" class="input" id="name" size="40" value="<?php echo htmlspecialchars($this->row['name']);?>" /></td>
		</tr>
		<tr>
			<td>性别：</td>
			<td><label>
				<input type="radio" name="gender" id="gender" value="男" <?php echo $this->row['gender'] == '男' ? ' checked' : '';?>/>
				男 </label>
					<label>
						<input type="radio" name="gender" id="gender" value="女" <?php echo $this->row['gender'] == '女' ? ' checked' : '';?>/>
						女 </label>
					<label>
						<input type="radio" name="gender" id="gender" value="未知" <?php echo $this->row['gender'] == '未知' ? ' checked' : '';?>/>
						未知 </label>			</td>
		</tr>
		<tr>
			<td>出生日期：</td>
			<td>
				<input name="birthday" type="text" class="input" id="birthday" size="40" value="<?php echo htmlspecialchars($this->row['birthday']);?>" />格式：2011-7-8
				
			</td>
		</tr>
		<tr>
			<td width="15%">手机号码：</td>
			<td><input name="mobile" type="text" class="input" id="mobile" size="40" value="<?php echo htmlspecialchars($this->row['mobile']);?>" /></td>
		</tr>
		<tr>
			<td width="15%">身份证号码：</td>
			<td><input name="idCardNumber" type="text" class="input" id="idCardNumber" size="40" value="<?php echo htmlspecialchars($this->row['idCardNumber']);?>" /></td>
		</tr>
		<tr>
			<td width="15%">身份证住址：</td>
			<td><input name="idCardAddress" type="text" class="input" id="idCardAddress" size="40" value="<?php echo htmlspecialchars($this->row['idCardAddress']);?>" /></td>
		</tr>
		<tr>
			<td width="15%">&nbsp;</td>
			<td><input name="submit" type="submit" id="submit" value="修改" class="button" />
			<input name="formClass" type="hidden" id="formClass" value="accountDetail" /></td>
		</tr>
	</form>
</table>
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
			<td width="35%" class="bd"><input type="text" class="input" name="graduationTime" id="graduationTime" value="<?php echo isset($this->memberBaseRow['graduationTime']) ? htmlspecialchars($this->memberBaseRow['graduationTime']) : '';?>" maxlength="10" />
				（格式：2011-7-8）</td>
		</tr>
		<tr>
			<td width="15%">&nbsp;</td>
			<td colspan="3"><input name="submit" type="submit" id="submit" value="修改" class="button" />
			<input name="formClass" type="hidden" id="formClass" value="base" /></td>
		</tr>
	</form>
</table>

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
			<td width="35%"><input type="text" class="input" name="createTime" id="createTime" value="<?php echo isset($this->memberEnterpriseRow['createTime']) ? htmlspecialchars($this->memberEnterpriseRow['createTime']) : '';?>" />
			（格式：2011-7-8）</td>
			<td width="15%">公司座机：</td>
			<td width="35%"><input type="text" class="input" name="telephone" id="telephone" value="<?php echo isset($this->memberEnterpriseRow['telephone']) ? htmlspecialchars($this->memberEnterpriseRow['telephone']) : '';?>" /></td>
		</tr>
		<tr>
			<td width="15%">税务登记证号码：</td>
			<td width="35%"><input type="text" class="input" name="taxRegistrationCertificate" id="taxRegistrationCertificate" value="<?php echo isset($this->memberEnterpriseRow['taxRegistrationCertificate']) ? htmlspecialchars($this->memberEnterpriseRow['taxRegistrationCertificate']) : '';?>" /></td>
			<td width="15%">营业执照扫描件：</td>
			<td width="35%">
			<input type="file" name="businessLicenseCopy" id="businessLicenseCopy" />
			</td>
		</tr>
		<tr>
			<td width="15%">组织机构代码证号码：</td>
			<td width="35%"><input type="text" class="input" name="organizationCode" id="organizationCode" value="<?php echo isset($this->memberEnterpriseRow['organizationCode']) ? htmlspecialchars($this->memberEnterpriseRow['organizationCode']) : '';?>" /></td>
			<td width="15%">银行开户许可证号码：</td>
			<td width="35%"><input type="text" class="input" name="licenseNumberBankAccount" id="licenseNumberBankAccount" value="<?php echo isset($this->memberEnterpriseRow['licenseNumberBankAccount']) ? htmlspecialchars($this->memberEnterpriseRow['licenseNumberBankAccount']) : '';?>" /></td>
		</tr>
		<tr>
			<td width="15%">去年营业额：</td>
			<td width="35%"><input type="text" class="input" name="turnoverLastYear" id="turnoverLastYear" value="<?php echo isset($this->memberEnterpriseRow['turnoverLastYear']) ? htmlspecialchars($this->memberEnterpriseRow['turnoverLastYear']) : '';?>" /></td>
			<td width="15%">雇用人数：</td>
			<td width="35%"><input type="text" class="input" name="employeesNumber" id="employeesNumber" value="<?php echo isset($this->memberEnterpriseRow['employeesNumber']) ? htmlspecialchars($this->memberEnterpriseRow['employeesNumber']) : '';?>" /></td>
		</tr>
		<tr>
			<td width="15%">&nbsp;</td>
			<td colspan="3"><input name="submit4" type="submit" id="submit4" value="修改" class="button" />
			<input name="formClass" type="hidden" id="formClass" value="enterprise" /></td>
		</tr>
	</form>
</table>
</body>
</html>