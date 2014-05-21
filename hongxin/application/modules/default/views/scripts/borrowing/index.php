<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<title><?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>
<div class="mainbox">
	<div class="search mtop10">
		<form name="borrowingForm" id="borrowingForm" method="post" action="<?php echo $this->projectUrl(array('status'=>$this->vars['status']));?>">
			关键词：
			<input name="keyword" type="text" class="input" id="keyword" value="<?php echo $this->vars['keyword'];?>"/>&nbsp;&nbsp;
			资金范围：
			<input name="amount1" type="text" class="input" id="amount1" size="10" value="<?php echo $this->vars['amount1'];?>" />
			至
			<input name="amount2" type="text" class="input" id="amount2" size="10" value="<?php echo $this->vars['amount2'];?>" />&nbsp;&nbsp;
			借款期限：
			<select name="deadlineLimit" id="deadlineLimit">
				<option value="">不限</option>
				<option value="1"<?php echo $this->vars['deadlineLimit'] == '1' ? ' selected' : '';?>>1~6个月</option>
				<option value="2"<?php echo $this->vars['deadlineLimit'] == '2' ? ' selected' : '';?>>6~12个月</option>
			</select>&nbsp;&nbsp;
			排序：
			<select name="orderby" id="orderby" >
				<option value="1"<?php echo $this->vars['orderby'] == '1' ? ' selected' : '';?>>按时间</option>
				<option value="2"<?php echo $this->vars['orderby'] == '2' ? ' selected' : '';?>>按金额</option>
				<option value="3"<?php echo $this->vars['orderby'] == '3' ? ' selected' : '';?>>按年利率</option>
				<option value="4"<?php echo $this->vars['orderby'] == '4' ? ' selected' : '';?>>按进度</option>
			</select>&nbsp;&nbsp;
			<input type="submit" name="Submit" value=" 搜索 " class="button" />
		</form>
  </div>
</div>
<div class="cl"></div>
<div class="mainbox">
	<div class="nytit1 mtop10">
		<span style="width:130px;">头像</span>
		<span style="text-align:left; width:220px;">标题/借款者</span>
		<span style="width:100px;">认证</span>
		<span style="width:100px;">金额</span>
		<span style="width:80px;">年利率</span>
		<span style="width:90px;">期限</span>
		<span style="width:125px;">进度/剩余时间</span>
	</div>
	<div class="nytxt1">
		<ul>
<?php
foreach($this->rows as $row) {
?>
			<li>
				<span style="width:45px;"><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'borrowing', 'action'=>'view', 'code'=>$row['code']));?>"><img src="<?php echo $row['avatarUrl'];?>" height="50"/></a></span>
				<span style="text-align:left; width:230px;">
					<p><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'borrowing', 'action'=>'view', 'code'=>$row['code']));?>" title="<?php echo $row['title'];?>"><?php echo substrMoreCn($row['title'], 36);?></a></p>
					<p>借款人：<?php echo $row['userName'];?></p>
				</span>
				<span style="width:105px;" class="tub"><a href="#"></a><a href="#" class="rz2"></a><a href="#" class="rz3"></a></span>
				<span style="width:85px;">￥<?php echo $row['amount'] * 1;?></span>
				<span style="width:60px;"><?php echo $row['monthInterestRate'] * 12 * 100;?>%</span>
				<span style="width:60px;"><?php echo $row['deadline'];?>个月</span>
				<span class="jind" style="width:125px;">
					<code><em style="width:<?php echo $row['schedule'];?>%"></em></code>
					<p>已有<?php echo $row['borrowedCount'];?>笔投标，借款完成 <?php echo $row['schedule'];?>%</p>
				</span>
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
