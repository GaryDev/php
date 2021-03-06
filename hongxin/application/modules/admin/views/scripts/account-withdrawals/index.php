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
        <td class="content"><span class="description">当前位置：</span>提现记录</td>
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
       			<input name="search" type="submit" id="search" value="查找" class="button" />
       		</td>
       	</tr>
    </table>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <form id="listForm" name="listForm" method="post" action="">
        <tr class="title">
            <td align="center">用户名</td>
            <td align="center">金额</td>
            <td align="center">手续费</td>
            <td align="center">状态</td>
            <td align="center">审核意见</td>
            <td align="center"> 申请时间</td>
            <td align="center" class="subject line">用户备注</td>
            <td width="10%" align="center">操作</td>
        </tr>
<?php
foreach ($this->rows as $key=>$row) {
?>
        <tr class="dataLine">
            <td align="center"><?php echo $row['userName'];?></td>
            <td align="center">￥<?php echo $row['amount'];?></td>
            <td align="center">￥<?php echo $row['fee'];?></td>
            <td align="center"><?php if ($row['status'] == 1) {echo '<span style="color:#f00;">已提交待审核</span>';} else if ($row['status'] == 2) {echo '已审核已发放';} else if ($row['status'] == 3) {echo '<span style="color:#ccc;">已经审核未通过(作废)</span>';}?></td>
          	<td align="center"><?php echo $row['statusNotes'];?></td>
            <td align="center"><?php echo date('Y-m-d H:i', $row['applyTime']);?></td>
            <td align="center" class="line"><?php echo $row['userNotes'];?></td>
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