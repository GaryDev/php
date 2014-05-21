<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<title>我的账户 - <?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>
<div class="mainbox">
	<?php echo $this->render('member-menu.php');?>
	<div class="tb3 mtop10">
		<div class="nytit6">
		<h3>更换头像</h3></div>
		<div class="nytxt6 search">
			<form id="uploadForm" name="uploadForm" enctype="multipart/form-data" method="post" action="">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center"><table border="0" >
							<tr>
								<td align="center" valign="middle" class="imgTab"><img src="<?php echo $this->avatarUrl;?>?rand=<?php echo rand(1, 1000);?>" /></td>
							</tr>
						</table></td>
						<td>
							<div>
								<input type="file" name="avatarPhoto" id="avatarPhoto" />
								<input name="upload" type="submit" id="upload" value="上传" class="button" />
							</div>
							<div>
								请选择一张格式为JPG/PNGG/GIF格式的照片，小于1MB。
							</div>
						</td>
					</tr>
				</table>
			</form>
		</div>
		
	</div>
</div>
<div class="cl"></div>

<?php echo $this->render('footer.php');?>
</body>
</html>
