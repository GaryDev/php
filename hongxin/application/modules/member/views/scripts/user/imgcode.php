
<div style="width:300px; padding-left: 25px; padding-top: 20px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" align="right">验证码：</td>
		<td height="30">
		<input name="code" type="text" id="code" style="border:#2B4A99 solid 1px;" size="8" /> 
		<img src="<?php echo $this->projectUrl(array('module' => 'admin', 'controller' => 'image-code', 'action' => 'index', 'rand' => rand(100, 999)));?>" 
			name="codeImage" border="0" align="absmiddle" id="codeImage" onclick="refreshCode();" style="text-decoration:underline; cursor:pointer;"/></td>
	</tr>
	<tr>
		<td height="30" align="right">&nbsp;</td>
		<td height="30" align="left"><input name="btn" type="button" id="btn" value="确定" class="button" onclick="verifyCode();" /></td>
	</tr>
</table>
</div>
