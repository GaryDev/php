<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-blue.css" rel="stylesheet"  type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<link rel="stylesheet" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/css/validationEngine.jquery.css" type="text/css" />
<title>我的账户 - <?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>
<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px;">
  <tr>
    <td width="180" height="40" align="left" valign="top">
    	<?php echo $this->render('member-menu.php');?>
    </td>
    <td valign="top">
		<div class="nytit6"><h3>订单管理</h3></div>
		<div class="nytxt6 search">
			<div>
				<form id="searchForm" name="searchForm" class="searchForm" method="post" action="<?php echo $this->projectUrl();?>">
					订单状态：
					<select name="status" onchange="document.forms[0].submit();">
						<option value="">全部</option>
						<?php foreach($this->orderStatus as $key=>$value) {?>
						<option value="<?php echo $key?>" <?php echo $this->vars['status'] == $key ? ' selected' : ''; ?> ><?php echo $value?></option>
						<?php } ?>
					</select>
				</form>
			</div>
			<table width="100%" border="0" class="table">
				<tr class="subject line">
					<td align="left">订单号</td>
					<td>产品名称</td>
					<td>下单时间</td>
					<td>订单金额</td>
					<td>状态</td>
					<td align="center">操作</td>
				</tr>
				<?php
				foreach ($this->rows as $key=>$row) {
				?>
					<tr class="line">
						<td align="left"><?php echo $row['orderSN'];?></td>
						<td><a target="_blank" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'borrowing', 'action'=>'view', 'code'=>$row['borrowCode']));?>"><?php echo $row['title'];?></a></td>
						<td><?php echo date('Y-m-d H:i:s', $row['addTime']);?></td>
						<td><?php echo $row['orderAmount'];?></td>
						<td><?php echo $this->orderStatus[$row['status']];?></td>
						<td align="center">
						<?php if($row['status'] == 10) {?>
		                  <a href="#" class="link pay">付款</a>
		                  <a href="#" class="link cancel" orderId="<?php echo $row['orderSN'];?>">取消</a>
		                <?php } else if($row['status'] == 20) {?>
		                  <a href="#" class="link cession">转让</a>
		                <?php } ?>
						</td>
					</tr>
				<?php
				}
				?>
				</table>
				<?php
				if (count($this->rows) == 0) {
				?>
					<div class="nopage">暂无记录</div>
				<?php
				} else {
				?>
					<div class="page"><?php echo $this->pageString;?></div>
				<?php
				}
				?>
		</div>
	</td>
	</tr>
</table>

<?php echo $this->render('footer.php');?>

<script type="text/javascript">
	$(".cancel").click(function(){
		var orderNo = $(this).attr("orderId");
		if(confirm("是否取消订单[" + orderNo + "]?")) {
			document.forms[0].action = "<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'order', 'action'=>'cancel'));?>/orderNo/" + orderNo;
			document.forms[0].submit();
			return true;
		}
		return false;
	});
</script>

</body>
</html>
