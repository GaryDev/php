<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/admin/css/public.css" rel="stylesheet"/>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/admin/scripts/load.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl;?>/files/editor/ckeditor.js"></script>
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
        <td class="content"><span class="description">当前位置：</span><a href="<?php echo $this->backUrl;?>">信息列表</a> &gt; 修改信息</td>
    </tr>
</table>
<form action="" method="post" enctype="multipart/form-data" name="editorForm" id="editorForm">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
            <td>标题：</td>
            <td>
				<input name="title" type="text" class="input" id="title" size="50" maxlength="50" value="<?php echo $this->row['title'];?>"/> 
				&nbsp;&nbsp;
			<label><input type="checkbox" name="isLink" id="isLink" <?php echo $this->row['isLink'] == '1' ? ' checked' : '';?>/> 链接</label></td>
        </tr>
        <tr id="linkUrlBlock">
			<td>链接地址：</td>
        	<td><input name="linkUrl" type="text" class="input" id="linkUrl" size="50" value="<?php echo $this->row['linkUrl'];?>"/></td>
       	</tr>
        <tr>
            <td>分类：</td>
            <td>
				<select name="classId" id="classId">
					<option value="0">选择分类</option>
<?php
foreach($this->archivesClassRows as $archivesClassRow) {
?>
					<option value="<?php echo $archivesClassRow['id'];?>" <?php echo $this->row['classId'] == $archivesClassRow['id'] ? ' selected' : '';?>><?php echo $archivesClassRow['name'];?></option>
<?php
}
?>
				</select>			</td>
        </tr>
        <tr>
        	<td>标题图片：</td>
        	<td><input type="file" name="picture" id="picture" />
       		<?php echo !empty($this->row['pictureUrl']) ? "<a href=\"{$this->row['pictureUrl']}\" target=\"_blank\" style=\"margin-top:5px; margin-bottom:5px; margin-left:30px;\"><img src=\"{$this->row['pictureUrl']}\" height=\"20\" align=\"absmiddle\" border=\"0\"/></a> <label><input name=\"deletePicture\" type=\"checkbox\" value=\"1\">删除</label>" : '';?></td>
       	</tr>
        <tr>
        	<td>发布状态：</td>
        	<td>
				<label><input name="status" type="radio" id="status1" value="1" <?php echo $this->row['status'] == '1' ? ' checked' : '';?>/> 发布中</label>
				&nbsp;&nbsp;
				<label><input name="status" type="radio"  id="status2" value="2" <?php echo $this->row['status'] == '2' ? ' checked' : '';?>/> 待发布</label>
				&nbsp;&nbsp;
				<input name="submit" type="submit" id="submit" value="保存" class="button" style="font-weight:bold; color:#000"/>			</td>
       	</tr>
        <tr>
        	<td>更新时间：</td>
        	<td>
				<input name="updateTime" type="text" class="input" id="updateTime" size="50" value="<?php echo date("Y-m-d H:i:s", $this->row['updateTime']);?>"/>
				<script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d %H:%M:00","firstDay":0,"showsTime":true,"showOthers":false,"timeFormat":24,"inputField":"updateTime","button":"updateTime"});</script>			</td>
       	</tr>
        <tr id="contentBlock">
            <td colspan="2">				
                <textarea dataType="editor" isCheckLength="1" name="content" title="内容" id="content" maxLength="0" minLength="0"><?php echo htmlspecialchars($this->row['content']);?></textarea>
                <script language="javascript">
                CKEDITOR.replace('content', {
					filebrowserImageUploadUrl : '<?php echo $this->projectUrl(array('action'=>'editor-upload', 'id'=>$this->row['id']));?>',
                	toolbar : 'Simple',
					height : '280px'
                });
                </script>            </td>
        </tr>
    </table>
</form>
<script language="javascript">
$(document).ready(function(){
	checkIsLink();
});
$("#isLink").click(function(){
	checkIsLink();
});

function checkIsLink(){
	if ($("#isLink").attr('checked') == true) {
		$("#contentBlock").css('display', 'none');
		$("#linkUrlBlock").css('display', '');
	} else {
		$("#contentBlock").css('display', '');
		$("#linkUrlBlock").css('display', 'none');
	}
}
$("#editorForm").submit(function(){
	if ($.trim($("#title").val()) == '') {
		alert('请填写标题。');
		$("#title").focus();
		return false;
	}
	if ($.trim($("#classId").val()) == '0') {
		alert('请选择一个分类。');
		$("#classId").focus();
		return false;
	}
});
</script>
</body>
</html>