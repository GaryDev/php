<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryLayer/layer.min.js"></script>
<title><?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>

<form id="paymentForm" name="paymentForm" method="post" action="<?php echo $this->ysburl; ?>" target="_blank">
<div class="mainbox">
	<table width="1085" border="0" align="center" cellpadding="5" cellspacing="0" style="border:1px #dedede solid;margin-top: 10px;">
		<tr>
			<td>订单成功创建！</td>
		</tr>
		<tr>
			<td>请您在提交订单后25分钟内完成资金冻结，否则订单会自动取消。</td>
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
		<!--  
		<tr>
			<td>网银支付</td>
		</tr>
		-->
		<tr>
			<td align="center"><input type="submit" class="btn" id="goPay" name="goPay" value="资金冻结" /></td>
		</tr>
	</table>
</div>
<?php foreach ($this->params as $n=>$p): ?>
	<?php //if(!in_array($n, array('name', 'idNum'))): ?>
		<input type="hidden" name="<?php echo $n; ?>" value="<?php echo $p; ?>" />
	<?php //endif; ?>
<?php endforeach; ?>
</form>

<div id="divComplete" style="width:350px; padding-left: 50px; padding-top: 50px; display:none;">
	<table width="100%" border="0" cellpadding="10" cellspacing="0" class="table">
		<tr height="50">
			<td style="font-size: 20px" align="center">操作完成前请勿关闭此窗口</td>
		</tr>
		<tr height="50">
			<td align="center"><input id="notifyBtn" type="button" value="已完成操作" class="button" /></td>
		</tr>
	</table>
</div>

<script type="text/javascript">
	$("#goPay").click(function(){
		popupWindow("资金冻结", "#divComplete");
		$(".xubox_close").hide();
		$("#paymentForm").submit();
		return false;
	});

	$("#notifyBtn").click(function(){
		var frm = $("#paymentForm")[0];
		frm.action = '<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'order', 'action'=>'payment'));?>';
		frm.target = "_self";
		frm.submit();
	});
</script>

<?php echo $this->render('footer.php');?>
</body>
</html>