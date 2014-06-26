
<table width="1175" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30" style="border-bottom: 1px solid #dedede"><table width="1085" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right">
       	<label style="margin-right: 20px;">客服热线：400-606-0009</label>
        <a id="guide" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'guide', 'action'=>'index'));?>" style="font-size: 12px;color:#ff0000;margin-right:20px;">新手指引</a>
		<?php if (!empty($this->loginedUserName)) { ?>
	    	你好，用户<a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'index', 'action'=>'index'));?>" style="margin-right:10px;"><?php echo $this->loginedUserName;?></a>
	    	<a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'logout'));?>">退出</a>
		<?php } ?>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="1085" border="0" align="center" cellpadding="10" cellspacing="0">
  <tr>
    <td width="416"><a href="http://www.jianfengcf.com" target="_blank"><img src="/files/default/images/logo2.jpg"></a></td>
    <!--  <td width="400" align="right"><a id="guide" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'guide', 'action'=>'index'));?>" style="font-size: 16px;color:#30318B;">新手指引</a></td>-->
    <td width="385" align="right"></td>
    <?php if (empty($this->loginedUserName)) { ?>
    <td height="70"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <!--  <td class="top_tel" style="text-align: right;">客服热线：400-606-0009</td> -->
	        <td width="85" align="center" height="30px" style="border: 1px solid #dedede;"><a id="login" href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'login'));?>" class="dl">登录</a> </td>
	        <td width="85" align="center" height="30px" style="border: 1px solid #dedede; background:#30318b;"><a id="register" href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'register'));?>" class="dl" style="color:#ffffff;">免费注册</a></td>
      </tr>
    </table></td>
     <?php }?>
  </tr>
</table>
<table width="1175" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="40" bgcolor="#30318b"><table width="1085" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left"><a id="index" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'index', 'action'=>'index'));?>" class="menu"><span class="menu_on">首页</span></a></td>
        <td align="left"><a id="safe" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'info', 'action'=>'safe'));?>" class="menu">安全保障</a></td>
        <td align="left"><a id="borrowing" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'borrowing', 'action'=>'index'));?>" class="menu">我要投资</a></td>
        <td align="left"><a id="lease" href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'borrowing', 'action'=>'apply'));?>" class="menu">企业融资</a></td>
        <!-- <td align="center"><a id="cession" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'cession', 'action'=>'index'));?>" class="menu">债权转让</a></td> -->
        <td align="left"><a id="archives" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'index'));?>" class="menu">信息公告</a></td>
        <!--  <td align="center"><a id="guide" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'guide', 'action'=>'index'));?>" class="menu">新手指引</a></td>-->
        <td align="left"><a id="member" href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'index', 'action'=>'index'));?>" class="menu">我的账户</a></td>
        <!-- <td align="center"><a id="about" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'info', 'action'=>'about'));?>" class="menu">关于我们</a></td>-->
        <!-- <td align="center"><a id="contact" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'info', 'action'=>'contact'));?>" class="menu">联系我们</a></td>-->
      	<td width="30%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryLayer/layer.min.js"></script>
<script language="javascript">

function checkLogin(type)
{
	var status = 1;
	var url = '<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'check-login'));?>' + '?rand=' + Math.random();
	var loginUrl = "<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'login'));?>";
	var registerUrl = "<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'register'));?>";
	$.ajax({
		type: "POST",
		url: url,
		dataType: "html",
		async: false,
		success: function(data){
			status = data;
		}
	});
	if(status != 0) {
		var msg = '';
		if(type == 1) {
			if(status == 2) {
				status = 0;
			} else {
				msg = "请先<a href='"+loginUrl+"' style='text-decoration:underline;'>登录</a>，才能查看";
			}
		} else if(type == 2) {
			msg = "请先<a href='"+loginUrl+"' style='text-decoration:underline;'>登录</a>，才能操作";
			if(status == 2) {
				msg = "企业账户不能投资，请您<a href='"+registerUrl+"' style='text-decoration:underline;'>注册</a>个人账户！";
			} else if(status == -1) {
				popupWindow("身份验证","<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'identify'));?>");
				return false;
			}
		}
		msg == '' || layer.msg(msg, 5, 5);
	}
	return (status == 0);
}

function goApply()
{
	//if(checkLogin(2))
	//{
		window.location.href = "<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'borrowing', 'action'=>'apply'));?>";
	//}
}

<?php
if ($this->module == 'default') {
	if($this->controller == 'borrowing') {
		$menu = 'borrowing';
	}
	else if($this->controller == 'archives' || in_array($this->action, array('about', 'contact'))) {
		$menu = 'archives';
	} else {
		$menu = $this->action;
	}
} else if ($this->module == 'member') {
	$menu = 'member';
} else {
	$menu = 'index';
}
?>
$("a.menu").each(function(){
	var $this = $(this);
	var $child = $this.children(":first");
	if($child.is('span')) {
		var text = $child.html();
		$child.remove();
		$this.html(text);
		return false;
	}
});
$("#<?php echo $menu; ?>").wrapInner("<span class='menu_on'></span>");

</script>