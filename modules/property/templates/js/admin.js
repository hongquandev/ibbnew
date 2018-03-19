
var Property = function (form) {
    DEFINE.PROPERTY_SELF = this;
	this.form = form;
    this.next = '';

}

Property.prototype = {
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

                if (this.callback_func[i]()==false ){
					ok = false;
				}
			}
		}
        //alert(ok);
		
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
		var search_query = document.getElementById('search_text').value;
		if (search_query.length > 0) {
			self._store.load({params:{start:0, limit:20,search_query :search_query}});
		} else {
			Ext.Msg.alert('Warning.','Please entry some chars to search.');		
		}
	},
	
	getKind : function(url, obj1, obj2) {
		var param = new Object();
		param.kind = jQuery(obj1).val();
		param.target = obj2;
		jQuery.post(url, param, this.onGetKind,'json');		
	},
	
	onGetKind : function(data) {
		if (data.error == 0) {
			form_select.removeAll(data.target);
			if (data.content) {
				var i = 0;
				for (var el in data.content) {
					if (parseInt(el[0]) >= 0) {
						form_select.add(data.target, {'value' : el, 'text' : data.content[el]})
					}
					i++;
				}
			}
		} else {
			alert('error');
		}		
	},
	
	onChangeKind : function(obj, a1, a2) {
		var val = jQuery(obj).val();
		
		if (val == 1) {
			if (a1 && a1.length > 0) {
				for (var i = 0; i < a1.length; i++) {
					jQuery(a1[i]).show();
				}
			}
			
			if (a2 && a2.length > 0) {
				for (var i = 0; i < a2.length; i++) {
					jQuery(a2[i]).hide();
				}
			}
		} else {
			if (a2 && a2.length > 0) {
				for (var i = 0; i < a2.length; i++) {
					jQuery(a2[i]).show();
				}
			}
			
			if (a1 && a1.length > 0) {
				for (var i = 0; i < a1.length; i++) {
					jQuery(a1[i]).hide();
				}
			}
		}
	},
	
	viewSelect: function(obj) {/*
		var op1 = document.getElementById('op1').value;
		var op2 = document.getElementById('op2').value;
		var op3 = document.getElementById('op3').value;
		var op4 = document.getElementById('op4').value;
		*/	
		self._limit = obj.value;
        //alert(self._limit);
		
  


        //self._grid.render();
        //self._pagingBar.setPageSize(self._limit);
        //self._grid.changePage(self._limit);
		self._store.reload({params:{start:0, limit:obj.value, time_at :jQuery(obj).val()}});
        //alert(self._grid.changePage(50));
        /*self._grid.bbar = new Ext.PagingToolbar({
			pageSize: self._limit,
			store: self._store,
			displayInfo: true,
			displayMsg: 'Displaying topics {0} - {1} of {2}',
			emptyMsg: "No topics to display"
		});*/
        //alert(self._grid.bbar.pageSize);
	
	},
	downDoc:function(url) {
		document.location = url;
		//$.post(url,{},Property.onDownDoc,'html');	
	},
    validAgent:function(next){
        this.next = next;
        var agent = $('#agent_name').val();
        var agent_id = $('#agent_id').val();
        var token = $('#token').val();
        if (agent == ''){
            Common.warningObject('#agent_name');
        }else{
            var url = '/modules/property/action.admin.php?action=get-valid&token='+token;
            $.post(url,{name:agent,id:agent_id},this.onValid,'html');
        }

    },
	onValid: function(data){
        var result = jQuery.parseJSON(data);
        if (result.success){
            DEFINE.PROPERTY_SELF.submit(DEFINE.PROPERTY_SELF.next);
        }else{
            if (result.msg){//not found
                Ext.Msg.show({
                    title:'Warning !'
                    ,msg:result.msg
                    ,icon:Ext.Msg.WARNING
                    ,buttons:Ext.Msg.OK
                    ,fn:function(response) {
                    $.post('/modules/property/action.admin.php?action=get-nameAgent&token='+$('#token').val(),{agent_id:$('#agent_id').val()},function(data){
                                var result = jQuery.parseJSON(data);
                                jQuery('#agent_name').val(result.data);
                            });
		        }
	            });
            }else{//multi choice
                //create popup
                var radio =  new Ext.form.RadioGroup({
                            id:'rdAgent',
                            fieldLabel: 'Select Agent',
                            columns:1,
                            autoHeight:true,
                            collapsed: true
                            //items: result.data
                       });
                var options = new Ext.Window({
                   title:'Advance property',
                   bodyStyle:'padding:10px',
                   //width:400,
                   autoHeight:true,
                   width:600,
                   layout:'form',
                   closable:false,
                   items:radio,
                   buttons:[{text:'Save',
                             icon : '/admin/resources/images/default/dd/save.png',
                                handler:function(){
                                       var checkItem = Ext.getCmp('rdAgent').getValue();
                                       if (checkItem == null){
                                           Ext.Msg.alert('Failure', 'Please choose a option !');
                                       }else{
                                           //var mask = new Ext.LoadMask(Ext.get('options'), {msg:'Saving. Please wait...'});
                                           //mask.show();
                                           $('#agent_id').val(checkItem.id);
                                           $('#agent_name').val(checkItem.inputValue);
                                           //document.location = '?module=property&action=add&agent_id='+$('#agent_id').val()+'&token='+$('#token').val();
                                           //alert(self['sug_agent']._location);
                                           document.location = self['sug_agent']._location.replace('[1]',$('#agent_id').val())+$('#token').val();
                                       }
                                        radio.destroy();
                                        options.hide();
                             }},
                            {text:'Cancel',
                             icon : '/admin/resources/images/default/dd/cancel.png',
                                handler:function(){
                                   radio.destroy();
                                   options.hide();
                             }
                            }

                        ]

                });
                radio.items = result.data;
                //options.doLayout();
                options.show();
            }
        }
    }
}




var Comment = function(form) {
	this.form = form;
}

Comment.prototype = {
	submit:function(next){
		var validation = new Validation(this.form);
		if(validation.isValid()){
			if (next == true) {
				jQuery(this.form+' [name=next]').val(1);
			}
			jQuery(this.f0rm).submit();
		}
	},
	
	reset: function(form) {
		jQuery(this.form+' [id=note_id]').val(0);
		jQuery(this.form+' [id=content]').val('');
		jQuery(this.form+' [id=active]').attr('checked',true);
	}
		
}

