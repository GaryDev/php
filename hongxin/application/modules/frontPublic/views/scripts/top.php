
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30" bgcolor="#dedede"><table width="1085" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="1195" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="121"><img src="/files/default/images/logo.jpg" width="121" height="34"></td>
    <td width="1074" height="70"><table width="40%" border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td class="top_tel">客服热线：400-606-0009</td>
        <?php if (empty($this->loginedUserName)) { ?>
	        <td width="160" align="right"><a id="login" href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'login'));?>" class="dl">登录</a> </td>
	        <td width="50" align="center"><a id="register" href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'register'));?>" class="dl">注册</a></td>
	    <?php } else { ?>
	    	<td width="160" align="center">你好，用户<a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'index', 'action'=>'index'));?>" class="dl"><?php echo $this->loginedUserName;?></a> </td>
	    	<td width="50" align="center"><a href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'user', 'action'=>'logout'));?>" class="dl">退出</a>
	    <?php } ?>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="40" bgcolor="#1eb2d5"><table width="1085" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><a id="index" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'index', 'action'=>'index'));?>" class="menu"><span class="menu_on">首页</span></a></td>
        <td align="center"><a id="about" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'info', 'action'=>'about'));?>" class="menu">关于我们</a></td>
        <td align="center"><a id="lease" href="#" class="menu">投资理财</a></td>
        <td align="center"><a id="borrowing" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'borrowing', 'action'=>'index'));?>" class="menu">企业融资</a></td>
        <td align="center"><a id="cession" href="#" class="menu">债券转让</a></td>
        <td align="center"><a id="notice" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'info', 'action'=>'notice'));?>" class="menu">信息公告</a></td>
        <td align="center"><a id="guide" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'info', 'action'=>'guide'));?>" class="menu">新手指引</a></td>
        <td align="center"><a id="member" href="<?php echo $this->projectUrl(array('module'=>'member', 'controller'=>'index', 'action'=>'index'));?>" class="menu">会员中心</a></td>
        <td align="center"><a id="contact" href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'info', 'action'=>'contact'));?>" class="menu">联系我们</a></td>
      </tr>
    </table></td>
  </tr>
</table>
<script language="javascript">
<?php
if ($this->module == 'default' && $this->controller != 'borrowing') {
	$menu = $this->action;
} else if ($this->controller == 'borrowing') {
	$menu = 'borrowing';
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