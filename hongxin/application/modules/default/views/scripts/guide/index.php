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
        /*background: #efefef;*/
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
        /*background: #30318B;*/
    	/*color: #ffffff;*/
    	border-bottom: 1px solid #000000;
    }
</style>
</head>

<body>
<?php echo $this->render('top.php');?>

<div id="tabContainer" style="width: 1200px;">
	<ul>
      <li id="tab1" style="margin-left: 60px;"><a href="#" class="on" onclick="switchTab('tab1','con1');this.blur();return false;">个人投资</a></li>
      <li id="tab2"><a href="#" onclick="switchTab('tab2','con2');this.blur();return false;">企业融资</a></li>
    </ul>
	<div style="clear: both" />

	<div id="con1" style="width: 1090px; margin: 45px 5px 5px 45px; padding-left: 11px;">
	<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#f3f3f3; border:1px #dedede solid;">
	  <tr>
	    <td height="400"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	      <tr>
	        <td width="50%" valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0">
	          <tr>
	            <td align="left"><span style="font-size:25px;">1. 鉴丰财富是什么？</span></td>
	          </tr>
	          <tr>
	            <td align="left">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">鉴丰财富是目前中国互联网金融中专做票据理财业务的专家行业的领头羊，是一个以个人对企业小额借贷为主要产品，利用银行承兑汇票为担保物主体，为借贷两端搭建的公平，透明，安全，高效的互联网金融服务平台。企业融资用户可以在鉴丰财富上以银行承兑汇票为质押，发布借款请求来实现企业快捷的融资需求；个人投资用户可以把自己的部分闲余资金通过鉴丰财富平台出借给以银行承兑汇票来未担保的有资金需求的企业，在获得有保障，高收益的理财回报的同时帮助的优质的融资企业，努力实现国家提出的“发展普惠金融，鼓励金融创新，丰富金融市场层次和产品”这一宏伟目标。</td>
	          </tr>
	          
	        </table></td>
	        <td width="50%"><img src="/files/default/images/zy_geren.png"></td>
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
	            <td align="left"><span style="font-size:25px;">2. 为什么选择鉴丰财富？</span></td>
	          </tr>
	          <tr>
	            <td align="left">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">最安全</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">每个交易细节都是从投资人角度考虑资金安全制度设计。从投资人开始投资开始到资金本息安全回笼，每一环节都有多重风险防控设计。</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">高收益</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">年化收益6到10%，满标次日立即生息。</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">低门槛</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">100元起投。</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">易变现</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">交易系统支持投资人T+1再转让手中债权，自主定价转让保证资金流动性高。</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">易操作</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">每个交易环节都在保证资金安全的前提下，以用户体验的角度去简化设计交易环节，让用户安心轻松理财。</td>
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
	            <td align="left"><span style="font-size:25px;">3. 便捷快速，轻松理财</span></td>
	          </tr>
	          <tr>
	            <td align="left">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">简单3步，实现财富增值</td>
	          </tr>
	          <tr>
	            <td align="left">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">第一步，注册用户，完成身份认证<br>
			              第二步，选择要投资的产品<br>
			              第三步，账户充值，投资产品</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt"><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'borrowing', 'action'=>'index'));?>"><img src="/files/default/images/tz_3go.jpg" width="165" height="46"></a></td>
	          </tr>
	        </table></td>
	        <td width="514" align="center"><img src="/files/default/images/tz_3.jpg"></td>
	      </tr>
	    </table></td>
	  </tr>
	</table>
	</div>

	<div id="con2" style="width: 1090px; margin: 45px 5px 5px 45px; padding-left: 11px; display:none;">
	<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#f3f3f3; border:1px #dedede solid;">
	  <tr>
	    <td height="400"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	      <tr>
	        <td width="50%" valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0">
	          <tr>
	            <td align="left"><span style="font-size:25px;">1. 鉴丰财富是什么？</span></td>
	          </tr>
	          <tr>
	            <td align="left">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">鉴丰财富是目前中国互联网金融中专做票据理财业务的专家行业的领头羊，是一个以个人对企业小额借贷为主要产品，利用银行承兑汇票为担保物主体，为借贷两端搭建的公平，透明，安全，高效的互联网金融服务平台。企业融资用户可以在鉴丰财富上以银行承兑汇票为质押，发布借款请求来实现企业快捷的融资需求；个人投资用户可以把自己的部分闲余资金通过鉴丰财富平台出借给以银行承兑汇票来未担保的有资金需求的企业，在获得有保障，高收益的理财回报的同时帮助的优质的融资企业，努力实现国家提出的“发展普惠金融，鼓励金融创新，丰富金融市场层次和产品”这一宏伟目标。</td>
	          </tr>
	          
	        </table></td>
	        <td width="50%"><img src="/files/default/images/zy_qiye.png"></td>
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
	            <td align="left"><span style="font-size:25px;">2. 为什么选择鉴丰财富？</span></td>
	          </tr>
	          <tr>
	            <td align="left">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">最安全</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">每个交易细节都是从投资人角度考虑资金安全制度设计。从投资人开始投资开始到资金本息安全回笼，每一环节都有多重风险防控设计。</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">高收益</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">年化收益6到10%，满标次日立即生息。</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">低门槛</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">100元起投。</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">易变现</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">交易系统支持投资人T+1再转让手中债权，自主定价转让保证资金流动性高。</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">易操作</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">每个交易环节都在保证资金安全的前提下，以用户体验的角度去简化设计交易环节，让用户安心轻松理财。</td>
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
	            <td align="left"><span style="font-size:25px;">3. 便捷快速，轻松理财</span></td>
	          </tr>
	          <tr>
	            <td align="left">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt">简单4步，实现财富增值</td>
	          </tr>
	          <tr>
	            <td align="left">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">第一步，注册用户，完成身份认证<br>
			              第二步，发起融资申请<br>
			              第三步，上传必要申请材料<br>
			              第四步，通过审核后开始筹标。满标后，借款完成立刻放款，之后您只需每月还款即可</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_nr">&nbsp;</td>
	          </tr>
	          <tr>
	            <td align="left" class="xszy_bt"><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'borrowing', 'action'=>'apply'));?>"><img src="/files/default/images/zy_3go.jpg" width="165" height="46"></a></td>
	          </tr>
	        </table></td>
	        <td width="514" align="center"><img src="/files/default/images/zy_3.jpg"></td>
	      </tr>
	    </table></td>
	  </tr>
	</table>
	</div>
</div>
<?php echo $this->render('footer.php');?>
</body>
</html>