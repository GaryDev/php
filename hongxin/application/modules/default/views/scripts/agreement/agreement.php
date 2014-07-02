<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<title><?php echo $this->menuTitle;?> - <?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
<style>
.nytxt3 * {
	font-size: 14px;
	line-height: 30px;	
}
ul {
	padding-left: 20px;
}
ul li {
	list-style-type:disc;
}
</style>
<script>
	$(document).ready(function(){
		$("#content").val($("#agreement").html());
	});
</script>
</head>

<body>
<?php echo $this->render('top.php');?>
<form action="" method="post">
<div class="mainbox">
	<div class="nytit3 mtop10"></div>
	<div id="agreement" class="nytxt3" style="margin-bottom: 10px;">
	<center><h1 style="font-size: 20px;"><?php echo $this->menuTitle;?></h1></center>
	<?php echo $this->content;?>
	</div>
	<div style="text-align: center;">
		<input type="submit" class="btn" value="保存" />
		<input type="hidden" name="content" id="content" value="" />
		<input type="hidden" name="orderNo" id="orderNo" value="<?php echo $this->orderNo; ?>" />
	</div>
</div>
</form>
<?php echo $this->render('footer.php');?>
</body>
</html>