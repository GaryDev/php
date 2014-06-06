
<form id="identifyForm" name="identifyForm" method="post" action="<?php echo $this->ysburl; ?>" target="_blank">
<div style="width:350px; padding-left: 50px; padding-top: 20px;">
<table border="0" style="margin-top:10px; width:350px;" class="table">
	<tr>
		<td>真实姓名：</td>
		<td><input name="name" type="text" class="input" id="name" size="30" value="<?php echo htmlspecialchars($this->row['name']);?>" /></td>
	</tr>
	<tr>
		<td>身份证号码：</td>
		<td><input name="idNum" type="text" class="input" id="idNum" size="30" value="<?php echo htmlspecialchars($this->row['idCardNumber']);?>" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input id="identify" type="button" value="去验证身份并开通支付账号" class="button" /></td>
	</tr>
</table>
</div>
<?php foreach ($this->params as $n=>$p): ?>
	<?php if(!in_array($n, array('name', 'idNum'))): ?>
		<input type="hidden" name="<?php echo $n; ?>" value="<?php echo $p; ?>" />
	<?php endif; ?>
<?php endforeach; ?>
</form>

<div id="divComplete" style="width:350px; padding-left: 50px; padding-top: 50px; display:none;">
	<table width="100%" border="0" cellpadding="10" cellspacing="0" class="table">
		<tr height="50">
			<td style="font-size: 20px" align="center">身份验证进行中，请稍后......</td>
		</tr>
		<tr height="50">
			<td align="center"><input id="notifyBtn" type="button" value="已完成验证身份" class="button" /></td>
		</tr>
	</table>
</div>

<script type="text/javascript">
	$("#identify").click(function(){
		if($("#name").val() == '') {
			alert("请输入真实姓名。");
			return false;
		}
		if($("#idNum").val() == '') {
			alert("请输入身份证号码。");
			return false;
		}
		var param = "{"
		$("input:text, input[type=hidden]").each(function(){
			param += '"' + this.name + '":' +  '"' + $.trim(this.value) + '",';
		});
		var json = param.substring(0, param.length - 1) + "}";
		$.post('<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'get-mac'));?>' + '?rand=' + Math.random(), 
				$.parseJSON(json),
				function(data){	
					$("input[name=mac]").val(data.replace(/"/g, ''));
					$("#identifyForm").hide();
					$("#divComplete").show();
					$(".xubox_close").hide();
					$("#identifyForm").submit();
				}
		);
		return false;
	});

	$("#notifyBtn").click(function(){
		var frm = $("#identifyForm")[0];
		frm.action = '<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'identify-notify'));?>';
		frm.target = "_self";
		frm.submit();
		//location.reload(true);
	});
</script>