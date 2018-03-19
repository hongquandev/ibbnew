	var MediaManagement = function() {
		this.prepare = null;
		this.finish = null;
		this.type_send = 'html';
	}
	
	MediaManagement.prototype = {
		send: function(url) {
			if (this.prepare != null) {
				this.prepare();
			}
			
			if (this.finish != null) {
				jQuery.post(url,{},this.finish,this.type_send);
			} else {
				jQuery.post(url,{},this.onSend,this.type_send);
			}
		}
		
		,onSend: function(data) {
			var info = jQuery.parseJSON(data);
			if (info.data) {
				jQuery('#pvm-right').html(info.data);
			} else {
				alert('failure');
			}
		}
	}
	
	var mm = new MediaManagement();
	var mm_popup = new Popup();
	
	//sendfriend_data = ['property_id','email_from','email_to','message']; 
	
	mm.prepare = function() {
		jQuery('#mm_loading').show();
	};
	
	mm.finish = function(data) {
		var info = jQuery.parseJSON(data);
		if (info.data) {
			jQuery('#mm-right').html(info.data);
		} else {
			alert('failure');
		}
		jQuery('#mm_loading').hide();
		//pvm.clear('#frmPVM',['email_to','message']);//clear data from SendFriend form
		//jQuery(pvm_popup.container).fadeOut('slow',function(){pvm_popup.hide()});
	};
	
	//END
	/*
	pvm_popup.init({id:'pvm_popup',className:'popup_overlay'});
	
	pvm_popup.updateContainer('<div class="popup_container" style="width:400px"></div>');
	*/
	function showMM() {
		mm_popup.show().toCenter();
		jQuery('#mm_loading').hide();
		/*
		jQuery('#frmMM [name=property_id]').val(property_id);
		jQuery('#frmMM [name=email_from]').val(email);
		*/
	}
	
	function closeMM() {
		jQuery('#mm_loading').hide();
		//pvm.clear('#frmPVM',['email_to','message']);
		jQuery(mm_popup.container).fadeOut('slow',function(){mm_popup.hide()});
	}
//END