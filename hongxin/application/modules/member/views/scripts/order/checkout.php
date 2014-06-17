
<form id="paymentForm" name="paymentForm" method="post" action="<?php echo $this->ysburl; ?>" target="_blank">
	<table width="400" border="0" align="center" cellpadding="5" cellspacing="0" style="border:0px #dedede solid;margin-top: 10px;margin-left: 30px;">
		<tr>
			<td width="40%" valign="top">
				<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0">
					<tr>
						<th>订单信息</th>
					</tr>
					<tr>
						<td>订单号：<?php echo $this->row['orderSN']; ?></td>
					</tr>
					<tr>
						<td>产品名称：<?php echo $this->row['title']; ?></td>
					</tr>
					<tr>
						<td>交易金额：<?php echo $this->row['orderAmount']; ?> 元</td>
					</tr>
					<tr>
						<td>预期收益：<?php echo $this->row['benifit']; ?> 元</td>
					</tr>
					<tr>
						<td>购买时间：<?php echo date('Y-m-d H:i:s', $this->row['addTime']); ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table width="400" border="0" align="center" cellpadding="5" cellspacing="0" style="border:0px #dedede solid;margin-top: 10px;margin-left: 30px;">
		<tr>
			<td align="center"><input type="submit" class="btn" id="goPay" name="goPay" value="资金冻结" /></td>
		</tr>
	</table>
<?php foreach ($this->params as $n=>$p): ?>
	<?php //if(!in_array($n, array('name', 'idNum'))): ?>
		<input type="hidden" name="<?php echo $n; ?>" value="<?php echo $p; ?>" />
	<?php //endif; ?>
<?php endforeach; ?>
</form>

<div id="divComplete" style="width:350px; padding-left: 50px; padding-top: 50px; display:none;">
	<table width="100%" border="0" cellpadding="10" cellspacing="0" class="table">
		<tr height="50">
			<td style="font-size: 20px" align="center">操作完成前请勿关闭此窗口</td>
		</tr>
		<tr height="50">
			<td align="center"><input id="notifyBtn" type="button" value="已完成操作" class="button" /></td>
		</tr>
	</table>
</div>

<script type="text/javascript">
	$("#paymentForm").submit(function(){
		$("#paymentForm").hide();
		$("#divComplete").show();
		$(".xubox_close").hide();
		//$("#paymentForm").submit();
		return true;
	});

	$("#notifyBtn").click(function(){
		var frm = $("#paymentForm")[0];
		frm.action = '<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'order', 'action'=>'payment'));?>';
		frm.target = "_self";
		frm.submit();
	});
</script>

