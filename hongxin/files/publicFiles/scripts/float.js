function float(direction, x, y, html)
{
	//direction=1 : 左上, direction=2 : 左下, direction=3 : 右下, direction=4 : 右下
	var obj = document.createElement("div");
	obj.innerHTML = html;
	document.getElementsByTagName("body")[0].appendChild(obj);
	obj.style.position="absolute";
	
	if (document.all) {
		if (direction == 1) {
			obj.style.left = x + "px";
			obj.style.top = y + "px";
			initFunc = function(){obj.style.top=(document.documentElement.scrollTop + y)+"px";}
		} else if (direction == 2) {
			obj.style.left = x + "px";
			obj.style.bottom = y + "px";
			var offsetHeight = obj.offsetHeight

			initFunc = function(){obj.style.top=(document.documentElement.scrollTop + document.documentElement.clientHeight - y - offsetHeight)+"px";}
		} else if (direction == 3) {
			obj.style.right = x + "px";
			obj.style.top = y + "px";
			initFunc = function(){obj.style.top=(document.documentElement.scrollTop + y)+"px";}
		} else if (direction == 4) {
			obj.style.right = x + "px";
			obj.style.bottom = y + "px";
			var offsetHeight = obj.offsetHeight

			initFunc = function(){obj.style.top=(document.documentElement.scrollTop + document.documentElement.clientHeight - y - offsetHeight)+"px";}
		}
		initFunc();
		window.attachEvent('onresize', initFunc);
		window.attachEvent('onscroll', initFunc);
	} else {
		if (direction == 1) {
			obj.style.left = x + "px";
			obj.style.top = y + "px";
			initFunc = function(){	obj.style.top = y + "px"; obj.style.position="fixed";}
		} else if (direction == 2) {
			obj.style.left = x + "px";
			obj.style.bottom = y + "px";
			initFunc = function(){	obj.style.bottom = y + "px"; obj.style.position="fixed";}
		} else if (direction == 3) {
			obj.style.right = x + "px";
			obj.style.top = y + "px";
			initFunc = function(){	obj.style.top = y + "px"; obj.style.position="fixed";}
		} else if (direction == 4) {
			obj.style.right = x + "px";
			obj.style.bottom = y + "px";
			initFunc = function(){	obj.style.bottom = y + "px"; obj.style.position="fixed";}
		}
		initFunc();
		window.addEventListener('resize', initFunc, false);
		window.addEventListener('scroll', initFunc, false);
	}

}