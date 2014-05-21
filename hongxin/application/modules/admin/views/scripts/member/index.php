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
        <td class="content"><span class="description">当前位置：</span>会员列表</td>
        <td align="right"></td>
    </tr>
</table>
<form id="searchForm" name="searchForm" method="post" action="<?php echo $this->projectUrl();?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
        	<td align="left">用户名：
        		<input name="userName" type="text" class="input" id="userName" size="20" value="<?php echo htmlspecialchars($this->vars['userName']);?>" />
        		&nbsp;&nbsp;&nbsp;&nbsp;手机：
        		<input name="mobile" type="text" class="input" id="mobile" size="20" value="<?php echo htmlspecialchars($this->vars['mobile']);?>" />
        		&nbsp;&nbsp;&nbsp;&nbsp;电子邮箱：
        		<input name="email" type="text" class="input" id="email" size="20" value="<?php echo htmlspecialchars($this->vars['email']);?>" />
        		&nbsp;&nbsp;&nbsp;&nbsp;状态：
        		<select name="status" id="status">
					<option value="0">状态不限</option>
					<option value="1" <?php echo $this->vars['status'] == 1 ? ' selected' : '';?>>未激活</option>
					<option value="2" <?php echo $this->vars['status'] == 2 ? ' selected' : '';?>>已激活</option>
					<option value="3" <?php echo $this->vars['status'] == 3 ? ' selected' : '';?>>帐号关闭</option>
				</select>
			<input name="type" type="hidden" id="type" value="<?php echo htmlspecialchars($this->vars['type']);?>" />
       		<input name="search" type="submit" id="search" value="查找" class="button" /></td>
       	</tr>
    </table>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <form id="listForm" name="listForm" method="post" action="">
        <tr class="title">
            <td width="8%" align="center">选择</td>
            <td align="center">用户名</td>
            <td align="center">用户状态</td>
            <td align="center">审核状态</td>
            <td align="center">邮件</td>
            <td align="center">注册时间</td>
            <?php if ($this->vars['type'] == 'E') { ?><td width="10%" align="center">操作</td><?php }?>
        </tr>
<?php
foreach ($this->rows as $key=>$row) {
?>
        <tr class="dataLine">
            <td width="8%" align="center"><input name="selectId[]" type="checkbox" id="selectId<?php echo $key;?>" value="<?php echo $row['id'];?>" /></td>
            <td align="center"><?php echo $row['userName'];?></td>
            <td align="center"><?php if ($row['status'] == 1) {echo '<span style="color:red;">未激活</span>';} else if ($row['status'] == 2){echo '已激活';} else if ($row['status'] == 3){echo '<span style="color:#ccc;">帐号关闭</span>';} ?></td>
            <?php if ($this->vars['type'] == 'E') { ?>
            <td align="center"><?php if ($row['borrowersStatus'] == 1) {echo '<span style="color:#000;">未提交</span>';} else if ($row['borrowersStatus'] == 2){echo '审核中';} else if ($row['borrowersStatus'] == 3){echo '<span style="color:green;">审核通过</span>';} else if ($row['borrowersStatus'] == 4){echo '<span style="color:red;">审核未通过</span>';} ?></td>
            <?php } else if ($this->vars['type'] == 'P') { ?>
            <td align="center"><?php if ($row['lendersStatus'] == 1) {echo '<span style="color:#000;">未提交</span>';} else if ($row['lendersStatus'] == 2){echo '审核中';} else if ($row['lendersStatus'] == 3){echo '<span style="color:green;">审核通过</span>';} else if ($row['lendersStatus'] == 4){echo '<span style="color:red;">审核未通过</span>';} ?></td>
            <?php } ?>
            <td align="center"><?php echo $row['email'];?></td>
            <td align="center"><?php echo date('Y-m-d H:i', $row['regTime']);?></td>
            <?php if ($this->vars['type'] == 'E') { ?>
	            <td width="10%" align="center">
	            <!--  
	            <a href="<?php echo $this->projectUrl(array('action'=>'view', 'id'=>$row['id'], 'backUrl'=>urlencode($this->pageUrl)));?>">查看</a>&nbsp;
	            -->
				<?php if($row['borrowersStatus'] != 1) { ?>
	            <a href="<?php echo $this->projectUrl(array('action'=>'approve', 'id'=>$row['id'], 'backUrl'=>urlencode($this->pageUrl)));?>">审核</a>
	            <?php } ?>
	            </td>
            <?php }?>
        </tr>
<?php
}
?>
        <tr>
            <td colspan="8">
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
        <td colspan="8" class="paginator"><?php echo $this->pageString;?></td>
    </tr>
</table>
</body>
</html>