<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->title;?></title>
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/admin/css/public.css" rel="stylesheet"/>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/admin/scripts/load.js"></script>
<script language="javascript">
function isDisplay(id, is)
{
    if (is == 0) {
        $("#name"+id).attr("title", "菜单不显示");
        $("#name"+id).css("color", "#cccccc");
    }
}
</script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="navigation">
    <tr>
        <td class="content"><span class="description">当前位置：</span><a href="<?php echo $this->projectUrl(array('action'=>'grant-user-list')) ;?>">用户组授权 - 用户组列表</a> &gt; <span style="font-weight:bold;"><?php echo $this->userGroupRow['name'];?></span>权限<span></td>
    </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <form id="listForm" name="listForm" method="post" action="">
        <tr class="title">
            <td align="center">名称</td>
        </tr>

<?php echo $this->catalogList;?>

        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <input name="selectAllSetButton" type="button" id="selectAllSetButton" value="全选" class="button" onclick="selectAllSet('catalogId[]');" />
                            <input name="selectAllClearButton" type="button" id="selectAllClearButton" value="取消" class="button" onclick="selectAllClear('catalogId[]');" />                        </td>
                        <td align="right"><input name="updateOrder" type="submit" id="updateOrder" value="保存选中的权限" class="button" onclick="$('#listForm').attr('action', '');" /></td>
                    </tr>
                </table>            </td>
        </tr>
    </form>
</table>
<script language="javascript">
var catalogCheckboxs = document.getElementsByName("catalogId[]");
for(var i=0; i<=catalogCheckboxs.length-1; i++) {
    catalogCheckboxs[i].onclick=function(){
        if (this.checked == true) {
            ids = this.id.split('_');
            id = ids[0];
            for(var n = 1; n <= ids.length-1; n++) {
                id += "_" + ids[n];
                if (document.getElementById(id)) {
                    document.getElementById(id).checked = true;
                }
            }
            
            for(var n=0; n<=catalogCheckboxs.length-1; n++) {
                if (catalogCheckboxs[n].id.search(this.id+"_") != -1) {
                    catalogCheckboxs[n].checked = true;
                }
            }
        } else {
            for(var n=0; n<=catalogCheckboxs.length-1; n++) {
                if (catalogCheckboxs[n].id.search(this.id+"_") != -1) {
                    catalogCheckboxs[n].checked = false;
                }
            }
        }
    }
}
</script>
</body>
</html>