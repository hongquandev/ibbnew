var Report = function (form) {
	this.form = form;
}

Report.prototype = {
	callback_func :[],
	
	goto:function(url){
		document.location = url;
	},
	
	submit:function(next){
		//input:frm='#frmProperty'
		var validation = new Validation(this.form);
		var ok = true;
		if (this.callback_func.length > 0) {
			for (i = 0; i < this.callback_func.length ;i++) {
				if (this.callback_func[i]()==false){
					ok = false;
				}
			}
		}
		
		if(ok && validation.isValid()){
			if (next == true) {
				jQuery(this.form+' [name=next]').val(1);
			}
			jQuery(this.form).submit();
		}
	},
	
	flushCallback: function(){
		this.callback_func = [];
	},
	
	search: function() {
		hideMsg();
		var search_query = '';
		var date_begin = document.getElementById('date_begin').value;
		var date_end = document.getElementById('date_end').value;
		
		if (date_begin.length > 0 && date_end.length > 0) {
			self._store.load({params:{start:0, limit:20, date_begin:date_begin, date_end:date_end}});
		} else {
			Ext.Msg.alert('Warning.','Please input enought information.');		
		}
	},
	/*
	isSubmit: function() {
		var is_submit = jQuery('#is_submit').val();
		if (is_submit == 1) {
			return true;
		} else {
			return false;
		}
	}
	*/
	
	eventHover: function(id) {
		//alert(jQuery('content_'+id).val());
	},
	
	eventUnHover: function(id) {
		//alert(id+'unhover');
	},
	

	showBox: function(message_id,target,token) {
		url = '/modules/report/action.admin.php?action=view-email_enquire-detail';
		$.post(url,{message_id:message_id,target:target,token:token},this.onShowBox,'html');	
	},
	
	onShowBox: function(data) {
		var json = jQuery.parseJSON(data);
		if (json.target.length > 0) {
			jQuery('#'+json.target).show();
			jQuery('#'+json.target).html(json.msg);
		}
	},
	
	pageSelect3: function(obj) {
		self._store3.load({params:{start:0, limit:20, time_at :jQuery(obj).val()}});
	},
	
	pageSelect4: function(obj) {
		self._store4.load({params:{start:0, limit:20, time_at :jQuery(obj).val()}});
	}
	
	
}