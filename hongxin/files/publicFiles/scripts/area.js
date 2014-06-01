function area()
{
	this.url = '';
	
	this.joinBy = 'id';//id or name
	
	this.defaultProvinceId = 0;
	this.defaultCityId = 0;
	this.defaultCountyId = 0;
	
	this.defaultProvinceName = null;
	this.defaultCityName = null;
	this.defaultCountyName = null;
	
	this.provinceElementId = 'province';
	this.cityElementId = 'city';
	this.countyElementId = 'county';
	
	this.provinceSelectedKey = null;
	this.citySelectedKey = null;
	this.countySelectedKey = null;
}

area.prototype.set = function()
{
	var obj = this;
	document.getElementById(this.provinceElementId).onchange = function(){
		obj.provinceSelectedKey = this.selectedIndex > 0 ? this.selectedIndex - 1 : null;
		obj.loadCity();
	}
	document.getElementById(this.cityElementId).onchange = function(){
		obj.citySelectedKey = this.selectedIndex > 0 ? this.selectedIndex - 1 : null;
		obj.loadCounty();
	}
	this.loadProvince();
}

area.prototype.loadProvince = function()
{
	var data = this.data;
	var element = document.getElementById(this.provinceElementId);
	var value;
	var text;
	var defaultValue = this.joinBy == 'id' ? this.defaultProvinceId : this.defaultProvinceName;
	
	if (this.provinceSelectedKey == null) {
		if (element.length == 0) {
			var nullValue = this.joinBy == 'id' ? 0 : '';
			element.options[0] = new Option(nullValue, '省份');
		}
	}
	element.length = 1;

	for(var i = 0; i <= data.length - 1; i++) {
		value = this.joinBy == 'id' ? data[i].id : data[i].name;
		text = data[i].name;
		element.options[i+1] = new Option(text, value);
		if (element.options[i+1].value == defaultValue) {
			element.options[i+1].selected = true;
			this.provinceSelectedKey = i;
		}
	}
	this.loadCity();
}

area.prototype.loadCity = function()
{
	var element = document.getElementById(this.cityElementId);
	var value;
	var text;
	var defaultValue = this.joinBy == 'id' ? this.defaultCityId : this.defaultCityName;
	if (!element) {
		return false;
	}

	if (this.citySelectedKey == null) {
		if (element.length == 0) {
			var nullValue = this.joinBy == 'id' ? 0 : '';
			element.options[0] = new Option(nullValue, '城市');
		}
	}
	element.length = 1;
	
	if (this.provinceSelectedKey == null) {
		this.loadCounty();
		return ;
	}

	var data = this.data[this.provinceSelectedKey].city;
	var selectIndex = null;
	for(var i = 0; i <= data.length - 1; i++) {
		value = this.joinBy == 'id' ? data[i].id : data[i].name;
		text = data[i].name;
		element.options[i+1] = new Option(text, value);
		if (element.options[i+1].value == defaultValue) {
			element.options[i+1].selected = true;
			selectIndex = i;
		}
	}
	this.citySelectedKey = selectIndex;

	this.loadCounty();
}

area.prototype.loadCounty = function()
{	
	var element = document.getElementById(this.countyElementId);
	var value;
	var text;
	var defaultValue = this.joinBy == 'id' ? this.defaultCountyId : this.defaultCountyName;
	if (!element) {
		return false;
	}

	if (this.countySelectedKey == null) {
		if (element.length == 0) {
			var nullValue = this.joinBy == 'id' ? 0 : '';
			element.options[0] = new Option(nullValue, '区/县');
		}
	}
	element.length = 1;

	if (this.provinceSelectedKey == null || this.citySelectedKey == null) {
		return ;
	}

	var data = this.data[this.provinceSelectedKey].city[this.citySelectedKey].county;
	var selectIndex = null;
	for(var i = 0; i <= data.length - 1; i++) {
		value = this.joinBy == 'id' ? data[i].id : data[i].name;
		text = data[i].name;
		element.options[i+1] = new Option(text, value);
		if (element.options[i+1].value == defaultValue) {
			element.options[i+1].selected = true;
			selectIndex = i;
		}
	}
	this.countySelectedKey = selectIndex;
}