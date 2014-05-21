<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->title;?></title>
<link href="<?php echo $this->baseUrl;?>/files/admin/css/frame.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/admin/scripts/load.js"></script>
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr height="7%">
        <td colspan="2" valign="top"><?php echo $this->render('top.php');?></td>
    </tr>
    <tr height="93%">
        <td width="16%" align="center" valign="top" class="leftMenu">
            <iframe scrolling="auto" width="100%" height="100%" src="<?php echo $this->projectUrl(array('action'=>'left')) ;?>" name="frameLeft" frameborder="0"></iframe>
        </td>
        <td width="84%">
            <iframe width="100%" height="100%" src="<?php echo $this->projectUrl(array('action'=>'main')) ;?>" name="frameRight" scrolling="auto" frameborder="0">你的浏览器不支持...</iframe>
        </td>
    </tr>
</table>

<script language="javascript">
var refreshTime= <?php echo $this->effectiveOnlineTime;?>;

function updateOnLine()
{
    var url = '<?php echo $this->projectUrl(array('controller'=>'login', 'action'=>'update-on-line', 'noUpdateOnline'=>1)) ;?>'+'/rand/' + Math.random();
    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        async: true,
         success: function(data){
            if (data.state == 1) {
                location.href="<?php echo $this->projectUrl(array('controller'=>'login', 'action'=>'index')) ;?>";
                return ;
            } else if (data.state == 2) {
                alert('此用户已不存在！');
                location.href="<?php echo $this->projectUrl(array('controller'=>'login', 'action'=>'index')) ;?>";
                return ;
            } else if (data.state == 3) {
                alert('此用户已在其他地方登录，你已被强制下线！');
                location.href="<?php echo $this->projectUrl(array('controller'=>'login', 'action'=>'index')) ;?>";
                return ;
            } else if (data.state == 4) {
                alert('你没有自动更新状态的权限，请与系统负责人联系！');
                location.href="<?php echo $this->projectUrl(array('controller'=>'login', 'action'=>'index')) ;?>";
                return ;
            } else {
                effectiveTimeHistory = effectiveTime;
                effectiveTime = data.effectiveTime;
                if (effectiveTime <= 0) {
                    location.href="<?php echo $this->projectUrl(array('controller'=>'login', 'action'=>'index')) ;?>";
                    return ;
                }

                setTimeout("updateOnLine()", refreshTime*1000); 
            }
         } 
    });
}
</script>
</body>
</html>