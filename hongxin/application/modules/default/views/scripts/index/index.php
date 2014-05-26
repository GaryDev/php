<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryTableSorter/jquery.tablesorter.js"></script>
<title><?php echo $this->title;?></title>
<meta name="keywords" content="<?php echo $this->keywords;?>" />
<meta name="description" content="<?php echo $this->description;?>" />
<script type="text/javascript">
	$(document).ready(function(){ 
	        var sorter = $("#productTable").tablesorter({
	        	headers: { 0: { sorter: false}, 5: {sorter: false} },
		        debug: true
	        });
	    }); 
</script>
</head>

<body>
<?php echo $this->render('top.php');?>

<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:15px;">
  <tr>
    <td width="717"><img src="/files/default/images/ad.jpg" width="717" height="318" /></td>
    <td width="368" valign="top"><table width="98%" border="0" align="right" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid;">
      <tr>
        <td height="318" align="center" valign="middle" bgcolor="#f3f3f3"><table width="92%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; height:90px; background:url(/files/default/images/ico_1.jpg) no-repeat 20px center;background-color:#ffffff; ">
          <tr>
            <td align="left"><table width="60%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-left:100px;_margin-left:50px;">
              <tr>
                <td height="35" align="left" class="top_tel">诚信交易</td>
              </tr>
              <tr>
                <td align="left">工信部认证可信网站平台所有交易合法可信</td>
              </tr>
            </table></td>
          </tr>
        </table>
          <table width="92%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; height:90px; background:url(/files/default/images/ico_2.jpg) no-repeat 20px center;background-color:#ffffff; margin-top:10px;">
            <tr>
              <td align="left"><table width="60%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-left:100px;_margin-left:50px;">
                <tr>
                  <td height="35" align="left" class="top_tel">安全可靠</td>
                </tr>
                <tr>
                  <td align="left">所有交易票据均由银行发布受银行认可并可实际兑换</td>
                </tr>
              </table></td>
            </tr>
          </table>
          <table width="92%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; height:90px; background:url(/files/default/images/ico_3.jpg) no-repeat 20px center;background-color:#ffffff; margin-top:10px;">
            <tr>
              <td align="left"><table width="60%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-left:100px;_margin-left:50px;">
                <tr>
                  <td height="35" align="left" class="top_tel">权威保障</td>
                </tr>
                <tr>
                  <td align="left">本网站风险金帐户已受中国工商银行托管，有效保证理财人的财产安全。</td>
                </tr>
              </table></td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background:#f3f3f3; margin-top:10px;">
  <tr>
    <td width="330" height="350"><table width="300" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background:#fff;">
      <tr>
        <td height="320">
        <form name="form1" method="post" action="">
          <table width="208" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td height="35" align="left" class="bt_hs22">个性化定制您的投资</td>
            </tr>
            <tr>
              <td height="30" align="left" class="bt_hs14">期望收益</td>
            </tr>
            <tr>
              <td height="35" align="left"><input type="text" class="xlbd" />&nbsp;<span class="bt_hs14">%</span></td>
            </tr>
            <tr>
              <td height="30" align="left" class="bt_hs14">期望金额</td>
            </tr>
            <tr>
              <td height="35" align="left"><input type="text" class="xlbd" />&nbsp;<span class="bt_hs14">万元</span></td>
            </tr>
            <tr>
              <td height="30" align="left" class="bt_hs14">期望期限</td>
            </tr>
            <tr>
              <td height="35" align="left"><input type="text" class="xlbd" />&nbsp;<span class="bt_hs14">个月</span></td>
            </tr>
            <tr>
              <td height="60" align="left" valign="middle"><label>
                <input type="image" name="imageField" id="imageField" src="/files/default/images/cx.jpg"/>
              </label></td>
            </tr>
          </table>
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
            <th width="70" height="30" align="center" class="header">金额(万)</th>
            <th width="70" height="30" align="center" class="header">期限(天)</th>
            <th width="70" height="30" align="center" class="header">投标率(%)</th>
            <th width="70" height="30" align="center">&nbsp;</th>
          </tr>
         </thead>
         <tbody>
          <tr>
            <td align="left" bgcolor="#FFFFFF" class="bt_hs12">项目名称项目名称项目名称1</td>
            <td align="right" bgcolor="#FFFFFF" class="hsbfb">13.1</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">100</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">365</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">65</td>
            <td align="center" bgcolor="#FFFFFF" class="bt_hs14"><a href="#" class="xq">详情</a></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF" class="bt_hs12">项目名称项目名称项目名称2</td>
            <td align="right" bgcolor="#FFFFFF" class="hsbfb">13.2</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">110</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">365</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">66</td>
            <td align="center" bgcolor="#FFFFFF" class="bt_hs14"><a href="#" class="xq">详情</a></td>
          </tr> 
          <tr>  
            <td align="left" bgcolor="#FFFFFF" class="bt_hs12">项目名称项目名称项目名称3</td>
            <td align="right" bgcolor="#FFFFFF" class="hsbfb">13.3</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">120</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">365</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">67</td>
            <td align="center" bgcolor="#FFFFFF" class="bt_hs14"><a href="#" class="xq">详情</a></td>
          </tr> 
          <tr>  
            <td align="left" bgcolor="#FFFFFF" class="bt_hs12">项目名称项目名称项目名称4</td>
            <td align="right" bgcolor="#FFFFFF" class="hsbfb">13.4</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">130</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">365</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">68</td>
            <td align="center" bgcolor="#FFFFFF" class="bt_hs14"><a href="#" class="xq">详情</a></td>
          </tr> 
          <tr>  
            <td align="left" bgcolor="#FFFFFF" class="bt_hs12">项目名称项目名称项目名称5</td>
            <td align="right" bgcolor="#FFFFFF" class="hsbfb">13.5</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">140</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">365</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">69</td>
            <td align="center" bgcolor="#FFFFFF" class="bt_hs14"><a href="#" class="xq">详情</a></td>
          </tr> 
          <tr>  
            <td align="left" bgcolor="#FFFFFF" class="bt_hs12">项目名称项目名称项目名称6</td>
            <td align="right" bgcolor="#FFFFFF" class="hsbfb">13.6</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">150</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">365</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">70</td>
            <td align="center" bgcolor="#FFFFFF" class="bt_hs14"><a href="#" class="xq">详情</a></td>
          </tr> 
          <tr>  
            <td align="left" bgcolor="#FFFFFF" class="bt_hs12">项目名称项目名称项目名称7</td>
            <td align="right" bgcolor="#FFFFFF" class="hsbfb">13.7</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">160</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">365</td>
            <td align="right" bgcolor="#FFFFFF" class="bt_hs12">71</td>
            <td align="center" bgcolor="#FFFFFF" class="bt_hs14"><a href="#" class="xq">详情</a></td>
          </tr>
          </tbody>
        </table>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background:#f3f3f3; margin-top:10px;">
  <tr>
    <td width="33%" height="350" align="center" valign="middle"><table width="96%" border="0" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background:url(/files/default/images/mxcp.jpg) no-repeat 240px 10px;background-color:#ffffff;">
      <tr>
        <td height="40" align="left" class="bt_hs16" style="padding-top:20px; padding-left:20px;">赋银财富银票第0001期 </td>
        </tr>
      <tr>
        <td height="30" align="left" valign="middle"  style="padding-left:20px;"><span class="bt_hs14">年化收益率：</span><span class="hsbfb1">13.2</span><span class="hsbfb2">%</span></td>
        </tr>
      <tr>
        <td height="30"><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr height="10" >
            <td align="left" valign="middle">
    			<div class="barbox">
					<div class="bartext">45%</div>
	    			<div class="progressbar">
					    <div class="orange" style="width: 45%;">
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
            <td width="50%" height="25" align="left"><span class="hsbfb2">认筹：</span>100元起<br/></td>
            <td width="50%" height="25" align="left"><span class="hsbfb2">停售：</span>2014-05-20<br/></td>
            </tr>
          <tr>
            <td width="50%" height="25" align="left"><span class="hsbfb2">剩余：</span>56天</td>
            <td width="50%" height="25" align="left"><span class="hsbfb2">已售：</span>300份</td>
            </tr>
          <tr>
            <td width="50%" height="25" align="left"><span class="hsbfb2">总价：</span>29.677万</td>
            <td width="50%" height="25" align="left">&nbsp;</td>
            </tr>
          
        </table></td>
      </tr>
      <tr>
        <td height="30" align="left" style="padding-left:20px;">还款来源到期由：<span class="hsbfb2">中工国商银行无条件兑付</span></td>
      </tr>
      <tr>
        <td height="70" align="left"><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50%" height="25" align="left" valign="middle"><table width="95%" border="0" align="left" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" class="box_hs"><a href="#"><span>查看汇票</span></a></td>
                </tr>
              
            </table>
              <br/></td>
            <td width="50%" height="25" align="right"><table width="95%" border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" class="box_hs1"><a href="#"><span>更多产品</span></a></td>
              </tr>
            </table></td>
          </tr>
          
        </table></td>
      </tr>
      
      
    </table></td>
    <td width="33%" align="center" valign="middle"><table width="96%" border="0" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background:url(/files/default/images/jjmp.jpg) no-repeat 240px 10px;background-color:#ffffff;">
      <tr>
        <td height="40" align="left" class="bt_hs16" style="padding-top:20px; padding-left:20px;">赋银财富银票第0001期 </td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle"  style="padding-left:20px;"><span class="bt_hs14">年化收益率：</span><span class="renbfb1">13.2</span><span class="renbfb2">%</span></td>
      </tr>
      <tr>
        <td height="30"><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr height="10" >
              <td align="left" valign="middle">
    			<div class="barbox">
					<div class="bartext">85%</div>
	    			<div class="progressbar">
					    <div class="red" style="width: 85%;">
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
              <td width="50%" height="25" align="left"><span class="redbfb2">认筹：</span>100元起<br></td>
              <td width="50%" height="25" align="left"><span class="redbfb2">停售：</span>2014-05-20<br></td>
            </tr>
            <tr>
              <td width="50%" height="25" align="left"><span class="redbfb2">剩余：</span>56天</td>
              <td width="50%" height="25" align="left"><span class="redbfb2">已售：</span>300份</td>
            </tr>
            <tr>
              <td width="50%" height="25" align="left"><span class="redbfb2">总价：</span>29.677万</td>
              <td width="50%" height="25" align="left">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="30" align="left" style="padding-left:20px;">还款来源到期由：<span class="renbfb2">中工国商银行无条件兑付</span></td>
      </tr>
      <tr>
        <td height="70" align="left"><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="50%" height="25" align="left" valign="middle"><table width="95%" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" class="box_red"><a href="#"><span>查看汇票</span></a></td>
                  </tr>
                </table>
                  <br></td>
              <td width="50%" height="25" align="right"><table width="95%" border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" class="box_red1"><a href="#"><span>更多产品</span></a></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="33%" align="center" valign="middle"><table width="96%" border="0" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background:url(/files/default/images/zqzr.jpg) no-repeat 240px 10px;background-color:#ffffff;">
      <tr>
        <td height="40" align="left" class="bt_hs16" style="padding-top:20px; padding-left:20px;">赋银财富银票第0001期 </td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle"  style="padding-left:20px;"><span class="bt_hs14">年化收益率：</span><span class="lsbfb1">13.2</span><span class="lsbfb2">%</span></td>
      </tr>
      <tr>
        <td height="30"><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr height="10" >
              <td align="left" valign="middle">
    			<div class="barbox">
					<div class="bartext">55%</div>
	    			<div class="progressbar">
					    <div style="width: 55%;">
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
              <td width="50%" height="25" align="left"><span class="lsbfb2">认筹：</span>100元起<br></td>
              <td width="50%" height="25" align="left"><span class="lsbfb2">停售：</span>2014-05-20<br></td>
            </tr>
            <tr>
              <td width="50%" height="25" align="left"><span class="lsbfb2">剩余：</span>56天</td>
              <td width="50%" height="25" align="left"><span class="lsbfb2">已售：</span>300份</td>
            </tr>
            <tr>
              <td width="50%" height="25" align="left"><span class="lsbfb2">总价：</span>29.677万</td>
              <td width="50%" height="25" align="left">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="30" align="left" style="padding-left:20px;">还款来源到期由：<span class="lsbfb2">中工国商银行无条件兑付</span></td>
      </tr>
      <tr>
        <td height="70" align="left"><table width="88%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="50%" height="25" align="left" valign="middle"><table width="95%" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" class="box_ls"><a href="#"><span>查看汇票</span></a></td>
                  </tr>
                </table>
                  <br></td>
              <td width="50%" height="25" align="right"><table width="95%" border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" class="box_ls1"><a href="#"><span>更多产品</span></a></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>

<table width="1085" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background:#f3f3f3; margin-top:10px;">
  <tr>
    <td width="33%" height="300" align="center" valign="middle"><table width="96%" border="0" cellpadding="0" cellspacing="0" style="border:1px #dfdfdf solid; background-color:#ffffff;">
      <tr>
        <td width="50%" height="40" align="left" class="lsbfb" style="border-bottom:2px #1eb3d4 solid; padding-left:10px;">理财课堂</td>
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
        <td width="50%" height="40" align="left" class="lsbfb" style="border-bottom:2px #1eb3d4 solid; padding-left:10px;">行业咨询</td>
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
            <td align="center"><a href="#"><img src="/files/default/images/linke.jpg" width="139" height="45" /></a></td>
            <td align="center"><a href="#"><img src="/files/default/images/linke.jpg" width="139" height="45" /></a></td>
            <td align="center"><a href="#"><img src="/files/default/images/linke.jpg" width="139" height="45" /></a></td>
            <td align="center"><a href="#"><img src="/files/default/images/linke.jpg" width="139" height="45" /></a></td>
            <td align="center"><a href="#"><img src="/files/default/images/linke.jpg" width="139" height="45" /></a></td>
            <td align="center"><a href="#"><img src="/files/default/images/linke.jpg" width="139" height="45" /></a></td>
          </tr>
          
        </table></td>
        <td width="40" align="center"><img src="/files/default/images/r_jt.jpg" width="26" height="36"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="30" align="center" valign="middle">
    	友情链接： 
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