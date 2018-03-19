	//LOGIN & SENDPOPUP FROM LIBRARY
	var login_cls = new Log();
	var login_popup_cls = new Popup();
	//BEGIN LOGIN						
	login_data = ['email','password']; 
	
	login_cls.prepare = function() {
		jQuery('#login_loading').show();
	};
	
	login_cls.finish = function(data) {
		var info = jQuery.parseJSON(data);
		
		if (info.success) {
			if (info.redirect && typeof login_cls.callback_fnc !=  'function') {
				document.location = info.redirect.replace(/&amp;/g,'&');
			}
		} else if (info.error) {
			showErrorLoginPopup(info.error);
			jQuery('#login_loading').hide();
			return false;
		}
		
		jQuery('#login_loading').hide();
		login_cls.clear('#frmLoginPopup',['email','password']);//clear data from login form
		jQuery(login_popup_cls.container).fadeOut('slow',function(){login_popup_cls.hide()});
        /**/
        if(typeof login_cls.callback_fnc ==  'function'){
            login_cls.callback_fnc();
        }
	};
	
	//END
	login_popup_cls.init({id:'login_popup2',className:'popup_overlay'});
	login_popup_cls.updateContainer('<div class="popup_container login-container"><div id="contact-wrapper">\
			<div class="title"><h2><span class="span-title-login-a">Login</span><span   class="span-title-login-b" onclick="closeLoginPopup()">Close X</span></h2><div class="clearthis"></div></div>\
            <div class="content" style="width:94%">\
				<form name="frmLoginPopup" id="frmLoginPopup" onsubmit="return false;" method="post">\
                 <div id="login_msg" class="login-msg-all"></div>\
                <div class="div-login-msg"></div>\
				<div class="input-box">\
				  <label for="subject"><strong id="notify_email">Email<span >*</span></strong></label><br/>\
				  <input type="text" name="email" id="email" value="" class="input-text validate-email" style="width:290px" onKeyUp="handlerLoginPopup(event)"/>\
				</div>\
				<div class="input-box">\
				  <label for="subject"><strong id="notify_password">Password<span >*</span></strong></label><br/>\
				  <input type="password" name="password" id="password" value="" class="input-text validate-require" style="width:290px" onKeyUp="handlerLoginPopup(event)"/>\
				</div>\
				</form>\
				<p>\
				<button class="btn-submit" onClick="clickLoginPopup()"><span><span>SUBMIT</span></span></button><br/><br/>\
				<span class="question">Not registered? </span><a id="link_reg_now" style="font-weight: bold" href="' + ROOTURL + '/?module=agent&action=landing" target="_blank">Register now</a>\
				<div id="login_loading" style="display:none;position:absolute"><img src="/modules/general/templates/images/loading.gif" style="height:30px;" alt="" /></div>\
				</p>\
			</div></div></div></div>');
	
	
	
	function clickLoginPopup() {
		login_cls.data = {email:jQuery('#frmLoginPopup [name=email]').val(),
                          password:jQuery('#frmLoginPopup [name=password]').val(),
                          re_url: document.location.href
                        };
		login_cls.login('#frmLoginPopup', '/modules/agent/action.php?action=login');
	}
	
	function showLoginPopup() {
		login_popup_cls.show().toCenter();
		jQuery('#login_loading').hide();
		hideErrorLoginPopup();
	}

    function showLoginPopup_block() {
        login_popup_cls.show().toCenter();
        jQuery('#link_reg_now').attr('href',ROOTURL+ '/?module=agent&action=register-buyer');
        jQuery('#login_loading').hide();
        hideErrorLoginPopup();
    }
	function closeLoginPopup() {
		jQuery('#login_loading').hide();
		login_cls.clear('#frmLoginPopup',['email','password']);
		jQuery(login_popup_cls.container).fadeOut('slow',function(){login_popup_cls.hide()});
	}
	
	function showErrorLoginPopup(str) {
		jQuery('#login_msg').addClass('message-box');
		jQuery('#login_msg').html(str);
		jQuery('#login_msg').show();
	}
	
	function hideErrorLoginPopup() {
		jQuery('#login_msg').removeClass('message-box');
		jQuery('#login_msg').html('');
		jQuery('#login_msg').hide();
	}
	
	function handlerLoginPopup(e) {
		if (window.event) {
			e = window.event;
		}
		
		var _email = jQuery.trim(jQuery('#frmLoginPopup [name=email]').val());
		var _password = jQuery.trim(jQuery('#frmLoginPopup [name=password]').val());
		if (e.keyCode == 13 && _email.length > 0 && _password.length > 0) {
			clickLoginPopup()
		}
	}
    var customerRegistration_popup_cls = null;
    function customerRegistration_init(){
        customerRegistration_popup_cls = new Popup();
        customerRegistration_popup_cls.init({id:'customerRegistration_popup',className:'popup_overlay'});
        customerRegistration_popup_cls.updateContainer('<div class="popup_container customerRegistration_container">\
            <div id="contact-wrapper">\
                <div class="title"><h2><span class="span-title-login-a" style="float: left">Customer Registration</span><span class="span-title-login-b" onclick="customerRegistration_hide()">Close X</span></h2><div class="clearthis"></div></div>\
                <div class="content" style="width:94%">\
                    <p style="font-weight: bold">Want to know more and be kept up to date with our online developments and listings</p>\
                    <p>Enter your details below to make sure you get the lastest news on the biggest change in real estate in 100 years</p>\
                    <form name="frmCustomerRegistrationPopup" id="frmCustomerRegistrationPopup" onsubmit="return false;" method="post">\
                    <div id="login_msg_cusres" class="login-msg-all"></div>\
                    <div class="div-login-msg"></div>\
                    <div class="input-box">\
                      <label for="subject"><strong id="notify_firstname">First Name<span >*</span></strong></label>\
                      <input type="text" name="firstname" id="firstname" value="" class="input-text" style="width:35%;margin-right: 12px"/>\
                      <label for="subject"><strong id="notify_lastname">Last Name<span >*</span></strong></label>\
                      <input type="text" name="lastname" id="lastname" value="" class="input-text" style="width:36%"/>\
                    </div>\
                    <div class="input-box">\
                      <label for="subject"><strong id="notify_email"><span>Email Address*</span></strong></label>\
                      <input type="text" name="email" id="email" value="" class="input-text" style="width:98%"/>\
                    </div>\
                    <div class="input-box">\
                      <label for="subject"><strong id="notify_postcode"><span>Postcode</span></strong></label>\
                      <input type="text" name="postcode" id="postcode" value="" class="input-text" style="width:98%"/>\
                    </div>\
                    <div class="input-box">\
                      <label for="subject"><strong id="notify_describes"><span>What best describes you?</span></strong></label>\
                      <input type="text" name="describes" id="describes" value="" class="input-text" style="width:98%"/>\
                    </div>\
                    <div class="input-box">\
                      <label for="subject"><strong id="notify_interested"><span>What are you interested in?</span></strong></label>\
                      <input type="text" name="interested" id="interested" value="" class="input-text" style="width:98%"/>\
                    </div>\
                    <div class="input-box">\
                      <label for="subject"><strong id="notify_interested_project"><span>Are you interested in a project?</span></strong></label>\
                      <input type="text" name="interested_project" id="interested_project" value="" class="input-text" style="width:98%"/>\
                    </div>\
                    <div class="input-box">\
                      <label for="subject"><strong id="notify_agree"><span>I agree to the terms and conditon of BidRhino.com</span></strong></label>\
                      <input type="checkbox" name="agree" id="agree" value="1" class="checkbox-text"/>\
                    </div>\
                    </form>\
                    <p>\
                    <button class="btn-submit" onClick="customerRegistration_submit()"><span><span>SUBMIT</span></span></button>\
                    <div id="login_loading_cusres" style="display:none;position:absolute"><img src="/modules/general/templates/images/loading.gif" style="height:30px;" alt="" /></div>\
                    </p>\
                    </div>\
                </div>\
            </div>\
        </div>');
    }
    function customerRegistration_show(){
        customerRegistration_popup_cls.show().toCenter();
    }
    function customerRegistration_hide(){
        jQuery(customerRegistration_popup_cls.container).fadeOut('slow',function(){customerRegistration_popup_cls.hide()});
    }
    function customerRegistration_submit(){
        jQuery('#login_loading_cusres').show();
        var data = jQuery('#frmCustomerRegistrationPopup').serialize();
        var url = ROOTURL +'/modules/general/action.php?action=customer_registration';
        jQuery.post(url,data,function(data){
            jQuery('#login_loading_cusres').hide();
            var result = jQuery.parseJSON(data);
            console.log(data);
            customerRegistration_hide();
        },'json');
    }
    customerRegistration_init();