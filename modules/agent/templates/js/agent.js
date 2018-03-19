
var Agent = function(){
    this.callback_func  = [];
	this.toggle_question = 0;
}

Agent.prototype = {
	
	gotoStep:function(url){
		document.location = url;
	},
	
	step:function(frm,sign){
		var validation = new Validation(frm);
        var ok = true;
		if (this.callback_func['valid'] && this.callback_func['valid'].length > 0) {
			for (var i = 0; i < this.callback_func['valid'].length ;i++) {
				if (this.callback_func['valid'][i]() == false) {
                     ok = false;
				}
			}
		}
		if(validation.isValid() && ok){
			if(sign =='finish'){
				jQuery('#sign',frm).val('finish');
            }
			jQuery(frm).submit();
		}else{
            try{
                Recaptcha.reload();
            }
            catch(er){
            }
        }
        return true;
	},
    addCallbackFnc: function(key, fnc) {
		if (!this.callback_func[key]) {
			this.callback_func[key] = [];
		}
		this.callback_func[key].push(fnc);
	},

	flushCallback: function() {
		this.callback_func = [];
	},
    onstep:function(data_captcha)
    {
        var data = jQuery.parseJSON(data_captcha);
        if(data.success)
        {
            jQuery('#captcha_step1').html(data.form);
        }
    },
	submit:function(frm){
        var ok = true;
        if (this.callback_func['valid'] && this.callback_func['valid'].length > 0) {
            for (var i = 0; i < this.callback_func['valid'].length ;i++) {
                if (this.callback_func['valid'][i]() == false) {
                    ok = false;
                }
            }
        }
		var validation = new Validation(frm);
		if(validation.isValid() && ok){
			jQuery(frm).submit();
		}
        return true;
	}
	
	//Begin : Security Question = SQ
	,showSQ : function() {
		jQuery('#msg_question').html('');
		jQuery('#new_question').val('');
		if (this.toggle_question == 0) {
			jQuery('#question_container').show();
		} else {
			jQuery('#question_container').hide();			
		}
		
		this.toggle_question = Math.abs(this.toggle_question - 1);
	}
	
	,saveSQ: function() {
        var url = '/modules/agent/action.php?action=sq_save';
		var val = jQuery('#new_question').val();
		jQuery('#msg_question').html('');
		
		if (jQuery.trim(val).length > 0) {
			jQuery('#loading_question').show();
			var param = new Object();
			param.new_question = val;
			$.post(url, param, this.onSaveSQ,'html');
		}
	}
	
	,onSaveSQ : function(data) {
		var result = jQuery.parseJSON(data);
		if (result.success) {
			if (result.id && result.title) {
				form_select.add('security_question',{value: result.id, text: result.title})	
			}
		}
		
		if (result.msg) {
			jQuery('#msg_question').html(result.msg);
		}
		jQuery('#loading_question').hide();
	}
	//End : Security Question = SQ
    ,changeStatus: function(agent_id,obj){
        var url = '/modules/agent/action.php?action=changeStatus';
        $.post(url,{agent_id:agent_id},function(data){
                var result = $.parseJSON(data);
                if (result.success){
                    $(obj).html(result.status);

                }else{
                    showMess(result.msg);
                }
              },'html');
    }
    ,prepareList:function(action,container){
        var url = '/modules/agent/action.php?action='+action;
        $.post(url,{},function(data){
                   $(container).html(data);
        },'html');
    }
    ,addRegion:function(frm,action){
        var validation = new Validation(frm);
        if (validation.isValid()){
            var params = new Object();
            $.each($('input,select,textarea',frm),function(){
                params[$(this).attr('name')] = $(this).val();
            });
            var url = '/modules/agent/action.php?action='+action;
            $.post(url,{params:params},function(data){
                        var result = jQuery.parseJSON(data);
                        if (result.success){
                            $.each($('input,select,textarea',frm),function(){
                                if ($(this).attr('name') == 'country'){
                                    $(this).val(country_default);
                                    $(this).parent().find('span').html($(this).find('option:selected').text());
                                    $(this).change();
                                }else{
                                    $(this).val('');
                                }
                            });
                            if (action == 'addRegion'){
                                self['agent'].prepareList('prepareRegion','#region');
                            }else{
                                self['agent'].prepareList('preparePartner','#reference');
                            }
                        }else{
                            showMess('Process fail ! Please try again.')
                        }

                   },'html');
        }
    }
    ,deleteRegion:function(id,prefix){
        var action = prefix == 'row'?'deleteRegion':'deletePartner';
        var url = '/modules/agent/action.php?action='+action;
        $.post(url,{id:id},function(data){
                    var result = jQuery.parseJSON(data);
                    if (result.msg){
                        showMess(result.msg);
                    }else{
                        $('#'+prefix+'_'+id).remove();
                    }
                },'html');
    }
    ,editRegion:function(id,prefix){
        var action = prefix == 'row'?'editRegion':'editPartner';
        var url = '/modules/agent/action.php?action='+action;
        $.post(url,{id:id},function(data){
                    var result = jQuery.parseJSON(data);
                    if (result.msg){
                        showMess(result.msg);
                    }else{
                        $.each(result,function(key,value){
                           if ($('[name='+key+']').length > 0){
                               $('[name='+key+']').val(value);
                               if ($('[name='+key+']')[0].tagName == 'SELECT'){
                                   $('[name='+key+']').parent().find('span').html($('[name='+key+'] option:selected').text());
                                   $('[name='+key+']').change();
                               }
                           }                           
                        });
                    }
               },'html')
    },
    loadRef:function(){
        var url = '/modules/agent/action.php?action=loadRef';
        $.post(url,function(data){
            var result = jQuery.parseJSON(data);
            $.each(result,function(key,value){
               if (value == 1){
                  if ($('[name='+key+']').length > 0){
                      $('[name='+key+']').attr('checked','checked');
                  }
               }
            });
        },'html');
    },
    contactAgent:function(){
        var url = '';
        $.post(url,function(data){

        })
    },
    init:function(obj,site,lock){
        var self = this;
        if ($('#'+obj).length > 0){
            $('#'+obj).bind('keyup', function(e) {
                self.checkUsername(this,site,lock);
            });
        }
        if($('.photoThumbDiv').length > 0){
                        $.each($('.photoThumbDiv'),function(){
                            $(this).find('.icons').bind('click', function() {
                                 if ($(this).attr("onClick") != undefined) {
                                 }else{
                                     self.deleteImage(this,$(this).attr('lang'));
                                 }
                            });
                            $(this).hover(
                                 function () {
                                   $(this).children('.icons').show();
                                 }, function () {
                                   $(this).children('.icons').hide();
                                 }
                             );
                        })
                    }

    },
    deleteImage:function(obj,suffix){
        if (confirm('Do you really want to delete this photo ?')){
            var url = '/modules/agent/action.php?action=delete_' + suffix;
            $.post(url, {}, function(data) {
                        var result = $.parseJSON(data);
                        if (result.success) {
                            $(obj).parents('.photoThumbDiv').remove();
                        } else {
                            alert(result.msg);
                        }
                    }, 'html');
        }
    },
    checkUsername:function(obj,site,lock){
        if(lock == 'lock') {
            if ($(obj).closest('li').find('p').length > 0) {
            } else {
                $(obj).closest('li').append('<p style="margin-top:7px"></p>');
            }
            $(obj).closest('li').find('p').html('You can not edit here!').addClass('error-text');
            return true;
        }
        var url = '/modules/agent/action.php?action=checkUser';
        if ($(obj).closest('li').find('p').length > 0) {
        } else {
            $(obj).closest('li').append('<p style="margin-top:7px"></p>');
        }
        $(obj).closest('li').find('p').html('Checking...').removeClass('error-text');
        $.post(url, {key:$(obj).val(),site:site}, function(data) {
                    var result = $.parseJSON(data);
                    if (result.unavai) {
                        $(obj).closest('li').find('p').html(result.msg).addClass('error-text');
                    } else {
                        $(obj).closest('li').find('p').html('This address is available.').removeClass('error-text');
                    }
                }, 'html');
    }
};


//BEGIN MESSAGE
var Message = function (frm){
	this.frm = frm
	this.textarea_reply = false;
}

Message.prototype = {
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
			jQuery(this.frm).attr('action',jQuery(this.frm).attr('action')+'&message_id='+_msg_id+'&type='+type);
			jQuery('#is_submit',this.frm).val(1);
			jQuery(this.frm).submit();
			return true;
		} else if (_multi == true) {
			//alert('Can not process for many mail at the moment.');
            showMess('Can not process for many mail at the moment.')
		} else if (_msg_id == 0) {
			//alert('Please select one mail.');
            showMess('Please select one mail.')
		}
		jQuery('#is_submit',this.frm).val(0);
		return false;
	},
	
	replyMsg: function (msg_id) {
		this.textarea_reply = true;
		jQuery(this.frm+' [id=tab_email]').show();
		jQuery(this.frm+' [name=email]').val(jQuery(this.frm+' [name=reply_from]').html());
		jQuery(this.frm+' [name=content]').html(jQuery(this.frm+' [name=reply_content]').html());
		jQuery(this.frm+' [name=req]').val('reply');
	},
	
	forwardMsg: function (msg_id) {
		this.textarea_reply = true;
		jQuery(this.frm+' [id=tab_email]').show();
		jQuery(this.frm+' [name=email]').val('');
		jQuery(this.frm+' [name=content]').val(jQuery(this.frm+' [name=forward_content]').html());
		jQuery(this.frm+' [name=req]').val('forward');
	},
	
	textareaReply: function (msg_id) {
		if (this.textarea_reply == false) {
			this.replyMsg(this.frm, msg_id);
		}
	},
	
	delMsg: function (action) {
		var _check = false;
		jQuery('[name^=chk]').each(function () {
			if (jQuery(this).is(':checked')) {
				_check = true;
			}
		});
		
		if (_check == true) {		
			jQuery(this.frm).attr('action',action);
			/*if (confirm('Do you really want to delete ?')) {
				jQuery('#is_submit',this.frm).val(1);
				jQuery(this.frm).submit();
			}*/
            showConfirm('Please confirm if you really want to delete this?','',this.frm);
            /*if (isConfirm('Do you really want to delete?') == true){
                jQuery('#is_submit',this.frm).val(1);
				jQuery(this.frm).submit();
            }*/
		} else {
			jQuery('#is_submit',this.frm).val(0);
			//alert('Please select least one mail.');
            showMess('Please select the message you want to delete.');
		}
	},
	
	rowClick: function (msg_id) {
		jQuery(this.frm).attr('action',jQuery(this.frm).attr('action')+'&message_id='+msg_id);
		jQuery('#is_submit',this.frm).val(1);
		jQuery(this.frm).submit();
	},
	
	eventOnElement: function (element, event_name, def_text) {
		var _obj = null;
		if (typeof element == 'object') {
			_obj = element;
		} else {
			_obj = jQuery(this.frm+' [name='+element+']');
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
			jQuery('#is_submit',this.frm).val(1);
			return true;
		}
		//jQuery(this.frm).attr("onsubmit","return false;");
		//jQuery(this.frm).submit(function(){return false;});
		jQuery('#is_submit',this.frm).val(0);
		return false;
	},
	
	submit: function () {
		//jQuery(this.frm).attr('onsubmit','return false;');
		var vl = new Validation(this.frm);
		if (vl.isValid()) {
			//jQuery(this.frm).attr('onsubmit','return true;');

			jQuery('#is_submit',this.frm).val(1);
            jQuery(this.frm).submit();
			return true;
		}
		jQuery('#is_submit',this.frm).val(0);
		//jQuery(this.frm).submit(function(){return false;});
		return false;
	},
	
	isSubmit: function() {
		if (jQuery('#is_submit',this.frm).val() == 1) {
			return true;
            //this.frm.submit();
		} else {
			return false;
		}
	}
}
//END MESSAGE



//BEGIN CREDITCARD
var CreditCard = function(form) {
	this.form = form;
}

CreditCard.prototype = {
	pre_checkbox :'',
	callback_func :[],
	newCC: function (url) {
		document.location = url;
	},
	
	delCC: function (action) {
		var _check = false;
		jQuery('[name^='+this.pre_checkbox+']').each(function () {
			if (jQuery(this).attr('checked') == true) {
				_check = true;
			}
		});
		
		if (_check == true) {		
			jQuery(this.form).attr('action',action);
			jQuery('#is_submit',this.form).val(1);
			jQuery(this.form).submit();
		} else {
			alert('Please select least one creditcard.');
			jQuery('#is_submit',this.form).val(0);
		}
	},
	
	rowClick: function (cc_id) {
		var _action = jQuery(this.form).attr('action');
		_action = _action.replace('view-','edit-');
		jQuery(this.form).attr('action',_action+'&cc_id='+cc_id);
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
	
	submit: function () {
		var vl = new Validation(this.form);
		
		var ok = true;
		if (this.callback_func.length > 0) {
			for (i = 0; i < this.callback_func.length ;i++) {
				if (this.callback_func[i]()==false){
					ok = false;
				}
			}
		}
		
		var ok2 = vl.isValid();
		
		if (ok && ok2) {
			jQuery('#is_submit',this.form).val(1);
			var _action = jQuery(this.form).attr('action');
			_action = _action.replace('edit-','add-');
			jQuery(this.form).attr('action',_action);
			jQuery(this.form).submit();
			return true;
		}
		jQuery('#is_submit',this.form).val(0);
		return false;
	},
	
	isSubmit : function () {
		if (jQuery('#is_submit',this.form).val() == 1) {
			return true;
		} else {
			return false;
		}
	}
}
//END CREDITCARD


