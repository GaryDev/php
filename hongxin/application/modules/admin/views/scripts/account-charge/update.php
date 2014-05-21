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
        <td class="content"><span class="description">当前位置：</span><a href="<?php echo $this->projectUrl(array('action'=>'index')) ;?>">充值记录</a> &gt; 更改状态</td>
    </tr>
</table>
<form id="editForm" name="editForm" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
            <td>用户名：</td>
            <td><?php echo $this->row['userName']?></td>
        </tr>
        <tr>
        	<td>充值金额：</td>
        	<td>￥<?php echo $this->row['amount']?></td>
       	</tr>
        <tr>
        	<td>类型：</td>
        	<td><?php if ($this->row['type'] == 1) {echo '线上支付';} else if ($this->row['type'] == 2) {echo '线下转账';} else if ($this->row['type'] == 3) {echo '其他';};?></td>
       	</tr>
        <tr>
        	<td>汇款渠道：</td>
        	<td><?php echo trim($this->row['from']) != '' ? $this->row['from'] : '--';?></td>
       	</tr>
        <tr>
        	<td>流水号：</td>
        	<td><?php echo trim($this->row['serialNumber']) != '' ? $this->row['serialNumber'] : '--';?></td>
       	</tr>
        <tr>
        	<td>支付时间：</td>
        	<td><?php echo $this->row['paymentTime'];?></td>
       	</tr>
        <tr>
			<td>状态：</td>
        	<td>
				<label><input type="radio" name="status" id="status" value="1" <?php echo $this->row['status'] == 1 ? ' checked' : '';?> <?php echo $this->row['status'] > 1 ? ' disabled' : '';?>/>已提交待审核</label>
				<label><input type="radio" name="status" id="status" value="2" <?php echo $this->row['status'] == 2 ? ' checked' : '';?> <?php echo $this->row['status'] > 2 ? ' disabled' : '';?>/>已审核通过</label>
				<label><input type="radio" name="status" id="status" value="3" <?php echo $this->row['status'] == 3 ? ' checked' : '';?> />已经审核未通过(作废)</label>
				
<?php
foreach($this->row['statusLogRows'] as $logRow) {
?>
				<div><?php echo $logRow['user'];?>于<?php echo $logRow['time'];?>将状态“<?php echo $logRow['previousStatus'];?>”修改为“<?php echo $logRow['currentStatus'];?>”</div>
<?php
}
?>			</td>
        </tr>

        <tr>
        	<td>提交时间：</td>
        	<td><?php echo date('Y-m-d H:i', $this->row['addTime']);?></td>
       	</tr>
        <tr>
        	<td>备注：</td>
        	<td><?php echo trim($this->row['notes']) != '' ? $this->row['notes'] : '--';?></td>
       	</tr>
        <tr>
        	<td width="15%">&nbsp;</td>
        	<td><input name="submit" type="submit" id="submit" value="修改" class="button" /></td>
       	</tr>
    </table>
</form>
</body>
</html>