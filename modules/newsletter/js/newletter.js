//NEWSLETTER
var NewsLetter = function(form){
    this.form = form;
};
NewsLetter.prototype = {
    isSubmit: function(){
        var validation = new Validation(this.form);
        if(validation.isValid()){
			jQuery(this.form).submit();
        }
    }
};



//END




//BEGIN SHOW POPUP CUSTOMIZE FOR MASS EMAIL
var Customize = function(){
    this.prepare = null;
    this.finish = null;
    this.type_send = 'html';
    this.data = [];
};

Customize.prototype = {
    load: function(url) {
			if (this.prepare != null) {
				this.prepare();
			}
            var params = this.data;
			if (this.finish != null) {
                var country = $('country').val();
        		jQuery.post(url,{country:country,params:params},this.finish,this.type_send);
			} else {
				jQuery.post(url,{country:country,params:params},this.onLoad,this.type_send);
			}
		}

	,onLoad: function(data) {
			var info = jQuery.parseJSON(data);
			if (info.data) {
				jQuery('#popup').html(info.data);
                this.loadData();
			} else {
				alert('failure');
			}
             jQuery('#customize_loading').hide();
		}
    ,submit: function(){
        var data = new Object();
            data.user = [];
            $('input[type=checkbox]:checked').each(function(){
                data.user.push($(this).val());
            });
            data.suburb = $('#suburb').val();
            data.country = $('#country').val();
            data.state = $('#state').val();
            data.other_state = $('#other_state').val();
        this.data = data;
        this.sydc();
    }
    ,isSubmit: function(form){
        var _val = jQuery(form).val();
		if (_val == 1) {
			return true;
		}
		return false;
    }
    ,loadData: function(){
        if (this.data.country){
           changeCountry(this.data.country);
        }
        /*var ar = ["vendors","buyers","partners"];
        $.each(this.data,function(key,value){
            if ($.inArray(key,ar) >= 0) {
                $('input[name='+key+']').attr('checked',value);
            }
            else {
                $('#'+key).val(value);
            }
        });*/


    }
    ,clearData: function(){
        this.data = [];
    }
    ,sydc: function(){
        $.each(this.data,function(key,value){
            if (key == 'user'){
                $('#frmLetter [name='+key+']').val(value.toString());
            }else{
                $('#frmLetter [name='+key+']').val(value);
            }
        });
    }

};

 var customize = new Customize();
 var customize_popup = new Popup();

 customize_popup.init({id:'customize_popup',className:'popup_overlay'});
 customize_popup.updateContainer('<div class="popup_container" style="width:397px;height: 212px;"><div id="popup"></div></div>');
 

    customize.prepare = function() {
		//jQuery('#customize_loading').show();
        jQuery('div.popup_container').attr('align','center');
        var top = (jQuery('div.popup_container').height() - 30)/2;
        jQuery('#popup').html('<img src="/modules/general/templates/images/loading.gif" alt="" style="height:30px;margin-top: '+top+'px"/>');
	};

	customize.finish = function(data) {

		var info = jQuery.parseJSON(data);
		if (info.data) {
            //alert(info.data);
            //jQuery('#popup').html('test test');
            jQuery('div.popup_container').removeAttr('align');
			jQuery('#popup').html(info.data);
            customize.loadData();
		} else {
			alert('failure');
		}
        jQuery('#customize_loading').hide();
		//jQuery('#popup').hide();
	};
 function showCustomize(){
    customize_popup.show().toCenter();
    customize.load('../modules/newsletter/action.admin.php?action=loadCustomize&token='+$('#token').val());
 }

function closeCustomize(){
    customize.clearData();
    jQuery(customize_popup.container).fadeOut('slow',function(){customize_popup.hide()});
}
function submitCustomize(){
    customize.submit();
    customize_popup.hide();
}



//SELECTED BOX
var SelectedBox = function(){
    this.text = '';
    this.selectbox = '';
    this.container = '';
    this._total = 5;
    this._current = -1;
};
SelectedBox.prototype = {
    hideBox: function(){
        $(this.selectbox).removeClass('select-box-open');
        $(this.selectbox).addClass('select-box-close');
        $(this.container).hide();
    },
    getText : function(obj){
        $(this.text).text($(obj).text());
        $('input[name=mail_to]').val($(obj).attr('id'));
                
        if ($(obj).attr('id') == 'item_-1'){
            showCustomize();
        }
        this.hideBox();
    },
    changeStatus: function(){
        if ($(this.container).css("display") == 'none'){//hide
            $(this.container).show();
            $(this.selectbox).removeClass('select-box-close');
            $(this.selectbox).addClass('select-box-open');
        } else{
            this.hideBox();

        }
    },
    moveByKey: function(e){
		if (window.event) {
			e = window.event;
		}
		switch (e.keyCode) {
			case 40://down
				if (this._current < this._total) {
					this._current++;
				}
			    break;
			case 38://up
				if (this._current > 0) {
					this._current--;
				}
			    break;
			case 13://enter
				if (this._current < 0) {
                    this.hideBox();
				} else {
					this._current = -1;
                    this.getText('#item_'+this._current);
					this.hideBox();
				}
			    break;
			default:

			break;
		}
	}

}

function changeCountry(country){
    if (country == 1){
        //Common.changeCountry('/modules/general/action.php?action=get_states',obj,'state');
        $('#state').show();
        $('#other_state').hide();
    }else{
        $('#other_state').show();
        $('#state').hide();
    }
}


