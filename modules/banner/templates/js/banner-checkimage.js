var BANNER = function(form) {
     DEFINE.BANNER_SELF = this;
    this.form = form;
}

BANNER.prototype = {
    callback_func :[],
	submit : function() {

        var validation = new Validation(this.form);

        var ok = true;
        var ok_ = validation.isValid();
		if (this.callback_func.length > 0) {
			for (var i = 0; i < this.callback_func.length ;i++) {
                if (this.callback_func[i]()==false ){
					ok = false;
				}
			}
		}
        
		if (ok_ && validFile() && ok) {
			jQuery(this.form).submit();
		}
	},
    flushCallback: function(){
		this.callback_func = [];
	},
    validAgent:function(){
        var agent = $('#agent_name').val();
        var agent_id = $('#agent_id').val();
        var token = $('#token').val();
        if (agent == ''){
            Common.warningObject('#agent_name');
        }else{
            var url = '/modules/property/action.admin.php?action=get-valid&token='+token;
            $.post(url,{name:agent,id:agent_id,type:'partner'},this.onValid,'html');
        }
    },
	onValid: function(data){
        var result = jQuery.parseJSON(data);
        if (result.success){
            DEFINE.BANNER_SELF.submit();
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
                            fieldLabel: 'Select Partner',
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
                                           $('#agent_id').val(checkItem.id);
                                           $('#agent_name').val(checkItem.inputValue);
                                           if ($('#banner_id') != 0){
                                               document.location = '?module=banner&action=add&agent_id='+$('#agent_id').val()+'&token='+$('#token').val();
                                           }
                                           
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
                options.show();
            }
        }
    }
}
	
function validFileImageBanner()
{
	var extensions = new Array("jpg","jpeg","gif","png", 'bmp');

	var image_file = document.frmCreate.image_file.value;
	
	var image_length = document.frmCreate.image_file.value.length;
	
	var pos = image_file.lastIndexOf('.') + 1;
	
	var ext = image_file.substring(pos, image_length);
	
	var final_ext = ext.toLowerCase();
	for (i = 0; i < extensions.length; i++)
	{
		if (document.frmCreate.image_file.value.length) {
			if(extensions[i] == final_ext)
			{	
				//showMess("Banner Center will be resized width : 616px height: 110px"+"<br>"+"Banner Right will be resized width: 280px");	
				return true;
			}
			
		}
		
		if (document.frmCreate.image_file.value.length == 0) {
				return true;			
		}
	}		
		//alert("You must upload an image file with one of the following extensions: "+ extensions.join(', ') +".");
		$("#image_file").replaceWith($("#image_file").clone(true));
		$("#image_file").val(""); 
        showMess("You must upload an image file with one of the following extensions: "+ extensions.join(', ') +".");
		//document.frmCreate.image_file.value = '';
		
		
		return false;
		
}