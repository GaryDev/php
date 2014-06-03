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
				<td><h3>身份认证</h3></td>
				<td align="right"></td>
			</tr>
		</table>
		<form id="identifyForm" name="identifyForm" method="post" action="<?php echo $this->ysburl; ?>" target="_blank">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
			<tr>
				<td width="15%">真实姓名：</td>
				<td><input name="userName" type="text" class="input" id="userName" size="40" value="<?php echo htmlspecialchars($this->row['name']);?>" /></td>
			</tr>
			<tr>
				<td width="15%">身份证号码：</td>
				<td><input name="idCardNumber" type="text" class="input" id="idCardNumber" size="40" value="<?php echo htmlspecialchars($this->row['idCardNumber']);?>" /></td>
			</tr>
			<tr>
				<td width="15%">&nbsp;</td>
				<td><input name="submit" type="submit" id="submit1" value="去验证身份并开通支付账号" class="button" /></td>
			</tr>
		</table>
		<?php foreach ($this->params as $n=>$p): ?>
			<?php //if(!in_array($n, array('name', 'idNum'))): ?>
				<input type="hidden" name="<?php echo $n; ?>" value="<?php echo $p; ?>" />
			<?php //endif; ?>
		<?php endforeach; ?>
		</form>
    </td>
  </tr>  
</table>

<?php echo $this->render('footer.php');?>

</body>
</html>
