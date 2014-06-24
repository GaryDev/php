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
<script type="text/javascript">
    function switchTab(ProTag, ProBox) {
        for (i = 1; i < 3; i++) {
            if ("tab" + i == ProTag) {
                document.getElementById(ProTag).getElementsByTagName("a")[0].className = "on";
            } else {
                document.getElementById("tab" + i).getElementsByTagName("a")[0].className = "";
            }
            if ("con" + i == ProBox) {
                document.getElementById(ProBox).style.display = "";
            } else {
                document.getElementById("con" + i).style.display = "none";
            }
        }
    }
</script>
<style type="text/css">
    #tabContainer
    {
        margin: 15px auto 5px auto;
    	padding-top: 3px;
    }
    #tabContainer li
    {
        /*float: left;*/
        width: 200px;
        margin: 3px 3px;
        background: #efefef;
        text-align: center;
    }
    #tabContainer a
    {
        display: block;
    	font-size: 15px;
    	line-height: 30px;
    }
    #tabContainer a.on
    {
        background: #30318B;
    	color: #ffffff;
    }
	#tabContainer .tt
    {
        border-bottom: 2px solid #DDDDDD;
	    color: #666666;
	    font-size: 18px;
	    font-weight: bold;
	    line-height: 48px;
	    width: 798px;
    	margin-bottom: 5px;
    	text-align: left;
    }
</style>
</head>

<body style="text-align: center;">
<?php echo $this->render('top.php');?>

<?php if(!in_array($this->action, array('about', 'contact'))): ?>
<div class="mainbox" style="text-align: left;">
	<div class="nytit3 mtop10"><h3><?php echo $this->menuTitle;?></h3></div>
	<div class="nytxt3"><?php echo $this->content;?></div>

</div>
<?php else: ?>
<table id="tabContainer" style="width: 1200px;">
	<tr>
		<td valign="top">
			<ul>
		      <li id="tab1" style="margin-left: 35px;"><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'index', 'classId'=>3));?>" class="<?php echo ($this->vars['classId'] == 3) ? 'on' : ''; ?>">理财课堂</a></li>
		      <li id="tab2" style="margin-left: 35px;"><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'index', 'classId'=>2));?>" class="<?php echo ($this->vars['classId'] == 2) ? 'on' : ''; ?>">行业资讯</a></li>
		      <li id="tab3" style="margin-left: 35px;"><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'index', 'classId'=>6));?>" class="<?php echo ($this->vars['classId'] == 6) ? 'on' : ''; ?>">媒体报道</a></li>
		      <li id="tab4" style="margin-left: 35px;"><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'info', 'action'=>'about'));?>" class="<?php echo ($this->action == 'about') ? 'on' : ''; ?>">关于我们</a></li>
		      <li id="tab5" style="margin-left: 35px;"><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'info', 'action'=>'contact'));?>" class="<?php echo ($this->action == 'contact') ? 'on' : ''; ?>">联系我们</a></li>
		    </ul>
		</td>
		<td style="width: 30px;">&nbsp;</td>
		<td valign="top" style="width: 950px;">
		<div class="tt"><?php echo $this->menuTitle; ?></div>
		<table width="798px" border="0" cellpadding="0" cellspacing="0">
		<tr><td align="left"><?php echo $this->content;?></td></tr>
		</table>
		</td>
	</tr>
</table>
<?php endif; ?>

<?php echo $this->render('footer.php');?>
</body>
</html>