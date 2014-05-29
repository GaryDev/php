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
    	<div class="nytit6"><h3>融资申请</h3></div>
		<div class="nytxt6 search">
			<form id="applyForm" name="applyForm" enctype="multipart/form-data" method="post" action="">
				<table width="100%" border="0" align="left" class="table">
					<!--  
					<tr>
						<td align="left">融资标题：</td>
						<td align="left"><input name="title" type="text" class="input" id="title" size="40"/> <span class="desc">简单说明融资用途</span></td>
					</tr>
					-->
					<tr>
						<td align="left">融资金额：</td>
						<td align="left"><input name="amount" type="text" class="input" id="amount" value="0" size="15"/>元 </td>
					</tr>
					<tr>
						<td align="left">银行承兑汇票扫描件：</td>
						<td align="left"><input type="file" name="ticketCopy" id="ticketCopy" /></td>
					</tr>
					<tr>
						<td align="left">年利率：</td>
						<td align="left"><input name="yearInterestRate" type="text" class="input" id="yearInterestRate" size="15"/>
							% <span style="color: #000;">（指导年利率<span id="maxYearRate" style="color: red; font-weight: bold;"><?php echo $this->maxYearRate;?></span>%）</span></td>
					</tr>
					<tr>
						<td align="left">融资截止日期：</td>
						<td align="left">
						<input name="applyEndDate" type="text" class="input" readonly="readonly" id="applyEndDate" value="" size="15"/>
						<script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","firstDay":0,"showsTime":false,"showOthers":false,"inputField":"applyEndDate","button":"applyEndDate"});</script></td>
					</tr>
					<tr>
						<td align="left">票据截止日期：</td>
						<td align="left">
						<input name="ticketEndDate" type="text" class="input" readonly="readonly" id="ticketEndDate" value="" size="15"/>
						<script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","firstDay":0,"showsTime":false,"showOthers":false,"inputField":"ticketEndDate","button":"ticketEndDate"});</script></td>
					</tr>
					<tr>
						<td align="left">最迟还款日期：</td>
						<td align="left">
						<input name="repayEndTime" type="text" class="input" readonly="readonly" id="repayEndTime" value="" size="15"/>
						<script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","firstDay":0,"showsTime":false,"showOthers":false,"inputField":"repayEndTime","button":"repayEndTime"});</script></td>
					</tr>
					<tr>
						<td align="left">到期承诺还款银行：</td>
						<td align="left">
						<select name="repayBank" id="repayBank" style="width: 20%">
							<option value="">请选择</option>
							<?php foreach ($this->banks as $bank) {?>
							<option value="<?php echo $bank; ?>"><?php echo $bank; ?></option>
							<?php } ?>
						</select>
						</td>
					</tr>
					<tr>
						<td align="left">融资说明：</td>
						<td align="left"><textarea name="notes" cols="60" rows="5" class="input" id="notes"></textarea>
						<br/><span class="desc">（请详细填写融资用途，可以更快的帮您获得借款。最大800字）</span></td>
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
