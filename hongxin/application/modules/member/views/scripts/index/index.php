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
				    <?php if($this->loginedUserType == 'E') { ?>
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
            <?php if($this->loginedUserType == 'E') { ?>
            <td width="66%" align="left" valign="top" style="padding:20px; line-height:25px;">
            <span class="bt_hs14">企业融资</span><br/>
             	 等待付款(<span class="bt_js12">0</span>) 付款成功(<span class="bt_js12">0</span>) 退款(<span class="bt_js12">0</span>) <br/>
              <br/>
              <span class="bt_hs14">我的理财</span><br/>
              	等待付款(<span class="bt_js12">0</span>) 付款成功(<span class="bt_js12">0</span>) 退款(<span class="bt_js12">0</span>) </td>
             <?php }?>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="50"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dedede solid;background:#f3f3f3;">
          <tr>
            <td width="50%" height="30" align="right" class="bt_hs14">近期交易</td>
            <td width="50%" align="right" style="padding-right:20px;"><a href="#">查看全部订单</a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px; border-bottom:1px #e5e5e5 solid;">
          <tr>
            <td width="92"><a href="#" class="ny_img"><img src="/files/default/images/tu.jpg" width="90" height="90"></a></td>
            <td width="324" height="110"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="40" align="left"><a href="#" class="nyls">稳健盈家KF01号第122期预约365天型</a></td>
                </tr>
                <tr>
                  <td height="25" align="left" class="bt_js12">起始金额：￥5万</td>
                </tr>
                <tr>
                  <td height="25" align="left" class="box_hs">开发银行：中国工商银行</td>
                </tr>
            </table></td>
            <td width="243" align="center" valign="middle">收益率：<span class="hsbfb1"></span><span class="ny_bfb">12.3%</span> 收益类型：保息固定</td>
            <td width="246"><table width="80%" border="0" align="right" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="25" align="left">风险等级：极低-R1</td>
                </tr>
                <tr>
                  <td height="25" align="left">发行起始日：2014-05-13</td>
                </tr>
                <tr>
                  <td height="25" align="left" class="box_hs">发行截止日：2014-05-19</td>
                </tr>
            </table></td>
            </tr>
        </table>
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px; border-bottom:1px #e5e5e5 solid;">
            <tr>
              <td width="92"><a href="#" class="ny_img"><img src="/files/default/images/tu.jpg" width="90" height="90"></a></td>
              <td width="324" height="110"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="40" align="left"><a href="#" class="nyls">稳健盈家KF01号第122期预约365天型</a></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" class="bt_js12">起始金额：￥5万</td>
                  </tr>
                  <tr>
                    <td height="25" align="left" class="box_hs">开发银行：中国工商银行</td>
                  </tr>
              </table></td>
              <td width="243" align="center" valign="middle">收益率：<span class="hsbfb1"></span><span class="ny_bfb">12.3%</span> 收益类型：保息固定</td>
              <td width="246"><table width="80%" border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="25" align="left">风险等级：极低-R1</td>
                  </tr>
                  <tr>
                    <td height="25" align="left">发行起始日：2014-05-13</td>
                  </tr>
                  <tr>
                    <td height="25" align="left" class="box_hs">发行截止日：2014-05-19</td>
                  </tr>
              </table></td>
            </tr>
          </table>
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px; border-bottom:1px #e5e5e5 solid;">
            <tr>
              <td width="92"><a href="#" class="ny_img"><img src="/files/default/images/tu.jpg" width="90" height="90"></a></td>
              <td width="324" height="110"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="40" align="left"><a href="#" class="nyls">稳健盈家KF01号第122期预约365天型</a></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" class="bt_js12">起始金额：￥5万</td>
                  </tr>
                  <tr>
                    <td height="25" align="left" class="box_hs">开发银行：中国工商银行</td>
                  </tr>
              </table></td>
              <td width="243" align="center" valign="middle">收益率：<span class="hsbfb1"></span><span class="ny_bfb">12.3%</span> 收益类型：保息固定</td>
              <td width="246"><table width="80%" border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="25" align="left">风险等级：极低-R1</td>
                  </tr>
                  <tr>
                    <td height="25" align="left">发行起始日：2014-05-13</td>
                  </tr>
                  <tr>
                    <td height="25" align="left" class="box_hs">发行截止日：2014-05-19</td>
                  </tr>
              </table></td>
            </tr>
          </table>
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px; border-bottom:1px #e5e5e5 solid;">
            <tr>
              <td width="92"><a href="#" class="ny_img"><img src="/files/default/images/tu.jpg" width="90" height="90"></a></td>
              <td width="324" height="110"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="40" align="left"><a href="#" class="nyls">稳健盈家KF01号第122期预约365天型</a></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" class="bt_js12">起始金额：￥5万</td>
                  </tr>
                  <tr>
                    <td height="25" align="left" class="box_hs">开发银行：中国工商银行</td>
                  </tr>
              </table></td>
              <td width="243" align="center" valign="middle">收益率：<span class="hsbfb1"></span><span class="ny_bfb">12.3%</span> 收益类型：保息固定</td>
              <td width="246"><table width="80%" border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="25" align="left">风险等级：极低-R1</td>
                  </tr>
                  <tr>
                    <td height="25" align="left">发行起始日：2014-05-13</td>
                  </tr>
                  <tr>
                    <td height="25" align="left" class="box_hs">发行截止日：2014-05-19</td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
      </tr>
      
      
    </table></td>
  </tr>
</table>

<?php echo $this->render('footer.php');?>
</body>
</html>