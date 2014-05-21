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
		<h3>借款额度申请</h3></div>
		<div class="nytxt6 search">

			<form id="applyForm" name="applyForm" method="post" action="">
				<table width="100%" border="0" align="left" class="table">
<?php
if ($this->memberRow['borrowingCreditIsOpen'] == 1) {
?>
					<tr>
						<td align="left">当前信用借款额度：</td>
						<td align="left">￥<?php echo $this->creditAmount;?></td>
					</tr>
<?php
}
?>
<?php
if ($this->memberRow['borrowingRecommendIsOpen'] == 1) {
?>
					<tr>
						<td align="left">当前推荐借款额度：</td>
						<td align="left">￥<?php echo $this->recommendAmount;?></td>
					</tr>
<?php
}
?>
					<tr>
						<td align="left">申请增加额度：</td>
						<td align="left"><input name="amount" type="text" class="input" id="amount" value="0"/>
							元</td>
					</tr>
					<tr>
						<td align="left">申请增加类型：</td>
						<td align="left">
							<select name="type" id="type">
<?php
if ($this->memberRow['borrowingCreditIsOpen'] == 1) {
?>
								<option value="credit">信用额度</option>
<?php
}
?>
<?php
if ($this->memberRow['borrowingRecommendIsOpen'] == 1) {
?>
								<option value="recommend">推荐额度</option>
<?php
}
?>
							</select>
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

<script language="javascript">
var isCheck = null;
$("#applyForm").submit(function(){
	var url = "<?php echo $this->projectUrl(array('action'=>'check', 'type'=>'{type}'), NULL, false);?>";
	url = url.replace('{type}', $('#type').val());
	
	if (parseFloat($.trim($("#amount").val())) == 0) {
		alert('请填写金额。');
		$("#amount").focus();
		return false;
	} else if (parseFloat($.trim($("#amount").val())) <= 0 || isNaN($.trim($("#amount").val()))) {
		alert('金额填写错误。');
		$("#amount").focus();
		return false;
	}

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
