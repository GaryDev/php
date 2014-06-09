<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-blue.css" rel="stylesheet"  type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<link rel="stylesheet" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryFormValidator/css/validationEngine.jquery.css" type="text/css" />
<!--时间选择器-->
<script src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar.js"></script>
<script src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/lang/cn_utf8.js"></script>
<script src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-setup.js"></script>
<link type="text/css" href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-blue.css" rel="stylesheet" />
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
    <td valign="top">
    	<div class="nytit6"><h3>转让申请</h3></div>
		<div class="nytxt6 search">
			<form id="applyForm" name="applyForm" enctype="multipart/form-data" method="post" action="">
				<table width="100%" border="0" align="left" class="table">
					<tr>
						<td align="left" width="15%">可以转让的债权：</td>
						<td align="left">
							<select name="cessionName" style="width: 20%;">
								<option value="">请选择</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="left">转让方式：</td>
						<td align="left">
							<label><input type="radio" name="cessionType" id="cessionType" value="+" />加价</label>
							<label><input type="radio" name="cessionType" id="cessionType" value="-" checked="checked" />减价</label>
						</td>
					</tr>
					<tr>
						<td align="left">转让金额上限：</td>
						<td align="left"><input name="amount" type="text" class="input" id="amount" value="0" size="15"/>元 </td>
					</tr>
					<tr>
						<td align="left">转让金：</td>
						<td align="left"><input name="fee" type="text" class="input" id="fee" value="0" size="15"/>元 </td>
					</tr>
					<tr>
						<td align="left">转让截止日期：</td>
						<td align="left">
						<input name="applyEndDate" type="text" class="input" readonly="readonly" id="applyEndDate" value="" size="15"/>
						<script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","firstDay":0,"showsTime":false,"showOthers":false,"inputField":"applyEndDate","button":"applyEndDate"});</script></td>
					</tr>
					<tr>
						<td align="left">&nbsp;</td>
						<td align="left"><input type="submit" name="applyButton" id="applyButton" value="申请" class="btn" />	</td>
					</tr>
				</table>
			</form>
		</div>
    </td>
</tr>
</table>

<?php echo $this->render('footer.php');?>
<script language="javascript">
$("#applyForm").submit(function()
{
	/*if ($.trim($("#title").val()) == '') {
		alert('请填写融资标题。');
		$("#title").focus();
		return false;
	} else*/ if (parseFloat($.trim($("#amount").val())) == 0) {
		alert('请填写融资金额。');
		$("#amount").focus();
		return false;
	} else if (parseFloat($.trim($("#amount").val())) <= 0 || isNaN($.trim($("#amount").val()))) {
		alert('融资金额填写错误。');
		$("#amount").focus();
		return false;
	}
	if (checkYearInterestRate() == false) {
		return false;
	}

	return true;
});

/*验证年利率*/
function checkYearInterestRate()
{
	if($.trim($("#yearInterestRate").val()) == '') return true;
	if (parseFloat($.trim($("#yearInterestRate").val())) <= 0 || isNaN($.trim($("#yearInterestRate").val()))) {
		alert('年利率填写错误。');
		$("#yearInterestRate").focus();
		return false;
	}
	$("#yearInterestRate").val(parseFloat($.trim($("#yearInterestRate").val())));
}

$("#yearInterestRate").blur(checkYearInterestRate);
</script>
</body>
</html>
