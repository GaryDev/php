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
<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px;">
  <tr>
    <td width="180" height="40" align="left" valign="top">
    	<?php echo $this->render('member-menu.php');?>
    </td>
    <td valign="top">
		<div class="nytit6"><h3>正在融资的项目</h3></div>
		<div class="nytxt6 search">
			<div>
				<form id="searchForm" name="searchForm" class="searchForm" method="post" action="<?php echo $this->projectUrl();?>">
					融资编号：
					<input name="code" type="text" id="code" size="10" class="input" value="<?php echo htmlspecialchars($this->vars['code']);?>"/>
					<label></label>
					<input type="submit" name="button" id="button" value="查找" class="button"/>
				</form>
			</div>
			<table width="100%" border="0" class="table">
				<tr class="subject line">
					<td align="left">融资编号</td>
					<td>融资金额</td>
					<td>期限</td>
					<td>年利率</td>
					<td>状态</td>
					<td>完成率</td>
					<td>申请时间</td>
					<td>票据截止时间</td>
					<td align="center">操作</td>
				</tr>
				<?php
				foreach ($this->rows as $key=>$row) {
				?>
					<tr class="line">
						<td align="left"><a href="<?php echo $this->projectUrl(array('action'=>'view', 'code'=>$row['code']));?>"><?php echo $row['code'];?></a></td>
						<td><?php echo $row['amount'] / 10000;?>万</td>
						<td><?php echo $row['deadline'];?>天</td>
						<td><?php echo $row['yearInterestRate'];?>%</td>
						<td><?php if ($row['status'] == 1) {echo '已提交待审核';} else if ($row['status'] == 2) {echo '初审已通过';} else if ($row['status'] == 3) {echo '终审已通过（融资中）';}  else if ($row['status'] == 4) {echo '初审未通过';}  else if ($row['status'] == 5) {echo '终审未通过';} ?></td>
						<td><?php echo $row['percent']; ?>%</td>
						<td><?php echo date('Y-m-d', $row['addTime']);?></td>
						<td><?php echo date('Y-m-d', $row['ticketEndTime']);?></td>
						<td align="center">
						<a href="<?php echo $this->projectUrl(array('action'=>'view', 'code'=>$row['code']));?>" class="link">详细</a>
						<?php //if($row['percent'] > 95 && $row['percent'] < 100) {?>
						<!--  <a href="<?php echo $this->projectUrl(array('action'=>'complete', 'code'=>$row['code']));?>" class="link">完成</a> -->
						<?php //}?>
						<?php if($row['percent'] == 100 && $row['ticketEndTime'] <= time()) {?>
						<a href="<?php echo $this->projectUrl(array('action'=>'repay', 'code'=>$row['code']));?>" class="link">还款</a>
						<?php }?>
						</td>
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
	</td>
	</tr>
</table>

<?php echo $this->render('footer.php');?>

</body>
</html>
