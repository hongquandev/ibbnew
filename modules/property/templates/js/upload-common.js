function deleteAction(url,target,is_admin){
	if (is_admin == 1) {
		Ext.Msg.show({
				title:'Delete record?'
				,msg:'Do you really want to delete ?'
				,icon:Ext.Msg.QUESTION
				,buttons:Ext.Msg.YESNO
				,scope:this
				,fn:function(response) {
					if('yes' !== response) {
						return ;
					}
					
					$.post(url,{target:target},onDeleteAction,'html');
				}
			});
		
	} else {
        confirm_del(url,target,'onDeleteAction','Do you want to delete ?');
    }
}

function onDeleteAction(data){
	var JSONobject = jQuery.parseJSON(data);
	if(JSONobject.success == 1) {
		if(JSONobject.target != null) {
			if (typeof JSONobject.type != 'undefined' && JSONobject.type == 'doc') {
				jQuery('#'+JSONobject.target).html(JSONobject.replace_text);
			} else {
				jQuery('#'+JSONobject.target).hide();
			}
		}
	} else {
		//alert('Error when deleting.');
		showMess('Error when deleting.');
	}
}


function defaultAction(url,target,is_admin){
	if (is_admin == 1) {
		Ext.Msg.show({
				title:'Default record?'
				,msg:'Do you really want to default ?'
				,icon:Ext.Msg.QUESTION
				,buttons:Ext.Msg.YESNO
				,scope:this
				,fn:function(response) {
					if('yes' !== response) {
						return ;
					}
					$.post(url,{target:target},onDefaultAction,'html');
				}
		});
	} else {
		$.post(url,{target:target},onDefaultAction,'html');
	}
}

function onDefaultAction(data){
	var JSONobject = jQuery.parseJSON(data);
	if(JSONobject.success == 1) {
		if(JSONobject.target != null) {
			var ar = JSONobject.target.split('_');
			jQuery('[id^=' + ar[0] + '_]').each(function() {
				if (jQuery(this).attr('id') == JSONobject.target) {
				} else if (JSONobject['default'] == 1 ){
					jQuery(this).val(0);
					jQuery('#uniform-' + jQuery(this).attr('id')+' > span').html('none');
				}
			});
		}
	} else {
		//alert('Error when choose default.');
		showMess('Error when choose default.');
	}
}

var popup_delete = null;
popup_delete = new Popup();
popup_delete.init({id:'popup_delete',className:'popup_overlay'});
function confirm_del(url, target, fnc, msg, mode) {
	if(mode == null) {
		popup_delete.updateContainer('<div class="popup_container" style="width:356px;height: 122px;min-height: 120px;"><div id="contact-wrapper">\
		<div class="title"><h2 id="txtt"> This page says:<span id="btnclosex" onclick="confirm_del(\''+url+'\',\''+target+'\',\''+fnc+'\',\''+msg+'\',\'cancel\')">x</span></h2> </div>\
		<div class="clearthis" style="clear:both;"></div>\
		<div align="center" style="margin-bottom: 20px; margin-top: 20px;" class="content content-po" id="msg"> '+msg+'</div>\
		<div align="center" class="button" style="margin: 5px 25px 0px 30px;"><button class="btn-red" style="margin-right: 25px;" onclick="confirm_del(\''+url+'\',\''+target+'\',\''+fnc+'\',\''+msg+'\',\'ok\')"><span><span>OK</span></span></button>\
		<button style="width:84px;*width:74px;" class="btn-red" onclick="confirm_del(\''+url+'\',\''+target+'\',\''+fnc+'\',\''+msg+'\',\'cancel\')"><span><span>CANCEL</span></span></button></div>\
		</div></div></div>');
		popup_delete.show().toCenter();
	} else {
		if(mode == 'cancel') {
			jQuery(popup_delete.container).fadeOut('slow',function(){popup_delete.hide()});
		} else {
			jQuery(popup_delete.container).fadeOut('slow',function(){popup_delete.hide()});
			$.post(url,{target:target},onDeleteAction,'html');
		}
	}
}
//END
