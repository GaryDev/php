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
        <td class="content"><span class="description">当前位置：</span>融资列表</td>
        <td align="right"></td>
    </tr>
</table>
<form id="searchForm" name="searchForm" method="post" action="<?php echo $this->projectUrl();?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
        	<td align="left">融资用户：
        		<input name="userName" type="text" class="input" id="userName" size="20" value="<?php echo htmlspecialchars($this->vars['userName']);?>" />
        		&nbsp;&nbsp;&nbsp;&nbsp;融资编号：
        		<input name="code" type="text" class="input" id="code" size="20" value="<?php echo htmlspecialchars($this->vars['code']);?>" />
        		&nbsp;&nbsp;&nbsp;&nbsp;标题：
        		<input name="title" type="text" class="input" id="title" size="20" value="<?php echo htmlspecialchars($this->vars['title']);?>" />
        		&nbsp;&nbsp;&nbsp;&nbsp;状态：
        		<select name="status" id="status">
					<option value="0">状态不限</option>
					<option value="1" <?php echo $this->vars['status'] == 1 ? ' selected' : '';?>>等待审核</option>
					<option value="2" <?php echo $this->vars['status'] == 2 ? ' selected' : '';?>>初审已通过</option>
					<option value="3" <?php echo $this->vars['status'] == 3 ? ' selected' : '';?>>终审已通过</option>
					<option value="4" <?php echo $this->vars['status'] == 4 ? ' selected' : '';?>>初审未通过</option>
					<option value="5" <?php echo $this->vars['status'] == 5 ? ' selected' : '';?>>终审未通过</option>
				</select>
       		<input name="search" type="submit" id="search" value="查找" class="button" /></td>
       	</tr>
    </table>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <form id="listForm" name="listForm" method="post" action="">
        <tr class="title">
            <td width="5%" align="center">选择</td>
            <td align="center">融资用户</td>
            <td align="center">融资编号</td>
            <td align="center">标题</td>
            <td align="center">融资金额</td>
            <td align="center">期限</td>
            <td align="center">年利率</td>
            <td align="center">当前状态</td>
            <td align="center">是否明星</td>
            <td align="center">申请状态</td>
            <td align="center">申请时间</td>
            <td width="10%" align="center">操作</td>
        </tr>
<?php
foreach ($this->rows as $key=>$row) {
?>
        <tr class="dataLine">
        	<td width="5%" align="center"><input name="selectId[]" type="checkbox" id="selectId<?php echo $key;?>" value="<?php echo $row['id'];?>" /></td>
            <td align="center"><?php echo $row['userName'];?></td>
            <td align="center"><?php echo $row['code'];?></td>
            <td align="center" title="<?php echo $row['title'];?>"><div style="margin-left:5px;"><?php echo substrMoreCn($row['title'], 20, '...');?> <?php echo !empty($row['pictureUrl']) ? "<a href=\"{$row['pictureUrl']}\" target=\"_blank\" style=\"margin:5px;\"><img src=\"{$row['pictureUrl']}\" height=\"20\" align=\"absmiddle\" border=\"0\"/></a>" : '';?></div></td>
            <td align="right"><?php echo $row['amount'];?>元</td>
            <td align="right"><?php echo $row['deadline'];?>天</td>
            <td align="right"><?php echo $row['yearInterestRate'];?>%</td>
            <td align="center"><?php echo $row['borrowStatus'];?></td>
            <td align="center"><?php if($row['popStar'] == 'Y') {echo '是';} else {echo '否';} ?></td>
            <td align="center"><?php if ($row['status'] == 1) {echo '已提交待审核';} else if ($row['status'] == 2) {echo '初审已通过';} else if ($row['status'] == 3) {echo '终审已通过';}  else if ($row['status'] == 4) {echo '初审未通过';}  else if ($row['status'] == 5) {echo '终审未通过';} ?></td>
            <td align="center"><?php echo date('Y-m-d', $row['addTime']);?></td>
            <td width="10%" align="center"><a href="<?php echo $this->projectUrl(array('action'=>'approve', 'id'=>$row['id'], 'backUrl'=>urlencode($this->pageUrl)));?>">审核</a></td>
        </tr>
<?php
}
?>
        <tr>
            <td colspan="12">
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
        <td colspan="12" class="paginator"><?php echo $this->pageString;?></td>
    </tr>
</table>
</body>
</html>