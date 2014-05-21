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
        <td class="content"><span class="description">当前位置：</span>用户列表</td>
        <td align="right"><input name="insert" type="button" id="insert" value="添加用户" class="button" onclick="location.href='<?php echo $this->projectUrl(array('action'=>'insert')) ;?>';" /></td>
    </tr>
</table>
<form id="searchForm" name="searchForm" method="post" action="<?php echo $this->projectUrl(array('groupId'=>$this->groupId));?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
            <td align="center"><input name="keyword" type="text" class="input" id="keyword" size="30" value="<?php echo htmlspecialchars($this->keyword);?>" />
                <select name="searchType" id="searchType">
                    <option value="1" <?php if ($this->searchType == 1) {echo 'selected';}?>>按用户名/工号</option>
                    <option value="2" <?php if ($this->searchType == 2) {echo 'selected';}?>>按姓名</option>
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
            <td align="center">工号</td>
            <td align="center">姓名</td>
            <td align="center">所在组</td>
            <td align="center">状态</td>
            <td align="center">在线情况</td>
            <td width="10%" align="center">操作</td>
        </tr>
<?php
$idArray = array();
$visitIdArray = array();
foreach ($this->rows as $key=>$row) {
    $visitIdArray[] = $row['visitId'];
    $idArray[] = $row['id'];
?>
        <tr class="dataLine">
            <td width="8%" align="center"><input name="selectId[]" type="checkbox" id="selectId<?php echo $key;?>" value="<?php echo $row['id'];?>" /></td>
            <td align="center"><?php echo $row['userName'];?></td>
            <td align="center"><?php echo $row['code'];?></td>
            <td align="center"><?php echo $row['name'];?></td>
            <td align="center"><?php echo $row['groupName'];?></td>
            <td align="center"><?php if ($row['status'] == '1') {echo '正常';} else if ($row['status'] == '2') {echo '<span style="color:#ccc;">关闭</span>';} else {echo '其他';}?></td>
            <td align="center"><span id="onlineInfo_<?php echo $row['id'];?>">加载中...</span></td>
            <td width="10%" align="center"><a href="<?php echo $this->projectUrl(array('action'=>'update', 'id'=>$row['id'], 'backUrl'=>urlencode($this->pageUrl))) ;?>">修改</a></td>
        </tr>
<?php
}
$visitIds = implode(',', $visitIdArray);
$ids = implode(',', $idArray);
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

<script language="javascript">
var ids = "<?php echo $ids;?>";
var vIds = "<?php echo $visitIds;?>";
var onlineElementPrefix = "onlineInfo_";
var refreshTime = <?php echo $this->effectiveOnlineTime*1000;?>;
function setOnlineData()
{
    if (vIds != '') {
        var url = '<?php echo $this->projectUrl(array('controller'=>'admin-visit', 'action'=>'is-online')) ;?>/visitIds/'+ vIds +'/rand/' + Math.random();
        $.ajax({
            type: "GET",
            url: url,
            async: true,
            dataType: "json",
            success: function(data){
                displayOnlineInfo(data);
                setTimeout("setOnlineData()", refreshTime); 
            } 
        });
    } else {
        displayOnlineInfo('');
    }
}

function displayOnlineInfo(data)
{
    userIds = ids.split(",");
    visitIds = vIds.split(",");
    for (var i = 0; i <= userIds.length-1; i++) {
        initString = "if (typeof(data.id"+ visitIds[i] +")=='object') {isOnline = data.id"+ visitIds[i] +".isOnline;} else {isOnline = -1;}";
        eval(initString);
        if (isOnline == 1) {
            $("#" + onlineElementPrefix + userIds[i]).html("在线");
        } else if (isOnline == 0) {
            $("#" + onlineElementPrefix + userIds[i]).html("<span style=\"color:#cccccc;\">离线</span>");
        } else {
            $("#" + onlineElementPrefix + userIds[i]).html("<span style=\"color:#ff0000;\">无登录记录</span>");
        }
    }
}
setOnlineData();
</script>
</body>
</html>