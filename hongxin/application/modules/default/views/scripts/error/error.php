<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>访问出现了一个问题</title>
<style type="text/css">
div{font-size:14px; color:#006699; text-align:left;}
a{color:#006699;}
body{margin:30px;}
.line{margin-top:10px; margin-bottom:15px; height:0px; border-bottom:#006699 solid 2px; width:500px;}
.title{font-size:16px; font-weight:bold;}
</style>
</head>

<body>
	<div class="title">访问出现了一个问题</div>
	<div class="line">&nbsp;</div>
	<div><?php echo $this->message;?></div>
	<div style="margin-top:20px;"><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'index', 'action'=>'index'));?>" target="_parent"><img src="<?php echo $this->baseUrl;?>/files/default/images/logo.jpg" border="1" /></a></div>
	<!--<?php echo $this->exception;?>-->
</body>
</html>