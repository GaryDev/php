<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryLayer/layer.min.js"></script>
<link href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryUI/redmond/jquery-ui-1.10.4.custom.min.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryUI/jquery-ui-1.10.4.custom.min.js"></script>
<title><?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
<script>
	$(function() {
		var orderUnit = <?php echo $this->row['borrowUnit'];?>;
		var yearRate = <?php echo $this->row['yearInterestRate']; ?>;
		var benifitDay = <?php echo $this->benifitDay;?>;
		var conf = {
			range: "min",
			min: 1,
			max: parseInt($("#remaining").html()),
			value: 1,
			step: 1,
			slide: function( event, ui ) {
				$( "#orderQty" ).val( ui.value );
				calculate(parseInt(ui.value));
			}
		};
		$( "#slider" ).slider(conf);
		
		$("#orderQty").change(function(){
			var value = this.value;
			$("#slider").slider("value", parseInt(value));
			calculate(parseInt(value));
		});

		$("button").button({
			icons: {
				primary: "ui-icon-arrowrefresh-1-e"
			}
		}).click(function(){
			var $this = $(this);
			$this.attr("disabled", true);
			checkQty(function(data){
				$("#remaining").html(data);
				$this.attr("disabled", false);
			});
			return false;
		});

		$("#orderForm").submit(function(){
			var valid = checkQty(function(data){
				if(data < 1) {
					layer.msg("剩余份额已不足", 2, 5);
					return false;
				}
				return true;
			});
			return valid;
		});

		function calculate(qty) {
			var amount = orderUnit * qty;
			var benifit = amount * (yearRate/100) * (benifitDay/365);
			benifit = Math.round(benifit*100)/100;
			$("#amount").html(amount.toString());
			$("#benifit").html(benifit.toString());
		}

		function checkQty(callback)
		{
			var url = '<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'borrowing', 'action'=>'get-qty'));?>' + '?rand=' + Math.random();
			$.ajax({
				type: "POST",
				url: url,
				data: "code=" + $("#code").html(),
				async: false,
				success: callback
			});
		}
		
		calculate(1);
	});
</script>
</head>

<body>
<?php echo $this->render('top.php');?>

<div class="mainbox">

<form method="post" id="orderForm">


<table width="1085" border="0" align="center" cellpadding="10" cellspacing="0" style="border:1px #dedede solid;margin-top: 10px;">
	<tr>
		<td>填写并核对订单信息</td>
	</tr>
</table>

<table width="1085" border="0" align="center" cellpadding="10" cellspacing="0" style="border:1px #dedede solid;margin-top: 10px;">
	<tr>
		<td width="70%" valign="top">
			<table class="order-info" width="90%" border="0" align="center" cellpadding="10" cellspacing="0" style="border:1px #dedede solid;margin-top: 10px;">
				<tr>
					<th>购买份数</th>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="15%">当前购买份额</td>
					<td width="55%"><div id="slider"></div></td>
					<td><input type="text" id="orderQty" name="orderQty" value="1" style="text-align: right; width: 60px;" />份</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2">投资金额: <label id="amount"></label>元</td>
					<td colspan="2">预计收益: <label id="benifit"></label>元</td>
				</tr>
				<tr>
					<td colspan="2">剩余投资份数: <label id="remaining"><?php echo $this->row['amountUnit'];?></label>份&nbsp;<button>刷新</button></td>
					<td colspan="2">最大投资份数: <label><?php echo $this->row['amountMaxUnit'];?></label>份</td>
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
					<td align="center"><input type="submit" class="btn" name="goBuyBtn" id="goBuyBtn" value="提交订单" /></td>
				</tr>
			</table>
		</td>
		<td width="30%" valign="top">
			<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0">
    		<tr>
    			<td><span class="nyls"><?php echo $this->row['title']; ?></span></td>
    		</tr>
    		<tr>
    			<td>产品编号：<label id="code"><?php echo $this->row['code'];?></label></td>
    		</tr>
    		<tr>
    			<td>融资金额：<label><?php echo number_format($this->row['amount']);?></label>元</td>
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