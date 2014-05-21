<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<title>客服中心 - <?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>
<div class="mainbox">
	<div class="nytit3 mtop10"><h3>客服中心</h3></div>
	<div class="nytxt3">
		<ul class="nypic1">
<?php
foreach ($this->rows as $key=>$row) {
?>
			<li>
				<img src="<?php echo $row['avatarUrl'];?>" style="width:auto; height:auto;"/>
				<span>
					客服：<?php echo $row['name'];?><br />
					工号：<?php echo $row['code'];?><br />
					电话：<?php echo !empty($row['tel']) ? $row['tel'] : '--';?><br />
<?php
if (!empty($row['qq'])) {
?>
					<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $row['qq'];?>&amp;site=qq&amp;menu=yes"><img src="http://wpa.qq.com/pa?p=2:<?php echo $row['qq'];?>:41" alt="点击这里给我发消息" border="0" align="absmiddle" title="点击这里给我发消息" /></a>
<?php
}
?>
				</span>
			</li>
<?php
}
?>
		</ul>
	</div>	

</div>
<?php echo $this->render('footer.php');?>
</body>
</html>