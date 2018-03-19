
var Note = function(form,container,agent_id) {
    DEFINE.NOTE_SELF = this;
	this.form = form;
    this.container = container;
    this.agent = agent_id
}

Note.prototype = {
	submit:function(next){
        //alert('submit');
		var validation = new Validation(this.form);
		if(validation.isValid()){
			if (next == true) {
				jQuery(this.form+' [name=next]').val(1);
			}
			jQuery(this.form+' [id=action]').val('edit-note2');
            jQuery(this.form+' [id=submit_]').val(1);
			jQuery(this.form).submit();
		}
	},
	
	reset: function(url) {
		//url = '?module=property&action=edit-note&property_id='+jQuery(frm+'[id=property_id]').val()
		jQuery(this.form).attr('action',url);
		jQuery(this.form+' [id=active]').attr('checked',true);
		
		Common.emptyValues(this.form,'id',['content',{key:'note_id',value:0}]);
	},
	search : function() {
		var search_query = document.getElementById('search_text').value;
		if (search_query.length > 0) {
			hideMsg();
			self._store.load({params:{start:0, limit:20,search_query :search_query}});
		} else {
			Ext.Msg.alert('Warning.','Please entry some chars to search.');		
		}
		
	},
    edit: function(note_id){
        var token = jQuery(this.form+' [id=token]').val();
        var url = '/modules/note/action.admin.php?action=edit-note&token='+token;
        $.post(url,{note_id:note_id},function(data){
                    var result = jQuery.parseJSON(data);
                    if (result != ''){
                        jQuery(DEFINE.NOTE_SELF.form+' [id=note_id]').val(result.note_id);
                        jQuery(DEFINE.NOTE_SELF.form+' [id=content]').val(result.content);
                    }
                });
    },
    update_note: function(url){
        var token = jQuery(this.form+' [id=token]').val();
		jQuery.post(url+'&token='+token,{},function(data){
                    jQuery(jQuery(DEFINE.NOTE_SELF.form+' [id='+DEFINE.NOTE_SELF.container+']')).html(data);
               });
    },
    delete_note: function(note_id){
        var token = jQuery(this.form+' [id=token]').val();
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

                var url = '/modules/note/action.admin.php?action=delete-note&note_id='+note_id+'&token='+token;
                $.post(url,{},function(data){

                            DEFINE.NOTE_SELF.update_note('/modules/note/action.admin.php?action=update-note&agent_id='+DEFINE.NOTE_SELF.agent);
                       });
            }
	    });
    }
}

