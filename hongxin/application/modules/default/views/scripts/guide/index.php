<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<title><?php echo $this->menuTitle;?> - <?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
<script type="text/javascript">
    function switchTab(ProTag, ProBox) {
        for (i = 1; i < 3; i++) {
            if ("tab" + i == ProTag) {
                document.getElementById(ProTag).getElementsByTagName("a")[0].className = "on";
            } else {
                document.getElementById("tab" + i).getElementsByTagName("a")[0].className = "";
            }
            if ("con" + i == ProBox) {
                document.getElementById(ProBox).style.display = "";
            } else {
                document.getElementById("con" + i).style.display = "none";
            }
        }
    }
</script>
<style type="text/css">
    #tabContainer
    {
        margin: 15px 5px 5px 30px;
    	padding-top: 3px;
    }
    #tabContainer li
    {
        float: left;
        width: 200px;
        margin: 0 3px;
        background: #efefef;
        text-align: center;
    }
    #tabContainer a
    {
        display: block;
    	font-size: 15px;
    	line-height: 30px;
    }
    #tabContainer a.on
    {
        background: #30318B;
    	color: #ffffff;
    }
</style>
</head>

<body>
<?php echo $this->render('top.php');?>

<div id="tabContainer" style="width: 1200px;">
	<ul>
      <li id="tab1" style="margin-left: 75px;"><a href="#" class="on" onclick="switchTab('tab1','con1');this.blur();return false;">融资指引</a></li>
      <li id="tab2"><a href="#" onclick="switchTab('tab2','con2');this.blur();return false;">投资指引</a></li>
    </ul>
	<div style="clear: both" />
	
	<div id="con1" style="width: 1090px; margin: 45px 5px 5px 45px; padding-left: 26px;">
	<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#f3f3f3; border:1px #dedede solid;">
	  <tr>
	    <td height="400"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	      <tr>
	        <td width="50%" valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0">
	          <tr>
	            <td align="left"><img src="/files/default/images/zy_1bt.jpg" width="205" height="66"></td>
	            </tr>
	          <tr>
	            <td align="left" class="xszy_nr">赋银财富是目前中国互联网金融中P2P信贷行业的领军企业，是一个以个人对个人小额借贷为主要产品，为借贷两端搭建的公平、透明、安全、高效的互联网金融服务平台。借款用户可以在人人贷上获得信用评级、发布借款请求来实现个人快捷的融资需要；理财用户可以把自己的部分闲余资金通过人人贷平台出借<br>
	              给信用良好有资金需求的个人，在获得有保障，高收益的理财回报的同时帮助了优质的借款人。</td>
	          </tr>
	          
	        </table></td>
	        <td width="50%"><img src="/files/default/images/zy_1.jpg" width="514" height="332"></td>
	        </tr>
	    </table></td>
	  </tr>
	</table>
	<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:20px; background:#f3f3f3; border:1px #dedede solid;">
	  <tr>
	    <td height="500"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	      <tr>
	        <td valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0">
	          <tr>
	            <td align="left"><img src="/files/default/images/zy_2bt.jpg" width="208" height="65"></td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">无须任何抵押、担保，低门槛，纯信用借款</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">人人贷为借款人提供纯信用借款，无须任何抵押或担保，只需要提供必要申请材料并通过审核，即可获得最高50万的借款额度。</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">用户自主选择产品</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">人人贷面向各类借款用户，设计了工薪贷、生意贷、网商贷三种产品，用户可以根据自身情况选择适合的借款产品。</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">全程在线操作，最便捷的借款方式</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">无需出门，提交材料、审核、放款全程互联网操作，键盘加鼠标轻松搞定，7*24的互联网金融服务。</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">最安全的平台保障</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">我们采用业界最先进的加密技术，对您的注册信息、账户信息进行加密处理，人人贷绝不会以任何形式将这些信息透露给第三方。</td>
	          </tr>
	        </table></td>
	        <td width="514" align="center"><img src="/files/default/images/zy_2.jpg" width="405" height="397"></td>
	      </tr>
	    </table></td>
	  </tr>
	</table>
	<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:20px; background:#f3f3f3; border:1px #dedede solid;">
	  <tr>
	    <td height="350"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	      <tr>
	        <td valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0">
	          <tr>
	            <td align="left"><img src="/files/default/images/zy_3bt.jpg" width="206" height="62"></td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">轻松借款，只需4步</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">第一步 注册成为人人贷用户，完成身份认证<br>
	              第二步 选择借款产品发起申请<br>
	              第三步 上传必要申请材料<br>
	              第四步 通过审核后开始筹标<br>
	              满标后，借款完成立刻放款，之后您只需每月还款即可</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt"><a href="#"><img src="/files/default/images/zy_3go.jpg" width="165" height="46"></a></td>
	          </tr>
	        </table></td>
	        <td width="514" align="center"><img src="/files/default/images/zy_3.jpg" width="685" height="211"></td>
	      </tr>
	    </table></td>
	  </tr>
	</table>
	<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:20px; background:#f3f3f3; border:1px #dedede solid;">
	  <tr>
	    <td height="420"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	      <tr>
	        <td valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0">
	          <tr>
	            <td align="left"><img src="/files/default/images/zy_4bt.jpg" width="205" height="61"/></td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">工薪贷</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">工薪贷是人人贷为工薪阶层量身定制的一款借款产品。帮助您满足装修，买车以及个人消费等需求，提高生活品质。</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt"><a href="#" class="xszy_bt">生意贷</a></td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">生意贷是人人贷为私营业主打造的一款借款产品。相比银行贷款产品，它有申请方便，门槛低，借款审核和筹款周期短等特点。帮助您的公司解决燃眉之急。<br/></td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">网商贷</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">网商贷是人人贷为淘宝，天猫，京东等网商专门定制的一款借款产品。网商贷无需上传过多的申请材料，使您足不出户就能得到周转资金。</td>
	          </tr>
	        </table></td>
	        <td width="514" align="center"><img src="/files/default/images/zy_4.jpg" width="403" height="317" /></td>
	      </tr>
	    </table></td>
	  </tr>
	</table>
	</div>
	
	<div id="con2" style="width: 1090px; margin: 45px 5px 5px 45px; padding-left: 26px; display:none;">
	<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#f3f3f3; border:1px #dedede solid;">
	  <tr>
	    <td height="400"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	      <tr>
	        <td width="50%" valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0">
	          <tr>
	            <td align="left"><img src="/files/default/images/zy_1bt.jpg" width="205" height="66"></td>
	            </tr>
	          <tr>
	            <td align="left" class="xszy_nr">赋银财富是目前中国互联网金融中P2P信贷行业的领军企业，是一个以个人对个人小额借贷为主要产品，为借贷两端搭建的公平、透明、安全、高效的互联网金融服务平台。借款用户可以在人人贷上获得信用评级、发布借款请求来实现个人快捷的融资需要；理财用户可以把自己的部分闲余资金通过人人贷平台出借<br>
	              给信用良好有资金需求的个人，在获得有保障，高收益的理财回报的同时帮助了优质的借款人。</td>
	          </tr>
	        </table></td>
	        <td width="50%"><img src="/files/default/images/zy_1.jpg" width="514" height="332"></td>
	        </tr>
	    </table></td>
	  </tr>
	</table>
	<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:20px; background:#f3f3f3; border:1px #dedede solid;">
	  <tr>
	    <td height="550"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	      <tr>
	        <td valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0">
	          <tr>
	            <td align="left"><img src="/files/default/images/zy_2bt.jpg" width="208" height="65"></td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">无须任何抵押、担保，低门槛，纯信用借款</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">人人贷为借款人提供纯信用借款，无须任何抵押或担保，只需要提供必要申请材料并通过审核，即可获得最高50万的借款额度。</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">用户自主选择产品</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">人人贷面向各类借款用户，设计了工薪贷、生意贷、网商贷三种产品，用户可以根据自身情况选择适合的借款产品。</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">全程在线操作，最便捷的借款方式</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">无需出门，提交材料、审核、放款全程互联网操作，键盘加鼠标轻松搞定，7*24的互联网金融服务。</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">最安全的平台保障</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">我们采用业界最先进的加密技术，对您的注册信息、账户信息进行加密处理，人人贷绝不会以任何形式将这些信息透露给第三方。</td>
	          </tr>
	        </table></td>
	        <td width="514" align="center"><img src="/files/default/images/tz_2.jpg" width="524" height="513"></td>
	      </tr>
	    </table></td>
	  </tr>
	</table>
	<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:20px; background:#f3f3f3; border:1px #dedede solid;">
	  <tr>
	    <td height="350"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	      <tr>
	        <td valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0">
	          <tr>
	            <td align="left"><img src="/files/default/images/tz_3bt.jpg" width="206" height="63"></td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">轻松借款，只需4步</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">第一步 注册成为人人贷用户，完成身份认证<br>
	              第二步 选择借款产品发起申请<br>
	              第三步 上传必要申请材料<br>
	              第四步 通过审核后开始筹标<br>
	              满标后，借款完成立刻放款，之后您只需每月还款即可</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt"><a href="#"><img src="/files/default/images/tz_3go.jpg" width="161" height="46"></a></td>
	          </tr>
	        </table></td>
	        <td width="514" align="center"><img src="/files/default/images/tz_3.jpg" width="540" height="218"></td>
	      </tr>
	    </table></td>
	  </tr>
	</table>
	<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:20px; background:#f3f3f3; border:1px #dedede solid;">
	  <tr>
	    <td height="420"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	      <tr>
	        <td valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0">
	          <tr>
	            <td align="left"><img src="/files/default/images/tz_4bt.jpg" width="203" height="61"></td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">工薪贷</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">工薪贷是人人贷为工薪阶层量身定制的一款借款产品。帮助您满足装修，买车以及个人消费等需求，提高生活品质。</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt"><a href="#" class="xszy_bt">生意贷</a></td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">生意贷是人人贷为私营业主打造的一款借款产品。相比银行贷款产品，它有申请方便，门槛低，借款审核和筹款周期短等特点。帮助您的公司解决燃眉之急。<br></td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">网商贷</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">网商贷是人人贷为淘宝，天猫，京东等网商专门定制的一款借款产品。网商贷无需上传过多的申请材料，使您足不出户就能得到周转资金。</td>
	          </tr>
	        </table></td>
	        <td width="514" align="center"><img src="/files/default/images/tz_4.jpg" width="408" height="329"></td>
	      </tr>
	    </table></td>
	  </tr>
	</table>
	</div>
	
</div>
<?php echo $this->render('footer.php');?>
</body>
</html>