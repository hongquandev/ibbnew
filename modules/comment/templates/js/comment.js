
var Comment = function(form, container) {
	DEFINE.COMMENT_SELF = this;
	this.form = form;
	this.container = container;
	this.def_val = {name:'Name',email:'Email',title:'Title',comment:'Comment'};
	this.init();
}

Comment.prototype = {
	init:function() {
		this.onBlur(jQuery('input[name=name]', this.form), this.def_val.name);
		this.onFocus(jQuery('input[name=name]', this.form), this.def_val.name);

		this.onBlur(jQuery('input[name=email]', this.form), this.def_val.email);
		this.onFocus(jQuery('input[name=email]', this.form), this.def_val.email);

		this.onBlur(jQuery('input[name=title]', this.form), this.def_val.title);
		this.onFocus(jQuery('input[name=title]', this.form), this.def_val.title);

		this.onBlur(jQuery('textarea[name=content]', this.form), this.def_val.comment);
		this.onFocus(jQuery('textarea[name=content]', this.form), this.def_val.comment);
	},
	
	onBlur:function(obj, def_val) {
		jQuery(obj).blur(function() {
			if ((jQuery(obj).val()).length == 0) {
				jQuery(obj).val(def_val);
			}
		});
	},

    onFocus:function(obj, def_val) {
		jQuery(obj).focus(function() {
			if (jQuery(obj).val() == def_val) {
			jQuery(obj).val('');
			}
		});
	},

	
//	onFocus:function(obj, def_val) {
//		jQuery(obj).focus(function() {
//			jQuery(obj).val('');
//		});
//	},
    'validateEmail':function(obj) {
        if ($(obj).val() == ''){
            return true;
        }
        if (/^([a-z0-9,!\#\$%&'\*\+\/=\?\^_`\{\|\}~-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z0-9,!\#\$%&'\*\+\/=\?\^_`\{\|\}~-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*@([a-z0-9-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z0-9-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*\.(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]){2,})$/i.test(jQuery(obj).val())) {
            return true;
        }
        return false;
    },

	submit:function() {
		//input:frm='#frmComment'
		var validation = new Validation(this.form);
		if (validation.isValid()) {
			var url = '/modules/comment/action.php?action=send-comment';

			var name = jQuery('input[name=name]', this.form).val();
			var email = jQuery('input[name=email]', this.form).val();

            if((email == ''))
            {
                jQuery('input[name=email]', this.form).css({"border":"1px dashed rgb(255, 0, 0)", "color":"rgb(255, 0, 0)"})
                return true;
            }
			var title = jQuery('input[name=title]', this.form).val();
			var content = jQuery('textarea[name=content]', this.form).val();
			var id = jQuery('input[name=property_id]', this.form).val();
			
			jQuery.post(url,{name:name,email:email,title:title,content:content,property_id:id},this.onSubmit,'html');	
			
			jQuery('input[name=name]', this.form).attr('disabled','disabled');
			jQuery('input[name=email]', this.form).attr('disabled','disabled');
			jQuery('input[name=title]', this.form).attr('disabled','disabled');
			jQuery('textarea[name=content]', this.form).attr('disabled','disabled');
			
		}
	},
	
	onSubmit:function(data) {
		var result = jQuery.parseJSON(data);
		if (result.success) {
			
			if (result.data && result.data.length > 0) {
				//alert(jQuery('#'+Comment.comment_container+' li:nth-child(1)').html());
				var str = '<li><p class="cm-title">'+result.data.title+'</p><p class="cm-posted">Posted by '+result.data.name+' on '+result.data.created_date+'</p><p class="cm-content">'+result.data.content+'</p></li>';
				jQuery('#'+DEFINE.COMMENT_SELF.container+' li').first().before(str);
				
				
				if (result.data.delete_last == 1) {
					jQuery('#'+DEFINE.COMMENT_SELF.container+' li').last().remove();
				}
			}
			
			jQuery('input[name=name]', DEFINE.COMMENT_SELF.form).attr('disabled','').val(DEFINE.COMMENT_SELF.def_val.name);
			jQuery('input[name=email]', DEFINE.COMMENT_SELF.form).attr('disabled','').val(DEFINE.COMMENT_SELF.def_val.email);
			jQuery('input[name=title]', DEFINE.COMMENT_SELF.form).attr('disabled','').val(DEFINE.COMMENT_SELF.def_val.title);
			jQuery('textarea[name=content]', DEFINE.COMMENT_SELF.form).attr('disabled','').val(DEFINE.COMMENT_SELF.def_val.comment);
			
			//alert('Your comment need to be approved before show.');
			//alert('test');
			showMess('Your comment need to be approved before show.');
		} else {
			alert('ERROR:'+result.error);
		}
		
	},
	
	view:function(url) {
		jQuery.post(url,{cont:this.container},this.onView,'html');
	},
	
	onView:function(data) {
        //var result = jQuery.parseJSON(data);
        //var decode = Encoder.decode(result.data);
		jQuery('#'+DEFINE.COMMENT_SELF.container).html(data);
	}
}

//BEGIN MESSAGE
var CommentGrid = function (form){
	this.form = form
	this.textarea_reply = false;
}

CommentGrid.prototype = {
	goto: function (obj) {
		if (typeof obj == 'object') {
			url = jQuery(obj).val();
		} else {
			url = obj;
		}
		document.location = url;
	},
	newMsg: function (url) {
		document.location = url;
	},
	
	redirectReplyForword: function(type) {
		var _msg_id = 0;
		var _multi = false;
		
		jQuery('[name^=chk]').each(function () {
			var _check = jQuery(this).attr('checked');

			if (_msg_id > 0 && _check == true) {
				_multi = true;
			}

			if (_msg_id == 0 && _check == true) {
				_msg_id = jQuery(this).val();
			}
		});
		
		if (_msg_id > 0 && _multi == false) {
			jQuery(this.form).attr('action',jQuery(this.form).attr('action')+'&message_id='+_msg_id+'&type='+type);
			jQuery('#is_submit',this.form).val(1);
			jQuery(this.form).submit();
			return true;
		} else if (_multi == true) {
			showMess('Can not process for many mail at the moment.');
		} else if (_msg_id == 0) {
			showMess('Please select one mail.');
		}
		jQuery('#is_submit',this.form).val(0);
		return false;
	},
	
	replyMsg: function (msg_id) {
		this.textarea_reply = true;
		jQuery(this.form+' [id=tab_email]').show();
		jQuery(this.form+' [name=email]').val(jQuery(this.form+' [name=reply_from]').html());
		jQuery(this.form+' [name=content]').val(jQuery(this.form+' [name=reply_content]').html());
		jQuery(this.form+' [name=req]').val('reply');
	},
	
	forwardMsg: function (msg_id) {
		this.textarea_reply = true;
		jQuery(this.form+' [id=tab_email]').show();
		jQuery(this.form+' [name=email]').val('');
		jQuery(this.form+' [name=content]').val(jQuery(this.form+' [name=forward_content]').html());
		jQuery(this.form+' [name=req]').val('forward');
	},
	
	textareaReply: function (msg_id) {
		if (this.textarea_reply == false) {
			this.replyMsg(this.form, msg_id);
		}
	},
	
	del: function () {
		var _check = false;
		jQuery('[name^=chk]').each(function () {
			if (jQuery(this).attr('checked') == true) {
				_check = true;
			}
		});
		
		if (_check == true) {		
			//if (confirm('Do you really want to delete ?')) {
            confirm_mess('Do you really want to delete ?',this.form,'undefined');
				/*jQuery('#is_submit',this.form).val(1);
				jQuery(this.form).submit();*/

		} else {
			jQuery('#is_submit',this.form).val(0);
			showMess('Please select least one comment.');
		}
	},
	
	redirect: function (url) {
		document.location = url;
	},
    del_comment: function (url) {// Delete a comment in comment detail page
        if(true){
            confirm_mess('Do you really want to delete this comment ?',this.form,url);
        }
        else {
			//alert('Please select least one comment.');
		}
	},
	
	rowClick: function (msg_id) {
		jQuery(this.form).attr('action',jQuery(this.form).attr('action')+'&message_id='+msg_id);
		jQuery('#is_submit',this.form).val(1);
		jQuery(this.form).submit();
	},
	
	eventOnElement: function (element, event_name, def_text) {
		var _obj = null;
		if (typeof element == 'object') {
			_obj = element;
		} else {
			_obj = jQuery(this.form+' [name='+element+']');
		}
		
		var _val = jQuery(_obj).val();
		if (event_name == 'blur' && jQuery.trim(_val) == '') {
			jQuery(_obj).val(def_text);
		} else if (event_name == 'focus' && _val == def_text){
			jQuery(_obj).val('');
		}
	},
	
	send: function () {
		var vl = new Validation(this.frm);
		if (vl.isValid()) {
			//jQuery(this.frm).submit();
			jQuery('#is_submit',this.form).val(1);
			return true;
		}
		//jQuery(this.frm).attr("onsubmit","return false;");
		//jQuery(this.frm).submit(function(){return false;});
		jQuery('#is_submit',this.form).val(0);
		return false;
	},
	
	submit: function () {
		//jQuery(this.frm).attr('onsubmit','return false;');
		var vl = new Validation(this.form);
		if (vl.isValid()) {
			//jQuery(this.frm).attr('onsubmit','return true;');
			//jQuery(this.frm).submit();
			jQuery('#is_submit',this.form).val(1);
			return true;
		}
		jQuery('#is_submit',this.form).val(0);
		//jQuery(this.frm).submit(function(){return false;});
		return false;
	},
	
	isSubmit: function() {
		if (jQuery('#is_submit',this.form).val() == 1) {
			return true;
		} else {
			return false;
		}
	}
}
//END MESSAGE

// Confirm mess

var confirm_mess_popup = null;
 function confirm_mess(msg,form,url)
 {

     confirm_mess_popup = new Popup();
     confirm_mess_popup.init({id:'confirm_mess_popup',className:'popup_overlay'});
     confirm_mess_popup.updateContainer('<div class="popup_container" style="width:356px;height: 122px;min-height: 120px;"><div id="contact-wrapper">\
			                        <div class="title"><h2 id="txtt"> This page says:<span id="btnclosex" onclick="close_confirm_mess(\'cancel\',\''+form+'\',\''+url+'\')">x</span></h2> </div>\
			                        <div class="clearthis" style="clear:both;"></div>\
			                        <div align="center" style="margin-bottom: 20px; margin-top: 20px;" class="content content-po" id="msg">'+msg+'</div>\
			                        <div align="center" class="button" style="margin: 5px 25px 0px 30px;"><button class="btn-red" style="margin-right: 25px;" onclick="close_confirm_mess(\'ok\',\''+form+'\',\''+url+'\')"><span><span>OK</span></span></button>\
                                    <button style="width:84px;*width:74px;" class="btn-red" onclick="close_confirm_mess(\'cancel\',\''+form+'\',\''+url+'\')"><span><span>CANCEL</span></span></button></div>\
			                        </div></div></div>');
     confirm_mess_popup.show().toCenter();

 }
function close_confirm_mess(mode,form,url)
{
    if(url == 'undefined')
    {
        if(mode == 'ok')
        {
            jQuery('#is_submit',form).val(1);
            jQuery(form).submit();
        }
        else
        {
            jQuery( confirm_mess_popup.container).fadeOut('fast',function(){ confirm_mess_popup.hide()});
        }
    }else
    {
        if(mode == 'ok')
        {
            document.location=url;              
        }
        else
        {
            jQuery( confirm_mess_popup.container).fadeOut('fast',function(){ confirm_mess_popup.hide()});
        }
    }
    /*else if(mode == 'cancel')
     {
         return false;
     }
     else if(mode =='ok')
     {
         return true;
     }*/
}
