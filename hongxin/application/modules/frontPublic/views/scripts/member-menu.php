<table width="160" border="0" cellpadding="0" cellspacing="0" style="border:1px #eaeaea solid;">
      <tr>
        <td class="bt_bai14" style="background:url(/files/default/images/hyzx.jpg) no-repeat left center; height:27px; line-height:27px; padding-left:30px;">会员中心</td>
        </tr>
      <tr>
        <td style="padding-bottom:30px;">
         <?php if ($this->loginedUserType == 'E') { ?>
         <table width="120" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:10px;">
            <tr>
              <td height="30" class="bt_hs14">企业融资</td>
            </tr>
            <tr>
              <td><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'borrowing', 'action'=>'apply'));?>">· 票据融资申请</a><br/></td>
            </tr>
            <tr>
              <td><a href="#">· 订单管理</a><br/></td>
            </tr>
          </table>       
        <?php } ?>
        <?php if ($this->loginedUserType == 'P') { ?>
        <table width="120" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:10px;">
          <tr>
            <td height="30" class="bt_hs14">我的投资</td>
            </tr>
          <tr>
            <td><a href="#">· 预约管理</a><br/></td>
            </tr>
          <tr>
            <td><a href="#">· 订单管理</a><br/></td>
            </tr>
        </table>

          <table width="120" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:10px;">
            <tr>
              <td height="30" class="bt_hs14">债权转让</td>
            </tr>
            <tr>
              <td><a href="#">· 预约管理</a><br/></td>
            </tr>
            <tr>
              <td><a href="#">· 订单管理</a><br/></td>
            </tr>
          </table>
        <?php } ?>
          <table width="120" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:10px;">
            <tr>
              <td height="30" class="bt_hs14">我的理财</td>
            </tr>
            <tr>
              <td><a href="#">· 预约管理</a><br/></td>
            </tr>
            <tr>
              <td><a href="#">· 订单管理</a><br/></td>
            </tr>
          </table>
          <table width="120" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:10px;">
            <tr>
              <td height="30" class="bt_hs14">会员资料</td>
            </tr>
            <tr>
              <td><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'index'));?>">· 资料管理</a><br/></td>
            </tr>
            <tr>
              <td><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'modify-password'));?>">· 修改密码</a><br/></td>
            </tr>
          </table>
          </td>
        </tr> 
</table>
<?php if (false) {?>
	<div class="tb2 lt mtop10">
		<?php if ($this->loginedUserType == 'P') { ?>
		<div class="nytit4"><h3>我是投资者</h3></div>
		<div class="nytxt4">
			<ul>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'borrowing', 'action'=>'index'));?>">我要投资</a></li>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'borrowing-lender', 'action'=>'complete'));?>">已成功投资的项目</a></li>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'borrowing-lender', 'action'=>'in-progress'));?>">正在投标的项目</a></li>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'borrowing-lender', 'action'=>'cancel'));?>">已流标的项目</a></li>
			</ul>
		</div>
		<?php } ?>
		<?php if ($this->loginedUserType == 'E') { ?>
		<div class="nytit4"><h3>我是借款者</h3></div>
		<div class="nytxt4">
			<ul>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'borrowing', 'action'=>'apply'));?>">我要借款</a></li>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'borrowing', 'action'=>'in-progress'));?>">正在投标的项目</a></li>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'borrowing', 'action'=>'in-progress-repayment'));?>">正在还款的项目</a></li>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'borrowing', 'action'=>'complete-cancel'));?>">还款完成/作废的项目</a></li>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'borrowing-available-amount-details', 'action'=>'apply'));?>">额度申请</a></li>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'borrowing-available-amount-details', 'action'=>'list'));?>">额度变化记录</a></li>
			</ul>
		</div>
		<?php } ?>
		<div class="nytit4 mtop10"><h3>资金管理</h3></div>
		<div class="nytxt4">
			<ul>
				<!--<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'amount', 'action'=>'index'));?>">账户详情</a></li>-->
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'account-withdrawals', 'action'=>'apply'));?>">账户提现</a></li>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'account-withdrawals', 'action'=>'list'));?>">提现记录</a></li>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'account-charge', 'action'=>'add'));?>">账户充值</a></li>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'account-charge', 'action'=>'list'));?>">充值记录</a></li>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'account-details', 'action'=>'list'));?>">资金记录</a></li>
			</ul>
		</div>
		<div class="nytit4 mtop10"><h3>个人信息</h3></div>
		<div class="nytxt4">
			<ul>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'index'));?>">个人资料</a></li>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'avatar-upload'));?>">更换头像</a></li>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'modify-password'));?>">修改密码</a></li>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'bank'));?>">银行账号</a></li>
				<li><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'login-list'));?>">登录查询</a></li>
			</ul>
		</div>
	</div>
<?php } ?>