<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<link rel="stylesheet" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/css/validationEngine.jquery.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/js/jquery.validationEngine-cn.js"></script>
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
		<h3>修改密码</h3></div>
		<div class="nytxt6 search">
			<form id="passForm" name="passForm" method="post" action="">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
					<tr>
						<td>原密码：</td>
						<td><input name="oldPassword" type="password" class="validate[required] input" id="oldPassword" value="" size="30" /></td>
					</tr>
					<tr>
						<td>新密码：</td>
						<td><input name="password" type="password" class="validate[length[6,30]] input" id="password" value="" size="30" /></td>
					</tr>
					<tr>
						<td>确认新密码：</td>
						<td><input name="password2" type="password" class="validate[required,confirm[password]] input" id="password2" value="" size="30" /></td>
					</tr>
					<tr>
						<td></td>
						<td><input name="submit" type="submit" id="submit" value="修改" class="button" /></td>
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
