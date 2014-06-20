
<div style="width:350px; padding-left: 5px; padding-top: 20px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" align="right">输入图片上的文字：</td>
		<td height="30">
		<input name="code" type="text" id="code" style="border:#2B4A99 solid 1px;" size="8" /> 
		<img src="<?php echo $this->projectUrl(array('module' => 'admin', 'controller' => 'image-code', 'action' => 'index', 'rand' => rand(100, 999)));?>" 
			name="codeImage" border="0" align="absmiddle" id="codeImage" onclick="refreshCode(this);" style="text-decoration:underline; cursor:pointer;"/>
		<a href="javascript:void(0);" onclick="refreshCode('#codeImage');" style="text-decoration:underline; cursor:pointer;">看不清？</a>
		</td>
	</tr>
	<tr>
		<td height="30" align="center" colspan="2"><input name="btn" type="button" id="btn" value="确定" class="button" onclick="verifyCode();" /></td>
	</tr>
</table>
</div>
