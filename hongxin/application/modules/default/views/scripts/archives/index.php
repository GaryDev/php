<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<title><?php echo $this->archivesClassRow['name'];?> - <?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>
<div class="mainbox">
	<div class="nytit3 mtop10"><h3><?php echo $this->archivesClassRow['name'];?></h3></div>
	<div class="nytxt3">
<?php
if (!empty($this->rows)) {
?>
		<ul class="archivesHead">
			<li>
				<div class="title">标题</div>
				<div class="date">时间</div>
				<div style="clear:both;"></div>
			</li>
			<div style="clear:both;"></div>
		</ul>

		<ul class="archivesList">
<?php
	foreach ($this->rows as $key=>$row) {
		if ($row['isLink'] == 1) {
			$link = $row['linkUrl'];
		} else {
			$link = $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'view', 'id'=>$row['id']));
		}
?>
			<li>
				<div class="title"><a href="<?php echo $link;?>" title="<?php echo $row['title'];?>"><?php echo $row['title'];?></a></div>
				<div class="date"><?php echo date('Y-m-d', $row['updateTime']);?></div>
				<span style="clear:both;"></span>
			</li>
<?php
	}
?>
		</ul>
		<div class="page"><?php echo $this->pageString;?></div>
<?php
} else {
?>
		<div style="padding:20px; text-align:center;">暂无记录</div>
<?php
}
?>
	</div>	

</div>
<?php echo $this->render('footer.php');?>
</body>
</html>