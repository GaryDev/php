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
		<h3>账户提现</h3></div>
		<div class="nytxt6 search">

			<form id="applyForm" name="applyForm" method="post" action="">
				<table width="100%" border="0" align="left" class="table">
					<tr>
						<td align="left">持卡人：</td>
						<td align="left"><?php echo $this->memberRow['name'];?></td>
					</tr>
					<tr>
						<td align="left">银行名称：</td>
						<td><?php echo $this->memberRow['bankType'];?></td>
					</tr>
					<tr>
						<td align="left">开户支行：</td>
						<td><?php echo $this->memberRow['bankSubbranch'];?></td>
					</tr>
					<tr>
						<td align="left">银行帐号：</td>
						<td><?php echo $this->memberRow['bankAccount'];?></td>
					</tr>
					<tr>
						<td align="left">可用金额：</td>
						<td align="left">￥<?php echo $this->surplusAvailableAmount;?></td>
					</tr>
					<tr>
						<td align="left">冻结金额：</td>
						<td align="left">￥<?php echo $this->surplusLockAmount;?></td>
					</tr>
					<tr>
						<td align="left">金额：</td>
						<td align="left"><input name="amount" type="text" class="input" id="amount" value="0"/>
							元</td>
					</tr>
					<tr>
						<td align="left">备注：</td>
						<td align="left"><input name="userNotes" type="text" class="input" id="userNotes" value="" size="40" /></td>
					</tr>
					<tr>
						<td align="left">手续费：</td>
						<td align="left">每￥<?php echo $this->withdrawalsUnitAmount;?>收取￥<?php echo $this->withdrawalsUnitAmountFee;?></td>
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

<script language="javascript">
var isCheck = null;
$("#applyForm").submit(function(){
	var url = "<?php echo $this->projectUrl(array('action'=>'check', 'amount'=>'{amount}'), NULL, false);?>";
	url = url.replace('{amount}', $('#amount').val());

	if (isCheck == true) {
		isCheck = null;
		return true;
	}
	$("#applyButton").val('正在提交...');
	$("#applyButton").attr('disabled', true);
	$.ajax({
		type: "GET",
		url: url,
		dataType: "json",
		async: true,
		success: function(statusResult){
			$("#applyButton").val('申请');
			$("#applyButton").attr('disabled', false);
			if (statusResult.status != 0) {
				alert(statusResult.message);
			} else {
				isCheck = true;
				$("#applyForm").submit();
			}
		}
	});
	return false;
});

</script>
</body>
</html>
