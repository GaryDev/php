<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-blue.css" rel="stylesheet"  type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<link rel="stylesheet" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/css/validationEngine.jquery.css" type="text/css" />
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
		<h3>申请VIP会员</h3></div>
		<div class="nytxt6 search">
<?php
if (count($this->rows) > 0) {
?>
			<table width="100%" border="0" class="table">
				<tr class="subject line">
					<td>VIP期限</td>
					<td width="20%">申请时间</td>
					<td width="15%">价格</td>
					<td width="25%">状态</td>
				</tr>
<?php
$time = time();
foreach ($this->rows as $key=>$row) {
?>
				<tr class="line">
					<td><?php echo !empty($row['startTime']) ? date('Y-m-d H:i:s', $row['startTime']) : '--';?> 至 <?php echo !empty($row['endTime']) ? date('Y-m-d H:i:s', $row['endTime']) : '--';?></td>
					<td width="20%"><?php echo date('Y-m-d H:i:s', $row['addTime']);?></td>
					<td width="15%"><?php echo $row['year'] . '年';?>/￥<?php echo $row['price'] * 1;?></td>
					<td width="25%"><?php if ($row['status'] == 1) {echo '<span style="color:#f00;">已提交待审核</span>';} else if ($row['status'] == 2) {echo '已审核通过';} else if ($row['status'] == 3) {echo '<span style="color:#ccc;">已经审核未通过(作废)</span>';}?></td>
				</tr>
<?php
	$time = $row['endTime'];
}
?>
			</table>
			<div style="margin-top:20px;"></div>
<?php
}
?>
<form id="applyForm" name="applyForm" method="post" action="">
	<table border="0" align="left" >
		<tr>
			<td height="30" align="left">VIP服务：</td>
			<td height="30" align="left">
				<select name="year" id="year">
<?php
for($i = 1; $i <= 5; $i++) {
?>
					<option value="<?php echo $i;?>"><?php echo $i;?>年/￥<?php echo $this->vipPrice * $i;?></option>
<?php
}
?>
				</select>			</td>
		</tr>

		<tr>
			<td height="30" align="left">客服工号：</td>
			<td height="30" align="left"><input type="text" name="serviceCode" id="serviceCode" class="input"/></td>
		</tr>
		<tr>
			<td height="30" align="left">&nbsp;</td>
			<td height="30" align="left"><input type="submit" name="applyButton" id="applyButton" value="申请" class="button" />			</td>
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
	var url = "<?php echo $this->projectUrl(array('action'=>'check-apply-vip', 'year'=>'{year}', 'serviceCode'=>'{serviceCode}'), NULL, false);?>";
	url = url.replace('{year}', $('#year').val());
	url = url.replace('{serviceCode}', $('#serviceCode').val());

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
