var BannerArea = function () {
}

BannerArea.prototype = {
	change: function (url, o1, o2) {
		var param = new Object();
		param.area_id = jQuery(o1).val();
		param.target = o2;
		jQuery.post(url, param, this.onChange, 'json');		
	}
	
	, onChange: function (data) {
		if (data.error == 1) 
			return ;
			
		data.target = data.target.replace('#', '');
		form_select.removeAll(data.target);
		if (data.content) {
			for (var el in data.content) {
				if (parseInt(el) >= 0) {
					form_select.add(data.target, {'value' : el, 'text' : data.content[el]})
				}
			}
		}
	}
}

var banner_area = new BannerArea();
