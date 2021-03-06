<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/admin/css/public.css" rel="stylesheet"/>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/admin/scripts/load.js"></script>
<title><?php echo $this->title;?></title>
<script>
	function changePic()
	{
		if($("#ticketCopy").val() == "") {
			alert('请选择银行承兑汇票扫描件。');
			return false;
		} else if(!validateFileExt($("#ticketCopy").val())) {
			alert('银行承兑汇票扫描件格式不正确。');
			return false;
		}
		$('#act').val('changePic');
		return true;
	}
</script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="navigation">
    <tr>
        <td class="content"><span class="description">当前位置：</span><a href="<?php echo $this->projectUrl(array('action'=>'index')) ;?>">融资列表</a> &gt; 修改融资信息</td>
    </tr>
</table>
<form id="editorForm" name="editorForm" enctype="multipart/form-data" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
        	<td width="12%">融资用户：</td>
        	<td width="88%"><?php echo $this->row['userName']?></td>
       	</tr>
        <tr>
        	<td>融资企业：</td>
        	<td><?php echo $this->row['enterpriseName']?></td>
       	</tr>
        <tr>
        	<td>融资编号：</td>
        	<td><?php echo $this->row['code']?></td>
       	</tr>
        <tr>
			<td>融资标题：</td>
        	<td><?php echo $this->row['title'];?></td>
       	</tr>
        <tr>
        	<td>银行承兑汇票：</td>
        	<td><input type="file" name="ticketCopy" id="ticketCopy" />
       		<?php echo !empty($this->row['pictureUrl']) ? "<a href=\"{$this->row['pictureUrl']}\" target=\"_blank\" style=\"margin-top:5px; margin-bottom:5px; margin-left:30px;\"><img src=\"{$this->row['pictureUrl']}\" height=\"20\" align=\"absmiddle\" border=\"0\"/></a> <label><input name=\"changePicture\" type=\"submit\" value=\"修改\" class=\"button\" onclick=\"return changePic();\" /></label>" : '';?></td>
       	</tr>
        <tr>
        	<td>申请状态：</td>
        	<td>
				<label><input <?php echo $this->row['status'] > 1 ? ' disabled' : '';?> type="radio" name="status" id="status" value="1" <?php echo $this->row['status'] == '1' ? ' checked' : '';?>/> 已提交待审核</label>
				<label><input <?php echo $this->row['status'] > 2 ? ' disabled' : '';?> type="radio" name="status" id="status" value="2" <?php echo $this->row['status'] == '2' ? ' checked' : '';?>/> 初审已通过</label>
				<label><input type="radio" name="status" id="status" value="3" <?php echo $this->row['status'] == '3' ? ' checked' : '';?> <?php echo $this->row['status'] != '2' ? ' disabled' : '';?>/> 终审已通过</label>
				<label><input type="radio" name="status" id="status" value="4" <?php echo $this->row['status'] == '4' ? ' checked' : '';?> <?php echo $this->row['status'] == '3' ? ' disabled="disabled"' : '';?>/> 初审未通过</label>
				<label><input type="radio" name="status" id="status" value="5" <?php echo $this->row['status'] == '5' ? ' checked' : '';?> <?php echo $this->row['status'] != '2' ? ' disabled="disabled"' : '';?>/> 终审未通过</label>
				
				&nbsp;&nbsp;意见：<input type="text" name="statusMessage" id="statusMessage" class="input" value="<?php echo $this->row['statusMessage'];?>" <?php echo $this->row['status'] == '3' ? ' disabled="disabled"' : '';?> />
				<input name="submit" type="submit" id="submit" value="确认" class="button" <?php echo $this->row['status'] == '3' ? ' disabled="disabled"' : '';?> />
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
        	<td>当前状态：</td>
        	<td>
        	<?php echo $this->row['borrowStatus'];?>&nbsp;&nbsp;
        	<?php if($this->row['currentStatus'] == 3) { ?>
        		<input name="complete" type="submit" id="complete" value="立即满标" class="button" onclick="$('#act').val('complete');" />
        	<?php } else if($this->row['currentStatus'] == 4) {?>
        		<input name="repayment" type="submit" id="repayment" value="已还款" class="button" onclick="$('#act').val('repayment');" />
        	<?php } ?>
        	</td>
       	</tr>
        <tr>
			<td>融资金额：</td>
        	<td><?php echo $this->row['amount'];?>元</td>
       	</tr>
        <tr>
			<td>年利率：</td>
        	<td><?php echo $this->row['yearInterestRate'];?>%</td>
       	</tr>
        <tr>
			<td>融资期限：</td>
        	<td><?php echo $this->row['deadline'];?>天</td>
       	</tr>
        <tr>
			<td>投资单位：</td>
			<td><?php echo $this->borrowingUnitMin;?>元/份</td>
		</tr>
		<tr>
			<td>最小投资份数：</td>
			<td><?php echo $this->row['amountMinUnit'];?>份</td>
		</tr>
		<tr>
			<td>最大投资份数：</td>
			<td><?php echo $this->row['amountMaxUnit'];?>份</td>
		</tr>
		<tr>
			<td>投资开始时间：</td>
			<td><?php echo date('Y-m-d', $this->row['startTime']);?></td>
		</tr>
		<tr>
			<td>投资截止时间：</td>
			<td><?php echo date('Y-m-d', $this->row['endTime']);?></td>
		</tr>
		<tr>
			<td>票据到期时间：</td>
			<td><?php echo date('Y-m-d', $this->row['ticketEndTime']);?></td>
		</tr>
		<tr>
			<td>最迟还款日期：</td>
			<td><?php echo date('Y-m-d', $this->row['repayEndTime']);?></td>
		</tr>
        <tr>
            <td>融资用途：</td>
            <td><?php echo $this->row['notes'] != '' ? str_replace("\n", "<br/>", $this->row['notes']) : '--';?></td>
        </tr>
    </table>
</form>
<?php if ($this->row['status'] == '3') {?>
<form id="popstarForm" name="popstarForm" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
	<tr>
		<td width="12%">明星产品：</td>
		<?php if($this->popRow['id'] == 0 || $this->popRow['id'] == $this->row['id']) { ?>
		<td>
		<input type="checkbox" name="popstar" value="1" <?php echo $this->popRow['id'] == $this->row['id'] ? ' checked="checked"' : '';?> />
		<input name="submit" type="submit" id="submit" value="修改" class="button" />
		<input name="act" type="hidden" id="act" value="popstar" />
		</td>
		<?php } else { ?>
		<td><a href="<?php echo $this->projectUrl(array('action'=>'approve', 'id'=>$this->popRow['id']));?>"><?php echo $this->popRow['title']; ?></a></td>
		<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
</body>
</html>