
<div id="divForm" style="margin: 50px;">
	<form id="identifyForm" name="identifyForm" method="post" action="<?php echo $this->ysburl; ?>" target="_blank">
	<table width="100%" border="0" cellpadding="10" cellspacing="0" class="table">
		<tr>
			<td width="25%">真实姓名：</td>
			<td><input name="name" type="text" class="input" id="name" size="40" value="" /></td>
		</tr>
		<tr>
			<td width="25%">身份证号码：</td>
			<td><input name="idNum" type="text" class="input" id="idNum" size="40" value="" /></td>
		</tr>
		<tr>
			<td width="15%">&nbsp;</td>
			<td><input name="identify" type="submit" value="去验证身份并开通支付账号" class="button" /></td>
		</tr>
	</table>
	<?php foreach ($this->params as $n=>$p): ?>
		<?php //if(!in_array($n, array('name', 'idNum'))): ?>
			<input type="hidden" name="<?php echo $n; ?>" value="<?php echo $p; ?>" />
		<?php //endif; ?>
	<?php endforeach; ?>
	</form>
</div>
<div id="divComplete" style="border: 1px solid red; margin: 150px; display:none;">
	<form id="completeForm" name="completeForm" method="post" action="">
	<table width="100%" border="0" cellpadding="10" cellspacing="0" class="table">
		<tr>
			<td>身份验证进行中，请稍后......</td>
		</tr>
		<tr>
			<td><input name="complete" type="submit" value="已完成验证身份" class="button" /></td>
		</tr>
	</table>
	</form>
</div>

<script type="text/javascript">
	$("#identifyForm").submit(function(){
		$("#identifyForm").hide();
		$("#divComplete").show();
		return true;
	});
</script>