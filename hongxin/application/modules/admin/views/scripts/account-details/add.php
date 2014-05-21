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
        <td class="content"><span class="description">当前位置：</span> 会员充值</td>
    </tr>
</table>
<form id="editorForm" name="editorForm" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
            <td width="12%">用户名：</td>
            <td width="88%"><input name="userName" type="text" class="input" id="userName" size="40" /> <span id="memberUserInfo"></span></td>
        </tr>
        <tr>
        	<td>积分：</td>
        	<td><input name="amount" type="text" class="input" id="amount" value="100" size="40" onblur="numberCheck(this, 100, 1);"/>
       		    如果要扣除用户积分请填写负数
        		。</td>
       	</tr>
        <tr>
        	<td>说明：</td>
        	<td><input name="notes" type="text" class="input" id="notes" size="40" /></td>
       	</tr>
        <tr>
            <td>&nbsp;</td>
            <td><input name="submit" type="submit" id="submit" value="提交" class="button" /></td>
        </tr>
    </table>
</form>
<script language="javascript">
$('#userName').blur(function(){
	$('#memberUserInfo').html('检查中...');
    var url = '<?php echo $this->projectUrl(array('action'=>'get-user-amount-info'));?>?rand' + Math.random();
    $.ajax({
        type: "POST",
        url: url,
		data: "userName=" + $('#userName').val(),
        dataType: "json",
        async: true,
         success: function(data){
            $('#memberUserInfo').html(data.info);
         } 
    });

});
</script>
</body>
</html>