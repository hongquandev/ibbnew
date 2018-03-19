// JavaScript Document
function Validation(form_id) {
	this.rules = ['validate-agentEmail','validate-require','validate-number','validate-money','validate-number-gtzero','validate-email','validate-telephone','validate-mobilephone','validate-creditcard','validate-postcode','validate-digits','validate-cvv','validate-letter','validate-date','validate-datetime','validate-data','validate-price','validate-license','validate-choose-select','validate-url'];
	this.error = '';
	this.error_ar = [];
	
	this.form_id = form_id;
	this.form_obj = jQuery(form_id);
}

Validation.prototype = {

	'validate-require':function(obj) {
		if (jQuery.trim(jQuery(obj).val()).length == 0) {
			this.error = 'Error';
			return false;
		}
		return true;
	},
	
	'validate-number':function(obj) {
		if ($(obj).val() != ''){
            	if (/(^\d+$)/.test(jQuery(obj).val())) {
                    return true;
                }
                return false;
        }
        return true;
	},
	
	'validate-price':function(obj) {
		
		if (/(^\d+$)/.test(jQuery(obj).val()) && parseInt(jQuery(obj).val(),10) > 0) {
			return true;
		}
		return false;
		
	},
	
	'validate-digits':function(obj) {
		/*
		if (!/[^\d]/.test(jQuery(obj).val())) {
			return true;
		}
		return false;
		*/

        if ($(obj).val() == ''){
            return true;
        }
		if (/(^\d+$)/.test(jQuery(obj).val())) {
			return true;
		}
		return false;
		
	},
	
	'validate-cvv':function(obj) {
		if (/(^\d{3}$)/.test(jQuery(obj).val())) {
			return true;
		}
		return false;
	},
	
	
	'validate-money':function(obj) {
		// return /^[-+]?[0-9]+(\.[0-9]+)?$/.test(str);
		//if (jQuery(obj).val().length == 0 || isNaN(parseInt(jQuery(obj).val())) ){
		if (jQuery(obj).val().length == 0 || !(/^[0-9]+(\.[0-9]+)?$/.test(jQuery(obj).val()) )){
			this.error = 'Error';
			return false;
		}
		return true;
	},
	
	'validate-number-gtzero':function(obj) {
		if (parseInt(jQuery(obj).val()) < 1) {
			this.error = 'Error';
			return false;
		}
		return true;
	},
	
	'validate-email':function(obj) {
        if ($(obj).val() == ''){
            return true;
        }
		if (/^([a-z0-9,!\#\$%&'\*\+\/=\?\^_`\{\|\}~-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z0-9,!\#\$%&'\*\+\/=\?\^_`\{\|\}~-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*@([a-z0-9-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z0-9-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*\.(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]){2,})$/i.test(jQuery(obj).val())) {
			return true;
		}
		return false;
	},
	
	'validate-telephone':function(obj) {
        if (jQuery(obj).val() != ''){
            if (/(^\d{10}$)|(^\d{11}-\d{10}$)/.test(jQuery(obj).val())) {
                return true;
            }
            return false;
        }
        return true;

	},
    'validate-agentEmail':function(obj) {
		if (/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$/.test(jQuery(obj).val())) {
			return true;
		}
		return false;
	},
	
	'validate-date':function(obj) {
		if (/(^\d{4}-\d{2}-\d{2}$)/.test(jQuery(obj).val())) {
			return true;
		}
		return false;
	},

	'validate-datetime':function(obj) {
		if (/(^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$)/.test(jQuery(obj).val())) {
			return true;
		}
		return false;
	},

	
	'validate-mobilephone':function(obj) {
		return true;
	},
	
	'validate-postcode':function(obj) {
		//if (/(^\d{4}$)|(^\d{5}-\d{4}$)/.test(jQuery(obj).val())) {
        if ($(obj).val() == ''){
            return true;
        }
        if (/(^\d{4}$)/.test(jQuery(obj).val())) {
			return true;
		}
		return false;
	},
//    'validate-data':function(obj) {
//		 var region = jQuery('#suburb').val()+" "+jQuery('#state').val()+" "+jQuery('#postcode').val();
//         var url = '/modules/property/action.admin.php?action=validate-property';
//         jQuery.post(url,{region:region},this.testValid);
//	},
	
	'validate-creditcard':function(obj) {
		return true;
	},
	'validate-letter':function(obj) {
        if ($(obj).val() == ''){
            return true;
        }
		if (/^[a-z\sA-Z]+$/.test(jQuery(obj).val())) {
			return true;
		}
		return false;
	},
    'validate-license':function(obj){
        if (jQuery(obj).val() != '' && (jQuery(obj).val().length < 8  || isNaN(parseInt(jQuery(obj).val()))) ){
			return false;
		}
		return true;
    },
     'validate-choose-select':function(obj){
        if (jQuery(obj).val() == null){
			return false;
		}
		return true;
    },
    'validate-url':function(obj){
        if ($(obj).val() == ''){
            return true;
        }
        //var RegexUrl = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
        var RegexUrl = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/;
        return RegexUrl.test($(obj).val());
    },
	showErrorSign:function(obj) {
		jQuery(obj).css({"border":"1px dashed #ff0000","color":"#ff0000"});
		
		//high light *
		if ((notify = jQuery('#notify_' + jQuery(obj).attr('id'),this.form_obj))) {
			jQuery(notify).css({"color":"#ff0000"});
			//jQuery(notify).css({"border":"1px dashed #ff0000","color":"#ff0000"});
		}
	},
    testValid:function(result) {
        var info = jQuery.parseJSON(result);
        if (info == ''){
                       return false;
                   }
        return true;
     },
	
	isValid:function() {
		var is_valid = true;
		var elements = jQuery('input,select,textarea,file',this.form_obj);
		this.error_ar = [];
		for (i = 0; i < elements.length; i++) {
			this.error = '';
			
			jQuery(elements[i]).css({"border":"1px solid #bfbfbf","border-color":"","color":""});
			//high light *
			if ((notify = jQuery('#notify_' + jQuery(elements[i]).attr('id')))) {
				jQuery(notify).css({"color":""});
			}
			
			
			
			class_str = jQuery(elements[i]).attr('class');
                        try{
			class_ar = class_str.split(' ');
			
			for (j = 0; j < class_ar.length; j++) {
				if (jQuery.inArray(jQuery.trim(class_ar[j]),this.rules) > -1) {
					if (this[class_ar[j]](elements[i]) == false) {
						is_valid = false;
						this.error_ar.push(jQuery(elements[i]).attr('name'));
						
						//jQuery(elements[i]).addClass('validate-error').removeClass('border');
						//jQuery(elements[i]).removeClass('validate-error');
						this.showErrorSign(elements[i]);
						break;
					}
				}

			}
                        }catch(e){}
		}
		
		this.error = '';
		return is_valid;
	}
};

/*
var Validation = $.Class.create({
	rules : ['validate-require','validate-number','validate-money','validate-number-gtzero','validate-email','validate-telephone','validate-mobilephone','validate-creditcard','validate-postcode'],
	error : '',
	initialize:function(form_id){
		this.form_id = form_id;
		this.form_obj = jQuery(form_id);
	},
	
	
	'validate-require':function(obj){
		if(jQuery(obj).val().length==0){
			this.error = 'Error';
			return false;
		}
		return true;
	},
	
	'validate-number':function(obj){
		return true;
	},
	
	'validate-digits':function(obj){
		if(!/[^\d]/.test(jQuery(obj).val())){
			return true;
		}
		return false;
	},
	
	'validate-money':function(obj) {
		if(jQuery(obj).val().length==0 || parseFloat(jQuery(obj).val())==0){
			this.error = 'Error';
			return false;
		}
		return true;
	},
	
	'validate-number-gtzero':function(obj){
		if(parseInt(jQuery(obj).val())<1){
			this.error = 'Error';
			return false;
		}
		return true;
	},
	
	'validate-email':function(obj){
		if(/^([a-z0-9,!\#\$%&'\*\+\/=\?\^_`\{\|\}~-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z0-9,!\#\$%&'\*\+\/=\?\^_`\{\|\}~-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*@([a-z0-9-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z0-9-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*\.(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]){2,})$/i.test(jQuery(obj).val())){
			return true;
		}
		return false;
	},
	
	'validate-telephone':function(obj){
		return true;
	},
	
	'validate-mobilephone':function(obj){
		return true;
	},
	
	'validate-postcode':function(obj){
		if(/(^\d{4}$)|(^\d{5}-\d{4}$)/.test(jQuery(obj).val())){
			return true;
		}
		return false;
	},
	
	'validate-creditcard':function(obj){
		return true;
	},
	
	showErrorSign:function(obj){
		jQuery(obj).css({"border":"1px dashed #ff0000","color":"#ff0000"});
		
		//high light *
		if((notify = jQuery('#notify_'+jQuery(obj).attr('id'),this.form_obj))){
			jQuery(notify).css({"color":"#ff0000"});
		}
		
	},
	
	isValid:function(){
		var is_valid = true;
		var elements = jQuery('input,select,textarea,file',this.form_obj);
		for(i=0;i<elements.length;i++){
			this.error = '';
			
			jQuery(elements[i]).css({"border":"1px solid","border-color":"","color":""});
			//high light *
			if((notify = jQuery('#notify_'+jQuery(elements[i]).attr('id')))){
				jQuery(notify).css({"color":""});
			}
			
			
			
			class_str = jQuery(elements[i]).attr('class');
			class_ar = class_str.split(' ');
			
			for(j = 0; j < class_ar.length; j++){
				if($.inArray(class_ar[j],this.rules)>-1){
					if(this[class_ar[j]](elements[i])==false){
						is_valid = false;
						//jQuery(elements[i]).addClass('validate-error').removeClass('border');
						//jQuery(elements[i]).removeClass('validate-error');
						this.showErrorSign(elements[i]);
						break;
					}
				}
			}
		}
		
		this.error = '';
		return is_valid;
	}
});

*/
