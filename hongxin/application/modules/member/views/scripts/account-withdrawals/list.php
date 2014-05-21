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
		<h3>充值记录</h3></div>
		<div class="nytxt6 search">

			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
				<tr class="subject line">
					<td align="left">金额</td>
					<td align="left">手续费</td>
					<td align="left">状态</td>
					<td align="left">审核意见</td>
					<td align="left"> 申请时间</td>
					<td align="left" class="subject line">用户备注</td>
				</tr>
<?php
foreach ($this->rows as $key=>$row) {
?>
				<tr class="line">
					<td align="left">￥<?php echo $row['amount'];?></td>
					<td align="left">￥<?php echo $row['fee'];?></td>
					<td align="left"><?php if ($row['status'] == 1) {echo '<span style="color:#f00;">已提交待审核</span>';} else if ($row['status'] == 2) {echo '已审核已发放';} else if ($row['status'] == 3) {echo '<span style="color:#ccc;">已经审核未通过(作废)</span>';}?></td>
					<td align="left"><?php echo $row['statusNotes'];?></td>
					<td align="left"><?php echo date('Y-m-d H:i', $row['applyTime']);?></td>
					<td align="left" class="line"><?php echo $row['userNotes'];?></td>
				</tr>
<?php
}
?>
			</table>
<?php
if (count($this->rows) == 0) {
?>
			<div class="nopage">暂无记录</div>
<?php
} else {
?>
			<div class="page"><?php echo $this->pageString;?></div>
<?php
}
?>
		</div>
	</div>
</div>
<div class="cl"></div>

<?php echo $this->render('footer.php');?>

</body>
</html>
