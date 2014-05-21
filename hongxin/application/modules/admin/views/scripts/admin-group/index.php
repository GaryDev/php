<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->title;?></title>
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/admin/css/public.css" rel="stylesheet"/>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/admin/scripts/load.js"></script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="navigation">
    <tr>
        <td class="content"><span class="description">当前位置：</span>用户组列表</td>
        <td align="right"><input name="insert" type="button" id="insert" value="添加新组" class="button" onclick="location.href='<?php echo $this->projectUrl(array('action'=>'insert')) ;?>';" /></td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <form id="listForm" name="listForm" method="post" action="">
        <tr class="title">
            <td width="8%" align="center">选择</td>
            <td align="center">名称</td>
            <td width="10%" align="center">操作</td>
        </tr>
<?php
foreach ($this->rows as $key=>$row) {
?>
        <tr class="dataLine">
            <td width="8%" align="center"><input name="selectId[]" type="checkbox" id="selectId<?php echo $key;?>" value="<?php echo $row['id'];?>" /></td>
            <td align="center"><a href="<?php echo $this->projectUrl(array('controller'=>'admin', 'groupId'=>$row['id'])) ;?>"><?php echo $row['name'];?></a></td>
            <td width="10%" align="center"><a href="<?php echo $this->projectUrl(array('action'=>'update', 'id'=>$row['id'], 'backUrl'=>urlencode($this->pageUrl)));?>">修改</a></td>
        </tr>
<?php
}
?>
        <tr>
            <td colspan="3">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <input name="selectAllSetButton" type="button" id="selectAllSetButton" value="全选" class="button" onclick="selectAllSet('selectId[]');" />
                            <input name="selectAllClearButton" type="button" id="selectAllClearButton" value="取消" class="button" onclick="selectAllClear('selectId[]');" />                        </td>
                        <td align="right"><input name="delete" type="submit" id="delete" value="删除选中" class="button" onclick="if (confirm('确定删除吗？')){ $('#listForm').attr('action', '<?php echo $this->projectUrl(array('action'=>'delete', 'backUrl'=>urlencode($this->pageUrl))) ;?>');}else{return false;}" /></td>
                    </tr>
                </table>            </td>
        </tr>
    </form>
    <tr>
        <td colspan="3" class="paginator"><?php echo $this->pageString;?></td>
    </tr>
</table>
</body>
</html>