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
    #tabContainer li a, #archivesList a
    {
        display: block;
    	font-size: 15px;
    	line-height: 30px;
    }
    #tabContainer li a.on
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
    }
</style>
</head>

<body>
<?php echo $this->render('top.php');?>
<table id="tabContainer" style="width: 1200px;">
	<tr>
		<td valign="top">
			<ul>
		      <li id="tab1" style="margin-left: 35px;"><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'index', 'classId'=>3));?>" class="<?php echo ($this->vars['classId'] == 3) ? 'on' : ''; ?>">理财课堂</a></li>
		      <li id="tab2" style="margin-left: 35px;"><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'index', 'classId'=>2));?>" class="<?php echo ($this->vars['classId'] == 2) ? 'on' : ''; ?>">行业咨询</a></li>
		      <li id="tab3" style="margin-left: 35px;"><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'index', 'classId'=>6));?>" class="<?php echo ($this->vars['classId'] == 6) ? 'on' : ''; ?>">媒体报道</a></li>
		      <li id="tab4" style="margin-left: 35px;"><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'info', 'action'=>'about'));?>">关于我们</a></li>
		      <li id="tab5" style="margin-left: 35px;"><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'info', 'action'=>'contact'));?>">联系我们</a></li>
		    </ul>
		</td>
		<td style="width: 30px;">&nbsp;</td>
		<td valign="top" style="width: 950px;">
		<div class="tt"><?php echo $this->subTitle; ?></div>
		<?php
		if (!empty($this->rows)) {
		?>
				<table id="archivesList" width="798px" border="0" cellpadding="0" cellspacing="0">
		<?php
			foreach ($this->rows as $key=>$row) {
				if ($row['isLink'] == 1) {
					$link = $row['linkUrl'];
				} else {
					$link = $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'view', 'id'=>$row['id']));
				}
		?>
					<tr>
						<td width="70%"><a href="<?php echo $link;?>" title="<?php echo $row['title'];?>"><?php echo substrMoreCn($row['title'], 50, '...');?></a></td>
						<td align="center"><?php echo date('Y-m-d H:i:s', $row['updateTime']);?></td>
					</tr>
		<?php
			}
		?>
				</table>
				<div class="page"><?php echo $this->pageString;?></div>
		<?php
		} else {
		?>
				<div style="padding:20px; text-align:center;">暂无记录</div>
		<?php
		}
		?>
		</td>
	</tr>
</table>

<?php echo $this->render('footer.php');?>
</body>
</html>