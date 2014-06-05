/*
  名称: trim
  功能: 删除字符两边空格
*/
function trim(val)
{
    return val.replace(/(^\s*)|(\s*$)/g,"");
}

/*
  名称: selectAllClear
  功能: 把同名多选框全部取消
*/
function selectAllClear(checkBoxName)
{
    var el=document.getElementsByName(checkBoxName);
    for( i=0;i<=el.length-1;i++ ){
		if ( el[i].type=='checkbox' ){
			if ( el[i].disabled!=true ){
            	el[i].checked=false;
			}
        }
    }
}

/*
  名称: selectAlll
  功能: 把同名多选框全部选择和取消选择
*/
function selectAlll(checkBoxName, controlCheckBoxId)
{
    if ( document.getElementById(controlCheckBoxId).checked==true ){
        selectAllSet(checkBoxName);
    }else{
        selectAllClear(checkBoxName);
    }
}

/*
  名称: selectAllSet
  功能: 把同名多选框全部选择
*/
function selectAllSet(checkBoxName)
{
    var el=document.getElementsByName(checkBoxName);
    for( i=0;i<=el.length-1;i++ ){
        if ( el[i].type=='checkbox' ){
			if ( el[i].disabled!=true ){
				el[i].checked=true;
			}
        }
    }
}

/*
  名称: numberCheck
  功能: 检查是否为数字 type=0检测整数, type=1检测小数
*/
function numberCheck(element, defaultValue, type)
{
	if ( type==0 ){
		if ( element.value.search(/^[\+|\-]{0,1}[\d]+$/)==-1 ){
			element.value=defaultValue;
		}
	}else if ( type==1 ){
		if ( !(element.value.search(/^[\+|\-]{0,1}[\d]+$/)>-1 || element.value.search(/^[\+|\-]{0,1}[\d]+[\.]{1}[\d]+$/)>-1) ){
			element.value=defaultValue;
		}
	}
}

/*
  名称: switchDisplay
  功能: 显示开关
*/
function switchDisplay(id)
{
	if ( document.getElementById(id) ) {
		if ( document.getElementById(id).style.display == 'none' ) {
			if (document.getElementById(id).tagName == "DIV") {
				document.getElementById(id).style.display = 'block';
			} else {
				document.getElementById(id).style.display = '';
			}
		} else {
			document.getElementById(id).style.display = 'none';
		}
	}
}

/*
  名称: getRadioSelectedElement
  功能: 显示开关
*/
function getRadioSelectedElement(elementName)
{
	var nameArray=document.getElementsByName(elementName);
	for( var i=0;i<=nameArray.length-1;i++ ){
		if ( nameArray[i].checked==true ){
			return nameArray[i];
		}
	}
}

/*
  名称: addEventHandle
  功能: 添加监听
*/
function addEventHandler(target, type, func)
{
    if (target.addEventListener)
        target.addEventListener(type, func, false);
    else if (target.attachEvent)
        target.attachEvent("on" + type, func);
    else target["on" + type] = func;
}

/*
  名称: removeEventHandler
  功能: 移除监听
*/
function removeEventHandler(target, type, func)
{
    if (target.removeEventListener)
        target.removeEventListener(type, func, false);
    else if (target.detachEvent)
        target.detachEvent("on" + type, func);
    else delete target["on" + type];
}

/*
  名称: loadXmlFile
  功能: 加载xml数据
*/
function loadXmlFile(xmlFile)
{
	var xmlDom = null;
	if (window.ActiveXObject) {
		xmlDom = new ActiveXObject("Microsoft.XMLDOM");
		xmlDom.async = false;
		xmlDom.load(xmlFile);//如果用的是xml文件。
	} else if (document.implementation && document.implementation.createDocument){
    	var xmlhttp = new window.XMLHttpRequest();
    	xmlhttp.open("GET", xmlFile, false);
    	xmlhttp.send(null);
		xmlDom = xmlhttp.responseXML;
	}else{
    	xmlDom = null;
  }
  return xmlDom;
}

/*
  名称: loadScript
  功能: 加载script
*/
function loadScript(url, callback)
{
    var script = document.createElement("script")
    script.type = "text/javascript";
    if (script.readyState){  //IE
        script.onreadystatechange = function(){
            if (script.readyState == "loaded" ||
                    script.readyState == "complete"){
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {  //Others
        script.onload = function(){
            callback();
        };
    }
    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
}

/*
  名称: loadCss
  功能: 加载css
*/
function loadCss(url)
{
	var cssLink = document.createElement("link");
	cssLink.rel = "stylesheet";
	cssLink.rev = "stylesheet";
	cssLink.type = "text/css";
	cssLink.media = "screen";
	cssLink.href = url;
	document.getElementsByTagName("head")[0].appendChild(cssLink);
}

Array.prototype.inArray = function(e) 
{ 
    for(i=0;i<this.length;i++)
    {
        if(this[i] == e)
        return true;
    }
    return false;
}

/*
  名称: preventSelectDisabled
  功能: select disabled 兼容ie6
*/
function preventSelectDisabled(oSelect)
{
	var isOptionDisabled = oSelect.options[oSelect.selectedIndex].disabled;
	if(isOptionDisabled) {
		oSelect.selectedIndex = oSelect.defaultSelectedIndex;
		return false;
	}else {
		oSelect.defaultSelectedIndex = oSelect.selectedIndex;
		return true;
	}
}

/*
  名称: strlen
  功能: 测试字符长度
*/
function strlen(string)
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


function setHome(obj, vrl)
{
	try {
		obj.style.behavior='url(#default#homepage)';obj.setHomePage(vrl);
	}
	catch(e){
		if(window.netscape) {
			try {
				netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
			}
			catch (e) {
				alert("抱歉！您的浏览器不支持直接设为首页。请在浏览器地址栏输入“about:config”并回车然后将[signed.applets.codebase_principal_support]设置为“true”，点击“加入收藏”后忽略安全提示，即可设置成功。");
			}
			var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
			prefs.setCharPref('browser.startup.homepage',vrl);
		 }
	}
}

function bookmark(title, url)
{
	if (document.all) {
		window.external.AddFavorite(url, title);
	} else if (window.sidebar) {
		window.sidebar.addPanel(title, url, "");
	}
}

var layerhtml;
function layerWindow(title, page) {
	$.layer({
        type: 1,
        title: title,
        offset: [($(window).height() - 290)/2+'px', ''],
        border : [5, 0.5, '#666'],
        area: ['450px','290px'],
        shadeClose: false,
        page: page
    });
};

function popupWindow(title, url)
{
	var page = {};
	//if(layerhtml) {
	//	page.html = layerhtml;
	//} else {
		page.url = url;
		page.ok = function(datas) {
			layerhtml = datas;
		}
	//}
	layerWindow(title, page);
}
