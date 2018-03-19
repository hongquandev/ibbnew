var EmailAlert = function(frm) {
    this.frm = frm;
}
EmailAlert.prototype = {
	submit : function() {
		var validation = new Validation(this.frm);
		if (validation.isValid()) {
            $('#track').val(1);
			jQuery(this.frm).submit();
            return true;
		}
        return false;
	},
    isSubmit: function(){
      if ($('#track').val() == 1){
          return true;
      }
      return false;
    },
    del:function(id){
        var action = '?module=emailalert&action=delete&id='+id;
        jQuery(this.frm).attr('action',action);
        showConfirm('Do you want to delete this email alert ?','',this.frm);
    },
    search:function(id,frm){
        this.frm = frm;
        var url = '/modules/emailalert/action.php?action=getEmail';
            jQuery.post(url,{email_id:id,frm:this.frm},this.onSearch,'html');

    },
    onSearch:function(data){
        var result = jQuery.parseJSON(data);
        if (result.success){
            var data = result.data;
           /* var field = ['property_type','auction_sale','minprice','maxprice','address','suburb','state','postcode','bedroom','badroom','parking',
                        'car_space','car_port','land_size_max','land_size_min','unit','email_id'];
            $.each(field,function(){
                $('#'+this,result.form).val('');
                $('#'+this,result.form).val(data[this]);
            });*/
            $.each(result.data,function(k,value){
               $('#'+k,result.form).val('').val(value);
            });
            jQuery(result.form).attr('action','?module=property&action=search');
            /*if (parseInt($('#auction_sale').val()) == 10){
                    jQuery(result.form).attr('action','?module=property&action=search-sale');
            }else{
                    jQuery(result.form).attr('action','?module=property&action=search-auction');
                }*/
            jQuery(result.form).submit();
        }
    },
    changeStatus: function(id){
        var url = '/modules/emailalert/action.php?action=change-status';
        jQuery.post(url,{email_id:id},this.onChange,'html');
    },
    onChange: function(data){
        var result = jQuery.parseJSON(data);
        $('#stt_'+result.id).html(result.data);
    },
    resend: function(id,agent_id){
        var url = '/modules/emailalert/action.php?action=resend';
        jQuery.post(url,{email_id:id,agent_id:agent_id},this.onResend,'html');
    },
    onResend: function(data){
         var result = jQuery.parseJSON(data);
         showMess(result);
    },
    view_email:function(url,obj) {
        var len = $(obj).val();
		jQuery.post(url,{len:len},function(data){
                    jQuery('#content').html(data);
               });
	},
    view_email_paging:function(par,url,obj) {
        var len = $(obj).val();
        jQuery.post(url,{len:len},function(data){
            jQuery('#content').html(data);
        });
    }

}
