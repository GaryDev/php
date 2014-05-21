<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-blue.css" rel="stylesheet"  type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<link rel="stylesheet" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/css/validationEngine.jquery.css" type="text/css" />
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
<div class="mainbox">
	<?php echo $this->render('member-menu.php');?>
	<div class="tb3 mtop10">
		<div class="nytit6">
		<h3>账户充值</h3></div>
		<div class="nytxt6 search">

<form id="applyForm" name="applyForm" method="post" action="">
	<table width="100%" border="0" align="left" class="table">
		<tr>
			<td align="left">金额：</td>
			<td align="left"><input name="amount" type="text" class="input" id="amount" value="0"/>
				元</td>
		</tr>

		<tr>
			<td align="left">银行：</td>
			<td align="left">
				<select name="from" id="from">
					<option value="">选择</option>
<?php
foreach($this->bankTypes as $bank) {
?>
					<option value="<?php echo $bank;?>" <?php echo $this->row['bankType'] == $bank ? ' selected' : '';?>><?php echo $bank;?></option>
<?php
}
?>
				</select>
			</td>
		</tr>
		<tr>
			<td align="left">交易号：</td>
			<td align="left"><input type="text" name="serialNumber" id="serialNumber" class="input"/></td>
		</tr>
		<tr>
			<td align="left">汇款时间：</td>
			<td align="left">
				<input type="text" name="paymentTime" id="paymentTime" class="input"/>
				<script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","firstDay":0,"showsTime":false,"showOthers":false,"timeFormat":24,"inputField":"paymentTime","button":"paymentTime"});</script>
			</td>
		</tr>
		<tr>
			<td align="left">备注：</td>
			<td align="left"><input name="notes" type="text" class="input" id="notes" value="" size="40" /></td>
		</tr>
		<tr>
			<td align="left">&nbsp;</td>
			<td align="left"><input type="submit" name="applyButton" id="applyButton" value="申请" class="button" />			</td>
		</tr>
	</table>
</form>
		</div>
	</div>
</div>
<div class="cl"></div>

<?php echo $this->render('footer.php');?>

</body>
</html>
