var Agent = function(form){
	this.form = form;
}

Agent.prototype = {
	callback_func :[],
	
	submit: function(next, invalid) {

        if (next == true) {
            jQuery(this.form+' [name=next]').val(1);
        }

        if(typeof invalid != 'undefined' && invalid == true){
            jQuery(this.form).submit();
            return true;
        }

		var validation = new Validation(this.form);

		var ok = true;
		if (this.callback_func.length > 0) {
			for (i = 0; i < this.callback_func.length ;i++) {
				if (this.callback_func[i]()==false){
					ok = false;
				}
			}
		}

		var ok2 = validation.isValid();
		if (ok == true && ok2 == true) {
			jQuery(this.form).submit();
		}


	},

	flushCallback: function(){
		this.callback_func = [];
	},
	
	reset: function(url,tab) {
		if (typeof tab == 'undefined' || tab == 'personal') {
			Common.emptyValues(this.form,'id',['firstname','lastname','street','suburb','postcode','telephone','mobilephone','email_address','license_number','password','security_answer',{key:'agent_id',value:0}]);
			
			jQuery(this.form+' [id=allow_vendor_contact]').attr('checked',false);
			
			jQuery(this.form+' [id=notify_email]').attr('checked',false);
			jQuery(this.form+' [id=notify_sms]').attr('checked',false);
			jQuery(this.form+' [id=notify_turnon_sms]').attr('checked',false);
			jQuery(this.form+' [id=is_active]').attr('checked',true);
			
			jQuery(this.form).attr('action',url);
		} else if (tab == 'cc') {
			Common.emptyValues(this.form,'id',['card_name','billing_address','card_number','security_code',{key:'cc_id',value:0}]);
			jQuery(this.form+' [id=auction_date]').attr('checked',false);
		}
	},
	
	search: function() {
		var search_query = document.getElementById('search_text').value;
		if (search_query.length > 0) {
			hideMsg();
			self._store.load({params:{start:0, limit:20,search_query :search_query}});
		} else {
			Ext.Msg.alert('Warning.','Please entry some chars to search.');		
		}
	}
    ,prepareList:function(action,container,p){
        $(container).css('text-align','center').html('<img src="/modules/general/templates/images/loading.gif"/>');
        var url = '/modules/agent/action.admin.php?action='+action+'&token='+token+p;
        $.post(url,{agent_id:$('[name=agent_id]').val()},function(data){
                   $(container).html(data);
        },'html');
    }
    ,addRegion:function(frm,action){
        var validation = new Validation(frm);
        if (validation.isValid()){
            var params = new Object();
            $.each($('input[type=text],input[type=hidden],select,textarea',frm),function(){
                params[$(this).attr('name')] = $(this).val();
            });
            var url = '/modules/agent/action.admin.php?action='+action+'&token='+token;
            $.post(url,{params:params},function(data){
                        var result = jQuery.parseJSON(data);
                        if (result.success){
                            $.each($('input[type=text],input[type=hidden],select,textarea',frm),function(){
                                if ($(this).attr('name') == 'country'){
                                    $(this).val(country_default);
                                    $(this).parent().find('span').html($(this).find('option:selected').text());
                                    $(this).change();
                                }else if ($(this).attr('name') == 'agent_id'){
                                }else{
                                    $(this).val('');
                                }
                            });
                            if (action == 'add-region'){
                                self['agent'].prepareList('prepare-region','#region','');
                            }else{
                                self['agent'].prepareList('prepare-partner','#reference','');
                            }
                        }else{
                            showMess('Process fail ! Please try again.')
                        }

                   },'html');
        }
    }
    ,deleteRegion:function(id,prefix){
        var action = prefix == 'row'?'delete-region':'delete-partner';
        var url = '/modules/agent/action.admin.php?action='+action+'&token='+token;
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
        var action = prefix == 'row'?'edit-region':'edit-partner';
        var url = '/modules/agent/action.admin.php?action='+action+'&token='+token;
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
    init:function(obj,site,agent_id){
        var self = this;
        if ($('#'+obj).length > 0){
            $('#'+obj).bind('keyup', function(e) {
                self.checkUsername(this,site);
            });
        }
        if ($('.photoThumbDiv').length > 0){
            $.each($('.photoThumbDiv'),function(){
                $(this).find('.icons').bind('click', function() {
                     if ($(this).attr("onClick") != undefined) {
                     }else{
                         self.deleteImage(this,$(this).attr('lang'),agent_id);
                     }
                });
                $(this).hover(
                     function () {
                       $(this).children('.icons').show();
                     }, 
                     function () {
                       $(this).children('.icons').hide();
                     }
                 );
            })
        }

    },
    checkUsername:function(obj,site){
        var url = '/modules/agent/action.admin.php?action=check-user&token='+token;
        if ($(obj).closest('td').find('p').length > 0) {
        } else {
            $(obj).closest('td').append('<p style="margin-top:7px"></p>');
        }
        $(obj).closest('td').find('p').html('Checking...').removeClass('error-text');
        $.post(url, {key:$(obj).val(),site:site}, function(data) {
                    var result = $.parseJSON(data);
                    if (result.unavai) {
                        $(obj).closest('td').find('p').html(result.msg).addClass('error-text');
                    } else {
                        $(obj).closest('td').find('p').html('This address is available.').removeClass('error-text');
                    }
                }, 'html');
    },
    deleteImage:function(obj,suffix,agent_id){
        Ext.Msg.show({
				title:'Confirm?'
				,msg:'Do you really want to delete this photo ?'
				,icon:Ext.Msg.QUESTION
				,buttons:Ext.Msg.YESNO
				,scope:this
				,fn:function(response) {
					if('yes' !== response) {
						return ;
					}
					var url = '/modules/agent/action.admin.php?action=delete-'+suffix+'&token='+token;
                    $.post(url,{id:agent_id},function(data){
                            var result = $.parseJSON(data);
                            if (result.success){
                                $(obj).parents('.photoThumbDiv').remove();
                            }else{
                                alert(result.msg);
                            }
                    },'html');
				}
		});
    }

};

