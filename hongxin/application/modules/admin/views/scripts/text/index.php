<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->title;?></title>
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/admin/css/public.css" rel="stylesheet"/>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/admin/scripts/load.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl;?>/files/editor/ckeditor.js"></script>
</head>

<body>

	<table border="0" cellspacing="0" cellpadding="0" class="navigation">
		<tr>
			<td class="content"><span class="description">当前位置：</span>单页管理</td>
			<td align="right"></td>
		</tr>
	</table>

<div style="float:left; width:200px;">
	<table width="90%" border="0" cellspacing="0" cellpadding="0" class="table">
		<tr class="title">
			<td align="center">标题</td>
		</tr>
<?php
foreach ($this->rows as $key=>$row) {
?>
		<tr class="dataLine">
			<td align="center"><a href="<?php echo $this->projectUrl(array('id'=>$row['id'])) ;?>"><?php echo $row['title'];?></a></td>
		</tr>
<?php
}
?>
	</table>
</div>
<?php
if (!empty($this->row)) {
?>
<div style="float:left; width:750px; text-align:left;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" >
		<form id="editForm" name="editForm" method="post" action="">
			<tr class="title">
				<td rowspan="2" align="center" valign="top">&nbsp;</td>
				<td height="30" align="left" valign="top">

				<input name="title" type="text" class="input" id="title" value="<?php echo htmlspecialchars($this->row['title']);?>" size="40"  />
				&nbsp;&nbsp;&nbsp;&nbsp;显示排序
				<input name="sort" type="text" class="input" id="sort" value="<?php echo htmlspecialchars($this->row['sort']);?>" size="10"  />
			</td>
			</tr>
			<tr class="title">
				<td align="left" valign="top">

					<textarea id="content" name="content" ><?php echo htmlspecialchars($this->row['content']);?></textarea>
	<script language="javascript">
	CKEDITOR.replace('content');
	</script>
			</td>
			</tr>
			<tr class="title">
				<td align="center" valign="top">&nbsp;</td>
				<td align="left" valign="top"><input name="submit" type="submit" id="submit" value="提交" class="button" /></td>
			</tr>
		</form>
	</table>
</div>
<?php
}
?>
</body>
</html>