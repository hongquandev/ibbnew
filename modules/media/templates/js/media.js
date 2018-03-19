	var MediaManagement = function() {
		this.prepare = null;
		this.finish = null;
		this.content_type = 'html';
	}
	
	MediaManagement.prototype = {
		send: function(url) {
			if (this.prepare != null) {
				this.prepare();
			}
			
			if (this.finish != null) {
				jQuery.post(url,{},this.finish,this.content_type);
			} else {
				jQuery.post(url,{},this.onSend,this.content_type);
			}
		}
		
		,onSend: function(data) {
			var info = jQuery.parseJSON(data);
			if (info.data) {
				jQuery('#pvm-right').html(info.data);
			} else {
				alert('failure');
			}
		},
		
		getList: function(url) {
			
			if (this.prepare != null) {
				this.prepare();
			}
			
			if (this.finish != null) {
				jQuery.post(url,{},this.finish,this.content_type);
			} else {
				jQuery.post(url,{},this.onGetList,this.content_type);
			}
			
		},
		
		onGetList: function(data) {
			//var info = jQuery.parseJSON(data);
			if (data) {
				jQuery('#media_list').html(data);
			}
		}
	}
	
