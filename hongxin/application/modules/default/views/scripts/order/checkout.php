<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryColorbox/colorbox2.css" rel="stylesheet" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryColorbox/jquery.colorbox.js"></script>
<title><?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>

<div class="mainbox">
	<table width="1085" border="0" align="center" cellpadding="5" cellspacing="0" style="border:1px #dedede solid;margin-top: 10px;">
		<tr>
			<td>订单成功创建！</td>
		</tr>
		<tr>
			<td>请您在提交订单后25分钟内完成支付，否则订单会自动取消。</td>
		</tr>
	</table>
	<table width="1085" border="0" align="center" cellpadding="5" cellspacing="0" style="border:1px #dedede solid;margin-top: 10px;">
		<tr>
			<td width="40%" valign="top">
				<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0">
					<tr>
						<th>订单信息</th>
					</tr>
					<tr>
						<td>订单号：<?php echo $this->row['orderSN']; ?></td>
					</tr>
					<tr>
						<td>产品名称：<?php echo $this->row['title']; ?></td>
					</tr>
					<tr>
						<td>交易金额：<?php echo $this->row['orderAmount']; ?> 元</td>
					</tr>
					<tr>
						<td>预期收益：<?php echo $this->row['benifit']; ?> 元</td>
					</tr>
					<tr>
						<td>购买时间：<?php echo date('Y-m-d H:i:s', $this->row['addTime']); ?></td>
					</tr>
				</table>
			</td>
			<td width="60%" valign="top">
			<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0">
				<tr>
					<th colspan="2">投资人信息</th>
				</tr>
				<tr>
					<td width="25%">投资人姓名：</td>
					<td><?php echo $this->LoginedRow['userName']; ?></td>
				</tr>
				<tr>
					<td width="25%">投资人身份证号码：</td>
					<td><?php echo substr_replace($this->LoginedRow['idCardNumber'], '********' , 6, 8); ?></td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	<table width="1085" border="0" align="center" cellpadding="5" cellspacing="0" style="border:1px #dedede solid;margin-top: 10px;">
		<tr>
			<td>网银支付</td>
		</tr>
		<tr>
			<td align="center"><input type="button" class="btn" name="goPay" value="立即支付" /></td>
		</tr>
	</table>
</div>

<?php echo $this->render('footer.php');?>
</body>
</html>