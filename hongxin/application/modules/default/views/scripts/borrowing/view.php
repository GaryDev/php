<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryColorbox/jquery.colorbox.js"></script>
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryColorbox/colorbox2.css" rel="stylesheet" />
<title><?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
</head>

<body>
<?php echo $this->render('top.php');?>
<div class="mainbox">
	<div class="nytxt2 lt mtop10">
		<div class="nytxt2_l">
			<ul>
				<li><img src="<?php echo $this->row['avatarUrl'];?>" /></li>
				<li>用 户 名：<?php echo $this->row['userName'];?></li>
				<li><span>等&nbsp;&nbsp;&nbsp;&nbsp;级：</span>VIP</li>
<!--
				<li>借入积分：0</li>
				<li>投资积分：0</li>
-->
				<li>籍&nbsp;&nbsp;&nbsp;&nbsp;贯：<?php echo trim($this->row['idCardAddress']) != '' ? $this->row['idCardAddress'] : '--';?></li>

				<li>居 住 地：<?php echo @trim($this->memberBaseRow['liveAddress']) != '' ? $this->memberBaseRow['liveAddress'] : '--';?></li>
				<li>注册时间：<?php echo date("Y-m-d", $this->row['regTime']);?></li>
				<li>最后登录：<?php echo !empty($this->row['lastVisitTime']) ? date("Y-m-d", $this->row['lastVisitTime']) : '--';?></li>
				<li><span>认证信息：</span><span class="tub" style="margin:0;"><a href="#"></a><a href="#" class="rz2"></a><a href="#" class="rz3"></a></span></li>
                <div style=" clear:both;"></div>
<?php
if (!empty($this->serviceRow)) {
?>
				<li><span>客&nbsp;&nbsp;&nbsp;&nbsp;服</span>：<?php echo $this->serviceRow['name'];?></li>
<?php
	if (!empty($this->serviceRow['qq'])) {
?>
                <li>客服QQ：<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $this->serviceRow['qq'];?>&amp;site=qq&amp;menu=yes"><img src="http://wpa.qq.com/pa?p=2:<?php echo $this->serviceRow['qq'];?>:41" alt="点击这里给我发消息" border="0" align="absmiddle" title="点击这里给我发消息" /></a></li>
<?php
	}
?>
<?php
}
?>
			</ul>
	  	</div>
		<div class="nytxt2_r">
			<h4><?php echo $this->row['title'];?></h4>
			<p>借款金额： <b>￥<?php echo $this->row['amount'];?></b></p>
			<p><span style="width:310px;">还款方式： <?php if ($this->row['repaymentType'] == '1') {echo '等额本息';} else if ($this->row['repaymentType'] == '2') {echo '等本等息';} ?></span><span>借款期限： <?php echo $this->row['deadline'];?> 月</span></p>
			<p><span style="width:310px;">年利率： <?php echo $this->row['monthInterestRate'] * 12 * 100;?> % (月利率： <?php echo $this->row['monthInterestRate'] * 100;?> %)</span></p>
			<p style="color:#f00;">投资￥100元，期限<?php echo $this->row['deadline'];?>个月，可获得利息收益￥<?php echo $this->x;?>元</p>
			<p><span>投标进度：</span><span class="jind"><code style="width:<?php echo $this->row['schedule'];?>%"></code></span>  <?php echo $this->row['schedule'];?>%，  还需：￥<?php echo $this->row['amount'] - $this->row['borrowedAmount'];?>元</p>
			<p>最小投标金额： <?php echo $this->row['amountMinUnit'] != 0 ? '￥' . $this->row['amountMinUnit']  : '无限制';?>， 最大投标金额： <?php echo $this->row['amountMaxUnit'] != 0 ? '￥' . $this->row['amountMaxUnit'] : '无限制';?></p>
			<p>投标数量： <?php echo $this->row['borrowedCount'];?>笔</p>
			<p style="border-top:1px dashed #ccc; padding-top:20px; margin-top:10px;">
				<div class="borrowingStatus">
					<?php if ($this->row['status'] == 1) {echo '待审核';} else if ($this->row['status'] == 2) {echo '<div style="cursor:pointer;" onclick="$(document).ready(function(){$.fn.colorbox({href:\'' . $this->projectUrl(array('action'=>'loan', 'code'=>$this->row['code'])) . '\'});});">投标</div>';} else if ($this->row['status'] == 3) {echo '借款完成审核中';}  else if ($this->row['status'] == 4) {echo '还款中';} else if ($this->row['status'] == 5) {echo '还款完成';}   else if ($this->row['status'] == 6) {echo '作废';}?>
				</div>
			</p>
		</div>
	</div>
	<div class="nytit3 mtop10">
		<h3>投标人记录</h3>
	</div>
	<div class="nytxt3">
		<ul class="nylist1">
			<li style="font-weight:bold;">
				<span class="xh">序号</span>
				<span class="name">投标人</span>
				<span>投资金额</span>
				<span class="time">投标时间</span>
			</li>
<?php
if (!empty($this->loginedUserName)) {
?>
<?php
	foreach($this->borrowingDetailRows as $key=>$borrowingDetailRow) {
?>
			<li>
				<span class="xh"><?php echo $key + 1;?></span>
				<span class="name"><?php echo $borrowingDetailRow['userName'];?></span>
				<span>￥<?php echo $borrowingDetailRow['amount'];?></span>
				<span class="time"><?php echo date("Y-m-d H:i:s", $borrowingDetailRow['addTime']);?></span>
			</li>
<?php
	}
?>
<?php
	if (empty($this->borrowingDetailRows)) {
?>
			<li class="wei">暂无记录</li>
<?php
	}
?>
<?php
} else {
?>
	
			<li class="wei"><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'login', 'backUrl'=>urlencode($this->url())));?>">登录后可查看相关信息</a></li>
<?php
}
?>
		</ul>
	</div>
	<div class="nytit3 mtop10">
		<h3>招标人信息</h3>
	</div>
	<div class="nytxt3">
	
		<ul class="nylist2 nylist1">
			<li class="bt">借款说明</li>
			<li style="height:auto;"><?php echo !empty($this->row['notes']) ? str_replace("\n", "<br/>", $this->row['notes']) : '说明未填写';?></li>
			<li class="bt">资料审核</li>
<?php
if (!empty($this->loginedUserName)) {
?>
			<li>
				<span>性别：<?php echo $this->row['gender'];?></span>
				<span>出生年月：<?php echo $this->row['birthday'];?></span>
				<span>文化程度：<?php echo @trim($this->memberBaseRow['education']) != '' ? $this->memberVars['education'][$this->memberBaseRow['education']] : '--';?></span>
				<span>每月收入：<?php echo @trim($this->memberBaseRow['preTaxIncome']) != '' ?  $this->memberVars['preTaxIncome'][$this->memberBaseRow['preTaxIncome']] . "元/月" : '--';?></span>
			</li>
			<li>
				<span>社保：<?php echo @trim($this->memberBaseRow['isHaveSocialInsurance']) != '' ? $this->memberVars['isHaveSocialInsurance'][$this->memberBaseRow['isHaveSocialInsurance']] : '--';?></span>
				<span>住房条件：<?php echo @trim($this->memberBalanceRow['houseType']) != '' ? $this->memberVars['houseType'][$this->memberBalanceRow['houseType']] : '--';?></span>
				<span>是否购车：<?php echo @trim($this->memberBalanceRow['isHaveAuto']) != '' ? $this->memberVars['isHaveAuto'][$this->memberBalanceRow['isHaveAuto']] : '--';?></span>
				<span>婚姻状况：<?php echo @trim($this->memberBaseRow['marriageStatus']) != '' ? $this->memberVars['marriageStatus'][$this->memberBaseRow['marriageStatus']] : '--';?></span>
			</li>
<?php
} else {
?>
			<li class="wei"><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'login', 'backUrl'=>urlencode($this->url())));?>">登录后可查看相关信息</a></li>
<?php
}
?>
<!--
			<li class="bt">资金详情</li>
			<li><span>账户总额：￥2775.72</span><span>借入总额：￥21986.39</span><span>借出总额：￥0.00</span><span>担保总额：￥0.00</span></li>
			<li><span>充值总额：￥11979.15</span><span>已还总额：￥11,963.55</span><span>已收总额：￥6,529.98</span><span>垫付总额：￥0.00</span></li>
			<li><span>提现总额：￥29555.00</span><span>待还总额：￥22,748.15</span><span>待收总额：￥0.00</span></li>
			<li><span>信用额度：￥20,000.00</span><span>推荐额度：￥0.00</span><span>担保额度：￥10,000.00</span></li>
			<li class="wei"><a href="#">登录后可查看相关信息</a></li>
			<li class="bt">还款信用</li>
			<li><span>成功借款：5 次</span><span>流标：0 次</span><span>待还款：9 笔</span><span>提前还款：0 笔</span></li>
			<li><span>按时还款：3 笔</span><span>逾期还款：0 笔</span><span>垫付后还款：0 笔</span><span>逾期未还款：0 笔</span></li>
			<li class="wei"><a href="#">登录后可查看相关信息</a></li>
			<li class="bt">资料审核（仅显示最近20条记录）</li>
			<li style="font-weight:bold;"><span class="name">序号</span><span class="zlsh">资料说明</span><span  class="zlsh">更新时间</span><span  class="zlsh">是否通过</span></li>
			<li><span class="name">1</span><span class="zlsh">本人身份证</span><span  class="zlsh">2011-09-26</span><span  class="zlsh">审核通过</span></li>
			<li><span class="name">2</span><span class="zlsh">税务登记证</span><span  class="zlsh">2011-09-26</span><span  class="zlsh">审核通过</span></li>
			<li><span class="name">3</span><span class="zlsh">营业执照</span><span  class="zlsh">2011-09-26</span><span  class="zlsh">审核通过</span></li>
			<li><span class="name">4</span><span class="zlsh">租房合同</span><span  class="zlsh">2011-09-26</span><span  class="zlsh">审核通过</span></li>
			<li><span class="name">5</span><span class="zlsh">银行流水账单</span><span  class="zlsh">2011-09-26</span><span  class="zlsh">审核通过</span></li>
			<li><span class="name">6</span><span class="zlsh">手机通话清单</span><span  class="zlsh">2011-09-26</span><span  class="zlsh">审核通过</span></li>
			<li class="wei"><a href="#">登录后可查看相关信息</a></li>
-->
			<li class="bt">待还款记录</li>
			<li style="font-weight:bold;">
				<span class="xh">序号</span>
				<span class="jcbt">借出标题</span>
				<span class="qs">期数</span>
				<span class="rq">待还本息</span>
				<span class="rq">实际到期日期</span>
				<span class="qs">还款状态</span>
			</li>
<?php
if (!empty($this->loginedUserName)) {
?>
<?php
	foreach($this->borrowingNoPayRows as $key=>$borrowingNoPayRow) {
		$repaidMonth = ceil((time() - $borrowingNoPayRow['startTime']) / 3600 / 24 / 30);
?>
			<li>
				<span class="xh"><?php echo ($key + 1);?></span>
				<span class="jcbt"><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'borrowing', 'action'=>'view', 'code'=>$borrowingNoPayRow['code']));?>"><?php echo $borrowingNoPayRow['title'];?></a></span>
				<span class="qs"><?php echo $repaidMonth < $borrowingNoPayRow['deadline'] ? $repaidMonth : $borrowingNoPayRow['deadline'];?>/<?php echo $borrowingNoPayRow['deadline'];?>个月</span>
				<span class="rq">￥<?php echo $borrowingNoPayRow['bx'];?>元</span>
				<span class="rq"><?php echo date("Y-m-d", $borrowingNoPayRow['startTime'] + $borrowingNoPayRow['deadline'] * 30 * 3600 * 24);?></span>
				<span class="qs">未还款</span>
			</li>
<?php
	}
?>
<?php
	if (empty($this->borrowingNoPayRows)) {
?>
			<li class="wei">暂无记录</li>
<?php
	}
?>
<?php
} else {
?>
			
			<li class="wei"><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'login', 'backUrl'=>urlencode($this->url())));?>">登录后可查看相关信息</a></li>
<?php
}
?>
		</ul>
  	</div>
</div>

<?php echo $this->render('footer.php');?>
</body>
</html>