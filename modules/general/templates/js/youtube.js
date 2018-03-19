var YT = function() {
}

YT.prototype = {
	//BEGIN YOUTUBE
	getForm: function() {
		if (!jQuery('#if_target').length) {
			var url = '/modules/property/action.php?action=yt_form';
			yt.showLoading();
			jQuery.post(url,{},this.onGetForm,'html');	
		}
	},
	
	onGetForm: function(result) {
		yt.hideLoading();
		jQuery('#yt_form').html(result);
	},
	
	getId: function(id) {
		
	},
	
	del: function(id) {
		var url = '/modules/property/action.php?action=yt_delete';
		var param = {id:id};
		jQuery.post(url, param,this.onDel,'json');
		yt.showLoading();
	},
	
	onDel: function(data) {
		if (data.result == 1) {
			jQuery('#' + data.data).remove();
		}
		yt.hideLoading();
	},
	
	checkForFile: function() {
		if (jQuery('#yt_file').val().length == 0) {
			return false;
		}
		yt.showLoading();
	},
	
	showLoading: function() {
		jQuery('#yt_loading').show();
	},
	
	hideLoading: function() {
		jQuery('#yt_loading').hide();
	},
	
	prePackage: function() {
		if (jQuery('#yt_file').val().length > 0) {
			var url = '/modules/property/action.php?action=yt_testpackage';
			var id = jQuery('#p_id').val();
			if (!parseInt(id)) {
				id = jQuery('#property_id').val();
			}
			var param = {id : id};
			jQuery.post(url, param,this.onPrePackage,'json');
			yt.showLoading();
		}
	},
	
	onPrePackage: function(data) {
		if (data.msg && data.msg.length > 0) {
			try {
				showMess(data.msg);
			} catch (e) {
				alert(data.msg);
			}
			yt.hideLoading();
		} else {
			//jQuery('#yt_form').submit();
			document.yt_form.submit();
		}
	}
	
}

function getYTId() {
	//var id = jQuery.trim(frames['yt_if_target'].document.getElementsByTagName("body")[0].innerHTML);
	var id = jQuery.trim(frames['yt_if_target'].document.getElementsByTagName("div")[0].innerHTML);
	
	if (id.length > 0 && id.length < 50) {
		var html = jQuery('#yt_id').html();
		html += '<div id="'+id+'"> <img src="http://i.ytimg.com/vi/'+id+'/0.jpg" style="height:20px" > <a href="javascript:void(0)" onclick="yt.del(\''+id+'\')" >Delete</a></div>';
		jQuery('#yt_id').html(html);
	}
	
	yt.hideLoading();
}

function getYTId2(id) {
	
	if (id.length > 0 && id.length < 50) {
		var html = jQuery('#yt_id').html();
		html += '<div id="'+id+'"> <img src="http://i.ytimg.com/vi/'+id+'/0.jpg" style="height:20px" > <a href="javascript:void(0)" onclick="yt.del(\''+id+'\')" >Delete</a></div>';
		jQuery('#yt_id').html(html);
	}
	
	yt.hideLoading();
}


var yt = new YT();