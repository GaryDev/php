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
        <td class="content"><span class="description">当前位置：</span>用户登录记录(TOP20)，<?php echo $this->effectiveOnlineTime;?>秒更新一次。</td>
        <td align="right" class="content"><input name="insert" type="button" id="insert" value="查看更多..." class="button" onclick="location.href='<?php echo $this->projectUrl(array('action'=>'list')) ;?>';" /></td>
    </tr>
</table>
<span id="latestData">加载中...</span>
<script language="javascript">
function loadLatestOnlineData(){
    var url = '<?php echo $this->projectUrl(array('controller'=>'admin-visit', 'action'=>'ajax-list')) ;?>/rand/' + Math.random();
    $.ajax({
        type: "GET",
        url: url,
        async: true,
        success: function(data){
            $('#latestData').html(data);
            setTimeout('loadLatestOnlineData()', <?php echo $this->effectiveOnlineTime;?>*1000);
        } 
    });
}
loadLatestOnlineData();
</script>
</body>
</html>