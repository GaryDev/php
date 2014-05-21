<form name="loanForm" id="loanForm" method="post" action="<?php echo $this->url();?>">
	<div style="width:350px; line-height:30px; background:#3399FF; color:#FFFFFF; font-weight:bold; padding-left:10px; font-size:14px;">投标</div>
	<div style="width:350px;">
	<table border="0" style="margin-top:10px; width:350px;" class="table">
<?php
if ($this->errorMessage === NULL) {
?>

		<tr>
			<td>此标还需金额：</td>
			<td>￥<span id="borrowingUsedAmount"><?php echo $this->row['amount'] - $this->row['borrowedAmount'];?></span></td>
		</tr>
		<tr>
			<td>投资限额：</td>
			<td>
				<?php echo $this->row['amountMinUnit'] != 0 ? '<span style="display:none;" id="amountMinUnit">' . $this->row['amountMinUnit'] . '</span>最少￥' . $this->row['amountMinUnit'] * 1  : '最少无限制<span style="display:none;" id="amountMinUnit">0</span>';?>，
				<?php echo $this->row['amountMaxUnit'] != 0 ? '<span style="display:none;" id="amountMaxUnit">' . $this->row['amountMaxUnit'] . '</span>最大￥' . $this->row['amountMaxUnit'] * 1 : '最大无限制<span style="display:none;" id="amountMaxUnit">0</span>';?>
			</td>
		</tr>
		<tr>
			<td>投资金额：</td>
			<td><input type="text" name="borrowingAmount" id="borrowingAmount" class="input"></td>
		</tr>
		<tr>
			<td>账户可用金额：</td>
			<td>￥<span id="surplusAvailableAmount"><?php echo $this->surplusAvailableAmount * 1;?></span> <a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'account-charge', 'action'=>'add'));?>" style="text-decoration:underline;">点击充值</a></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="button" id="button" value="提交" class="button"></td>
		</tr>
<?php
} else {
?>
		<tr>
			<td colspan="2"><?php echo $this->errorMessage;?></td>
		</tr>
<?php
} 
?>
	</table>
	</div>
</form>
<script language="javascript">
$("#loanForm").submit(function(){
	if (parseFloat($.trim($("#borrowingAmount").val())) < 0 || isNaN($.trim($("#borrowingAmount").val())) || $.trim($("#borrowingAmount").val()) == '') {
		alert('投资金额填写错误。');
		$("#borrowingAmount").focus();
		$("#borrowingAmount").val($("#amountMinUnit").html() * 1);
		return false;
	} 
	var amount = parseFloat($.trim($("#borrowingAmount").val())) * 1;
	$("#borrowingAmount").val(amount);
	
	if (amount > parseFloat($("#borrowingUsedAmount").html())) {
		alert('投资金额不能大于此标可投金额。');
		$("#borrowingAmount").focus();
		$("#borrowingAmount").val($("#borrowingUsedAmount").html() * 1);
		return false;
	}
	
	if (amount < parseFloat($("#amountMinUnit").html()) && $("#amountMinUnit").html() != 0) {
		alert('投资金额必须大于投资限额￥' + ($("#amountMinUnit").html() * 1) + '。');
		$("#borrowingAmount").focus();
		$("#borrowingAmount").val($("#amountMinUnit").html() * 1);
		return false;
	}
	
	if (amount > parseFloat($("#amountMaxUnit").html()) && $("#amountMaxUnit").html() != 0) {
		alert('投资金额不能大于投资限额￥' + ($("#amountMaxUnit").html()  * 1) + '。');
		$("#borrowingAmount").focus();
		$("#borrowingAmount").val($("#amountMaxUnit").html() * 1);
		return false;
	}

	if (amount > parseFloat($("#surplusAvailableAmount").html())) {
		alert('投资金额不能大于你的帐号可用金额￥' + ($("#surplusAvailableAmount").html() * 1) + '。');
		$("#borrowingAmount").focus();
		$("#borrowingAmount").val($("#surplusAvailableAmount").html() * 1);
		return false;
	}

});
</script>
