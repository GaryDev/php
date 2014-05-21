<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/admin/css/frameLeft.css" rel="stylesheet"/>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/admin/scripts/load.js"></script>
<title><?php echo $this->title;?></title>
</head>

<body>
<div class="leftMenuSubject"><img src="<?php echo $this->baseUrl;?>/files/publicFiles/images/text.png" border="0" align="absmiddle"/> 管理目录</div>
<div style="padding-bottom:20px;">
<?php
echo $this->catalogList;
?>    
</div>
<script language="javascript">
$(".catalogStyle_0").css("display", "");
</script>
</body>
</html>