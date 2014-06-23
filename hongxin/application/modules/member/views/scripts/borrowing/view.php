<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-blue.css" rel="stylesheet"  type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<link rel="stylesheet" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/css/validationEngine.jquery.css" type="text/css" />
<!--时间选择器-->
<script src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar.js"></script>
<script src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/lang/cn_utf8.js"></script>
<script src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-setup.js"></script>
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-blue.css" rel="stylesheet" />
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
		<div class="nytit6">
		<h3>融资明细</h3></div>
		<div class="nytxt6 search">
			<table width="100%" border="0" align="left" class="table">
				<tr>
					<td width="15%" align="left">融资编号：</td>
					<td align="left"><?php echo $this->row['code'];?> <input type="submit" name="back" id="back" value="返回" class="button" onclick="history.go(-1);"/>	</td>
				</tr>
				<tr>
					<td align="left">融资标题：</td>
					<td align="left"><?php echo $this->row['title'];?></td>
				</tr>
				<tr>
					<td align="left">融资金额：</td>
					<td align="left"><?php echo $this->row['amount'];?>元</td>
				</tr>
				<!--  
				<tr>
					<td align="left">还款方式：</td>
					<td align="left"><?php echo '保本保息'; ?></td>
				</tr>
				-->
				<tr>
					<td align="left">年利率：</td>
					<td align="left"><?php echo $this->row['yearInterestRate'];?>%</td>
				</tr>
		
				<tr>
					<td align="left">状态：</td>
					<td align="left"><?php if ($this->row['status'] == 1) {echo '已提交待审核';} else if ($this->row['status'] == 2) {echo '初审已通过';} else if ($this->row['status'] == 3) {echo '终审已通过（融资中）';}  else if ($this->row['status'] == 4) {echo '初审未通过';}  else if ($this->row['status'] == 5) {echo '终审未通过';} ?></td>
				</tr>
<?php
if (trim($this->row['statusMessage']) != '') {
?>
				<tr>
					<td align="left">审核意见：</td>
					<td align="left"><b><?php echo $this->row['statusMessage'];?></b></td>
				</tr>
<?php
}
?>
				<tr>
					<td align="left">融资期限：</td>
					<td align="left"><?php echo $this->row['deadline'];?>天</td>
				</tr>
				<tr>
					<td align="left">投资单位：</td>
					<td align="left"><?php echo $this->borrowingUnitMin;?>元/份</td>
				</tr>
				<tr>
					<td align="left">最小投资份数：</td>
					<td align="left"><?php echo $this->row['amountMinUnit'];?>份</td>
				</tr>
				<tr>
					<td align="left">最大投资份数：</td>
					<td align="left"><?php echo $this->row['amountMaxUnit'];?>份</td>
				</tr>
				<tr>
					<td align="left">募集开始时间：</td>
					<td align="left"><?php echo date('Y-m-d', $this->row['startTime']);?></td>
				</tr>
				<tr>
					<td align="left">募集截止时间：</td>
					<td align="left"><?php echo date('Y-m-d', $this->row['endTime']);?></td>
				</tr>
				<tr>
					<td align="left">票据到期时间：</td>
					<td align="left"><?php echo date('Y-m-d', $this->row['ticketEndTime']);?></td>
				</tr>
				<tr>
					<td align="left">最迟还款日期：</td>
					<td align="left"><?php echo date('Y-m-d', $this->row['repayEndTime']);?></td>
				</tr>
				<tr>
					<td align="left">融资用途：</td>
					<td align="left"><?php echo str_replace("\n", "<br/>", $this->row['notes']);?></td>
				</tr>

			</table>
<!--  
			<h3>投标记录</h3>
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
				<tr class="title">
					<td width="10%" align="center">序号</td>
					<td>投标人</td>
					<td>投标金额</td>
					<td>投标时间</td>
				</tr>
<?php
foreach($this->borrowingDetailRows as $key=>$borrowingDetailRow) {
?>
			
				<tr>
					<td width="10%" align="center"><?php echo ($key + 1);?></td>
					<td><?php echo $borrowingDetailRow['userName'];?></td>
					<td>￥<?php echo $borrowingDetailRow['amount'];?></td>
					<td><?php echo date('Y-m-d H:i:s', $borrowingDetailRow['addTime']);?></td>
				</tr>
<?php
}
?>
<?php
if (empty($this->borrowingDetailRows)) {
?>
				<tr>
					<td colspan="4" align="center">暂无记录</td>
				</tr>
<?php
}
?>
			</table>
			
			
			<h3>还款记录</h3>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
				<tr class="title">
					<td width="10%" align="center">期数</td>
					<td>待还本息</td>
					<td>待还利息</td>
					<td>还款期限</td>
					<td>还款状态</td>
					<td>实际还款时间</td>
				</tr>
<?php
foreach($this->repaymentRows as $key=>$repaymentRow) {
?>
			
				<tr>
					<td width="10%" align="center"><?php echo $repaymentRow['numberOfCycles'];?></td>
					<td>￥<?php echo $repaymentRow['principal'] * 1;?></td>
					<td>￥<?php echo $repaymentRow['interest'] * 1;?></td>
					<td><?php echo date('Y-m-d H:i:s', $repaymentRow['currentCyclesRepaymentDeadline']);?></td>
					<td><?php if ($repaymentRow['status'] == '1') {echo '未还';} else if ($repaymentRow['status'] == '2') {echo '正常还款';} else if ($repaymentRow['status'] == '3') {echo '延期还款';} else if ($repaymentRow['status'] == '4') {echo '网站垫付';}?></td>
					<td><?php echo !empty($repaymentRow['repaymentTime']) ? date('Y-m-d H:i:s', $repaymentRow['repaymentTime']) : '--';?></td>
				</tr>
<?php
}
?>
<?php
if (empty($this->repaymentRows)) {
?>
				<tr>
					<td colspan="6" align="center">暂无记录</td>
				</tr>
<?php
}
?>
			</table>
<?php
if ($this->row['status'] == '4') {
?>
			<h3>还款</h3>
			<form name="repaymentForm" id="repaymentForm" method="post" action="">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
					<tr>
						<td align="left">可用金额：￥<?php echo $this->surplusAvailableAmount;?></td>
					</tr>
					<tr>
						<td align="left">还款金额：
							<label><input name="repaymentHowType" type="radio" id="repaymentHowType" value="1" checked="checked" /> ￥<?php echo $this->currentRepaymentAmount;?></label>&nbsp;&nbsp;
							<label><input name="repaymentHowType" type="radio" id="repaymentHowType2" value="2" /> 一次还清￥<?php echo $this->allNoRepaymentAmount;?></label>
							<input type="submit" id="submit" name="submit" value="还款" class="button" />
						</td>
					</tr>
				</table>
			</form>
<?php
}
?>
-->
		</div>
    </td>
</tr>
</table>

<?php echo $this->render('footer.php');?>

</body>
</html>
