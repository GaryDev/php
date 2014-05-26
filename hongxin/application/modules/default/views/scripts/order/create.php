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

<form method="post">


<table width="1085" border="0" align="center" cellpadding="10" cellspacing="0" style="border:1px #dedede solid;margin-top: 10px;">
	<tr>
		<td>填写并核对订单信息</td>
	</tr>
</table>

<table width="1085" border="0" align="center" cellpadding="10" cellspacing="0" style="border:1px #dedede solid;margin-top: 10px;">
	<tr>
		<td width="70%" valign="top">
			<table width="90%" border="0" align="center" cellpadding="10" cellspacing="0" style="border:1px #dedede solid;margin-top: 10px;">
				<tr>
					<th colspan="2">购买份数</th>
				</tr>
				<tr>
					<td width="15%">当前购买份额</td>
					<td><input type="text" name="orderQty" />份</td>
				</tr>
			</table>
			<table width="90%" border="0" align="center" cellpadding="10" cellspacing="0" style="border:1px #dedede solid;margin-top: 10px;">
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
			<table width="90%" border="0" align="center" cellpadding="10" cellspacing="0" style="margin-top: 10px;">
				<tr>
					<td align="center"><input type="submit" class="btn" name="goBuyBtn" value="提交订单" /></td>
				</tr>
			</table>
		</td>
		<td width="30%" valign="top">
			<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0">
    		<tr>
    			<td><span class="nyls"><?php echo $this->row['title']; ?></span></td>
    		</tr>
    		<tr>
    			<td>产品编号：<?php echo $this->row['code'];?></td>
    		</tr>
    		<tr>
    			<td>融资金额：<label><?php echo $this->row['amount'] / 10000;?></label>万</td>
    		</tr>
    		<tr>
    			<td>年化收益：<label><?php echo $this->row['yearInterestRate']; ?></label>%</td>
    		</tr>
    		<tr>
    			<td>项目期限：<label><?php echo $this->row['deadline'];?></label>天</td>
    		</tr>
    		<tr>
    			<td>投资单位：<label><?php echo $this->row['borrowUnit'];?></label>元/份</td>
    		</tr>
    		<tr>
    			<td>最小投资份数：<label><?php echo $this->row['amountMinUnit'];?></label>份</td>
    		</tr>
    		<tr>
    			<td>最大投资份数：<label><?php echo $this->row['amountMaxUnit'];?></label>份</td>
    		</tr>
    		<tr>
    			<td>募集开始时间：<?php echo date('Y-m-d', $this->row['startTime']);?></td>
    		</tr>
    		<tr>
    			<td>募集截止时间：<?php echo date('Y-m-d',$this->row['endTime']);?></td>
    		</tr>
    		<tr>
    			<td>项目到期时间：<?php echo date('Y-m-d',$this->row['ticketEndTime']);?></td>
    		</tr>
    		<tr>
    			<td>最迟还款日期：<?php echo date('Y-m-d',$this->row['repayEndTime']);?></td>
    		</tr>
    	</table>
		</td>
	</tr>
</table>

</form>

</div>

<?php echo $this->render('footer.php');?>
</body>
</html>