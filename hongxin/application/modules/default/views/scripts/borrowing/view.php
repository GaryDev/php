<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryColorbox/colorbox2.css" rel="stylesheet" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryLayer/layer.min.js"></script>
<title><?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>

<div class="mainbox">
<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="40"><a href="#"><font style="font-size: 14px;">首页</font></a> &gt; 
    <a href="#"><font style="font-size: 14px;">项目详情</font></a></td>
  </tr>
</table>
<table width="1085" border="0" align="center" cellpadding="10" cellspacing="0" class="infobox" style="border:1px #dedede solid;">
  <tr>
    <td width="335" height="400" valign="top">
    <table width="90%" border="0" align="center" cellpadding="20" cellspacing="0" style="border:1px #dedede solid;">
    	<tr>
    		<td align="center">到期由：<?php echo $this->row['repaymentBank']; ?>无条件兑付</td>
    	</tr>
    	<tr>
    		<td align="center"><a href="#" class="ny_img"><img src="<?php echo $this->row['ticketCopyPath']; ?>" /></a></td>
    	</tr>
    </table>
    </td>
    <td width="750" valign="top">
    	<table width="90%" border="0" align="center" class="brief" cellpadding="15" cellspacing="0">
    		<tr>
    			<td colspan="2"><span class="nyls" style="font-size: 20px;"><?php echo $this->row['title']; ?></span></td>
    			<td>
	    			<div class="barbox">
						<div class="bartext"><?php echo $this->row['percent']; ?>%</div>
		    			<div class="progressbar">
						    <div style="width: <?php echo $this->row['percent']; ?>%;">
						        <span></span>
						    </div>
						</div>
					</div>
    			</td>
    		</tr>
    		<tr>
    			<td>年化收益：<label><?php echo $this->row['yearInterestRate']; ?></label>%</td>
    			<td>融资金额：<label><?php echo $this->row['amount'] / 10000;?></label>万</td>
    			<td>产品编号：<?php echo $this->row['code'];?></td>
    		</tr>
    		<tr>
    			<td>项目期限：<label><?php echo $this->row['deadline'];?></label>天</td>
    			<td>最小投资份数：<label><?php echo $this->row['amountMinUnit'];?></label>份</td>
    			<td>&nbsp;</td>
    		</tr>
    		<tr>
    			<td>投资单位：<label><?php echo $this->row['borrowUnit'];?></label>元/份</td>
    			<td>最大投资份数：<label><?php echo $this->row['amountMaxUnit'];?></label>份</td>
    			<td>&nbsp;</td>
    		</tr>
    		<tr>
    			<td>募集开始时间：<?php echo date('Y-m-d', $this->row['startTime']);?></td>
    			<td>募集截止时间：<?php echo date('Y-m-d',$this->row['endTime']);?></td>
    			<td>&nbsp;</td>
    		</tr>
    		<tr>
    			<td>项目到期时间：<?php echo date('Y-m-d',$this->row['ticketEndTime']);?></td>
    			<td>最迟还款日期：<?php echo date('Y-m-d',$this->row['repayEndTime']);?></td>
    			<td>&nbsp;</td>
    		</tr>
    		<?php if($this->row['percent'] < '100') { ?>
    		<tr>
    			<td colspan="3"><input type="button" class="btn" name="goBuyBtn" value="立即投资" 
    			onclick="goBuy('<?php echo $this->row["code"]?>');" /></td>
    		</tr>
    		<?php } else { ?>
    		<tr>
    			<td colspan="3"><div style="text-align:center; line-height:40px;font-size:20px;">融资完成，即将起息</div></td>
    		</tr>
    		<?php } ?>
    	</table>
    </td>
  </tr>
</table>
<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #e6e6e6 solid; background:#f2f2f2; margin-top:10px;">
  <tr>
    <td height="40"><div class="ny_list">
      <ul>
        <li><a href="#" class="ny_list_d">产品介绍</a></li>
      </ul>
    </div></td>
  </tr>
</table>
<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px; line-height:25px;">
  <tr>
    <td width="25%" height="110" align="left" valign="top"><p class="bt_hs14">申购条件：</p>
      <p>本产品面向个人和机构投资者发售，适合经销售银行评估为保守型、稳健型、平衡型、成长型、进取型的个人投资者。机构投资者认购不受风险承受能力评级限制。销售地区范围包括但不限于杭州、上海、北京、深圳、南京、合肥、宁波、舟山、绍兴、桐乡、德清、温州、衢州。</p>
      <p class="bt_hs14">赎回规定：</p>
      <p>在理财期限内，投资者不得提前赎回，可能影响投资者的资金安排，带来流动性风险。</p>
      <p class="bt_hs14">收益率说明：</p>
      <p>理财收益＝理财本金×理财收益率×实际理财天数÷365</p>
      <p class="bt_hs14">投资风险说明：</p>
    <p>投资本产品可能面临的风险包括但不限于： （1） 政策风险：本产品是针对当前的相关法规和政策设计的。如国家宏观政策以及市场相关法规政策发生变化，可能影响理财计划的受理、投资、偿还等的正常进行，给投资者带来风险。 （2） 流动性风险：在理财期限内，投资者不得提前赎回，可能影响投资者的资金安排，带来流动性风险。 （3） 市场风险：如果在理财期限内，市场利率上升，本产品的收益率不随市场利率上升而提高。 （4） 早偿风险：如杭州银行在特定情况下提前终止理财，则投资者可能将无法实现期初预期的全部收益。 （5） 产品不成立风险：如募集期届满，理财产品募集金额未达到规模下限（如有约定）或市场发生剧烈波动，经杭州银行合理判断难以按照本产品</p></td>
  </tr>
</table>
</div>
<?php echo $this->render('footer.php');?>

<script type="text/javascript">
	function goBuy(code)
	{
		if(checkLogin(2))
		{
			window.location.href = "<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'order', 'action'=>'create'));?>/code/" + code;
		}
	}
</script>
</body>
</html>