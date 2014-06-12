<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->baseUrl;?>/files/default/css/base.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/date/calendar-blue.css" rel="stylesheet"  type="text/css" />
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jquery.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/public.js"></script>
<script language="javascript" src="<?php echo $this->baseUrl;?>/files/publicFiles/scripts/jqueryLayer/layer.min.js"></script>
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
						<td width="15%" align="left">票面金额：</td>
						<td align="left"><input name="ticketAmount" type="text" class="validate[required,onlyNumber] input" id="ticketAmount" value="" size="15"/>元 </td>
					</tr>
					<tr>
						<td align="left">银行承兑汇票扫描件：</td>
						<td align="left"><input type="file" name="ticketCopy" id="ticketCopy" /></td>
					</tr>
					<tr>
						<td align="left">年利率：</td>
						<td align="left"><input name="yearInterestRate" type="text" class="input" value="<?php echo $this->maxYearRate; ?>" id="yearInterestRate" size="15"/><span id="percent">%</span></td>
					</tr>
					<tr>
						<td align="left">融资截止日期：</td>
						<td align="left">
						<input name="applyEndDate" type="text" class="input" readonly="readonly" id="applyEndDate" value="" size="15"/>
						<script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","firstDay":0,"showsTime":false,"showOthers":false,"inputField":"applyEndDate","button":"applyEndDate", "onUpdate":function(){ calculateAmount(); }});</script></td>
					</tr>
					<tr>
						<td align="left">票据截止日期：</td>
						<td align="left">
						<input name="ticketEndDate" type="text" class="input" readonly="readonly" id="ticketEndDate" value="" size="15"/>
						<script type="text/javascript">Calendar.setup({"ifFormat":"%Y-%m-%d","firstDay":0,"showsTime":false,"showOthers":false,"inputField":"ticketEndDate","button":"ticketEndDate", "onUpdate":function(){ calculateAmount(); }});</script></td>
					</tr>
					<tr>
						<td width="15%" align="left">融资金额：</td>
						<td align="left"><input name="amount" type="text" class="input" id="amount" onfocus="this.blur();" value="" size="15" readonly="readonly" style="border: 0;"/>元 </td>
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
						<td align="left"><textarea name="notes" cols="60" rows="5" class="input" id="notes"></textarea></td>
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
	} else*/ if ($.trim($("#ticketAmount").val()) == "" || parseFloat($.trim($("#ticketAmount").val())) == 0) {
		alert('请填写票面金额。');
		$("#amount").focus();
		return false;
	} else if (parseFloat($.trim($("#ticketAmount").val())) <= 0 || isNaN($.trim($("#ticketAmount").val()))) {
		alert('票面金额填写错误。');
		$("#amount").focus();
		return false;
	}
	if($("#ticketCopy").val() == "") {
		alert('请选择银行承兑汇票扫描件。');
		return false;
	} else if(!validateFileExt($("#ticketCopy").val())) {
		alert('银行承兑汇票扫描件格式不正确。');
		return false;
	}
	if (checkYearInterestRate() == false) {
		return false;
	}
	if($("#applyEndDate").val() == "") {
		alert('请选择融资截止日期。');
		return false;
	}
	if(compareDate(new Date().format('yyyy-MM-dd'), $("#applyEndDate").val()) != 1) {
		alert('融资截止日期必须大于当前日期。');
		return false;
	}	
	if($("#ticketEndDate").val() == "") {
		alert('请选择票据截止日期。');
		return false;
	}
	if(compareDate($("#applyEndDate").val(), $("#ticketEndDate").val()) != 1) {
		alert('票据截止日期必须大于融资截止日期。');
		return false;
	}
	if($("#repayEndTime").val() == "") {
		alert('请选择最迟还款日期。');
		return false;
	}
	if(compareDate($("#ticketEndDate").val(), $("#repayEndTime").val()) != 1) {
		alert('最迟还款日期必须大于票据截止日期。');
		return false;
	}
	if($("#repayBank option:selected").val() == "") {
		alert('请选择到期承诺还款银行。');
		return false;
	}
	return true;
});

/*验证年利率*/
function checkYearInterestRate()
{
	if($.trim($("#yearInterestRate").val()) == '') {
		alert('请填写年利率。');
		return false;
	}
	if (parseFloat($.trim($("#yearInterestRate").val())) <= 0 || isNaN($.trim($("#yearInterestRate").val()))) {
		alert('年利率填写错误。');
		$("#yearInterestRate").focus();
		return false;
	}
}

function calculateAmount() {
	if($.trim($("#ticketAmount").val()) == "" || $.trim($("#yearInterestRate").val()) == "" ||
	   $.trim($("#ticketEndDate").val()) == "" || $.trim($("#applyEndDate").val()) == "") {
	   $("#amount").val("");
	   return false;
	}
	var amount = parseFloat($.trim($("#ticketAmount").val()));
	var yearRate = parseFloat($.trim($("#yearInterestRate").val()));
	var benifitDay = diffDate($.trim($("#ticketEndDate").val()), $.trim($("#applyEndDate").val()));
	var benifit = 0;
	if(benifitDay > 0) {
		benifit = amount * (1-(yearRate/100)) * (benifitDay/365);
	}
	benifit = Math.round(benifit*100)/100;
	$("#amount").val(benifit);
}

$("#ticketAmount").change(function(){ calculateAmount(); });
//$("#ticketEndDate").change(function(){ calculateAmount(); });
//$("#applyEndDate").change(function(){ calculateAmount(); });

$("#yearInterestRate").focusin(function(){
	layer.tips('利率精确到小数点后一位，<br/>范围5%-10%之间。融资最<br/>低利率由您的融资期限确<br/>定，一般来说融资利率越<br/>高，筹款速度越快。', 
			$("#percent") , {guide: 1, style: ['background-color:#FDFD79; color:#000;', '#FDFD79']});
	$(".xubox_main").parent().css("top", "256px");
}).focusout(function(){
	$(".xubox_tips").hide();
}).change(function(){
	calculateAmount();
});
</script>
</body>
</html>
