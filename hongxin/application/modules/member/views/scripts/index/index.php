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

<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px;">
  <tr>
    <td width="180" height="40" align="left" valign="top">
    	<?php echo $this->render('member-menu.php');?>
    </td>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="40" class="bt_hs16">您好，尊敬的会员<span class="hsbfb"><?php echo $this->loginedUserName; ?></span>，欢迎来到会员中心！
        </td>
        </tr>
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dedede solid;background:#f3f3f3;">
          <tr>
            <td width="33%" height="100" align="left" valign="top" style="padding:20px; line-height:25px;">
	            <span class="bt_hs14">账号信息</span><br/>
			    <?php if($this->infoComplete == 'Y') {?>
			    	<!--  账户：18355529699 <br/> -->
				    <?php if($this->loginedUserType == 'C') { ?>
				    	法人姓名：<?php echo $this->memberEnterpriseRow['legalPersonName']; ?>
				    <?php } else if($this->loginedUserType == 'P') {?>
				    	用户姓名：<?php echo $this->memeberRow['name']; ?>
				    <?php }?>
				    &nbsp;&nbsp;<a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'index'));?>" class="nygl">[管理]</a><br/>
					联系方式：<?php echo substr_replace($this->memeberRow['mobile'], '****', 3, 4); ?><br/>
			    <?php } else {?>
			    	<br/><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'index'));?>" style="color: red;">请完善个人资料以便后续操作</a><br/>
			    <?php }?>
			    <?php if($this->loginedUserType == 'P') { ?>
			        投资中资金：<span class="bt_js12">0</span>元<br/>
			        预期投资收益：<span class="bt_js12">0</span>元<br/>
			    <?php }?>
			         账户余额：<span class="bt_js12">0.00</span>元
		    </td>
            <?php if($this->loginedUserType == 'P') { ?>
            <td width="66%" valign="top"  style="padding:20px; line-height:25px;">
            <span class="bt_hs14">我的投资</span><br/>
              	等待付款(<span class="bt_js12">0</span>) 付款成功(<span class="bt_js12">0</span>) 退款(<span class="bt_js12">0</span>) <br/>
              <br/>
              <span class="bt_hs14">债权转让</span><br/>
              	等待付款(<span class="bt_js12">0</span>) 付款成功(<span class="bt_js12">0</span>) 退款(<span class="bt_js12">0</span>) </td>
            <?php }?> 
            <?php if($this->loginedUserType == 'C') { ?>
            <td width="66%" align="left" valign="top" style="padding:20px; line-height:25px;">
            <span class="bt_hs14">企业融资</span><br/>
             	 等待付款(<span class="bt_js12">0</span>) 付款成功(<span class="bt_js12">0</span>) 退款(<span class="bt_js12">0</span>) <br/>
              <br/></td>
              <!--  
              <span class="bt_hs14">我的理财</span><br/>
              	等待付款(<span class="bt_js12">0</span>) 付款成功(<span class="bt_js12">0</span>) 退款(<span class="bt_js12">0</span>) </td>
              -->
             <?php }?>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="50"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dedede solid;background:#f3f3f3;">
          <tr>
            <td width="50%" height="30" align="right" class="bt_hs14">近期3笔订单交易</td>
            <td width="50%" align="right" style="padding-right:20px;"><a href="#">查看全部订单</a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="top">
        <form id="orderForm" name="orderForm" method="post" action="">
        <?php foreach ($this->orderRows as $orderRow) {?>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px; border-bottom:1px #e5e5e5 solid;">
          <tr>
            <td width="324" height="110">
            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="25" align="left">订单金额：<span class="bt_js12"><?php echo $orderRow['orderAmount']; ?></span>元</td>
                </tr>
                <tr>
                  <td height="25" align="left">订单号：<?php echo $orderRow['orderSN']; ?></td>
                </tr>
                <tr>
                  <td height="40" align="left">产品名称：<a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'borrowing', 'action'=>'view', 'code'=>$orderRow['borrowCode']));?>" class="nyls"><?php echo $orderRow['title']; ?></a></td>
                </tr>
                <tr>
                  <td height="25" align="left">下单时间：<?php echo date('Y-m-d H:i:s', $orderRow['addTime']); ?></td>
                </tr>
                <tr>
                  <td height="25" align="left">订单状态：<?php echo $orderRow['statusText']; ?></td>
                </tr>
            </table>
            </td>
            <td width="243" align="center" valign="middle">
            	<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
	                  <td height="25" align="left">预期收益：<span class="bt_js12"><?php echo $orderRow['benifit']; ?></span>元</td>
	                </tr>
	                <tr>
	                  <td height="25" align="left">
	                  	收益率：<span class="bt_js12"><?php echo $orderRow['yearInterestRate']; ?></span>%
	                  </td>
	                </tr>
	                <tr>
	                  <td height="25" align="left">融资期限：<span class="bt_js12"><?php echo $orderRow['deadline'];?></span>天</td>
	                </tr>
	                <tr>
	                  <td height="25" align="left">融资截止日期：<?php echo date('Y-m-d', $orderRow['endTime']);?></td>
	                </tr>
	                <tr>
	                  <td height="25" align="left">最迟起息日期：<?php echo date('Y-m-d', $orderRow['repayEndTime']);?></td>
	                </tr>
            	</table>
            </td>
            <td width="246">
            <table width="80%" border="0" align="right" cellpadding="3" cellspacing="0">
                <?php if($orderRow['status'] == 10) {?>
                <tr>
                  <td align="center"><input type="button" class="btn" name="goPay" value="付款" /></td>
                </tr>
                <tr>
                  <td align="center"><input type="button" class="btn" name="goCancel" value="取消" onclick="return doCancel('<?php echo $orderRow['orderSN']; ?>');" /></td>
                </tr>
                <?php } else if($orderRow['status'] == 20) {?>
                <tr>
                  <td align="center"><input type="button" class="btn" name="goCession" value="转让" /></td>
                </tr>
                <?php } ?>
            </table>
            </td>
            </tr>
        </table>
        </form>
        <?php } ?>
        <?php if(empty($this->orderRows)) {?>
        	<div style="text-align:center; line-height:40px;">暂无记录</div>
        <?php } ?>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
	function doCancel(orderNo)
	{
		if(confirm("是否取消订单[" + orderNo + "]?")) {
			document.forms[0].action = "<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'order', 'action'=>'cancel'));?>/orderNo/" + orderNo;
			document.forms[0].submit();
			return true;
		}
		return false;
	}
</script>
<?php echo $this->render('footer.php');?>
</body>
</html