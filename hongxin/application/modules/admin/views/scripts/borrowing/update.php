<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/admin/css/public.css" rel="stylesheet"/>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/admin/scripts/load.js"></script>
<title><?php echo $this->title;?></title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="navigation">
    <tr>
        <td class="content"><span class="description">当前位置：</span><a href="<?php echo $this->projectUrl(array('action'=>'index')) ;?>">借款列表</a> &gt; 修改借款信息</td>
    </tr>
</table>
<form id="editorForm" name="editorForm" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
        	<td width="12%">借款用户：</td>
        	<td width="88%"><?php echo $this->row['userName']?></td>
       	</tr>
        <tr>
        	<td>借款编号：</td>
        	<td><?php echo $this->row['code']?></td>
       	</tr>
        <tr>
			<td>借款标题：</td>
        	<td><?php echo $this->row['title'];?></td>
       	</tr>
        <tr>
        	<td>状态：</td>
        	<td>
				<label><input <?php echo $this->row['status'] > 1 ? ' disabled' : '';?> type="radio" name="status" id="status" value="1" <?php echo $this->row['status'] == '1' ? ' checked' : '';?>/> 已提交待审核</label>
				<label><input <?php echo $this->row['status'] > 2 ? ' disabled' : '';?> type="radio" name="status" id="status" value="2" <?php echo $this->row['status'] == '2' ? ' checked' : '';?>/> 已审核借款中</label>
				<label><input type="radio" name="status" id="status" value="3" <?php echo $this->row['status'] == '3' ? ' checked' : '';?> <?php echo $this->row['status'] != 3 ? ' disabled' : '';?>/>借款完成审核中</label>
				<label><input <?php echo $this->row['status'] != 3 ? ' disabled' : '';?>  type="radio" name="status" id="status" value="4" <?php echo $this->row['status'] == '4' ? ' checked' : '';?>/> 还款中</label>
				<label><input type="radio" name="status" id="status" value="5" <?php echo $this->row['status'] == '5' ? ' checked' : '';?> disabled="disabled"/> 还款完成</label>
				<label><input type="radio" name="status" id="status" value="6" <?php echo $this->row['status'] == '6' ? ' checked' : '';?> <?php echo $this->row['status'] == '5' || $this->row['status'] == '4' ? ' disabled="disabled"' : '';?>/> 已经审核未通过(作废)</label>
				
				&nbsp;&nbsp;意见：<input type="text" name="statusMessage" id="statusMessage" class="input" value="<?php echo $this->row['statusMessage'];?>" />
				<input name="submit" type="submit" id="submit" value="修改" class="button" />
				<input name="act" type="hidden" id="act" value="updateStatus" />
				
<?php
foreach($this->row['statusLogRows'] as $logRow) {
?>
				<div><?php echo $logRow['user'];?>于<?php echo $logRow['time'];?>将状态“<?php echo $logRow['previousStatus'];?>”修改为“<?php echo $logRow['currentStatus'];?>”</div>
<?php
}
?>		</td>
       	</tr>
        <tr>
			<td>借款金额：</td>
        	<td>￥<?php echo $this->row['amount'] * 1;?></td>
       	</tr>
        <tr>
        	<td>网站收费：</td>
        	<td>￥<?php echo $this->row['fee'] * 1;?></td>
       	</tr>
        <tr>
        	<td>还款方式：</td>
        	<td><?php if ($this->row['repaymentType'] == '1') {echo '等额本息';} else if ($this->row['repaymentType'] == '2') {echo '等本等息';} ?></td>
       	</tr>
        <tr>
			<td>月利率：</td>
        	<td><?php echo $this->row['monthInterestRate'] * 100;?>%</td>
       	</tr>
        <tr>
			<td>借款期限：</td>
        	<td><?php echo $this->row['deadline'];?>个月</td>
       	</tr>
        <tr>
        	<td>投标限额：</td>
        	<td>￥<?php echo $this->row['amountMaxUnit'] * 1;?></td>
       	</tr>
        <tr>
			<td>最大标金额：</td>
        	<td>￥<?php echo $this->row['amountMaxUnit'] * 1;?></td>
       	</tr>
        <tr>
        	<td>申请时间：</td>
        	<td><?php echo $this->row['addTime'] > 0 ? date('Y-m-d H:i:s', $this->row['addTime']) : '--';?></td>
       	</tr>
        <tr>
			<td>开始时间：</td>
        	<td><?php echo $this->row['startTime'] > 0 ? date('Y-m-d H:i:s', $this->row['startTime']) : '未开始';?></td>
       	</tr>
        <tr>
            <td>借款说明：</td>
            <td><?php echo $this->row['notes'] != '' ? str_replace("\n", "<br/>", $this->row['notes']) : '--';?></td>
        </tr>
    </table>
</form>


<h3>投标记录</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
	<tr class="title">
		<td align="center">序号</td>
		<td>投标人</td>
		<td>投标金额</td>
		<td>投标时间</td>
	</tr>
<?php
foreach($this->borrowingDetailRows as $key=>$borrowingDetailRow) {
?>

	<tr>
		<td align="center"><?php echo ($key + 1);?></td>
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
		<td align="center">期数</td>
		<td>待还本息￥</td>
		<td>还款期限</td>
		<td>还款状态</td>
		<td>实际还款时间</td>
	</tr>
<?php
foreach($this->repaymentRows as $key=>$repaymentRow) {
?>

	<tr>
		<td align="center"><?php echo $repaymentRow['numberOfCycles'];?></td>
		<td><?php echo $repaymentRow['principal'] * 1;?> + <?php echo $repaymentRow['interest'] * 1;?> = <?php echo $repaymentRow['principal'] + $repaymentRow['interest'];?></td>
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
		<td colspan="5" align="center">暂无记录</td>
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
							<label><input name="repaymentHowType" type="radio" id="repaymentHowType2" value="2" <?php if ($this->surplusAvailableAmount < $this->currentRepaymentAmount && $this->surplusAvailableAmount > 0) {echo ' disabled';}?>/> 一次还清￥<?php echo $this->allNoRepaymentAmount;?></label>
							
							<?php if ($this->surplusAvailableAmount < $this->currentRepaymentAmount) {?>
							<input type="submit" id="submit" name="submit" value="网站垫付" class="button" />
							<?php } else {?>
							<input type="submit" id="submit" name="submit" value="还款" class="button" />
							<?php }?>
							<input name="act" type="hidden" id="act" value="repayment" />
						</td>
					</tr>
				</table>
			</form>
<?php
}
?>
</body>
</html>