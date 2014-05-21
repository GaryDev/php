<?php
header("content-type:text/html; charset=utf-8");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
    
        <tr class="title">
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
            <td align="center"><?php echo $row['userName'];?></td>
            <td align="center"><?php echo $row['ip'];?></td>
            <td align="center"><?php echo date('Y-m-d H:i:s', $row['time']);?></td>
            <td align="center"><?php echo timeToString($limitTime);?></td>
            <td align="center"><?php echo $this->effectiveOnlineTime+$row['lastOnlineTime'] < $time ? '<span style="color:#cccccc;">失效</span>' : '在线';?></td>
        </tr>
<?php
}
?>
</table>
