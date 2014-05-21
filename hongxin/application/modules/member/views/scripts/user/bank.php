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
		<h3>银行账号</h3></div>
		<div class="nytxt6 search">
			<form id="userForm" name="userForm" method="post" action="">
				<table width="100%" border="0" class="table">
					
					<tr>
						<td align="left">持卡人：</td>
						<td align="left" class="dataLine"><?php echo $this->row['name'];?></td>
					</tr>
					<tr>
						<td align="left">银行名称：</td>
						<td><select name="bankType" id="bankType">
								<option value="">选择</option>
								<?php
foreach($this->bankTypes as $bank) {
?>
								<option value="<?php echo $bank;?>" <?php echo $this->row['bankType'] == $bank ? ' selected' : '';?>><?php echo $bank;?></option>
								<?php
}
?>
							</select>						</td>
					</tr>
					<tr>
						<td align="left">开户支行：</td>
						<td><input name="bankSubbranch" type="text" class="input" id="bankSubbranch" size="40" value="<?php echo htmlspecialchars($this->row['bankSubbranch']);?>" /></td>
					</tr>
					<tr>
						<td align="left">银行帐号：</td>
						<td><input name="bankAccount" type="text" class="input" id="bankAccount" size="40" value="<?php echo htmlspecialchars($this->row['bankAccount']);?>" /></td>
					</tr>

					<tr>
						<td align="left">审核状态：</td>
					<td align="left" class="dataLine">
								<label>
								<input type="radio" name="bankStatus" id="bankStatus1" value="1" <?php echo $this->row['bankStatus'] == 1 ? ' checked' : '';?> disabled="disabled"/>
								未提交</label>
									<label>
									<input type="radio" name="bankStatus" id="bankStatus2" value="2" <?php echo $this->row['bankStatus'] == 2 ? ' checked' : '';?> disabled="disabled"/>
										待审核</label>
									<label>
									<input type="radio" name="bankStatus" id="bankStatus3" value="3" <?php echo $this->row['bankStatus'] == 3 ? ' checked' : '';?> disabled="disabled"/>
										已审核通过</label>
									<label>
									<input type="radio" name="bankStatus" id="bankStatus4" value="4" <?php echo $this->row['bankStatus'] == 4 ? ' checked' : '';?> disabled="disabled"/>
										已审核未通过</label>
						</td>
					</tr>
					<tr>
						<td align="left">&nbsp;</td>
						<td align="left" class="dataLine"><input type="submit" name="button" id="button" value="提交" class="button" /></td>
					</tr>
				</table>
			</form>
		</div>
		
	</div>
</div>
<div class="cl"></div>

<?php echo $this->render('footer.php');?>
<script language="javascript">
<?php 
if ($this->row['bankStatus'] == 2 || $this->row['bankStatus'] == 3) {
?>
$("#userForm").find('input').attr('disabled', true);
<?php
}
?>
</script>
</body>
</html>
