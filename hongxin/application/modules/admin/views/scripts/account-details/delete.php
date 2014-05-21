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
        <td class="content"><span class="description">当前位置：</span><a href="<?php echo $this->projectUrl(array('action'=>'index')) ;?>">明细列表</a> &gt; 删除结算记录</td>
    </tr>
</table>
<form id="editorForm" name="editorForm" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
        	<td width="20%">范围：</td>
        	<td>
				<select name="scope" id="scope">
        		<option value="user">指定用户的明细记录</option>
        		<option value="all">全部用户的明细记录</option>
        		</select>        	</td>
       	</tr>
        <tr id="userLine">
            <td width="20%">用户名：</td>
            <td><input name="userName" type="text" class="input" id="userName" size="40" /></td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        	<td>提示：删除后将不能恢复，请谨慎使用此操作。</td>
       	</tr>
        <tr>
            <td width="20%">&nbsp;</td>
            <td><input name="submit" type="submit" id="submit" value="提交" class="button" /></td>
        </tr>
    </table>
</form>
<script language="javascript">
$('#scope').change(function(){
	if (this.value == 'all') {
		$('#userLine').css('display', 'none');
	}
	if (this.value == 'user') {
		$('#userLine').css('display', '');
	}
});
$('#editorForm').submit(function(){
	return confirm('确定删除吗？');
});
</script>
</body>
</html>