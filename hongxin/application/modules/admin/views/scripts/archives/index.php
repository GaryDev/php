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
        <td class="content"><span class="description">当前位置：</span>信息列表</td>
        <td align="right"><input name="insert" type="button" id="insert" value="添加" class="button" onclick="location.href='<?php echo $this->projectUrl(array('action'=>'insert', 'classId'=>$this->vars['classId'])) ;?>';" /></td>
    </tr>
</table>
<form id="searchForm" name="searchForm" method="post" action="<?php echo $this->projectUrl();?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
        	<td align="left">
				标题：
        		<input name="title" type="text" class="input" id="title" size="30" value="<?php echo htmlspecialchars($this->vars['title']);?>" />
				&nbsp;&nbsp;&nbsp;&nbsp;
				分类：
				<select name="classId" id="classId">
					<option value="0">分类不限</option>
<?php
foreach($this->archivesClassRows as $archivesClassRow) {
?>
					<option value="<?php echo $archivesClassRow['id'];?>" <?php echo $this->vars['classId'] == $archivesClassRow['id'] ? ' selected' : '';?>><?php echo $archivesClassRow['name'];?></option>
<?php
}
?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;
        		状态：
        		<select name="status" id="status">
					<option value="0">状态不限</option>
					<option value="1" <?php echo $this->vars['status'] == 1 ? ' selected' : '';?>>发布中</option>
					<option value="2" <?php echo $this->vars['status'] == 2 ? ' selected' : '';?>>待发布</option>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;
       			<input name="search" type="submit" id="search" value="查找" class="button" />
			</td>
       	</tr>
    </table>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <form id="listForm" name="listForm" method="post" action="">
        <tr class="title">
            <td width="8%" align="center">选择</td>
            <td align="center">标题</td>
            <td align="center">分类</td>
            <td align="center">状态</td>
            <td align="center">更新时间</td>
            <td align="center">排序</td>
            <td width="10%" align="center">操作</td>
        </tr>
<?php
foreach ($this->rows as $key=>$row) {
?>
        <tr class="dataLine">
            <td width="8%" align="center"><input name="selectId[]" type="checkbox" id="selectId<?php echo $key;?>" value="<?php echo $row['id'];?>" />
           	<input type="hidden" name="id[]" id="id[]" value="<?php echo $row['id'];?>"/></td>
            <td align="left" title="<?php echo $row['title'];?>"><div style="margin-left:5px;"><?php echo substrMoreCn($row['title'], 39, '...');?> <?php echo !empty($row['pictureUrl']) ? "<a href=\"{$row['pictureUrl']}\" target=\"_blank\" style=\"margin:5px;\"><img src=\"{$row['pictureUrl']}\" height=\"20\" align=\"absmiddle\" border=\"0\"/></a>" : '';?></div></td>
            <td align="center"><?php echo $row['className'];?></td>
            <td align="center"><?php if ($row['status'] == '2') {echo '<span style="color:#ccc;">待发布</span>';} else if ($row['status'] == '1'){echo '发布中';} else if ($row['status'] == 3){echo '其他';} ?></td>
            <td align="center"><?php echo date('Y-m-d H:i', $row['updateTime']);?></td>
            <td align="center"><input name="orderNumber<?php echo $row['id'];?>" type="text" id="orderNumber<?php echo $row['id'];?>" size="5" class="input" value="<?php echo $row['orderNumber'];?>"/></td>
            <td width="10%" align="center"><a href="<?php echo $this->projectUrl(array('action'=>'update', 'id'=>$row['id'], 'backUrl'=>urlencode($this->pageUrl)));?>">修改</a></td>
        </tr>
<?php
}
?>
        <tr>
            <td colspan="7">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <input name="selectAllSetButton" type="button" id="selectAllSetButton" value="全选" class="button" onclick="selectAllSet('selectId[]');" />
                            <input name="selectAllClearButton" type="button" id="selectAllClearButton" value="取消" class="button" onclick="selectAllClear('selectId[]');" />
						</td>
                        <td align="right">
							<input name="order" type="submit" id="order" value="更改排序" class="button" onclick="if (confirm('确定更改排序吗？')){ $('#listForm').attr('action', '<?php echo $this->projectUrl(array('action'=>'set-order', 'backUrl'=>urlencode($this->pageUrl))) ;?>');}else{return false;}" />
							<input name="delete" type="submit" id="delete" value="删除选中" class="button" onclick="if (confirm('确定删除吗？')){ $('#listForm').attr('action', '<?php echo $this->projectUrl(array('action'=>'delete', 'backUrl'=>urlencode($this->pageUrl))) ;?>');}else{return false;}" />
						</td>
                    </tr>
                </table>
			</td>
        </tr>
    </form>
    <tr>
        <td colspan="7" class="paginator"><?php echo $this->pageString;?></td>
    </tr>
</table>
</body>
</html>