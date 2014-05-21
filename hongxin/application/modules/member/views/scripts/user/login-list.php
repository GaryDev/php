<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<link rel="stylesheet" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/css/validationEngine.jquery.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/js/jquery.validationEngine-cn.js"></script>
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
			<h3>登录查询</h3>
		</div>
		<div class="nytxt6 search">
			<table width="100%" border="0" class="table">
				<tr class="subject line">
					<td width="33%">登录时间</td>
					<td width="33%">活动时间</td>
					<td width="33%">登录IP</td>
				</tr>
<?php
$time = time();
foreach ($this->rows as $key=>$row) {
    $limitTime = $row['lastOnlineTime'] - $row['time'];
?>
				<tr class="line">
					<td width="33%"><?php echo date('Y-m-d H:i:s', $row['time']);?></td>
					<td width="33%"><?php echo timeToString($limitTime);?></td>
					<td width="33%"><?php echo $row['ip'];?></td>
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
