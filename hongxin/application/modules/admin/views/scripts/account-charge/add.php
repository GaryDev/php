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
        <td class="content"><span class="description">当前位置：</span>账户充值</td>
    </tr>
</table>
<form id="editForm" name="editForm" method="post" action="">
	<table width="100%" border="0" align="left" class="table">
		<tr>
			<td align="left">用户名：</td>
			<td align="left"><input name="userName" type="text" class="input" id="userName" value="" size="40" />
				填写待充值会员的用户名</td>
		</tr>
		<tr>
			<td align="left">金额：</td>
			<td align="left"><input name="amount" type="text" class="input" id="amount" value="0"/>
			元 （可填写负数）</td>
		</tr>

		<tr>
			<td align="left">备注：</td>
			<td align="left"><input name="notes" type="text" class="input" id="notes" value="" size="40" /></td>
		</tr>
		<tr>
			<td align="left">&nbsp;</td>
			<td align="left"><input type="submit" name="applyButton" id="applyButton" value="充值" class="button" />			</td>
		</tr>
	</table>
</form>
</body>
</html>