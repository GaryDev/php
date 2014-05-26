<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/style.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<title><?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>

<div class="mainbox">
<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dedede solid; border-top:none; background:#f3f3f3; border-bottom:1px #888888 solid; position:relative;">
  <tr>
    <td>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border-bottom:1px #d2d2d2 solid;">
        <tr>
          <td width="150" height="45" align="right" class="bt_hs12">到期承诺还款银行：</td>
          <td><a href="#" class="xz">不限</a>
          <?php foreach ($this->banks as $bank) {?>
			<a href="#" class="xz"><?php echo $bank; ?></a>
		  <?php } ?>
		  </td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border-bottom:1px #d2d2d2 solid;">
        <tr>
          <td width="150" height="45" align="right" class="bt_hs12">融资期限：</td>
          <td><a href="#" class="xz">不限</a>      <a href="#" class="xz">30天以内</a>      <a href="#" class="xz">30-90天</a>      <a href="#" class="xz">90-180天</a>      <a href="#" class="xz">180-365天</a>      <a href="#" class="xz">365天以上 </a></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border-bottom:1px #d2d2d2 solid;">
        <tr>
          <td width="150" height="45" align="right" class="bt_hs12">预期年收益率：</td>
          <td><a href="#" class="xz">不限</a>      <a href="#" class="xz">5%以下</a>      <a href="#" class="xz">5%-10%</a>      <a href="#" class="xz">10%以上</a> </td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="150" height="45" align="right" class="bt_hs12">融资金额：</td>
          <td><a href="#" class="xz">不限</a>      <a href="#" class="xz">10万以下</a>      <a href="#" class="xz">10-30万</a>      <a href="#" class="xz">30-50万</a>      <a href="#" class="xz">50-100万</a>      <a href="#" class="xz">100万以上</a></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</div>
<div class="cl"></div>

<div class="mainbox">
<?php
foreach($this->rows as $row) {
?>
<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px; border-bottom:1px #e5e5e5 solid;">
  <tr>
    <td width="10" style="text-align: center;">
    <a href="#" class="ny_img"><img src="/files/default/images/product-avatar.png" width="90" height="90" /></a>
    </td>
    <td width="200" height="110"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="40" align="left">
        <a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'borrowing', 'action'=>'view', 'code'=>$row['code']));?>" title="<?php echo $row['title'];?>" class="nyls"><?php echo substrMoreCn($row['title'], 36);?></a>
        	(编号：<?php echo $row['code'];?>)
        </td>
        </tr>
      <tr>
        <td height="25" align="left" class="bt_js12">融资金额：<span class="ny_bfb"><?php echo $row['amount'] / 10000;?></span>万&nbsp;(单位：<span class="ny_bfb"><?php echo $row['borrowUnit'];?></span>元/份)</td>
        </tr>
      <tr>
        <td height="25" align="left" class="box_hs">到期由<font style="color: red;"><?php echo $row['repaymentBank'];?></font>无条件兑付</td>
        </tr>
    </table></td>
    <td width="150" align="center">预期年收益率：<span class="hsbfb1"></span><span class="ny_bfb"><?php echo $row['yearInterestRate'];?>%</span></td>
    <td width="160"><table width="80%" border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td height="25" align="left">融资期限：<?php echo $row['deadline'];?>天</td>
      </tr>
      <tr>
        <td height="25" align="left">票据截止日期：<?php echo date('Y-m-d', $row['ticketEndTime']);?></td>
      </tr>
      <tr>
        <td height="25" align="left" class="box_hs">最迟还款日期：<?php echo date('Y-m-d', $row['repayEndTime']);?></td>
      </tr>
    </table></td>
    <td width="200">
    <table width="104" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td align="center"><input type="button" class="btn" name="goBuyBtn" value="立即投资" 
        	onclick='window.location.href = "<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'borrowing', 'action'=>'view', 'code'=>$row['code']));?>";' /></td>
      </tr>
      <tr>
        <td align="center">已投<span class="ny_bfb">49401</span>份</td>
      </tr>
      <tr>
        <td align="left">
           <div class="barbox">
				<div class="bartext">85%</div>
    			<div class="progressbar">
				    <div class="green" style="width: 85%;">
				        <span></span>
				    </div>
				</div>
			</div>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
<?php } ?>

<?php
if (empty($this->rows)) {
?>
	<div style="text-align:center; line-height:40px;">暂无记录</div>
<?php
} else {
?>
		<div class="page">
			<?php echo $this->pageString;?>
		</div>
<?php
}
?>

</div>

<?php echo $this->render('footer.php');?>
</body>
</html>