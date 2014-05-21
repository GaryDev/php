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
		<h3>资金记录</h3></div>
		<div class="nytxt6 search">

			<table width="100%" border="0" class="table">
				<tr class="subject line">
					<td>操作金额</td>
					<td>剩余金额</td>
					<td>操作时间</td>
					<td>备注</td>
				</tr>
<?php
foreach ($this->rows as $key=>$row) {
?>
				<tr class="line">
					<td>￥<?php echo $row['amount'] * 1;?></td>
					<td>￥<?php echo $row['surplusAvailableAmount'] * 1;?>（可用），￥<?php echo $row['surplusLockAmount'] * 1;?>（冻结）</td>
					<td><?php echo date('Y-m-d H:i', $row['addTime']);?></td>
					<td><?php echo $row['notes'];?></td>
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
