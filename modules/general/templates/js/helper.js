var helper={
	getAttrs:function(obj){
		var str = '';
		for(var e in obj){
			str+=' '+e;
		}
		alert(str);
	}
}

var form_select = {
	
	add:function (element,data) {
		element = this.getObject(element);
		var option = document.createElement('option');
		option.value = data.value;
		option.text = data.text;
		try {
			element.add(option,null);
		} catch (e) {
			element.add(option);
		}
	},
	
	removeAll:function (element) {
		element = this.getObject(element);
		while (element.options.length > 0) {
			element.remove(0);
		}
	},
	removeAt:function (element,at) {
		element = this.getObject(element);
		element.remove(at);
	},
	unSelectAt:function (element,at) {
		element = this.getObject(element);
		element.options[at].selected = false;
	},
	unSelectAll:function (element) {
		element = this.getObject(element);

		for (var i=0; i < element.length; i++) {
			this.unSelectAt(element,i);
		}
	},
	hasManySelect:function (element) {
		var j = 0;
		element = this.getObject(element);
		for (var i=0; i < element.length; i++) {
			
			if (element.options[i].selected) {
				j++;
			}
		}
		
		return (j > 1) ? true : false;
	},
	selectAt:function (element,value) {
		element = this.getObject(element);
		for (var i=0; i < element.length; i++) {
			if (element.options[i].value == value) {
				//element.selectIndex  = i;
				element.options[i].selected = true;
				break;
			}
		}
		
	},
	selectAll:function (element) {
		element = this.getObject(element);
		for (var i=0; i < element.length; i++) {
			element.options[i].selected = true;
		}
	},
	findIndex:function (element,value) {
		element = this.getObject(element);
		for (var i=0; i < element.length; i++) {
			if (element.options[i].value == value) {
				//element.selectIndex  = i;
				return i;
				break;
			}
		}
		return 0;
	},
	getObject:function (element) {
		if (typeof element == 'string') {
			element = document.getElementById(element);
		}
		return element;
	},
	move2:function (from,to) {
	}
}

var from_multiselect = {
	value_ar : [],
	id : '',
	setup : function (id) {
		from_multiselect.id = id.replace('#', '');
		jQuery('#' + from_multiselect.id + ' > option').each(function (index, item) {    
			if (jQuery(item).attr('selected')) {
				from_multiselect.value_ar.push(jQuery(item).val());
			}
		});
		
		jQuery('#' + from_multiselect.id).click(function () { 
			form_select.unSelectAll(id);
			from_multiselect.restore();
		});
	},
	
	restore : function () {
		if (from_multiselect.value_ar.length == 0) return;
		for (i = 0; i < from_multiselect.value_ar.length ; i++) {
			form_select.selectAt(from_multiselect.id, from_multiselect.value_ar[i]);
		}											
	}
}
