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
        <td class="content"><span class="description">当前位置：</span><a href="<?php echo $this->projectUrl(array('action'=>'index')) ;?>">借款额度变化记录</a> &gt; 更改状态</td>
    </tr>
</table>
<form id="editForm" name="editForm" method="post" action="">
    
	<table width="100%" border="0" align="left" class="table">

		<tr>
			<td width="23%" align="left">用户名：</td>
			<td width="77%" align="left"><input name="userName" type="text" class="input" id="userName"/> <span id="userMessage"></span></td>
		</tr>
		<tr>
			<td align="left">当前信用借款额度：</td>
			<td align="left">￥<span id="creditAmountBlock">0</span></td>
		</tr>

		<tr>
			<td align="left">当前推荐借款额度：</td>
			<td align="left">￥<span id="recommendAmountBlock">0</span></td>
		</tr>

		<tr>
			<td align="left">新增额度：</td>
			<td align="left"><input name="amount" type="text" class="input" id="amount" value="0"/>
				元</td>
		</tr>
		<tr>
			<td align="left">借款类型：</td>
			<td align="left">
				<select name="type" id="type">
					<option value="credit">信用额度</option>
					<option value="recommend">推荐额度</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="left">备注：</td>
			<td align="left"><input name="notes" type="text" class="input" id="notes" value="" size="40" /></td>
		</tr>
		<tr>
			<td align="left">&nbsp;</td>
			<td align="left"><input type="submit" name="applyButton" id="applyButton" value="添加" class="button" />			</td>
		</tr>
	</table>
</form>

<script language="javascript">
$("#userName").blur(function(){
	if ($.trim($("#userName").val()) != '') {
		var url = "<?php echo $this->projectUrl(array('action'=>'check', 'type'=>'{type}', 'userName'=>'{userName}'), NULL, false);?>?rand=" + Math.random();
		url = url.replace('{type}', $('#type').val());
		url = url.replace('{userName}', $('#userName').val());
		$("#userMessage").html('检查中...');
		$.ajax({
			type: "GET",
			url: url,
			dataType: "json",
			async: true,
			success: function(statusResult){
				if (statusResult.status != 0) {
					$("#userMessage").html(statusResult.message);
				} else {
					$("#userMessage").html(statusResult.message);
					if (typeof(statusResult.creditAmount) != 'undefined' && typeof(statusResult.recommendAmount) != 'undefined') {
						$("#type")[0].options.length = 0;
						$("#type")[0].options[0] = new Option('信用额度', 'credit');
						$("#type")[0].options[1] = new Option('推荐额度', 'recommend');
						$("#creditAmountBlock").html(statusResult.creditAmount);
						$("#recommendAmountBlock").html(statusResult.recommendAmount);
					} else if (typeof(statusResult.creditAmount) != 'undefined' && typeof(statusResult.recommendAmount) == 'undefined') {
						$("#type")[0].options.length = 0;
						$("#type")[0].options[0] = new Option('信用额度', 'credit');
						$("#creditAmountBlock").html(statusResult.creditAmount);
					} else if (typeof(statusResult.creditAmount) == 'undefined' && typeof(statusResult.recommendAmount) != 'undefined') {
						$("#type")[0].options.length = 0;
						$("#type")[0].options[0] = new Option('推荐额度', 'recommend');
						$("#recommendAmountBlock").html(statusResult.recommendAmount);
					}
				}
			}
		});
	} else {
		
	}
});

var isCheck = null;
$("#editForm").submit(function(){
	var url = "<?php echo $this->projectUrl(array('action'=>'check', 'type'=>'{type}', 'userName'=>'{userName}'), NULL, false);?>?rand=" + Math.random();
	url = url.replace('{type}', $('#type').val());
	url = url.replace('{userName}', $('#userName').val());

	if ($.trim($("#userName").val()) == '') {
		alert('用户名不能为空。');
		$("#userName").focus();
		return false;
	} else if (parseFloat($.trim($("#amount").val())) == 0) {
		alert('请填写金额。');
		$("#amount").focus();
		return false;
	} else if (parseFloat($.trim($("#amount").val())) <= 0 || isNaN($.trim($("#amount").val()))) {
		alert('金额填写错误。');
		$("#amount").focus();
		return false;
	}

	if (isCheck == true) {
		isCheck = null;
		return true;
	}
	$("#applyButton").val('正在提交...');
	$("#applyButton").attr('disabled', true);
	$.ajax({
		type: "GET",
		url: url,
		dataType: "json",
		async: true,
		success: function(statusResult){
			$("#applyButton").val('添加');
			$("#applyButton").attr('disabled', false);
			if (statusResult.status != 0) {
				alert(statusResult.message);
			} else {
				isCheck = true;
				$("#editForm").submit();
			}
		}
	});
	return false;
});

</script>
</body>
</html>