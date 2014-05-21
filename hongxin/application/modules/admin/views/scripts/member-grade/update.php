<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/admin/css/public.css" rel="stylesheet"/>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/admin/scripts/load.js"></script>
<!--时间选择器-->
<script src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar.js"></script>
<script src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/lang/cn_utf8.js"></script>
<script src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-setup.js"></script>
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-blue.css" rel="stylesheet" />
<title><?php echo $this->title;?></title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="navigation">
    <tr>
        <td class="content"><span class="description">当前位置：</span><a href="<?php echo $this->projectUrl(array('action'=>'index')) ;?>">会员VIP申请列表</a> &gt; 更改状态</td>
    </tr>
</table>
<form id="editForm" name="editForm" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
            <td>用户名：</td>
            <td><?php echo $this->row['userName']?></td>
        </tr>
        <tr>
			<td>状态：</td>
        	<td>
				<label><input type="radio" name="status" id="status" value="1" <?php echo $this->row['status'] == 1 ? ' checked' : '';?> <?php echo $this->row['status'] > 1 ? ' disabled' : '';?>/>已提交待审核</label>
				<label><input type="radio" name="status" id="status" value="2" <?php echo $this->row['status'] == 2 ? ' checked' : '';?> <?php echo $this->row['status'] > 2 ? ' disabled' : '';?>/>已审核通过</label>
				<label><input type="radio" name="status" id="status" value="3" <?php echo $this->row['status'] == 3 ? ' checked' : '';?> />已经审核未通过(作废)</label>
				
<?php
foreach($this->row['statusLogRows'] as $logRow) {
?>
				<div><?php echo $logRow['user'];?>于<?php echo $logRow['time'];?>将状态“<?php echo $logRow['previousStatus'];?>”修改为“<?php echo $logRow['currentStatus'];?>”</div>
<?php
}
?>			</td>
        </tr>

        <tr>
			<td>开始时间：</td>
        	<td><input name="startTime" type="text" class="input" id="startTime" size="40" value="<?php echo !empty($this->row['startTime']) ? date("Y-m-d H:i:s", $this->row['startTime']) : ($this->row['status'] == 1 ? date("Y-m-d 00:00:00") : '');?>" <?php echo $this->row['status'] > 1 ? ' disabled' : '';?> onchange="updateEndTime(this.value);"/>
				<script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d %H:%M:00","firstDay":0,"showsTime":true,"showOthers":false,"timeFormat":24,"inputField":"startTime","button":"startTime"});</script>			</td>
       	</tr>
        <tr>
        	<td>截止时间：</td>
        	<td id="endTimeBlock"><?php echo !empty($this->row['endTime']) ? date("Y-m-d H:i:s", $this->row['endTime']) : ($this->row['status'] == 1 ? date("Y-m-d 00:00:00", time() + 3600 * 24 * 365 * $this->row['year']) : '');?></td>
       	</tr>
        <tr>
        	<td width="15%">&nbsp;</td>
        	<td><input name="submit" type="submit" id="submit" value="修改" class="button" /></td>
       	</tr>
    </table>
</form>
<script language="javascript">
function updateEndTime(startTime)
{
	var url = "<?php echo $this->projectUrl(array('action'=>'get-time', 'year'=>'{year}', 'startTime'=>'{startTime}'), NULL, false);?>";
	url = url.replace('{year}', <?php echo $this->row['year'];?>);
	url = url.replace('{startTime}', encodeURIComponent($('#startTime').val()));

	$.ajax({
		type: "GET",
		url: url,
		dataType: "html",
		async: true,
		success: function(result){
			$("#endTimeBlock").html(result);
		}
	});
}
</script>
</body>
</html>