var jsonOption = function(jsonElement, grid, form, validateUrl) {
    this.jsonEl = jsonElement;
    this.grid = grid;
    this.form = form;
    this.validateUrl = validateUrl;
    this._callbackResetAction_fnc = [],
    this._callbackEditAction_fnc = []
}

jsonOption.prototype = {
    options : [],
    init:function(){
        var jsonStr = jQuery(this.jsonEl).val();
        if (jsonStr.length > 0){
            this.options = jQuery.parseJSON(jsonStr);
        }else{
            this.options = [];
        }
        if (typeof (this.form) == 'string') {
            this.form = jQuery(this.form);
        }
        this.saveBtn = this.form.find('input[name=save]');
        this.resetBtn = this.form.find('input[name=reset]');
        var self = this;
        this.saveBtn.unbind().bind('click',function(){
            self.saveNewRow();
        });

        this.resetBtn.unbind().bind('click',function(){
            self.reset();
        });
        this.container = this.form.find('#pack_option');
        this.loadUnit();
        this.loadSelectOption();
        jQuery('#option_type').unbind().bind('change',function(){
           self.loadSelectOption();
        });

        jQuery('#option_has_unit').unbind().bind('change',function(){
            self.loadUnit();
        });
        this.flushResetAction();
        this.flushEditAction();
    },
    update:function(code){
        var index = this.getIndexByCode(code);
        this.options[index].remove = (this.getOptionElement(code,'.cell-remove input').is(':checked') ? 1 : 0);
        jQuery(this.jsonEl).val(JSON.stringify(this.options));
    },
    edit:function(code) {
        var index = this.getIndexByCode(code);
        jQuery.each(this.options[index],function(k,value){
            var formEl = '#option_'+k;
            if (jQuery(formEl).length > 0){
                var tagEl = $(formEl)[0].tagName.toLowerCase();
                if ( (tagEl == 'input' && jQuery(formEl).attr('type') != 'checkbox') || tagEl == 'select'){
                    jQuery(formEl).val(value);
                }else if (tagEl == 'textarea'){
                    jQuery(formEl).text(value);
                }else if (tagEl == 'input' && jQuery(formEl).attr('type') == 'checkbox'){
                    if (value == 1){
                        jQuery(formEl).attr('checked','checked');
                    }else{
                        jQuery(formEl).removeAttr('checked');
                    }
                }
            }
        });
        this.index = index;
        if (this._callbackEditAction_fnc.length > 0) {
			for (var i = 0; i < this._callbackEditAction_fnc.length ;i++) {
				this._callbackEditAction_fnc[i]();
			}
		}
        this.loadUnit();
        this.loadSelectOption();
        this.disableElements();
    },
    saveNewRow:function(){
        //validate required
        this.addValidation();
        var validation = new Validation(this.container);
		if(validation.isValid()){
			//validate code
            this.enableElements();
            var data = this.form.serialize();
            if (!isNaN(this.index) && this.index != null){
                data += '&option_option_id='+this.options[this.index].option_id;
            }
            var url =  this.validateUrl;
            var self = this;
            jQuery.post(url, data, function(response) {
                var result = jQuery.parseJSON(response)
                if (result.success) {
                    self.addNewRow(result.data,result.html);
                    self.reset();
                }else{
                    self.disableElements();
                    //add error
                    if (jQuery('.message-box').length == 0){
                        jQuery('#pack_option').prepend('<div class="message-box"></div>');
                    }
                    jQuery('.message-box').replaceWith(' <div class="message-box">'+result.message+'</div>');
                }
            });
		}
    },
    addNewRow:function(data,html){
        //focus to page
        var len = 7;
        try{
            var total = this.options.length;
            var p = Math.ceil(total/len);
            if (!isNaN(this.index) && this.index != null){
                var oldCode = this.options[this.index].code;
                data.option_id = this.options[this.index].option_id;
                this.options[this.index] = data;

                p = Math.ceil(this.index/len);
                //gotoPage(p);
                //this.getOptionElement(oldCode).replaceWith(html);
                //this.getOptionElement(data.code,'.cell-uq').html((this.index + 1));
            }else{

                var index = this.getIndexByCode(data.code);
                if (index == null){//new option
                    this.options.push(data);
                    //gotoPage(p);
                    /*if (html){
                        jQuery(this.grid).find('tbody').append(html);
                        if (typeof (data.code) != 'undefined'){
                            this.getOptionElement(data.code,'.cell-uq').html(this.options.length);
                        }
                    }*/
                }else{//double option
                    this.options[index] = data;
                    p = Math.ceil(index/len);

                    //this.getOptionElement(data.code).replaceWith(html);
                    //this.getOptionElement(data.code,'.cell-uq').html(this.options.length);
                }
            }
            jQuery(this.jsonEl).val(JSON.stringify(this.options));
            gotoPage(p);
        }catch(e){
            console.log(e);
        }
    },
    reset:function(){
        this.index = null;
        jQuery.each(this.container.find('input'),function(item){
            var type = jQuery(this).attr('type');
            if (type == 'checkbox' || type == 'radio'){
                jQuery(this).attr('checked','checked');
            }else if (type != 'button' && type != 'submit') {
                jQuery(this).val('');
            }
        });

        jQuery.each(this.container.find('select'),function(item){
            jQuery(this).val('');
        });

        jQuery.each(this.container.find('textarea'),function(item){
            jQuery(this).text('');
        });
        this.enableElements();
        this.loadUnit();
        this.loadSelectOption();
        this.removeValidation();
        jQuery('#pack_option').find('.message-box').remove();
        if (this._callbackResetAction_fnc.length > 0) {
			for (var i = 0; i < this._callbackResetAction_fnc.length ;i++) {
				this._callbackResetAction_fnc[i]();
			}
		}
    },
    flushResetAction: function(){
		this._callbackResetAction_fnc = [];
	},
    flushEditAction: function(){
		this._callbackEditAction_fnc = [];
	},
    change:function(code){
        var index = this.getIndexByCode(code);
        this.options[index].is_active = 1 - this.options[index].is_active;

        var statusEl = this.getOptionElement(code,'.cell-status a');

        if (this.options[index].is_active){
            statusEl.html('Active');
        }else{
            statusEl.html('InActive');
        }
        jQuery(this.jsonEl).val(JSON.stringify(this.options));
    },
    getIndexByCode:function(code){
        var index = null;
        jQuery.each(this.options, function(i,item) {
            if (item.code == code) {
                index = i;
            }
        });
        return index;
    },
    getOptionElement : function(code, element) {
        var selector;
        if (typeof (element) != 'undefined'){
            selector = '#option_' + code  + ' ' + element;
        }else{
            selector = '#option_' + code;
        }

        var elems = jQuery(selector);
        if (!elems) {
            try {
                console.log(selector);
            } catch (e2) {
                alert(selector);
            }
        }
        return jQuery(selector);
    },
    loadUnit:function(){
        if (jQuery('#option_has_unit').val() == 1) {
            jQuery('#option_unit').closest('tr').show();
        } else {
            jQuery('#option_unit').closest('tr').hide();
        }
    },
    loadSelectOption:function(){
        if (jQuery('#option_type').val() == 'select' || jQuery('#option_type').val() == 'multiselect') {
            jQuery('#select_option').show();
        } else {
            jQuery('#select_option').hide();
        }

        if (jQuery('#option_type').val() == 'price' ||
            jQuery('#option_type').val() == 'date' ||
            jQuery('#option_type').val() == 'multiselect' ||
            jQuery('#option_type').val() == 'boolean'){
            jQuery('#option_has_unit').val(0);
            jQuery('#option_has_unit').closest('tr').hide();
        }else{
            jQuery('#option_has_unit').closest('tr').show();
        }
    },
    disableElements:function(){
        jQuery.each(jQuery('input,select,textarea',this.form),function(){
            if (jQuery(this).hasClass('disable-element')){
                jQuery(this).attr('disabled','disabled');
            }
        });
    },
    enableElements:function(){
        jQuery.each(this.container.find('.disable-element'),function(item){
            jQuery(this).removeAttr('disabled');
        });
    },
    addValidation:function(){
        this.validateOption = {};
        var self = this;
        jQuery.each(this.container.find('input,select,textarea'),function(item){
            var element = this;
            var classAr = jQuery(this).attr('class').split(' ');
            var option = [];
            jQuery.each(classAr,function(index,value){
                  if (value.match(/_validate-[a-z]/)){
                      var newClass = value.replace('_validate','validate');
                      jQuery(element).addClass(newClass);
                      option.push(newClass);
                  }
            });
            self.validateOption[jQuery(this).attr('id')] = option;
        });
    },
    removeValidation:function(){
        jQuery.each(this.validateOption,function(id,classAr){
             jQuery.each(classAr,function(index,value){
                  jQuery('#'+id).removeClass(value);
             });
        });
    }
};