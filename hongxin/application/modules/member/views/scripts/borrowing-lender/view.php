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
		<h3>“<?php echo $this->row['title'];?>”还款明细</h3></div>
		<div class="nytxt6 search">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
				<tr class="subject line">
					<td width="10%" align="center">期数</td>
					<td>待还本息</td>
					<td>待还利息</td>
					<td>还款期限</td>
					<td>还款状态</td>
				</tr>
<?php
foreach($this->repaymentDetailRows as $key=>$repaymentRow) {
?>
				<tr class="line">
					<td width="10%" align="center"><?php echo $repaymentRow['numberOfCycles'];?></td>
					<td>￥<?php echo $repaymentRow['principal'] * 1;?></td>
					<td>￥<?php echo $repaymentRow['interest'] * 1;?></td>
					<td><?php echo date('Y-m-d H:i:s', $repaymentRow['currentCyclesRepaymentDeadline']);?></td>
					<td><?php if ($repaymentRow['status'] == '1') {echo '未还';} else if ($repaymentRow['status'] == '2') {echo '正常还款';} else if ($repaymentRow['status'] == '3') {echo '延期还款';} else if ($repaymentRow['status'] == '4') {echo '网站垫付';}?></td>
				</tr>
				<?php
}
?>
			</table>
<?php
if (count($this->repaymentDetailRows) == 0) {
?>
			<div class="nopage">暂无记录</div>
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
