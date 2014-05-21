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
        <td class="content"><span class="description">当前位置：</span>明细列表</td>
        <td align="right"></td>
    </tr>
</table>
<form id="searchForm" name="searchForm" method="post" action="<?php echo $this->projectUrl();?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
        	<td align="left">
				用户名：
        		<input name="userName" type="text" class="input" id="userName" size="20" value="<?php echo htmlspecialchars($this->vars['userName']);?>" />
        		&nbsp;
   			<input name="search" type="submit" id="search" value="查找" class="button" /></td>
       	</tr>
    </table>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <form id="listForm" name="listForm" method="post" action="">
        <tr class="title">
            <td align="center">用户名</td>
            <td align="center">操作金额</td>
            <td align="center">剩余金额</td>
            <td align="center">操作时间</td>
            <td align="center">说明</td>
        </tr>
<?php
foreach ($this->rows as $key=>$row) {
?>
        <tr class="dataLine">
            <td align="center"><?php echo $row['userName'];?></td>
            <td align="center">￥<?php echo $row['amount'];?></td>
            <td align="center">￥<?php echo $row['surplusAvailableAmount'];?>（可用），￥<?php echo $row['surplusLockAmount'];?>（冻结）</td>
          <td align="center"><?php echo date('Y-m-d H:i', $row['addTime']);?></td>
            <td align="center"><?php echo $row['notes'] != '' ? $row['notes'] : '--';?></td>
        </tr>
<?php
}
?>
    </form>
    
    <tr>
        <td colspan="5" class="paginator"><?php echo $this->pageString;?></td>
    </tr>
</table>
</body>
</html>