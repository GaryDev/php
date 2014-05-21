<script language="javascript">
var serverTime = <?php echo time();?>;
function getDateTime()
{
    var date = new Date(serverTime*1000);
    var weekArray = ["日", "一", "二", "三", "四", "五", "六"];
    var dateString = date.getFullYear() + "年" + (date.getMonth()+1) + "月" + date.getDate() + "日 " + date.getHours() + "点" + date.getMinutes() + "分" + date.getSeconds() + "秒 " + "星期" + weekArray[date.getDay()];
    serverTime++;
    return dateString;
}
setInterval("document.getElementById('serverDateTime').innerHTML = getDateTime();", 1000);
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" valign="middle">
                        <a href="<?php echo $this->projectUrl(array('controller' => 'index', 'action' => 'index')) ;?>" style=" line-height:28px; font-size:28px; font-weight:bold; text-decoration:none; color:#2131A1;"><?php echo $this->systemName;?></a></td>
                    <td valign="bottom" align="left";>
<?php
if (!empty($this->currentUserRow)){
?>    
                    <img src="<?php echo $this->baseUrl;?>/files/admin/images/user.png" align="absmiddle"> <?php echo $this->currentUserRow['userName'];?>（<?php echo $this->currentUserRow['name'];?>），工号：<span style="font-weight:bold;"><?php echo $this->currentUserRow['code'];?></span>，级别：<span style="font-weight:bold;"><?php echo $this->currentUserRow['groupName'];?></span>
<?php
}
?>                    </td>
                    <td valign="bottom">
                        <table width="350" border="0" align="right" cellpadding="0" cellspacing="0">
                            <tr>
                                <td><span id="serverDateTime">加载中...</span></td>
                            </tr>
                            <tr>
                                <td>
<?php
if (!empty($this->currentUserRow)){
?>
<?php
    if ($this->master == $this->currentUserRow['userName']) {
?>
                                    <a href="<?php echo $this->projectUrl(array('controller' => 'catalog', 'action' => 'index')) ;?>" target="frameRight">系统目录管理</a>
<?php
    }
?>
                                    <a href="<?php echo $this->projectUrl(array('controller' => 'admin', 'action' => 'update-self-password')) ;?>" target="frameRight">修改密码</a>
                                    <a href="<?php echo $this->projectUrl(array('controller' => 'login', 'action' => 'logout')) ;?>">退出登录</a>
                                
<?php
} else {
?>
                                    你好访客，请登录!
<?php
}
?>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="2" colspan="3" class="topBg"></td>
                </tr>
            </table>
