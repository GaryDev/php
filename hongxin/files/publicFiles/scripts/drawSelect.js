function drawSelect(spaceElementId, instanceName){
	this.spaceElementId = spaceElementId;//select所在的节点ID
	this.instanceName = instanceName;//实例化名

	this.initUrl = '';
	this.initGetDataParamKey = 'code';

	this.changeUrl = '';
	this.changeGetDataParamKey = 'code';
	
	this.lastCodeElementId = 'lastId';//最后一个选择的的ID
	this.haveChildrenElementId = 'haveChildren';//最后一个选择是否还有子分类
}
drawSelect.prototype.init = function(id){
	var spaceElementId = this.spaceElementId;
	var spaceElement = document.getElementById(this.spaceElementId);
	var instanceName = this.instanceName;
	var getDataParamKey = this.initGetDataParamKey;
	var url = this.initUrl;
	var self = this;
	
	if (!spaceElement) {
		alert('空间不存在。');
		return ;
	}

	$.ajax({
		type: "POST",
		url: url,
		data : getDataParamKey + '=' + id,
		dataType: "json",
		async: true,
		success: function(data){
			var parentCode = '';
			for(var i = 0; i <= data.length - 1; i++) {
				var rows = data[i];
				if (i > 0) {
					spaceElement = childElement;
				}

				if (i == 0) {
					var parentElementId = '';
				} else {
					var parentElementId = selectElement.id;
				}

				var selectElement = document.createElement("select");
				selectElement.id = spaceElementId + '_' + parentCode;
				spaceElement.appendChild(selectElement);

				var childElement= document.createElement("span");
				childElement.id = spaceElementId + '_' + parentCode + '_span';
				spaceElement.appendChild(childElement);

				selectElement.onchange = function(){
					eval("var result=" + instanceName + ".change('"+ this.getAttribute('id') + "');");
					return result;
				}
				selectElement.options[0] = new Option('选择', '');
				
				selectElement.setAttribute('parentElementId', parentElementId);//设置上一级分类的名字
				for(var j = 0; j <= rows.length - 1; j++) {
					selectElement.options[j+1] = new Option(rows[j].name, rows[j].code);
					selectElement.options[j+1].setAttribute('num', rows[j].childRum);
					if (typeof(rows[j].selected) !== 'undefined') {
						selectElement.options[j+1].selected = true;
						parentCode = rows[j].code;
						self.setLastCode(rows[j].code);
						self.setHaveChildren(rows[j].childRum > 0 ? 1 : 0);
					}
				}
			}
		} 
	});
}

drawSelect.prototype.setLastCode = function(code){
	if (document.getElementById(this.lastCodeElementId)) {
		document.getElementById(this.lastCodeElementId).value = code;
	}
}

drawSelect.prototype.setHaveChildren = function(is){
	if (document.getElementById(this.haveChildrenElementId)) {
		document.getElementById(this.haveChildrenElementId).value = is;
	}
}

drawSelect.prototype.change = function(selectElementId){
	var element = document.getElementById(selectElementId);
	var index = element.selectedIndex;
	var spaceElementId = this.spaceElementId;
	var instanceName = this.instanceName;
	var self = this;
	
	//如果当前选中“选择”
	if (element.options[index].value == '') {
		//如果没有父节点ID
		if (element.getAttribute('parentElementId') != '') {
			this.setLastCode(document.getElementById(element.getAttribute('parentElementId')).value);
			this.setHaveChildren(1);
		} else {
			this.setLastCode('');
			this.setHaveChildren(0);
		}
		var spaceElement = document.getElementById(element.getAttribute('id') + '_span');
		spaceElement.innerHTML = '';//清空子节点的内容
	} else {
		//如果当前选择正常数据
		var num = element.options[index].getAttribute('num');
		var spaceElement = document.getElementById(element.getAttribute('id') + '_span');
		spaceElement.innerHTML = '';//清空子节点的内容

		if (num > 0) {
			var selectElement = document.createElement("select");
			selectElement.id = spaceElementId + '_' + element.options[index].value;
			spaceElement.appendChild(selectElement);
			selectElement.setAttribute('parentElementId', element.getAttribute('id'));//设置上一级分类的名字

			var childElement= document.createElement("span");
			childElement.id = spaceElementId + '_' + element.options[index].value + '_span';
			spaceElement.appendChild(childElement);
			
			
			selectElement.onchange = function(){
				eval("var result=" + instanceName + ".change('"+ this.getAttribute('id') + "');");
				return result;
			}
			selectElement.options[0] = new Option('loading...', '');
			$.ajax({
				type: "POST",
				url: this.changeUrl,
				data : this.changeGetDataParamKey + '=' + element.options[index].value,
				dataType: "json",
				async: true,
				success: function(data){
					selectElement.options[0] = new Option('选择', '');
					for(var j = 0; j <= data.length - 1; j++) {
						selectElement.options[j+1] = new Option(data[j].name, data[j].code);
						selectElement.options[j+1].setAttribute('num', data[j].childRum);
					}
				}
			});
			
			this.setHaveChildren(1);
		} else {
			this.setHaveChildren(0);
		}
		this.setLastCode(element.options[index].value);
		
	}
}