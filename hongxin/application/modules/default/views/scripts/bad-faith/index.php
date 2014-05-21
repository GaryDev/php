<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<title>逾期黑名单 - <?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>
<div class="cl"></div>
<div class="mainbox">
	<div class="nytit1 mtop10">
		<span style="width:100px; margin-left:15px;">头像</span>
		<span style="width:150px; margin-left:36px;">用户名</span>
		<span style="width:200px; margin-left:-2px;">E-mail</span>
		<span style="width:150px; margin-left:35px;">姓名</span>
		<span style="width:150px; margin-left:23px;">手机</span>
	</div>
	<div class="nytxt1">
		<ul>
<?php
foreach($this->rows as $row) {
?>
			<li>
				<span style="width:150px;"><img src="<?php echo $row['avatarUrl'];?>" height="50" style="border:#ccc solid 1px;"/></span>
				<span style="width:150px; text-align:left;"><?php echo $row['userName'];?></span>
				<span style="width:200px;"><?php echo $row['email'];?></span>
				<span style="width:150px;"><?php echo $row['name'];?></span>
				<span style="width:150px;"><?php echo $row['mobile'];?></span>
			</li>
<?php
}
?>
<?php
if (empty($this->rows)) {
?>
			<div style="text-align:center; line-height:40px;">暂无记录</div>
<?php
}
?>
		</ul>
<?php
if (!empty($this->rows)) {
?>
		<div class="page">
			<?php echo $this->pageString;?>
		</div>
<?php
}
?>
	</div>
</div>
<?php echo $this->render('footer.php');?>
</body>
</html>
