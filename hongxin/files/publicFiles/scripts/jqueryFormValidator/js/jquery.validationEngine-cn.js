/*
 * Inline Form Validation Engine, jQuery plugin
 * 
 * Copyright(c) 2009, Cedric Dugas
 * http://www.position-relative.net
 *	
 * Form validation engine witch allow custom regex rules to be added.
 * Licenced under the MIT Licence
 */

$(document).ready(function() {

	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("[class^=validate]").validationEngine({
		success :  false,
		failure : function() {}
	})
});

jQuery.fn.validationEngine = function(settings) {
	if($.validationEngineLanguage){					// IS THERE A LANGUAGE LOCALISATION ?
		allRules = $.validationEngineLanguage.allRules
	}else{
		allRules = {"required":{    			  // Add your regex rules here, you can take telephone as an example
							"regex":"none",
							"alertText":"* 不能为空。",
							"alertTextCheckboxMultiple":"* 请勾选。",
							"alertTextCheckboxe":"* 请勾选。"},
						"length":{
							"regex":"none",
							"alertText":"* 长度必须是 ",
							"alertText2":" 至 ",
							"alertText3": " 个字符。"},
						"minLength":{
							"regex":"none",
							"alertText":"* 长度至少是{length}个字符。 "},
						"maxLength":{
							"regex":"none",
							"alertText":"* 长度最多是{length}个字符。 "},
						"minCheckbox":{
							"regex":"none",
							"alertText":"* 输入错误。"},	
						"confirm":{
							"regex":"none",
							"alertText":"* 输入不匹配。"},		
						"telephone":{
							"regex":"/^(0[0-9]{2,3}\-[0-9]{7,8}){0,1}$/",
							"alertText":"* 无效的电话号码，正确的例如：021-88888888。"},	
						"qq":{
							"regex":"/^([0-9]{5,10}){0,1}$/",
							"alertText":"* 无效的QQ号码。"},	
						"mobileTelephone":{
							"regex":"/^1[358][0-9]{9}$/",
							"alertText":"* 无效的手机号。"},	
						"email":{
							"regex":"/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/",
							"alertText":"* 无效的电子邮件地址。"},	
						"date":{
                             "regex":"/^[0-9]{4}\-\[0-9]{1,2}\-\[0-9]{1,2}$/",
                             "alertText":"* 无效的时间, 格式例如：YYYY-MM-DD。"},
						"onlyNumber":{
							"regex":"/^[0-9\ ]+$/",
							"alertText":"* 只能输入数字。"},	
						"noSpecialCaracters":{
							"regex":"/^[0-9a-zA-Z]+$/",
							"alertText":"* 只能输入英文字母、阿拉伯数字之间的字符。"},	
						"onlyLetter":{
							"regex":"/^[a-zA-Z\ \']+$/",
							"alertText":"* 只能输入英文字符。"}
					}	
	}

 	settings = jQuery.extend({
		allrules:allRules,
		success : false,
		failure : function() {}
	}, settings);	


	$("form").bind("submit", function(caller){   // ON FORM SUBMIT, CONTROL AJAX FUNCTION IF SPECIFIED ON DOCUMENT READY
		if(submitValidation(this) == false){
			if (settings.success){
				settings.success && settings.success(); 
				return false;
			}
		}else{
			settings.failure && settings.failure(); 
			return false;
		}
	})
	//$(this).not("[type=checkbox]").bind("blur", function(caller){loadValidation(this)})
	$(this).not(":checkbox").bind("blur", function(caller){loadValidation(this)})
	//$(this+"[type=checkbox]").bind("click", function(caller){loadValidation(this)})
	$(this).filter(":checkbox").bind("click", function(caller){loadValidation(this)})
	
	var buildPrompt = function(caller,promptText) {			// ERROR PROMPT CREATION AND DISPLAY WHEN AN ERROR OCCUR
		var divFormError = document.createElement('div')
		var formErrorContent = document.createElement('div')
		var arrow = document.createElement('div')
		
		
		$(divFormError).addClass("formError")
		$(divFormError).addClass($(caller).attr("name"))
		$(formErrorContent).addClass("formErrorContent")
		$(arrow).addClass("formErrorArrow")

		$("body").append(divFormError)
		$(divFormError).append(arrow)
		$(divFormError).append(formErrorContent)
		$(arrow).html('<div class="line10"></div><div class="line9"></div><div class="line8"></div><div class="line7"></div><div class="line6"></div><div class="line5"></div><div class="line4"></div><div class="line3"></div><div class="line2"></div><div class="line1"></div>')
		$(formErrorContent).html(promptText)
	
		callerTopPosition = $(caller).offset().top;
		callerleftPosition = $(caller).offset().left;
		callerWidth =  $(caller).width()
		callerHeight =  $(caller).height()
		inputHeight = $(divFormError).height()

		callerleftPosition = callerleftPosition + callerWidth -30
		callerTopPosition = callerTopPosition  -inputHeight -10
	
		$(divFormError).css({
			top:callerTopPosition,
			left:callerleftPosition,
			opacity:0
		})
		$(divFormError).fadeTo("fast",0.8);
	};
	var updatePromptText = function(caller,promptText) {	// UPDATE TEXT ERROR IF AN ERROR IS ALREADY DISPLAYED
		updateThisPrompt =  $(caller).attr("name")
		$("."+updateThisPrompt).find(".formErrorContent").html(promptText)
		
		callerTopPosition  = $(caller).offset().top;
		inputHeight = $("."+updateThisPrompt).height()
		
		callerTopPosition = callerTopPosition  -inputHeight -10
		$("."+updateThisPrompt).animate({
			top:callerTopPosition
		});
	}
	var loadValidation = function(caller) {		// GET VALIDATIONS TO BE EXECUTED
		
		rulesParsing = $(caller).attr('class');
		rulesRegExp = /\[(.*)\]/;
		getRules = rulesRegExp.exec(rulesParsing);
		str = getRules[1]
		pattern = /\W+/;
		result= str.split(pattern);	
		
		var validateCalll = validateCall(caller,result)
		return validateCalll
		
	};
	var validateCall = function(caller,rules) {	// EXECUTE VALIDATION REQUIRED BY THE USER FOR THIS FILED
		var promptText =""	
		var prompt = $(caller).attr("name");
		var caller = caller;
		isError = false;
		callerType = $(caller).attr("type");
		
		for (i=0; i<rules.length;i++){
			switch (rules[i]){
			case "optional": 
				if(!$(caller).val()){
					closePrompt(caller)
					return isError
				}
				break;
			case "required": 
				_required(caller,rules);
				break;
			case "custom": 
				 _customRegex(caller,rules,i);
				break;
			case "length": 
				 _length(caller,rules,i);
				break;
			case "minLength": 
				 _minLength(caller,rules,i);
				break;
			case "maxLength": 
				 _maxLength(caller,rules,i);
				break;
			case "minCheckbox": 
				 _minCheckbox(caller,rules,i);
				break;
			case "confirm": 
				 _confirm(caller,rules,i);
				break;
			case "callback" : 
				_callback(caller,rules,i);
				break;
			default :;
			};
		};
		if (isError == true){
			
			if($("input[name="+prompt+"]").size()> 1 && callerType == "radio") {		// Hack for radio group button, the validation go the first radio
				caller = $("input[name="+prompt+"]:first")
			}
			($("."+prompt).size() ==0) ? buildPrompt(caller,promptText)	: updatePromptText(caller,promptText)
		}else{
			closePrompt(caller)
		}		
		
		/* VALIDATION FUNCTIONS */
		function _required(caller,rules){   // VALIDATE BLANK FIELD
			callerType = $(caller).attr("type")
			
			if (callerType == "text" || callerType == "password" || callerType == "textarea"){
				
				if(!$(caller).val()){
					isError = true
					promptText += settings.allrules[rules[i]].alertText+"<br />"
				}	
			}
			if (callerType == "radio" || callerType == "checkbox" ){
				callerName = $(caller).attr("name")
		
				if($("input[name="+callerName+"]:checked").size() == 0) {
					isError = true
					if($("input[name="+callerName+"]").size() ==1) {
						promptText += settings.allrules[rules[i]].alertTextCheckboxe+"<br />" 
					}else{
						 promptText += settings.allrules[rules[i]].alertTextCheckboxMultiple+"<br />"
					}	
				}
			}	
			if (callerType == "select-one") { // added by paul@kinetek.net for select boxes, Thank you
					callerName = $(caller).attr("name");
				
				if(!$("select[name="+callerName+"]").val()) {
					isError = true;
					promptText += settings.allrules[rules[i]].alertText+"<br />";
				}
			}
			if (callerType == "select-multiple") { // added by paul@kinetek.net for select boxes, Thank you
				callerName = $(caller).attr("id");
				
				if(!$("#"+callerName).val()) {
					isError = true;
					promptText += settings.allrules[rules[i]].alertText+"<br />";
				}
			}
		}
		function _customRegex(caller,rules,position){		 // VALIDATE REGEX RULES
			var customRule = rules[position+1]
			pattern = eval(settings.allrules[customRule].regex)
			callerType = $(caller).attr("type");
			if(callerType != "radio" && callerType != "checkbox") {
				callerValue = $(caller).val();
			} else {
				callerValue = $(caller).attr('value');
			}
			if(callerValue && !pattern.test(callerValue)){
				isError = true
				promptText += settings.allrules[customRule].alertText+"<br />"
			}
		}
		function _confirm(caller,rules,position){		 // VALIDATE FIELD MATCH
			var confirmField = rules[position+1]
			
			//if($(caller).attr('value') != $("#"+confirmField).attr('value')){
			if($(caller).val() != $("#"+confirmField).val()){
				isError = true
				promptText += settings.allrules["confirm"].alertText+"<br />"
			}
		}
		function _length(caller,rules,position){    // VALIDATE LENGTH
		
			var startLength = eval(rules[position+1])
			var endLength = eval(rules[position+2])
			//var feildLength = _strlen($(caller).attr('value'))
			var feildLength = _strlen($(caller).val())

			if(feildLength<startLength || feildLength>endLength){
				isError = true
				promptText += settings.allrules["length"].alertText+startLength+settings.allrules["length"].alertText2+endLength+settings.allrules["length"].alertText3+"<br />"
			}
		}
		function _minLength(caller,rules,position){    // VALIDATE LENGTH
		
			var length = eval(rules[position+1])
			//var feildLength = _strlen($(caller).attr('value'))
			var feildLength = _strlen($(caller).val());

			if(feildLength<length){
				isError = true
				promptText += settings.allrules["minLength"].alertText.replace(/\{length\}/g, length)+"<br />"
			}
		}
		function _maxLength(caller,rules,position){    // VALIDATE LENGTH
		
			var length = eval(rules[position+1])
			//var feildLength = _strlen($(caller).attr('value'))
			var feildLength = _strlen($(caller).val());

			if(feildLength>length){
				isError = true
				promptText += settings.allrules["maxLength"].alertText.replace(/\{length\}/g, length)+"<br />"
			}
		}
		function _strlen(string)
		{
			var i, charCode, totalBytes = 0;
			for ( i=0; i < string.length; i++ ) {
				charCode = string.charCodeAt(i);
				if (charCode < 0x007F) {
					totalBytes += 1;
				} else if ((charCode >= 0x0080) && (charCode <= 0x07FF)) {
					totalBytes += 2;
				} else if ((charCode >= 0x0800) && (charCode <= 0xFFFF)) {
					totalBytes +=3;
				}
			}
			return totalBytes;
		}
		function _callback(caller,rules,position){    // VALIDATE callback
			func = rules[position+1];
			isBackValue = rules[position+2];
			if (isBackValue == 1) {
				func += "('"+ $(caller).val().replace(/'/g, "\\'") +"')";
			}
			eval("var result = " + func + ";");
			if (!result.isRight) {
				isError = true
				promptText += result.message + "<br />"
			}
		}
		function _minCheckbox(caller,rules,position){    // VALIDATE CHECKBOX NUMBER
		
			nbCheck = eval(rules[position+1])
			groupname = $(caller).attr("name")
			groupSize = $("input[name="+groupname+"]:checked").size()
			
			if(groupSize > nbCheck){	
				isError = true
				promptText += settings.allrules["minCheckbox"].alertText+"<br />"
			}
		}

		return(isError) ? isError : false;
	};
	var closePrompt = function(caller) {	// CLOSE PROMPT WHEN ERROR CORRECTED
		closingPrompt = $(caller).attr("name")

		$("."+closingPrompt).fadeTo("fast",0,function(){
			$("."+closingPrompt).remove()
		});
	};
	var submitValidation = function(caller) {	// FORM SUBMIT VALIDATION LOOPING INLINE VALIDATION
		var stopForm = false
		$(caller).find(".formError").remove()
		var toValidateSize = $(caller).find("[class^=validate]").size()
		
		$(caller).find("[class^=validate]").each(function(){
			var validationPass = loadValidation(this)
			return(validationPass) ? stopForm = true : "";	
		});
		if(stopForm){							// GET IF THERE IS AN ERROR OR NOT FROM THIS VALIDATION FUNCTIONS
			destination = $(".formError:first").offset().top;
			$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination}, 1100)
			return true;
		}else{
			return false
		}
	};
};