<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/slide.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryTableSorter/jquery.tablesorter.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryLayer/layer.min.js"></script>
<title><?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
<script type="text/javascript">
	$(document).ready(function(){ 
        var sorter = $("#productTable").tablesorter({
        	headers: { 0: { sorter: false}, 5: {sorter: false} },
	        debug: false
        });

        var nums = [], timer, n = $$("idSlider").getElementsByTagName("li").length,
    	st = new SlideTrans("idContainer", "idSlider", n, {
    		//Vertical: false,
    		onStart: function(){//设置按钮样式
    			forEach(nums, function(o, i){ o.className = st.Index == i ? "on" : ""; })
    		}
    	});
	    for(var i = 1; i <= n; AddNum(i++)){};
	    function AddNum(i){
	    	var num = $$("idNum").appendChild(document.createElement("li"));
	    	num.innerHTML = i--;
	    	num.onmouseover = function(){
	    		timer = setTimeout(function(){ num.className = "on"; st.Auto = false; st.Run(i); }, 200);
	    	}
	    	num.onmouseout = function(){ clearTimeout(timer); num.className = ""; st.Auto = true; st.Run(); }
	    	nums[i] = num;
	    }
	    st.Run();
	}); 
    function viewTicket(url){
		if(checkLogin(1)) { 
			window.open(url, "_blank"); 
		}
		return false;
    }
    function goQuery(){
		if(checkLogin(2)) {
			$("#qForm").submit();
			return true;
		}
		return false;
    }
    function goBuy(code){
		//if(checkLogin(2)){
			window.location.href = "<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'borrowing', 'action'=>'view'));?>/code/" + code;
		//}
		return false;
    }
</script>
</head>

<body>
<?php echo $this->render('top.php');?>

<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px;">
  <tr>
    <td>
    <div class="bannercontainer" id="idContainer">
	<ul id="idSlider">
		<li><img src="/files/default/images/banner1.jpg" /></li>
		<li><img src="/files/default/images/banner2.jpg" /></li>
		<li><img src="/files/default/images/banner3.jpg" /></li>
		<li><img src="/files/default/images/banner4.jpg" /></li>
	</ul>
	<ul class="num" id="idNum">
	</ul>
	</div>
    </td>
   </tr>
</table>
<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="border:0px #dfdfdf solid; background:#f3f3f3; margin-top:10px;">
   <tr>
    <td><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid;">
      <tr>
        <td align="center" valign="middle" bgcolor="#f3f3f3">
        <table width="92%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; height:90px; background-color:#ffffff;margin-top: 10px; margin-bottom: 10px; margin-left: 7px;">
          <tr>
            <td align="center"><table width="60%" border="0" align="left" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center"><img src="/files/default/images/noteA.jpg" width="256" /></td>
              </tr>
            </table></td>
          </tr>
        </table>
        </td>
        <td align="center" valign="middle" bgcolor="#f3f3f3">
        <table width="92%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; height:90px; background-color:#ffffff;margin-top: 10px; margin-bottom: 10px; margin-left: 5px;">
          <tr>
            <td align="center"><table width="60%" border="0" align="left" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center"><img src="/files/default/images/noteB.jpg" width="256" /></td>
              </tr>
            </table></td>
          </tr>
        </table>
        </td>
        <td align="center" valign="middle" bgcolor="#f3f3f3">
        <table width="92%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; height:90px; background-color:#ffffff;margin-top: 10px; margin-bottom: 10px; margin-left: 5px;">
          <tr>
            <td align="center"><table width="60%" border="0" align="left" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center"><img src="/files/default/images/noteC.jpg" width="256" /></td>
              </tr>
            </table></td>
          </tr>
        </table>
        </td>
        <td align="center" valign="middle" bgcolor="#f3f3f3">
        <table width="92%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; height:90px; background-color:#ffffff;margin-top: 10px; margin-bottom: 10px; margin-left: 5px;">
          <tr>
            <td align="center"><table width="60%" border="0" align="left" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center"><img src="/files/default/images/noteD.jpg" width="256" /></td>
              </tr>
            </table></td>
          </tr>
        </table>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background:#f3f3f3; margin-top:10px;">
  <tr>
    <td width="330" height="350"><table width="300" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background:#fff;">
      <tr>
        <td height="320">
        <form id="qForm" name="qForm" method="post" action="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'borrowing', 'action'=>'index'));?>" target="_blank">
          <table width="208" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td height="35" align="left" class="bt_hs22">个性化定制您的投资</td>
            </tr>
            <tr>
              <td height="30" align="left" class="bt_hs14">投资收益率</td>
            </tr>
            <tr>
              <td height="35" align="left"><input type="text" name="qYearRate" class="xlbd" />&nbsp;<span class="bt_hs14">%</span></td>
            </tr>
            <tr>
              <td height="30" align="left" class="bt_hs14">投资金额</td>
            </tr>
            <tr>
              <td height="35" align="left"><input type="text" name="qAmount" class="xlbd" />&nbsp;<span class="bt_hs14">元</span></td>
            </tr>
            <tr>
              <td height="30" align="left" class="bt_hs14">投资期限</td>
            </tr>
            <tr>
              <td height="35" align="left"><input type="text" name="qDeadLine" class="xlbd" />&nbsp;<span class="bt_hs14">天</span></td>
            </tr>
            <tr>
              <td height="60" align="left" valign="middle"><label>
                <input type="image" name="imageField" id="imageField" src="/files/default/images/cx.jpg" onclick="return goQuery();" />
              </label></td>
            </tr>
          </table>
          <input type="hidden" name="qFrom" value="home" />
          </form>
        </td>
      </tr>
    </table></td>
    <td width="40"><img src="/files/default/images/jt.jpg" width="40" height="52" /></td>
    <td width="713"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background:#fff;">
      <tr>
       <td height="320">
        <table id="productTable" width="95%" border="0" align="center" cellpadding="1" cellspacing="1" class="tablesorter">
        <thead>
          <tr>
            <th height="20" align="center">产品名称</th>
            <th width="100" height="30" align="center" class="header">年化收益率(%)</th>
            <th width="70" height="30" align="center" class="header">剩余(元)</th>
            <th width="70" height="30" align="center" class="header">期限(天)</th>
            <th width="70" height="30" align="center" class="header">投标率(%)</th>
            <th width="70" height="30" align="center">&nbsp;</th>
          </tr>
         </thead>
         <tbody>
          <?php for($i=0; $i<7; $i++) { 
          	if(empty($this->borrowingRows) || count($this->borrowingRows) <= $i) {
          ?>
          	  <tr>
	            <td align="left" bgcolor="#FFFFFF" class="bt_hs12">&nbsp;</td>
	            <td align="right" bgcolor="#FFFFFF" class="hsbfb">&nbsp;</td>
	            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">&nbsp;</td>
	            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">&nbsp;</td>
	            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">&nbsp;</td>
	            <td align="center" bgcolor="#FFFFFF" class="bt_hs14">&nbsp;</td>
	          </tr>
          <?php } else {?>
	          <tr>
	            <td align="left" bgcolor="#FFFFFF" class="bt_hs12"><?php echo $this->borrowingRows[$i]['title']; ?></td>
	            <td align="right" bgcolor="#FFFFFF" class="hsbfb"><?php echo $this->borrowingRows[$i]['yearInterestRate']; ?></td>
	            <td align="right" bgcolor="#FFFFFF" class="bt_hs12"><?php echo number_format(($this->borrowingRows[$i]['amountUnit'] * $this->borrowingRows[$i]['borrowUnit'])); ?></td>
	            <td align="right" bgcolor="#FFFFFF" class="bt_hs12"><?php echo $this->borrowingRows[$i]['deadline']; ?></td>
	            <td align="right" bgcolor="#FFFFFF" class="bt_hs12"><?php echo $this->borrowingRows[$i]['percent']; ?></td>
	            <td align="center" bgcolor="#FFFFFF" class="bt_hs14">
	            	<a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'borrowing', 'action'=>'view', 'code'=>$this->borrowingRows[$i]['code']));?>" class="xq">详情</a>
	            </td>
	          </tr>
          <?php } } ?>
          </tbody>
        </table>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background:#f3f3f3; margin-top:10px;">
  <tr>
    <td width="33%" height="350" align="center" valign="middle">
    <table width="96%" border="0" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background:url(/files/default/images/mxcp.jpg) no-repeat 240px 10px;background-color:#ffffff;">
    <?php if($this->popRow['id'] > 0) {?>
      <tr>
        <td height="40" align="left" class="bt_hs16" style="padding-top:20px; padding-left:20px;"><?php echo $this->popRow['title']; ?></td>
        </tr>
      <tr>
        <td height="30" align="left" valign="middle"  style="padding-left:20px;"><span class="bt_hs14">年化收益率：</span><span class="hsbfb1"><?php echo $this->popRow['yearInterestRate']; ?></span><span class="hsbfb2">%</span></td>
        </tr>
      <tr>
        <td height="30"><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr height="10" >
            <td align="left" valign="middle">
    			<div class="barbox">
					<div class="bartext"><?php echo $this->popRow['percent']; ?>%</div>
					<div class="hsbfb2" style="float: left;">已投：</div>
	    			<div class="progressbar">
					    <div class="orange" style="width: <?php echo $this->popRow['percent']; ?>%;">
					        <span></span>
					    </div>
					</div>
				</div>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="30"><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50%" height="25" align="left"><span class="hsbfb2">投资：</span><?php echo $this->popRow['borrowUnit']; ?>元起<br/></td>
            <td width="50%" height="25" align="left"><span class="hsbfb2">截止：</span><?php echo date('Y-m-d', $this->popRow['endTime']); ?><br/></td>
            </tr>
          <tr>
            <td width="50%" height="25" align="left"><span class="hsbfb2">剩余：</span><?php echo $this->popRow['remainDay']; ?>天</td>
            <td width="50%" height="25" align="left"><span class="hsbfb2">已投：</span><?php echo $this->popRow['borrowedCount']; ?>份</td>
            </tr>
          <tr>
            <td width="50%" height="25" align="left"><span class="hsbfb2">融资额：</span><?php echo $this->popRow['amount']; ?>元</td>
            <td width="50%" height="25" align="left">&nbsp;</td>
            </tr>
          
        </table></td>
      </tr>
      <tr>
        <td height="30" align="left" style="padding-left:20px;">还款来源到期由：<span class="hsbfb2"><?php echo $this->popRow['repaymentBank']; ?>无条件兑付</span></td>
      </tr>
      <tr>
        <td height="70" align="left"><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
          <?php if($this->popRow['percent'] < '100') { ?>
          <tr>
            <td width="50%" height="25" align="left" valign="middle"><table width="95%" border="0" align="left" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" class="box_hs"><a href="javascript:void(0);" target="_blank" onclick='return viewTicket("<?php echo $this->popRow['ticketCopyUrl']; ?>");'><span>查看汇票</span></a></td>
                </tr>
              
            </table>
              <br/></td>
            <td width="50%" height="25" align="right"><table width="95%" border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" class="box_hs1"><a href="javascript:void(0);" onclick="goBuy('<?php echo $this->popRow['code'];?>');"><span>立即投资</span></a></td>
              </tr>
            </table></td>
          </tr>
          <?php } else { ?>
    		<tr>
    			<td width="100%"><div style="text-align:center; line-height:40px;font-size:20px;">融资完成，即将起息</div></td>
    		</tr>
    	<?php } ?>
        </table></td>
      </tr>
    <?php } else {?>
    	<tr><td  height="315" align="center">暂无记录</td></tr>
    <?php } ?>
    </table>
    </td>
    <td width="33%" align="center" valign="middle">
    <table width="96%" border="0" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background:url(/files/default/images/jjmp.jpg) no-repeat 240px 10px;background-color:#ffffff;">
      <?php if($this->doneRow['id'] > 0) {?>
      <tr>
        <td height="40" align="left" class="bt_hs16" style="padding-top:20px; padding-left:20px;"><?php echo $this->doneRow['title']; ?> </td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle"  style="padding-left:20px;"><span class="bt_hs14">年化收益率：</span><span class="renbfb1"><?php echo $this->doneRow['yearInterestRate']; ?></span><span class="renbfb2">%</span></td>
      </tr>
      <tr>
        <td height="30"><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr height="10" >
              <td align="left" valign="middle">
    			<div class="barbox">
					<div class="bartext"><?php echo $this->doneRow['percent']; ?>%</div>
					<div class="renbfb2" style="float: left;">已投：</div>
	    			<div class="progressbar">
					    <div class="red" style="width: <?php echo $this->doneRow['percent']; ?>%;">
					        <span></span>
					    </div>
					</div>
				</div>
              </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="30"><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="50%" height="25" align="left"><span class="renbfb2">投资：</span><?php echo $this->doneRow['borrowUnit']; ?>元起<br/></td>
              <td width="50%" height="25" align="left"><span class="renbfb2">截止：</span><?php echo date('Y-m-d', $this->doneRow['endTime']); ?><br/></td>
            </tr>
            <tr>
              <td width="50%" height="25" align="left"><span class="renbfb2">剩余：</span><?php echo $this->doneRow['remainDay']; ?>天</td>
              <td width="50%" height="25" align="left"><span class="renbfb2">已投：</span><?php echo $this->doneRow['borrowedCount']; ?>份</td>
            </tr>
            <tr>
              <td width="50%" height="25" align="left"><span class="renbfb2">融资额：</span><?php echo $this->doneRow['amount']; ?>元</td>
              <td width="50%" height="25" align="left">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="30" align="left" style="padding-left:20px;">还款来源到期由：<span class="renbfb2"><?php echo $this->doneRow['repaymentBank']; ?>无条件兑付</span></td>
      </tr>
      <tr>
        <td height="70" align="left"><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
            <?php if($this->doneRow['percent'] < '100') { ?>
            <tr>
              <td width="50%" height="25" align="left" valign="middle"><table width="95%" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" class="box_red"><a href="javascript:void(0);" target="_blank" onclick='return viewTicket("<?php echo $this->doneRow['ticketCopyUrl']; ?>");'><span>查看汇票</span></a></td>
                  </tr>
                </table>
                  <br></td>
              <td width="50%" height="25" align="right"><table width="95%" border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" class="box_red1"><a href="javascript:void(0);" onclick="goBuy('<?php echo $this->doneRow['code'];?>');"><span>立即投资</span></a></td>
                  </tr>
              </table></td>
            </tr>
          <?php } else { ?>
    		<tr>
    			<td width="100%"><div style="text-align:center; line-height:40px;font-size:20px;">融资完成，即将起息</div></td>
    		</tr>
    	<?php } ?>
        </table></td>
      </tr>
	  <?php } else {?>
    	<tr><td  height="315" align="center">暂无记录</td></tr>
      <?php } ?>
    </table>
    </td>
    <td width="33%" align="center" valign="middle">
    <table width="96%" border="0" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background:url(/files/default/images/jjmp.jpg) no-repeat 240px 10px;background-color:#ffffff;">
      <?php if($this->cessionRow['id'] > 0) {?>
      <tr>
        <td height="40" align="left" class="bt_hs16" style="padding-top:20px; padding-left:20px;"><?php echo $this->cessionRow['title']; ?> </td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle"  style="padding-left:20px;"><span class="bt_hs14">年化收益率：</span><span class="lsbfb1"><?php echo $this->cessionRow['yearInterestRate']; ?></span><span class="lsbfb2">%</span></td>
      </tr>
      <tr>
        <td height="30"><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr height="10" >
              <td align="left" valign="middle">
    			<div class="barbox">
					<div class="bartext"><?php echo $this->cessionRow['percent']; ?>%</div>
					<div class="lsbfb2" style="float: left;">已投：</div>
	    			<div class="progressbar">
					    <div class="red" style="width: <?php echo $this->cessionRow['percent']; ?>%;">
					        <span></span>
					    </div>
					</div>
				</div>
              </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="30"><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="50%" height="25" align="left"><span class="lsbfb2">投资：</span><?php echo $this->cessionRow['borrowUnit']; ?>元起<br/></td>
              <td width="50%" height="25" align="left"><span class="lsbfb2">截止：</span><?php echo date('Y-m-d', $this->cessionRow['endTime']); ?><br/></td>
            </tr>
            <tr>
              <td width="50%" height="25" align="left"><span class="lsbfb2">剩余：</span><?php echo $this->cessionRow['remainDay']; ?>天</td>
              <td width="50%" height="25" align="left"><span class="lsbfb2">已投：</span><?php echo $this->cessionRow['borrowedCount']; ?>份</td>
            </tr>
            <tr>
              <td width="50%" height="25" align="left"><span class="lsbfb2">融资额：</span><?php echo $this->cessionRow['amount']; ?>元</td>
              <td width="50%" height="25" align="left">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="30" align="left" style="padding-left:20px;">还款来源到期由：<span class="lsbfb2"><?php echo $this->cessionRow['repaymentBank']; ?>无条件兑付</span></td>
      </tr>
      <tr>
        <td height="70" align="left"><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
            <?php if($this->cessionRow['percent'] < '100') { ?>
            <tr>
              <td width="50%" height="25" align="left" valign="middle"><table width="95%" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" class="box_ls"><a href="javascript:void(0);" target="_blank" onclick='return viewTicket("<?php echo $this->cessionRow['ticketCopyUrl']; ?>");'><span>查看汇票</span></a></td>
                  </tr>
                </table>
                  <br></td>
              <td width="50%" height="25" align="right"><table width="95%" border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" class="box_ls1"><a href="javascript:void(0);" onclick="goBuy('<?php echo $this->cessionRow['code'];?>');"><span>立即投资</span></a></td>
                  </tr>
              </table></td>
            </tr>
          <?php } else { ?>
    		<tr>
    			<td width="100%"><div style="text-align:center; line-height:40px;font-size:20px;">融资完成，即将起息</div></td>
    		</tr>
    	<?php } ?>
        </table></td>
      </tr>
	  <?php } else {?>
    	<tr><td  height="315" align="center">暂无记录</td></tr>
      <?php } ?>
    </table></td>
  </tr>
</table>

<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background:#f3f3f3; margin-top:10px;">
  <tr>
    <td width="33%" height="300" align="center" valign="middle"><table width="96%" border="0" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background-color:#ffffff;">
      <tr>
        <td width="50%" height="40" align="left" class="lsbfb" style="border-bottom:2px #1eb3d4 solid; padding-left:10px;">理财课堂</td>
        <td width="50%" align="right" style="border-bottom:2px #1eb3d4 solid; padding-right:10px;"><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'index', 'classId'=>3));?>">+更多</a></td>
      </tr>
      <tr>
        <td height="240" colspan="2" align="left" valign="top">
        <table width="92%" border="0" align="center" cellpadding="0" cellspacing="0">
		<?php
		if (!empty($this->archives2Rows)) {
			foreach($this->archives2Rows as $row) {				
				if ($row['isLink'] == 1) {
					$link = $row['linkUrl'];
				} else {
					$link = $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'view', 'id'=>$row['id']));
				}
		?>
			  <tr>
	            <td height="30" align="left"><a href="<?php echo $link;?>" title="<?php echo $row['title'];?>" target="_blank"><?php echo substrMoreCn($row['title'], 30, '...');?></a></td>
	            <td align="right"><?php echo date('Y-m-d', $row['updateTime']);?></td>
	          </tr>
		<?php
			}
		} else {
		?>
			<tr><td height="30" align="left">暂无记录</td></tr>
		<?php
		}
		?>
		 </table>
        </td>
        </tr>
      
    </table></td>
    <td width="33%" height="300" align="center" valign="middle"><table width="96%" border="0" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background-color:#ffffff;">
      <tr>
        <td width="50%" height="40" align="left" class="lsbfb" style="border-bottom:2px #1eb3d4 solid; padding-left:10px;">行业资讯</td>
        <td width="50%" align="right" style="border-bottom:2px #1eb3d4 solid; padding-right:10px;"><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'index', 'classId'=>2));?>">+更多</a></td>
      </tr>
      <tr>
        <td height="240" colspan="2" align="left" valign="top">
        <table width="92%" border="0" align="center" cellpadding="0" cellspacing="0">
		<?php
		if (!empty($this->archives1Rows)) {
			foreach($this->archives1Rows as $row) {				
				if ($row['isLink'] == 1) {
					$link = $row['linkUrl'];
				} else {
					$link = $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'view', 'id'=>$row['id']));
				}
		?>
			  <tr>
	            <td height="30" align="left"><a href="<?php echo $link;?>" title="<?php echo $row['title'];?>" target="_blank"><?php echo substrMoreCn($row['title'], 30, '...');?></a></td>
	            <td align="right"><?php echo date('Y-m-d', $row['updateTime']);?></td>
	          </tr>
		<?php
			}
		} else {
		?>
			<tr><td height="30" align="left">暂无记录</td></tr>
		<?php
		}
		?>
        </table>
        </td>
      </tr>
    </table></td>
    <td width="33%" height="300" align="center" valign="middle"><table width="96%" border="0" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background-color:#ffffff;">
      <tr>
        <td width="50%" height="40" align="left" class="lsbfb" style="border-bottom:2px #1eb3d4 solid; padding-left:10px;">媒体报道</td>
        <td width="50%" align="right" style="border-bottom:2px #1eb3d4 solid; padding-right:10px;"><a href="<?php echo $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'index', 'classId'=>6));?>">+更多</a></td>
      </tr>
      <tr>
        <td height="240" colspan="2" align="left" valign="top">
        <table width="92%" border="0" align="center" cellpadding="0" cellspacing="0">
		<?php
		if (!empty($this->archives5Rows)) {
			foreach($this->archives5Rows as $row) {				
				if ($row['isLink'] == 1) {
					$link = $row['linkUrl'];
				} else {
					$link = $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'view', 'id'=>$row['id']));
				}
		?>
			  <tr>
	            <td height="30" align="left"><a href="<?php echo $link;?>" title="<?php echo $row['title'];?>" target="_blank"><?php echo substrMoreCn($row['title'], 30, '...');?></a></td>
	            <td align="right"><?php echo date('Y-m-d', $row['updateTime']);?></td>
	          </tr>
		<?php
			}
		} else {
		?>
			<tr><td height="30" align="left">暂无记录</td></tr>
		<?php
		}
		?>
        </table>
        </td>
      </tr>
    </table></td>
  </tr>
</table>

<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background:#f3f3f3; margin-top:10px;">
  <tr>
    <td height="40" align="center" valign="bottom" class="lsbfb">合作单位</td>
  </tr>
  <tr>
    <td height="100" align="center" valign="middle"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #e0e0e0 solid; background:#FFFFFF;">
      <tr>
        <td width="40" height="80" align="center"><img src="/files/default/images/l_jt.jpg" width="26" height="36" /></td>
        <td><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center"><a href="http://www.icbc.com.cn" target="_blank"><img src="/files/default/images/bank1.png" width="139" height="45" /></a></td>
            <td align="center"><a href="http://www.cmbchina.com" target="_blank"><img src="/files/default/images/bank2.png" width="139" height="45" /></a></td>
            <td align="center"><a href="http://bank.ecitic.com" target="_blank"><img src="/files/default/images/bank3.png" width="139" height="45" /></a></td>
            <td align="center"><a href="http://www.unspay.com" target="_blank"><img src="/files/default/images/bank4.png" width="139" height="45" /></a></td>
            <td align="center"><a href="http://www.ccb.com" target="_blank"><img src="/files/default/images/bank5.png" width="139" height="45" /></a></td>
            <td align="center"><a href="http://www.abchina.com" target="_blank"><img src="/files/default/images/bank6.png" width="139" height="45" /></a></td>
            <td align="center"><a href="http://www.bankcomm.com" target="_blank"><img src="/files/default/images/bank7.png" width="139" height="45" /></a></td>
          </tr>
          
        </table></td>
        <td width="40" align="center"><img src="/files/default/images/r_jt.jpg" width="26" height="36"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="30" align="center" valign="middle">
    	<label style="font-weight: bold; color:#000000;">友情链接：</label> 
    	<?php
		foreach($this->archives4Rows as $row) {
			
			if ($row['isLink'] == 1) {
				$link = $row['linkUrl'];
			} else {
				$link = $this->projectUrl(array('module'=>'default', 'controller'=>'archives', 'action'=>'view', 'id'=>$row['id']));
			}
		?>
		<a href="<?php echo $link;?>" title="<?php echo $row['title'];?>" target="_blank"><?php echo $row['title'];?></a>  |  
		<?php
		}
		?>
	</td>
  </tr>
</table>

<?php echo $this->render('footer.php');?>
</body>
</html>