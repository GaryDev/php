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
        margin: 15px 5px 5px 30px;
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
</style>
</head>

<body>
<?php echo $this->render('top.php');?>

<?php if($this->action != 'about'): ?>
<div class="mainbox">
	<div class="nytit3 mtop10"><h3><?php echo $this->menuTitle;?></h3></div>
	<div class="nytxt3"><?php echo $this->content;?></div>

</div>
<?php else: ?>
<table id="tabContainer" style="width: 1200px;">
	<tr>
		<td valign="top">
			<ul>
		      <li id="tab1" style="margin-left: 35px;"><a href="#" class="on" onclick="switchTab('tab1','con1');this.blur();return false;">公司简介</a></li>
		      <li id="tab2" style="margin-left: 35px;"><a href="#" onclick="switchTab('tab2','con2');this.blur();return false;">联系方式</a></li>
		    </ul>
		</td>
		<td valign="top">
			<div id="con1" style="width: 850px; position:absolute; left: 300px;top: 160px;"><?php echo $this->contentAbout;?></div>
			<div id="con2" style="width: 850px; position:absolute; left: 300px;top: 160px; display:none;"><?php echo $this->contentContact;?></div>
		</td>
	</tr>
</table>
<?php endif; ?>

<?php echo $this->render('footer.php');?>
</body>
</html>