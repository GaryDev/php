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
        <td class="content"><span class="description">当前位置：</span><a href="<?php echo $this->projectUrl(array('action'=>'index')) ;?>">系统目录</a> &gt; 添加目录</td>
    </tr>
</table>
<form id="editorForm" name="editorForm" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
            <td>名称：</td>
            <td><input name="name" type="text" class="input" id="name" size="50" maxlength="50" />
                必填</td>
        </tr>
        <tr>
            <td>显示属性：</td>
            <td><input name="isDisplay" type="checkbox" id="isDisplay" value="1" checked="checked" onclick="if (this.checked == true) {$('#noSystemUserIsDisplay').attr('checked', true);}"/>
                菜单显示
                    <input name="noSystemUserIsDisplay" type="checkbox" id="noSystemUserIsDisplay" value="1" checked="checked" onclick="if (this.checked == false) {$('#isDisplay').attr('checked', false);}"/>
                授权显示</td>
        </tr>
        <tr>
            <td>是否需要填写访问地址权限验证：</td>
            <td>
                <input name="haveAccessControl" type="radio" value="1" onclick="accessControl(parseInt(this.value));" />是
                <input name="haveAccessControl" type="radio" value="0" onclick="accessControl(parseInt(this.value));" checked />否            </td>
        </tr>
        <tr>
            <td bgcolor="#EFEFEF">模块：</td>
            <td bgcolor="#EFEFEF"><input name="module" type="text" class="input" id="module" size="50" maxlength="50" /></td>
        </tr>
        <tr>
            <td bgcolor="#EFEFEF">控制器：</td>
            <td bgcolor="#EFEFEF"><input name="controller" type="text" class="input" id="controller" size="50" maxlength="50" /></td>
        </tr>
        <tr>
            <td bgcolor="#EFEFEF">动作：</td>
            <td bgcolor="#EFEFEF"><input name="action" type="text" class="input" id="action" size="50" maxlength="50" /></td>
        </tr>
        <tr>
            <td bgcolor="#EFEFEF">请求的参数：</td>
            <td bgcolor="#EFEFEF"><input name="requestParams" type="text" class="input" id="requestParams" size="50" maxlength="50" /> 
                格式：参数1=值1&amp;参数2=值2。此参数不进行权限检查。</td>
        </tr>
        <tr>
            <td>跳转目标：</td>
            <td><input name="target" type="text" class="input" id="target" value="frameRight" size="50" maxlength="50" /></td>
        </tr>
        <tr>
            <td>父目录：</td>
            <td><?php echo count($this->parentRow) > 0 ? $this->parentRow['name'] : '<b>无</b>(此目录为顶级目录)';?></td>
        </tr>
        <tr>
            <td>排序号：</td>
            <td><input name="orderNumber" type="text" class="input" id="orderNumber" value="0" size="50" maxlength="50" onblur="numberCheck(this, 0, 0);" /></td>
        </tr>
        <tr>
            <td>描述：</td>
            <td><textarea name="description" id="description" cols="50" rows="5" class="input inputCommonSize" ></textarea></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input name="submit" type="submit" id="submit" value="提交" class="button" /></td>
        </tr>
    </table>
</form>
<script language="javascript">
function accessControl(is)
{
    if (is == 1) {
        $("#module").parent().parent().css("display", '');
        $("#controller").parent().parent().css("display", '');
        $("#action").parent().parent().css("display", '');
        $("#requestParams").parent().parent().css("display", '');
    } else {
        $("#module").val('');
        $("#controller").val('');
        $("#action").val('');
        $("#requestParams").val('');
        
        $("#module").parent().parent().css("display", 'none');
        $("#controller").parent().parent().css("display", 'none');
        $("#action").parent().parent().css("display", 'none');
        $("#requestParams").parent().parent().css("display", 'none');
    }
}
accessControl(0);
</script>
</body>
</html>