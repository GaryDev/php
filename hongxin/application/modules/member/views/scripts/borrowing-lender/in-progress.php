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
		<h3>正在投标的项目</h3></div>
		<div class="nytxt6 search">
			<div>
				<form id="searchForm" name="searchForm" class="searchForm" method="post" action="<?php echo $this->projectUrl();?>">
					借款编号：
					<input name="code" type="text" id="code" size="10" class="input" value="<?php echo htmlspecialchars($this->vars['code']);?>"/>
					<label></label>
					<input type="submit" name="button" id="button" value="查找" class="button"/>
				</form>
			</div>
			<table width="100%" border="0" class="table">
				<tr class="subject line">
					<td align="left">借款编号</td>
					<td>借款类型</td>
					<td>还款方式</td>
					<td>期限</td>
					<td>年利率</td>
					<td>状态</td>
					<td>时间</td>
					<td align="center">明细</td>
				</tr>
<?php
foreach ($this->rows as $key=>$row) {
?>
				<tr class="line">
					<td align="left"><a href="<?php echo $this->projectUrl(array('action'=>'view', 'code'=>$row['code']));?>"><?php echo $row['code'];?></a></td>
					<td><?php if ($row['type'] == 'credit') {echo '信用借款';} else if ($row['type'] == 'recommend') {echo '推荐借款';} ?></td>
					<td><?php if ($row['repaymentType'] == '1') {echo '等额本息';} else if ($row['repaymentType'] == '2') {echo '等本等息';} ?></td>
					<td><?php echo $row['deadline'];?>个月</td>
					<td><?php echo $row['monthInterestRate'] * 12 * 100;?>%</td>
					<td><?php if ($row['status'] == 1) {echo '已提交待审核';} else if ($row['status'] == 2) {echo '已审核借款中';} else if ($row['status'] == 3) {echo '借款完成审核中';}  else if ($row['status'] == 4) {echo '还款中';}  else if ($row['status'] == 5) {echo '还款完成';}   else if ($row['status'] == 6) {echo '<span style="color:#ccc;">已经审核未通过(作废)</span>';}?></td>
					<td><?php echo !empty($row['statusUpdateTime']) ? date('Y-m-d', $row['statusUpdateTime']) : '--';?></td>
					<td align="center"><a href="<?php echo $this->projectUrl(array('action'=>'view', 'code'=>$row['code']));?>" class="link">查看</a></td>
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
