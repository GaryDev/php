<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-blue.css" rel="stylesheet"  type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<link rel="stylesheet" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/css/validationEngine.jquery.css" type="text/css" />
<title>我的账户 - <?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>
<div class="mainbox">
	<?php echo $this->render('member-menu.php');?>
	<div class="tb3 mtop10">
		<div class="nytit6">
		<h3>额度变化记录</h3></div>
		<div class="nytxt6 search">
			<div>
				<form id="searchForm" name="searchForm" class="searchForm" method="post" action="<?php echo $this->projectUrl();?>">
					借款类型：
					
					<label><input type="radio" name="type" id="type" value="credit" <?php echo $this->vars['type'] == 'credit' ? ' checked' : '';?>/> 信用借款</label>
					<label><input type="radio" name="type" id="type" value="recommend" <?php echo $this->vars['type'] == 'recommend' ? ' checked' : '';?>/> 推荐借款</label>
					<label><input type="radio" name="type" id="type" value="" <?php echo $this->vars['type'] == '' ? ' checked' : '';?>/> 不限制</label>
					<input type="submit" name="button" id="button" value="查找" class="button"/>
				</form>
			</div>
			<table width="100%" border="0" class="table">
				<tr class="subject line">
					<td>新增额度</td>
					<td>累计可用额度</td>
					<td>类型</td>
					<td>状态</td>
					<td>申请时间</td>
					<td>备注</td>
				</tr>
<?php
foreach ($this->rows as $key=>$row) {
?>
				<tr class="line">
					<td>￥<?php echo $row['amount'] * 1;?></td>
					<td>￥<?php echo $row['surplusAmount'] * 1;?></td>
					<td><?php if ($row['type'] == 'credit') {echo '信用借款';} else if ($row['type'] == 'recommend') {echo '推荐借款';} ?></td>
					<td><?php if ($row['status'] == 1) {echo '<span style="color:#f00;">已提交待审核</span>';} else if ($row['status'] == 2) {echo '已审核通过';} else if ($row['status'] == 3) {echo '<span style="color:#ccc;">已经审核未通过(作废)</span>';}?></td>
					<td><?php echo date('Y-m-d H:i', $row['addTime']);?></td>
					<td><?php echo $row['notes'];?></td>
				</tr>
<?php
}
?>
			</table>
<?php
if (count($this->rows) == 0) {
?>
			<div class="nopage">暂无记录</div>
<?php
} else {
?>
			<div class="page"><?php echo $this->pageString;?></div>
<?php
}
?>
		</div>
	</div>
</div>
<div class="cl"></div>

<?php echo $this->render('footer.php');?>

</body>
</html>
