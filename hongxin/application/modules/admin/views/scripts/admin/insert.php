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
        <td class="content"><span class="description">当前位置：</span><a href="<?php echo $this->projectUrl(array('action'=>'index')) ;?>">用户列表</a> &gt; 添加用户</td>
    </tr>
</table>
<form id="editorForm" name="editorForm" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
            <td width="12%">用户名：</td>
            <td width="88%"><input name="userName" type="text" class="input" id="userName" size="50" maxlength="20" /> 
            英文字母、数字以及下划线，长度5-20个字符。</td>
        </tr>
        <tr>
        	<td>工号：</td>
        	<td><input name="code" type="text" class="input" id="code" size="50" maxlength="20" value="<?php echo $this->defaultCode;?>" />
英文字母、数字以及下划线，长度5-20个字符。不能和用户名相同</td>
       	</tr>
        <tr>
        	<td>状态：</td>
        	<td>
				<label><input name="status" type="radio" id="radio" value="1" checked="checked" /> 正常</label>
				<label><input type="radio" name="status" id="radio2" value="2" /> 关闭</label>
			</td>
       	</tr>
        <tr>
            <td>密码：</td>
            <td><input name="password" type="text" class="input" id="password" size="50" maxlength="20" /> 
            长度5-20个字符。</td>
        </tr>
        <tr>
            <td>姓名：</td>
            <td><input name="name" type="text" class="input" id="name" size="50" maxlength="50" />
                填写真实姓名。</td>
        </tr>
        <tr>
            <td>QQ：</td>
            <td><input name="qq" type="text" class="input" id="qq" size="50" maxlength="50" /></td>
        </tr>
        <tr>
            <td>E-mail：</td>
            <td><input name="email" type="text" class="input" id="email" size="50" maxlength="50" /></td>
        </tr>
        <tr>
            <td>所在组：</td>
            <td>
                <select name="groupId" id="groupId">
                    <option value="0">--选择--</option>
<?php
foreach($this->userGroupRows as $userGroupRow) {
?>
                    <option value="<?php echo $userGroupRow['id'];?>"><?php echo $userGroupRow['name'];?></option>
<?php
}
?>
                </select>            </td>
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
</body>
</html>