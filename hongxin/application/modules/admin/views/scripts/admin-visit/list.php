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
        <td class="content"><span class="description">当前位置：</span>用户登录记录</td>
    </tr>
</table>
<form id="searchForm" name="searchForm" method="post" action="<?php echo $this->projectUrl(array('groupId'=>$this->groupId));?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
            <td align="center"><input name="keyword" type="text" class="input" id="keyword" size="30" value="<?php echo $this->keyword;?>" />
                <select name="searchType" id="searchType">
                    <option value="1" <?php if ($this->searchType == 1) {echo 'selected';}?>>按用户名</option>
                    <option value="2" <?php if ($this->searchType == 2) {echo 'selected';}?>>按IP</option>
                </select>
                <input name="search" type="submit" id="search" value="查找" class="button" />
            </td>
        </tr>
    </table>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    <form id="listForm" name="listForm" method="post" action="">
        <tr class="title">
            <td width="8%" align="center">选择</td>
            <td align="center">用户名</td>
            <td align="center">登录IP</td>
            <td align="center">登录时间</td>
            <td align="center">在线时间</td>
            <td align="center">当前状态</td>
        </tr>
<?php
$time = time();
foreach ($this->rows as $key=>$row) {
    $limitTime = $row['lastOnlineTime'] - $row['time'];
?>
        <tr class="dataLine">
            <td width="8%" align="center"><input name="selectId[]" type="checkbox" id="selectId<?php echo $key;?>" value="<?php echo $row['id'];?>" /></td>
            <td align="center"><?php echo $row['userName'];?></td>
            <td align="center"><?php echo $row['ip'];?></td>
            <td align="center"><?php echo date('Y-m-d H:i:s', $row['time']);?></td>
            <td align="center"><?php echo timeToString($limitTime);?></td>
            <td align="center"><?php echo $this->effectiveOnlineTime+$row['lastOnlineTime'] < $time ? '<span style="color:#cccccc;">失效</span>' : '在线';?></td>
        </tr>
<?php
}
?>
        <tr>
            <td colspan="6">
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
        <td colspan="6" class="paginator"><?php echo $this->pageString;?></td>
    </tr>
</table>
</body>
</html>