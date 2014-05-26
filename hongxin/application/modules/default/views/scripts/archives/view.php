<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<title><?php echo $this->row['title'];?> - <?php echo $this->row['className'];?> - <?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>
<div class="mainbox">
	<div class="nytit3 mtop10"><h3><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'index', 'classId'=>$this->row['classId']));?>"><?php echo $this->row['className'];?></a></h3></div>
	<div class="nytxt3">
		<p style="text-align:center; font-weight:bold;"><?php echo $this->row['title'];?></p>
		<div><?php echo $this->row['content'];?></div>
	</div>

</div>
<?php echo $this->render('footer.php');?>
</body>
</html>