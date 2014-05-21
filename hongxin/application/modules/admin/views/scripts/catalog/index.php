<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/admin/css/public.css" rel="stylesheet"/>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/admin/scripts/load.js"></script>
<script language="javascript">
function isDisplay(id, is)
{
    if (is == 0) {
        $("#name"+id).attr("title", "菜单不显示");
        $("#name"+id).css("color", "#999999");
        $("#isDisplay"+id).html("×");
    } else {
        $("#isDisplay"+id).html("√");
    }
}
</script>
<script language="javascript">
function noSystemUserIsDisplay(id, is)
{
    if (is == 0) {
        $("#name"+id).attr("title", "授权不显示, 菜单不显示");
        $("#name"+id).css("color", "#dddddd");
        $("#noSystemUserIsDisplay"+id).html("×");
    } else {
        $("#noSystemUserIsDisplay"+id).html("√");
    }
}
</script>
<title><?php echo $this->title;?></title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="navigation">
    <tr>
        <td class="content"><span class="description">当前位置：</span>系统目录</td>
        <td align="right"><input name="insert" type="button" id="insert" value="添加顶级目录" class="button" onclick="location.href='<?php echo $this->projectUrl(array('action'=>'insert')) ;?>';" /></td>
    </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <form id="listForm" name="listForm" method="post" action="">
        <tr class="title">
            <td width="8%" align="center">选择</td>
            <td align="center">名称</td>
            <td align="center">排序(小到大)</td>
            <td align="center">菜单显示</td>
            <td align="center">授权显示</td>
            <td width="20%" align="center">操作</td>
        </tr>

<?php echo $this->listContent;?>

        <tr>
            <td colspan="6">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <input name="selectAllSetButton" type="button" id="selectAllSetButton" value="全选" class="button" onclick="selectAllSet('selectId[]');" />
                            <input name="selectAllClearButton" type="button" id="selectAllClearButton" value="取消" class="button" onclick="selectAllClear('selectId[]');" />                        </td>
                        <td align="right"><input name="updateOrder" type="submit" id="updateOrder" value="修改排序" class="button" onclick="$('#listForm').attr('action', '');" />
                        <input name="delete" type="submit" id="delete" value="删除选中" class="button" onclick="if (confirm('确定删除此目录及子目录吗？')){ $('#listForm').attr('action', '<?php echo $this->projectUrl(array('action'=>'delete')) ;?>');}else{return false;}" /></td>
                    </tr>
                </table>            </td>
        </tr>
    </form>
</table>
<script language="javascript">
function insertChild(id)
{
    var url = "<?php echo $this->projectUrl(array('action'=>'insert', 'parentId'=>'{id}')) ;?>";
    url = url.replace("%7Bid%7D", id);
    location.href = url;
}
function deleteSelfAndChidren(id)
{
    if (confirm("确定删除此目录及子目录吗？")){
        var url = "<?php echo $this->projectUrl(array('action'=>'delete', 'id'=>'{id}')) ;?>";
        url = url.replace("%7Bid%7D", id);
        location.href = url;
    }
}
function update(id)
{
    var url = "<?php echo $this->projectUrl(array('action'=>'update', 'id'=>'{id}')) ;?>";
    url = url.replace("%7Bid%7D", id);
    location.href = url;
}
</script>
</body>
</html>