
jQuery(function ($) {
	$('#confirm-dialog input.btn-bid-lan, #confirm-dialog a.btn-bid-lan').click(function (e) {
		e.preventDefault();

		confirm("Continue to the Bid ?", function () {														 
				
		});
	});
});

function confirmGos(message,  callback) {
	$('#popup_container').modal({
							
		position: ["20%",],
		overlayId: 'confirm-overlay',
		containerId: 'confirm-container', 
		onShow: function (dialog) {
			var modal = this;

			$('.message', dialog.data[0]).append(message);

			// if the user clicks "yes"
			$('.yes', dialog.data[0]).click(function () {
				// call the callback
				
				if ($.isFunction(callback)) {
					callback.apply();
				}
				// close the dialog
				modal.close(); // or $.modal.close();
			});
		}
	});
}
/*var Confirm = function(){
    this.ok = false;
    this.property_id = 0;
}
Confirm.prototype = {
    init: function(){
        var conf_popup = new Popup();
        conf_popup.init({id:'conf_popup',className:'popup_overlay'});
    },
    showPopup: function(error_to_from,url,form,type){
        showConfirm(error_to_from,url,form,type);
//        jQuery('#OK').bind('click',function(){
//            self['bid_' + this.property_id].bid(this.property_id);
//        });
    }
}*/
var Confirm_popup = function(){
    this.fnc = [];
    this.msg = '';
    this.property_id = 0;
};
Confirm_popup.prototype = {
    addFunc: function(fnc) {
		this.fnc.push(fnc);
	},

	flushCallback: function() {
		this.fnc = [];
	}
};
//var confirm_nh = Confirm_popup();
//POPUP CONFIRM
    var conf_popup = new Popup();
    var frm = '';
    var type = 'ok/cancel';
    var ok = false;
    conf_popup.init({id:'conf_popup',className:'popup_overlay'});


	function showConfirm(error_to_from,url,form,type) {
		if (typeof self['confirm_nh'] != 'undefined' && self['confirm_nh'].fnc != null){
            self['confirm_nh'].flushCallback();
        }
        frm = form;
        if (type = 'ok/cancel'){
            btn1 = 'OK';
            btn2 = 'Cancel';
        }
        if (type = 'yes/no'){
            btn1 = 'Yes';
            btn2 = 'No';
        }

        /*conf_popup.updateContainer('<div class="popup_container" style="width:356px;height: auto;min-height: 120px;z-index:1000"><div id="contact-wrapper">\
			 <div class="title"><h2 id="test-cufon"> This page says:<span id="btnclosex" onclick="closeConfirm()">x</span></h2> </div>\
			 <div class="clearthis" style="clear:both;"></div>\
			 <div class="content content-po" id="confirm-msg">\
                 <img src="/modules/property/templates/images/alert.png"></img>\
                <div class="msg-box" id="msg-confirm" style="display:none"></div><span>'+error_to_from+'</span></div>\
             </div>\
                <input type="hidden" id="url"></input><input type="hidden" id="is_confirm" value="0"></input>\
			 <div class="clearthis"></div><div class="center-confirm-button"><button class="btn-red" id="OK" onclick="confirm_popup()"><span><span>'+btn1+'</span></span></button>\
             <button class="btn-red" onclick="closeConfirm()"><span><span>'+btn2+'</span></span></button></div>\
			  </div></div></div>');*/

        var width = jQuery.browser.mobile?290:365;
        conf_popup.updateContainer('<div class="popup_container" style="width:'+width+'px;height: auto;min-height: 120px;z-index:1000"><div id="contact-wrapper">\
			 <div class="title"><h2 id="test-cufon"> This page says:<span id="btnclosex" onclick="closeConfirm()">x</span></h2> </div>\
			 <div class="clearthis" style="clear:both;"></div>\
			 <div class="content content-po" id="confirm-msg">\
                 <img src="/modules/property/templates/images/alert.png"></img>\
                <div class="msg-box" id="msg-confirm" style="display:none"></div><span style="font-weight: bold;">'+error_to_from+'</span></div>\
             </div>\
                <input type="hidden" id="url"></input><input type="hidden" id="is_confirm" value="0"></input>\
			 <div class="clearthis"></div><div class="center-confirm-button"><button class="btn-red-popup" id="OK" onclick="confirm_popup()" style="margin-right: 10px"><span><span>'+btn1+'</span></span></button>\
             <button class="btn-red-popup" onclick="closeConfirm()"><span><span>'+btn2+'</span></span></button></div>\
			  </div></div></div>');

        conf_popup.show().toCenter();
        jQuery('#url').val(url);
        Cufon.replace('#test-cufon');
	}

	function closeConfirm() {
		jQuery(conf_popup.container).fadeOut('slow',function(){conf_popup.hide()});
	}
    function confirm_popup(){
        var url = jQuery('#url').val();
        if (url != ''){
            Common.redirect(url);
            return;
        }
        if (frm != ''){
            jQuery('#is_submit',frm).val(1);
            jQuery(frm).submit();
            closeConfirm();
            return;
        }
        var ok = true;
        if (typeof self['confirm_nh'] != 'undefined' && self['confirm_nh'].fnc != null){
            for (var i = 0; i < self['confirm_nh'].fnc.length ;i++) {
                if (self['confirm_nh'].fnc[i]() == false){
                    ok = false;
                }
            }
            if (ok) closeConfirm();
            else{
                $('#msg-confirm').show();
                $('#msg-confirm').html('Error');
            }
            //self['confirm_nh'].flushCallback();
        }
        //closeConfirm();
    }

//END
