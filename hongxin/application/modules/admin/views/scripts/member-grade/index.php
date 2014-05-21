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
        <td class="content"><span class="description">当前位置：</span>会员VIP申请列表</td>
        <td align="right"></td>
    </tr>
</table>
<form id="searchForm" name="searchForm" method="post" action="<?php echo $this->projectUrl();?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
        	<td align="left">用户名：
        		<input name="userName" type="text" class="input" id="userName" size="20" value="<?php echo htmlspecialchars($this->vars['userName']);?>" />
        		&nbsp;&nbsp;&nbsp;&nbsp;客服工号：
        		<input name="serviceCode" type="text" class="input" id="serviceCode" size="20" value="<?php echo htmlspecialchars($this->vars['serviceCode']);?>" />
        		&nbsp;&nbsp;&nbsp;&nbsp;状态：
        		<select name="status" id="status">
					<option value="0">状态不限</option>
					<option value="1" <?php echo $this->vars['status'] == 1 ? ' selected' : '';?>>已提交待审核</option>
					<option value="2" <?php echo $this->vars['status'] == 2 ? ' selected' : '';?>>已审核通过</option>
					<option value="3" <?php echo $this->vars['status'] == 3 ? ' selected' : '';?>>已经审核未通过(作废)</option>
				</select>
       		<input name="search" type="submit" id="search" value="查找" class="button" /></td>
       	</tr>
    </table>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <form id="listForm" name="listForm" method="post" action="">
        <tr class="title">
            <td align="center">用户名</td>
            <td align="center">客服工号</td>
            <td align="center">状态</td>
            <td align="center">价格</td>
            <td align="center">开始时间</td>
            <td align="center">截止时间</td>
            <td align="center">申请时间</td>
            <td width="10%" align="center">操作</td>
        </tr>
<?php
foreach ($this->rows as $key=>$row) {
?>
        <tr class="dataLine">
            <td align="center"><?php echo $row['userName'];?></td>
            <td align="center"><?php echo $row['serviceCode'];?></td>
            <td align="center"><?php if ($row['status'] == 1) {echo '<span style="color:#f00;">已提交待审核</span>';} else if ($row['status'] == 2) {echo '已审核通过';} else if ($row['status'] == 3) {echo '<span style="color:#ccc;">已经审核未通过(作废)</span>';}?></td>
            <td align="center"><?php echo $row['year'];?>年，共￥<?php echo $row['year'] * $row['price'];?></td>
            <td align="center"><?php echo !empty($row['startTime']) ? date('Y-m-d H:i', $row['startTime']) : '--';?></td>
            <td align="center"><?php echo !empty($row['endTime']) ? date('Y-m-d H:i', $row['endTime']) : '--';?></td>
            <td align="center"><?php echo date('Y-m-d H:i', $row['addTime']);?></td>
            <td width="10%" align="center"><a href="<?php echo $this->projectUrl(array('action'=>'update', 'id'=>$row['id'], 'backUrl'=>urlencode($this->pageUrl)));?>">更改状态</a></td>
        </tr>
<?php
}
?>
    </form>
    <tr>
        <td colspan="8" class="paginator"><?php echo $this->pageString;?></td>
    </tr>
</table>
</body>
</html>