var id_popup, id_pro = null;
var Property = function () {
    this.country_obj = null;
    this.effect_id = '';
    this.effect_obj = null;
    this.delay_send_friend = '';
    this.callback_func = [];
    this.pass = false;
    this.suburb = null;
    this.state = null;
    this.postcode = null;
    this.is_submit = '';
    this.status_sold = null;
};
Property.prototype = {
    gotoStep: function (url) {
        document.location = url;
    },
    isSubmit: function (form) {
        var _val = jQuery('#' + this.is_submit, form).val();
        if (_val == 1) {
            return true;
        }
        return false;
    },
    submit: function (form, track) {
        //input:frm='#frmProperty'
        var validation = new Validation(form);
        var _ok = validation.isValid();
        var ok = true;
        if (this.callback_func['valid'] && this.callback_func['valid'].length > 0) {
            for (var i = 0; i < this.callback_func['valid'].length; i++) {
                if (this.callback_func['valid'][i]() == false) {
                    ok = false;
                    //break;
                }
            }
        }
        //Common.validRegion('/modules/property/action.php?action=validate-property','#suburb','#state','#postcode',form);
//		if (ok && _ok) {
        if (_ok && ok) {
            if (track == true) {
                jQuery(form + ' [name=track]').val('1');
            }
            jQuery('#' + this.is_submit, form).val(1);
            jQuery(form).submit();
            return true;
        }
        jQuery('#' + this.is_submit, form).val(0);
        return false;
    },
    addCallbackFnc: function (key, fnc) {
        if (!this.callback_func[key]) {
            this.callback_func[key] = [];
        }
        this.callback_func[key].push(fnc);
    },
    flushCallback: function () {
        this.callback_func = [];
    },
    //BEGIN WATCHLIST
    addWatchlist: function (url) {
        showLoadingPopup();
        jQuery.post(url, {}, this.onAddWatchlist, 'html');
    },
    onAddWatchlist: function (result) {
        //alert(result);
        closeLoadingPopup();
        var result = jQuery.parseJSON(result);
        var data = '';
        if (result.success) {
            data = result.success;
            showMess(data);
        } else {
            if (result.error == 'login-popup')
                showLoginPopup();
            else {
                data = result.error;
                showMess(data);
            }
        }
    },
    getKind: function (url, obj1, obj2) {
        var param = new Object();
        param.kind = jQuery(obj1).val();
        param.target = obj2;
        jQuery.post(url, param, this.onGetKind, 'json');
    },
    onGetKind: function (data) {
        if (data.error == 0) {
            data.target = data.target.replace('#', '');
            form_select.removeAll(data.target);
            if (data.content) {
                var i = 0;
                for (var el in data.content) {
                    if (parseInt(el) >= 0) {
                        if (i == 0) {
                            jQuery('#uniform-' + data.target + ' > span').html(data.content[el]);
                        }
                        form_select.add(data.target, {'value': el, 'text': data.content[el]})
                    }
                    i++;
                }
            }
        } else {
            alert('error');
        }
    },
    onChangeKind: function (obj, a1, a2) {
        var val = jQuery(obj).val();
        var def = 1;
        if (typeof arguments[3] != 'undefined') {
            def = arguments[3];
        }
        if (val == def) {
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
//    /*valid*/
//    validRegion:function(suburb, state, postcode, form){
//        //alert('Valid');
//        var url = '/modules/property/action.php?action=validate-property';
//        this.suburb = suburb;
//        this.state = state;
//        this.postcode = postcode;
//        this.effect_id = form;
//        var region = jQuery(suburb).val()+" "+jQuery(state).val()+" "+jQuery(postcode).val();
//        //$.post(url,{region:region},this.onRegion,'html');
//        //alert(url);
//        //alert($.post(url,{region:region},this.onRegion,'html'));
//        //alert(region);
//    },
//    onRegion:function(result){
//      //alert('onValid');
//
//      var info = jQuery.parseJSON(result);
//        if (info == ''){
//           var validation = new Validation(Property.effect_id);
//           //alert(validation.form_id);
//           validation.showErrorSign(Property.suburb);
//           validation.showErrorSign(Property.state);
//           validation.showErrorSign(Property.postcode);
//           //showMess('Invalid Region!');
//		}
//
//    },
    /*end valid*/

    //check property sold
    set_status_sold: function (value) {
        this.status_sold = value;
    },
    get_status_sold: function () {
        return this.status_sold;
    },
    checkOffer: function (property_id, agent_id) {
        showLoadingPopup();
        var url = '/modules/property/action.php?action=check_offer';
        $.post(url, {property_id: property_id, agent_id: agent_id}, this.oncheckOffer, 'html');
    },
    oncheckOffer: function (data) {
        var result = jQuery.parseJSON(data);
        closeLoadingPopup();
        if (result.success) {
            jQuery('#mao_loading_' + id_pro).hide();
            jQuery(id_popup).show();
            jQuery('#content', '#makeanoffer_' + result.property_id).val('');
            jQuery('#content', '#makeanoffer_' + result.property_id).css({color: '', border: ''});
            jQuery('#agent_email', '#makeanoffer_' + result.property_id).val(jQuery('#agent_email_active', '#makeanoffer_' + result.property_id).val());
            jQuery('#agent_email', '#makeanoffer_' + result.property_id).css({color: '', border: ''});
        } else {
            if (result.error == 'login') {
                showLoginPopup();
            } else {
                if (result.term) {
                    term.showPopup(id_pro);
                } else if (result.redirect != null) {
                    document.location = result.redirect;
                } else {
                    showMess(result.error, '', false);
                }
            }
        }
    },
    //BEGIN MAKE AN OFFER
    openMakeAnOffer: function (popup_id, property_id, agent_id) {
        //alert(agent_id);
        if ($('#email_address').val() == '' && $('#login').val() == true) {
            confirmEmail(agent_id);
            return;
        }
        if (parseInt(agent_id) == 0 || typeof agent_id == 'undefined') {
            //showMess('Login to use that feature.','',false);
            showLoginPopup();
            return;
        }
        id_popup = popup_id;
        id_pro = property_id;
        this.checkOffer(property_id, agent_id);
        /*
         jQuery('#mao_loading_'+property_id).hide();
         jQuery(popup_id).show();
         */
    },
    closeMakeAnOffer: function (popup_id) {
        jQuery(popup_id).hide();
    },
    makeAnOffer: function (form_id, property_id, popup_id) {
        var url = '/modules/property/action.php?action=make_an_offer';
        var validation = new Validation(form_id);
        if (validation.isValid()) {
            //showLoadingPopup();
            var param = new Object();
            param.property_id = property_id;
            param.agent_email = jQuery('#agent_email', form_id).val();
            param.agent_id = jQuery('#agent_id', form_id).val();
            param.content = jQuery('#content', form_id).val();
            param.offer_price = jQuery('#offer_price', form_id).val();
            param.popup_id = popup_id;
            jQuery('#mao_loading_' + property_id).show();
            $.post(url, param, this.onMakeAnOffer, 'html');
            return true;
        }
    },
    onMakeAnOffer: function (data) {
        //closeLoadingPopup();
        var result = jQuery.parseJSON(data);
        if (result.property_id) {
            jQuery('#mao_loading_' + result.property_id).hide();
            if (result.error) {
                if (result.error_id == 2) {
                    jQuery('#offer_price', '#frmMakeAnOffer_' + result.property_id).css({
                        "width": "100%",
                        "border": "1px dashed rgb(255, 0, 0)",
                        "color": "rgb(255, 0, 0)"
                    })
                }
                showMess(result.error, '', false);
            } else if (result.popup_id) {
                //Property.closeMakeAnOffer(result.popup_id);
                jQuery(result.popup_id).hide();
            }
        }
    },
    buynow: function (property_id, buynow_price) {
        if (authentic_id > 0) {
            show_buynow_popup(property_id, buynow_price);
        } else {
            showLoginPopup();
        }
    },
    autoBidSetting: function (property_id) {
        var url = '/modules/property/action.php?action=auto_bid_setting';
        var param = new Object();
        param.property_id = property_id;
        param.autobid_enable = jQuery('#autobid_enable_' + property_id).is(':checked') ? 1 : 0;
        $.post(url, param, this.onAutoBidSetting, 'html');
        return true;
    },
    onAutoBidSetting: function (data) {
        var result = jQuery.parseJSON(data);
        if (result.success == 1) {
            jQuery('#msg_' + result.property_id).html(result.msg);
            jQuery('#msg_' + result.property_id).show();
        }
    },
    closeRequireActive: function (popup_id) {
        jQuery(popup_id).hide();
    },
    requireActive: function (form_id, property_id, popup_id) {
        var url = '/modules/property/action.php?action=require_activation';
        var validation = new Validation(form_id);
        if (validation.isValid()) {
            var param = new Object();
            param.property_id = property_id;
            param.agent_email = jQuery('#agent_email', form_id).val();
            param.agent_id = jQuery('#agent_id', form_id).val();
            param.content = jQuery('#content', form_id).val();
            param.subject = jQuery('#subject_email', form_id).val();
            param.popup_id = popup_id;
            jQuery('#mao_loading_' + property_id).show();
            $.post(url, param, this.onRequireActive, 'html');
            return true;
        }
    },
    onRequireActive: function (data) {
        var result = jQuery.parseJSON(data);
        if (result.property_id) {
            jQuery('#mao_loading_' + result.property_id).hide();
            jQuery('#requireActive_' + result.property_id).hide();
            if (result.sent) {
                showMess('Your requirement has been sent to iBB. We will check and activate your property soon.')
            }
            else {
                showMess('Error Mail,Try Again !');
            }
        }
    },
    sendMail: function (property_id) {
        var url = '/modules/property/action.php?action=send-mail';
        var par = new Object();
        par.agent_name = jQuery('#winner-name', '#winner-info-' + property_id).val();
        par.email_to = jQuery('#winner-email', '#winner-info-' + property_id).val();
        par.property_id = property_id;
        par.content = jQuery('#winner-content', '#winner-info-' + property_id).val();
        //par.popup_id = popup_id;
        if (par.content == '') {
            jQuery('#winner-content', '#winner-info-' + property_id).css({
                "border": "1px dashed rgb(255, 0, 0)",
                "color": "rgb(255, 0, 0)"
            });
        }
        else {
            jQuery('#winner-loading').show();
            jQuery.post(url, par, this.OnsendMail, 'html');
        }
    },
    OnsendMail: function (data) {
        var data_ = jQuery.parseJSON(data);
        jQuery('#winner-loading').hide();
        if (data_.sent == 1) {
            jQuery('#winner-mess-success', '#winner-info-' + data_.property_id).show();
        }
        else if (data_.sent == 0) {
            jQuery('#winner-mess-fail', '#winner-info-' + data_.property_id).show();
        }
        else {
            showConfirm('The mail is error!');
        }
    },
    // BEGIN AUTO BID
    before_openAutoBidForm: function (popup_id, property_id) {
        //check had email
        if ($('#email_address').val() == '' && $('#login').val() == true) {
            confirmEmail('');
            return;
        }
        var url = '/modules/property/action.php?action=before_auto_bid';
        var param = new Object()
        param.property_id = property_id;
        param.popup_id = popup_id;
        $.post(url, param, this.Onbefore_openAutoBidForm, 'html')
    },
    Onbefore_openAutoBidForm: function (data) {
        var data = jQuery.parseJSON(data)
        if (data.success == 1) {
            // show popup set Auto Bid
            //this.openAutoBidForm(data.popup_id,data.property_id);
            jQuery('#autobid_msg').hide();
            jQuery('#abs_loading_' + data.property_id).hide();
            jQuery(data.popup_id).show();
        } else {
            if (data.term) {
                term.showPopup(data.property_id);
            } else {
                showMess(data.msg, '', false);
            }
        }
    },
    openAutoBidForm: function (popup_id, property_id) {
        jQuery('#autobid_msg').hide();
        jQuery('#abs_loading_' + property_id).hide();
        jQuery(popup_id).show();
    },
    closeAutoBidForm: function (popup_id) {
        jQuery(popup_id).hide();
    },
    acceptBid: function (form_id, property_id, popup_id) {
        /*
         self['property_cls_' + property_id] = this;
         var url = '/modules/property/action.php?action=auto_bid';
         jQuery('#autobid_msg').hide();
         var validation = new Validation(form_id);
         if (validation.isValid()) {
         var param = new Object();
         param.property_id = property_id;
         param.agent_auction_step = jQuery(form_id + ' #agent_auction_step').val();
         param.agent_maximum_bid = jQuery(form_id + ' #agent_maximum_bid').val();
         param.accept = 1;
         param.form_id = form_id;

         jQuery(form_id + ' #abs_loading_' + property_id).show();
         $.post(url, param, this.onAcceptBid, 'html');
         return true;
         }
         */
        self['property_cls_' + property_id] = this;
        var url = '/modules/property/action.php?action=auto_bid';
        jQuery('#autobid_msg_' + property_id).hide();
        var validation = new Validation(form_id);
        if (validation.isValid()) {
            var param = new Object();
            param.property_id = property_id;
            param.agent_auction_step = jQuery('#agent_auction_step', form_id).val();
            param.agent_maximum_bid = jQuery('#agent_maximum_bid', form_id).val();
            param.accept = 1;
            param.form_id = form_id;
            jQuery('#abs_loading_' + property_id).show();
            $.post(url, param, this.onAcceptBid, 'html');
            return true;
        }
    },
    onAcceptBid: function (data) {
        var output = jQuery.parseJSON(data);
        /*
         if (output.property_id) {
         jQuery(output.form_id + ' #abs_loading_'+output.property_id).hide();
         }

         if (output.msg) {
         jQuery(output.form_id + ' #autobid_msg').html(output.msg);
         jQuery(output.form_id + ' #autobid_msg').show();
         }

         if (output.success == 1) {
         jQuery(output.form_id + ' #reg_autobid_accept_btn').hide();
         jQuery(output.form_id + ' #reg_autobid_cancel_btn').show();
         jQuery(output.form_id + ' #reg_autobid_close_btn').show();

         }
         */
        if (output.property_id) {
            jQuery('#abs_loading_' + output.property_id).hide();
        }
        if (output.msg) {
            jQuery('#autobid_msg_' + output.property_id).html(output.msg);
            jQuery('#autobid_msg_' + output.property_id).show();
        }
        if (output.success == 1) {
            jQuery('#reg_autobid_accept_btn_' + output.property_id).hide();
            jQuery('#reg_autobid_cancel_btn_' + output.property_id).show();
            jQuery('#reg_autobid_close_btn_' + output.property_id).show();
        }
    },
    cancelBid: function (form_id, property_id, popup_id) {
        self['property_cls_' + property_id] = this;
        var url = '/modules/property/action.php?action=auto_bid';
        /*
         jQuery(form_id + ' #autobid_msg').hide();
         jQuery(form_id + ' #abs_loading_' + property_id).show();

         jQuery(form_id + ' #abs_loading_' + property_id).show();
         $.post(url,{property_id : property_id,
         accept : 0 ,
         form_id : form_id},this.onCancelBid,'html');
         */
        jQuery('#autobid_msg_' + property_id).hide();
        jQuery('#abs_loading_' + property_id).show();
        $.post(url, {
            property_id: property_id,
            accept: 0,
            form_id: form_id
        }, this.onCancelBid, 'html');
    },
    onCancelBid: function (data) {
        var output = jQuery.parseJSON(data);
        /*
         if (output.property_id) {
         jQuery(output.form_id + ' #abs_loading_' + output.property_id).hide();
         }

         if (output.msg) {
         jQuery(output.form_id + ' #autobid_msg').html(output.msg);
         jQuery(output.form_id + ' #autobid_msg').show();
         }

         if (output.success == 1) {
         jQuery(output.form_id + ' #reg_autobid_cancel_btn').hide();
         jQuery(output.form_id + ' #reg_autobid_accept_btn').show();
         }
         */
        if (output.property_id) {
            jQuery('#abs_loading_' + output.property_id).hide();
        }
        if (output.msg) {
            jQuery('#autobid_msg_' + output.property_id).html(output.msg);
            jQuery('#autobid_msg_' + output.property_id).show();
        }
        if (output.success == 1) {
            jQuery('#reg_autobid_cancel_btn_' + output.property_id).hide();
            jQuery('#reg_autobid_accept_btn_' + output.property_id).show();
        }
    },
    regAutoBid: function (form_id, property_id, popup_id) {
        self['property_cls_' + property_id] = this;
        var url = '/modules/property/action.php?action=auto_bid';
        jQuery('#autobid_msg_' + property_id).hide();
        var is_autobid = jQuery(form_id + ' #is_autobid').val();
        if (is_autobid == 1) {//is auto bid, goto REFUSE
            jQuery('#abs_loading_' + property_id).show();
            $.post(url, {
                property_id: property_id,
                accept: 0,
                form_id: form_id
            }, this.onRegAutoBid, 'html');
        } else {//is not auto bid, goto ACCEPT
            var validation = new Validation(form_id);
            if (validation.isValid()) {
                var agent_auction_step = jQuery(form_id + ' #agent_auction_step').val();
                var agent_maximum_bid = jQuery(form_id + ' #agent_maximum_bid').val();
                jQuery('#abs_loading_' + property_id).show();
                $.post(url, {
                    property_id: property_id,
                    agent_auction_step: agent_auction_step,
                    agent_maximum_bid: agent_maximum_bid,
                    accept: 1,
                    form_id: form_id
                }, this.onRegAutoBid, 'html');
                return true;
            }
        }
    },
    onRegAutoBid: function (data) {
        var output = jQuery.parseJSON(data);
        if (output.property_id) {
            jQuery('#abs_loading_' + output.property_id).hide();
        }
        if (output.msg) {
            jQuery('#autobid_msg_' + output.property_id).html(output.msg);
            jQuery('#autobid_msg_' + output.property_id).show();
        }
        if (output.success == 1) {
            if (typeof output.accept != 'undefined') {
                jQuery(output.form_id + ' #is_autobid').val(parseInt(output.accept));
            }
            if (output.label) {
                jQuery('#reg_autobid_btn_' + output.property_id).html(output.label);
            }
        }
        //BEGIN CALL CALLBACK FUNCTION
        /*
         var property_id = output.property_id;
         if (self['property_cls_'+property_id] && self['property_cls_'+property_id].callback_func['reg_auto_bid_before'] && self['property_cls_'+property_id].callback_func['reg_auto_bid_before'].length > 0) {
         for (i = 0; i < self['property_cls_'+property_id].callback_func['reg_auto_bid_before'].length; i++) {
         self['property_cls_'+property_id].callback_func['reg_auto_bid_before'][i](output);
         }
         }
         */
        //END
    },
    listenerAutoBid: function (form_id, property_id, bid_obj) {
        if (jQuery(form_id + ' #is_autobid').val() == 1) {
            bid_obj.bid(property_id);
        }
    },
    listenerStopAutoBid: function (form_id, property_id, bid_obj) {
        if (typeof bid_obj.autobid != 'undefined' && parseInt(bid_obj.autobid) == 0) {
            jQuery('#is_autobid').val(0);
            jQuery('#autobid_msg').html(bid_obj.msg);
            jQuery('#reg_autobid_btn').html('Accept');
            jQuery('#autobid_' + property_id).show();
        }
    },
    changeValue: function (obj, default_value) {
        if (jQuery(obj).val() == 0) {
            jQuery(obj).val(default_value);
        }
    },
    //BEGIN SEND FRIEND
    popupSendFriend: function (url, property_url, obj) {
        var id = 'delay_send_friend';
        this.delay_send_friend = id;
        if (document.getElementById(id) == null) {
            var div = document.createElement('div');
            div.id = id;
            div.className = 'popup-sendfriend';
            document.body.appendChild(div);
        } else {
            div = document.getElementById(id);
        }
        div.innerHTML = '<input type="button" value="x" id="btnprox" onclick="Property.delPopupSendFriend(\'' + id + '\')"/><label>Email:</label><input type="text" name="email" id="email"/><input type="button" value="Send" onclick="Property.sendFriend(\'' + url + '\',\'' + property_url + '\',\'' + id + '\')"/>';
        gosPopup.show('#' + id);
        var pos = jQuery(obj).position();
        div.style.left = pos.left + 'px';
        div.style.top = pos.top + 'px';
    },
    delPopupSendFriend: function (id) {
        gosPopup.hide('#' + id);
        document.body.removeChild(document.getElementById(id));
    },
    sendFriend: function (url, property_url, id) {
        var email = jQuery('#' + id + ' input[name=email]').val();
        if (jQuery.trim(email).length > 0) {
            $.post(url, {property_url: property_url, email: email}, Property.onSendFriend, 'html');
            return true;
        }
        showMess('Please input email.');
    },
    onSendFriend: function (data) {
        var result = jQuery.parseJSON(data);
        if (result.success) {
            Property.delPopupSendFriend(Property.delay_send_friend);
            //alert(result.success);
        } else {
            //alert(result.error);
        }
    },
    //BEGIN DOCUMENT
    downDoc: function (url) {
        document.location = url;
        //$.post(url,{},Property.onDownDoc,'html');
    },
    onDownDoc: function (data) {
    },
    //BEGIN STATUS
    status: function (property_id, target) {
        var url = '/modules/property/action.php?action=status-property';
        $.post(url, {property_id: property_id, target: target}, this.onStatus, 'html');
        showLoadingPopup();
    },
    onStatus: function (data) {
        closeLoadingPopup();
        var json = jQuery.parseJSON(data);
        if (json.target.length > 0) {
            jQuery('#' + json.target).html(json.msg);
        }
    },
    //Begin Rent Now Enable
    rentNowActive: function (property_id, target) {
        var url = '/modules/property/action.php?action=rentnow-status-property';
        $.post(url, {property_id: property_id, target: target}, this.onrentNowActive, 'html');
        showLoadingPopup();
    },
    onrentNowActive: function (data) {
        closeLoadingPopup();
        var json = jQuery.parseJSON(data);
        if (json.target.length > 0) {
            jQuery('#' + json.target).html(json.msg);
        }
    },
    setLogo: function (property_id, target) {
        var url = '/modules/property/action.php?action=logo-property';
        $.post(url, {property_id: property_id, target: target}, this.onStatus, 'html');
    },
    setFocusHome: function (property_id, target, mode) {
        var url = '/modules/property/action.php?action=set-' + target;
        var param = new Object();
        param.property_id = property_id;
        param.target = target;
        param.mode = mode;
        $.post(url, param, this.onSetFocusHome, 'html');
    },
    onSetFocusHome: function (data) {
        var json = jQuery.parseJSON(data);
        if (json.success) {
            if (json.mode == 'change') {
            }
            else {
                jQuery('#hid_payment_money').val(json.price);
                listenerPanel();
            }
        } else if (json.error) {
            showMess('Error!');
        }
    },
    /*
     setFocus: function(property_id,target) {
     var focus=parseInt(jQuery('#set_focus').val());
     var home=parseInt(jQuery('#set_home').val());
     if(focus==0)
     {
     jQuery('#set_focus').val(1);
     jQuery('#payment_step8').show();
     if(home==0)
     {
     }
     else{

     }
     }
     else{
     jQuery('#set_focus').val(0);
     if(home==0)
     {
     jQuery('#payment_step8').hide();
     }
     else{
     }
     }
     },

     onSetFocus: function(data) {
     var data = jQuery.parseJSON(data);
     if (data.success > 0) {
     if (data.value > 0) {
     jQuery('#set_focus').val(1);
     if(data.set_jump == 0){
     jQuery('#payment_step8').show();
     }

     } else {
     jQuery('#set_focus').val(0);
     if(data.set_jump == 0){
     jQuery('#payment_step8').hide();

     }

     }
     //jQuery('#' + target + '_loading').html();
     }
     },

     setHomepage: function(property_id,target) {
     var focus=parseInt(jQuery('#set_focus').val());
     var home=parseInt(jQuery('#set_home').val());
     if(home==0)
     {
     jQuery('#set_home').val(1);
     jQuery('#payment_step8').show();
     }
     else{
     jQuery('#set_home').val(0);
     if(focus==0)
     {
     jQuery('#payment_step8').hide();
     }
     else{

     }
     }
     },

     onSetHomepage: function(data) {
     var data = jQuery.parseJSON(data);
     if (data.success > 0) {
     if (data.value > 0) {
     jQuery('#set_home').val(1);
     if(data.focus == 0){
     jQuery('#payment_step8').show();
     }

     } else {
     jQuery('#set_home').val(0);
     if(data.focus == 0){
     jQuery('#payment_step8').hide();
     }
     }
     //jQuery('#' + target + '_loading').html();
     }
     },
     */
    //Begin confirm sold a property
    confirm_sold: function (property_id, target) {
        //show pop up confirm
        //Post serve
        url = '/modules/property/action.php?action=sold-property';
        $.post(url, {property_id: property_id, target: target}, this.on_sold, 'html');
        showLoadingPopup();
    },
    on_sold: function (data) {
        closeLoadingPopup();
        var json = jQuery.parseJSON(data);
        if (json.target.length > 0) {
            jQuery('#' + json.target).html(json.msg);
        }
    }
}
var ImageShow = function (container, total, proid, child) {
    this.container = container;
    this.total = total;
    this.id = proid;
    if (this.total > 0) {
        this.current = 1;
    } else {
        this.current = 0;
    }
    if (typeof child == 'string') {
        this.child = child;
    } else {
        this.child = 'img';
    }
}
ImageShow.prototype = {
    prev: function () {
        if (this.current > 1) {
            this.current--;
            jQuery('#' + this.container + ' div img').each(function () {
                var id = jQuery(this).attr('id');
                if (!/(^img_mark_)/.test(id)) {
                    jQuery(this).hide();
                }
            });
            jQuery('#' + this.container + ' div #' + this.child + '_' + this.current).show();
            //jQuery('#'+this.container+' div #img_mark_payment_'+this.id).show();
            jQuery('#' + this.container + ' div.toolbar-img span.img-num').text(this.current + '/' + this.total);
            this.showMark();
        }
    },
    next: function () {
        if (this.current < this.total) {
            this.current++;
            jQuery('#' + this.container + ' div img').each(function () {
                var id = jQuery(this).attr('id');
                if (!/(^img_mark_)/.test(id)) {
                    jQuery(this).hide();
                }
            });
            jQuery('#' + this.container + ' div #' + this.child + '_' + this.current).show();
            //jQuery('#'+this.container+' div #'+this.child+'_'+this.current).css('display','block');
            jQuery('#' + this.container + ' div.toolbar-img span.img-num').text(this.current + '/' + this.total);
            this.showMark();
            //alert('#'+this.container+' div #'+this.child+'_'+this.current);
        }
    },
    focus: function (i) {
        if (i > 0 && i <= this.total) {
            this.current = i;
            jQuery('#' + this.container + ' div img').each(function () {
                var id = jQuery(this).attr('id');
                if (!/(^img_mark_)/.test(id) && !/(^img_ebidda_mark_)/.test(id)) {
                    jQuery(this).hide();
                }
            });
            jQuery('#' + this.container + ' div #' + this.child + '_' + this.current).show();
            jQuery('#' + this.container + ' div.toolbar-img span.img-num').text(this.current + '/' + this.total);
            this.showMark();
        }
    },
    showMark: function () {
        /*if (jQuery('#img_mark_' + this.id).attr('src') != null && jQuery('#img_mark_' + this.id).attr('src').length > 0) {
         jQuery('#img_mark_' + this.id).show();
         }else{
         jQuery('#img_mark_' + this.id).hide();
         }*/
    },
    showMarkPM: function (pay_status) {
        if (pay_status != 'complete') {
            jQuery('#img_mark_payment_' + this.id).show();
        } else {
            jQuery('#img_mark_payment_' + this.id).hide();
        }
    }
};
//BEGIN BIDHISTORY
var bh_popup = new Popup();
var bidhistory = new BidHistory();
bidhistory.prepare = function () {
};
bidhistory.finish = function (data) {
    try {
        closeLoadingPopup();
        var info = jQuery.parseJSON(data);
        //var info = data;
        jQuery('#bh_container').html(info);
        bh_popup.show().toCenter();
    } catch (e) {
        console.log(e.message);
    }
};
function showBidHistory(property_id, view, mode) {
    if (mode == null) {
        bh_popup.removeChild();
        bh_popup.init({id: 'pro_popup', className: 'popup_overlay'});
        bh_popup.updateContainer('<div class="popup_container" style="width:600px;"><div id="contact-wrapper" class="contact-wrapper-bh">\
					 <div class="title"><h2> Auction / Bid history <span id="btnclosex" onclick="bh_popup.hide()">x</span></h2></div>\
					 <div class="content" style="width:98%;max-height:400px" id="bh_container">\
					 </div></div></div>');
        Cufon.replace('h2');
        if (view != null)
            bidhistory.send('/modules/general/action.php?action=bid_history&property_id=' + property_id + '&view=' + view);
        else {
            bidhistory.send('/modules/general/action.php?action=bid_history&property_id=' + property_id);
        }
    }
    else {
        if (mode == 'winner-info') {
            bh_popup.removeChild();
            bh_popup.init({id: 'winner_popup', className: 'popup_overlay'});
            bh_popup.updateContainer('<div class="popup_container" style="width:480px;"><div id="contact-wrapper" class="contact-wrapper-bh">\
					 <div class="title"><h2> Winner Information <span id="btnclosex" onclick="bh_popup.hide()">x</span></h2></div>\
					 <div class="content" style="width:98%;max-height:700px" id="bh_container">\
					 </div></div></div>');
            bidhistory.send('/modules/general/action.php?action=winner_info&property_id=' + property_id);
        }
    }
}
function pagingBid(url) {
    jQuery.post(url, {}, function (data) {
            var result = jQuery.parseJSON(data);
            if (result) {
                jQuery('#bh_container').html(result);
            }
        }, 'html'
    );
}
//END BIDHISTORY
// BEGIN REGISTER TO BID
function showRegisterBid(property_id, action, title) {
    {
        try {
            //loading_popup.show().toCenter();
            showLoadingPopup();
            bh_popup.removeChild();
            bh_popup.init({id: 'pro_popup', className: 'popup_overlay'});
            bh_popup.updateContainer('<div class="popup_container" style="width:600px;"><div id="contact-wrapper" class="contact-wrapper-bh">\
                         <div class="title"><h2> ' + title + ' <span id="btnclosex" onclick="bh_popup.hide()">x</span></h2></div>\
                         <div class="content" style="width:98%;" id="bh_container">\
                         </div></div></div>');
            Cufon.replace('h2');
            bidhistory.send('/modules/general/action.php?action=' + action + '&property_id=' + property_id);
        } catch (e) {
        }
    }
}
// END
//BEGIN SENDFRIEND
var sendfriend = new SendFriend();
var sendfriend_popup = new Popup();
//BEGIN SENDFRIEND
sendfriend_data = ['property_id', 'email_from', 'email_to', 'message'];
sendfriend.prepare = function () {
    jQuery('#sendfriend_loading').show();
};
sendfriend.finish = function (data) {
    jQuery('#sendfriend_loading').hide();
    sendfriend.clear('#frmSendfriend', ['email_to', 'message']);//clear data from SendFriend form
    jQuery(sendfriend_popup.container).fadeOut('slow', function () {
        sendfriend_popup.hide()
    });
};
//END
sendfriend_popup.init({id: 'send_popup', className: 'popup_overlay'});
sendfriend_popup.updateContainer('<div class="popup_container sendfriend-container" style="width:400px"><div id="contact-wrapper">\
			<div class="title"><h2> SEND TO A FRIEND</h2><span id="btnclosex" onclick="closeSendfriend()">Close X</span></div>\
			<div class="content" style="width:94%">\
				<form name="frmSendfriend" id="frmSendfriend">\
				<input type="hidden" name="property_id" id="property_id" value=""/>\
				<div class="input-box">\
				  <label for="subject"><strong id="notify_email_from">Email from <span >*</span></strong></label><br/>\
				  <input type="text" name="email_from" id="email_from" value="" class="input-text validate-require validate-email" style="width:98%"/>\
				</div>\
				<div class="input-box">\
				  <label for="subject"><strong id="notify_email_to">Email to <span >*</span></strong></label><br/>\
				  <input type="text" name="email_to" id="email_to" value="" class="input-text validate-require validate-email" style="width:98%"/>\
				</div>\
				<div class="input-box">\
					<label for="subject"><strong id="notify_message">Message <span >*</span></strong></label><br/>\
					<textarea rows="5" cols="30" name="message" id="message" class="input-text validate-require" style="width:98%;"></textarea></div></form><button class="btn-submit" name="submit" onClick="sendfriend.send(\'#frmSendfriend\',\'/modules/property/action.php?action=share-sendfriend\',sendfriend_data)"><span><span>SEND</span></span></button><div id="sendfriend_loading" style="display:inline;position:absolute"><img src="/modules/general/templates/images/loading.gif" alt="" style="height:30px;"/></div></div></div></div></div>');
function showSendfriend(property_id, email) {
    sendfriend_popup.show().toCenter();
    jQuery('#sendfriend_loading').hide();
    jQuery('#frmSendfriend [name=property_id]').val(property_id);
    jQuery('#frmSendfriend [name=email_from]').val(email);
}
function closeSendfriend() {
    jQuery('#sendfriend_loading').hide();
    sendfriend.clear('#frmSendfriend', ['email_to', 'message']);
    jQuery(sendfriend_popup.container).fadeOut('slow', function () {
        sendfriend_popup.hide()
    });
}
//END SENDFRIEND
//BEGIN CONTACT VENDOR
var contact = new Contact();
var contact_popup = new Popup();
//BEGIN CONTACT
var contact_data = ['agent_id_to', 'email_to', 'agent_id_from', 'contactname', 'subject', 'email', 'telephone', 'message'];
contact.prepare = function () {
    jQuery('#contact_loading').show();
};
contact.finish = function (data) {
    var info = jQuery.parseJSON(data);
    if (info.success) {
    } else {
    }
    jQuery('#contact_loading').hide();
    contact.clear('#frmContact', ['message']);//clear data from Contact form
    jQuery(contact_popup.container).fadeOut('slow', function () {
        contact_popup.hide()
    });
}
//END
contact_popup.init({id: 'contact_popup', className: 'popup_overlay'});
contact_popup.updateContainer('<div class="popup_container" style="width:450px"><div id="contact-wrapper">\
			 <div class="title"><h2> Contact Information <span id="btnclosex" class="btn-x" onclick="closeContact()">Close X</span></h2> </div>\
			 <div class="content" style="width:94%">\
				<form name="frmContact" id="frmContact">\
				<input type="hidden" name="agent_id_to" id="agent_id_to" value=""/>\
				<input type="hidden" name="email_to" id="email_to" value=""/><input type="hidden" name="property_id" id="property_id" value=""/>\
				<input type="hidden" name="agent_id_from" id="agent_id_from" value=""/>\
				<div class="input-box">\
					<label for="subject"><strong>Name <span id="notify_contactname">*</span></strong></label><br/>\
					<input type="text" name="contactname" id="contactname" value="" class="input-text validate-require" style="width:100%"/>\
				</div>\
				<div class="input-box">\
					<label for="subject"><strong>Subject <span id="notify_subject">*</span></strong></label><br/>\
					<input type="text" name="subject" id="subject" value="" class="input-text validate-require" style="width:100%"/>\
				</div>	\
				<div class="input-box">\
					<label for="subject"><strong>Email <span id="notify_email">*</span></strong></label><br/>\
					<input type="text" name="email" id="email" value="" class="input-text validate-email" style="width:100%"/>\
				</div>\
				<div class="input-box">\
					<label><strong>Telephone </strong></label><br/>\
					<input type="text" name="telephone" id="telephone" value="" class="input-text" style="width:100%"/>\
				</div>\
				<div class="input-box">\
					<label for="subject"><strong>Message <span id="notify_message">*</span></strong></label><br/>\
					<textarea rows="5" cols="30" name="message" id="message" class="input-text validate-require" style="width:100%;"></textarea></div></form><div><button class="btn-blue" name="submit" onClick="contact.send(\'#frmContact\',\'/modules/property/action.php?action=contact\',contact_data)"><span><span>Submit</span></span></button><div id="contact_loading" style="display:inline;position:absolute"><img src="/modules/general/templates/images/loading.gif" style="height:30px;" alt="" /></div></div></div></div>');
function showContact(agent_id_from, contactname, email, telephone, agent_id_to, email_to, property_id) {
    contact_popup.show().toCenter();
    jQuery('#contact_loading').hide();
    jQuery('#frmContact [name=agent_id_from]').val(agent_id_from);
    jQuery('#frmContact [name=contactname]').val(contactname);
    jQuery('#frmContact [name=email]').val(email);
    jQuery('#frmContact [name=telephone]').val(telephone);
    jQuery('#frmContact [name=agent_id_to]').val(agent_id_to);
    jQuery('#frmContact [name=email_to]').val(email_to);
    if (property_id != null)
        jQuery('#frmContact [name=property_id]').val(property_id);
}
function closeContact() {
    jQuery('#contact_loading').hide();
    contact.clear('#frmContact', ['message']);
    jQuery(contact_popup.container).fadeOut('slow', function () {
        contact_popup.hide()
    });
}
//END CONTACT VENDOR
//VIEW MORE
var Loading = function () {
}
Loading.prototype = {
    'show': function (div) {
        jQuery(div).css('position', 'relative');
        jQuery(div).append('<div class="contain-loading"><div class="small-loading"></div></div>');
        jQuery(div + ' .contain-loading').css({
            'z-index': '1000',
            'position': 'absolute',
            'background': 'white',
            'top': '0px',
            'left': '0px',
            'opacity': '0.6',
            'width': jQuery(div).width(),
            'height': jQuery(div).height()
        });
        jQuery(div + ' .contain-loading .small-loading').css({
            'top': (jQuery(div).innerHeight() - jQuery('.small-loading').height()) / 2,
            'left': (jQuery(div).innerWidth() - jQuery('.small-loading').width()) / 2
        });
    },
    'hide': function (div) {
        jQuery(div).find('.contain-loading').remove();
    }
}
var PropertyViewMore = function () {
    this.prepare = null;
    this.finish = null;
    this.type_send = 'html';
}
PropertyViewMore.prototype = {
    send: function (url) {
        if (this.prepare != null) {
            this.prepare();
        }
        if (this.finish != null) {
            jQuery.post(url, {}, this.finish, this.type_send);
        } else {
            jQuery.post(url, {}, this.onSend, this.type_send);
        }
    }
    , onSend: function (data) {
        var info = jQuery.parseJSON(data);
        if (info.data) {
            jQuery('#pvm-right').html(info.data);
        } else {
            alert('failure');
        }
    }
}
var pvm = new PropertyViewMore();
var pvm_popup = new Popup();
var loading = new Loading();
pvm.prepare = function () {
    //jQuery('#viewmore_loading').show();
    loading.show('#pvm-right');
};
pvm.finish = function (data) {
    var info = jQuery.parseJSON(data);
    if (info.data) {
        jQuery('#pvm-right').html(info.data);
    } else {
        alert('failure');
    }
    //jQuery('#viewmore_loading').hide();
    loading.hide('#pvm-right');
};
//END
function showPVM(property_id) {
    pvm_popup.show().toCenter();
//		jQuery('#pvm_loading').hide();
//
//		jQuery('#frmPVM [name=property_id]').val(property_id);
//		jQuery('#frmPVM [name=email_from]').val(email);
}
function closePVM(property_id) {
    jQuery('#pvm_loading').hide();
    //pvm.clear('#frmPVM',['email_to','message']);
    jQuery(pvm_popup.container).fadeOut('slow', function () {
        pvm_popup.hide()
    });
}
//END VIEW MORE LAN
// *****HISTORY PROPERTY
var PropertyHistory = function () {
    this.prepare = null;
    this.finish = null;
    this.type_send = 'html';
}
PropertyHistory.prototype = {
    send: function (url) {
        if (this.prepare != null) {
            this.prepare();
        }
        if (this.finish != null) {
            jQuery.post(url, {}, this.finish, this.type_send);
        } else {
            jQuery.post(url, {}, this.onSend, this.type_send);
        }
    }
    , onSend: function (data) {
        var info = jQuery.parseJSON(data);
        if (info.data) {
            jQuery('#pro-his-right').html(info.data);
        } else {
            alert('failure');
        }
    },
    prepare: function () {
        jQuery('#viewmore_loading').show();
    },
    finish: function (data) {
        var info = jQuery.parseJSON(data);
        if (info.data) {
            jQuery('#pro-his-right').html(info.data);
        } else {
            alert('failure');
        }
        jQuery('#viewmore_loading').hide();
    }
}
var pro_his = null;
var pro_his_popup = null;
function show_history(property_id) {
    pro_his = new PropertyHistory();
    pro_his_popup = new Popup();
    pro_his_popup.init({id: 'pro_his_popup', className: 'popup_overlay'});
    pro_his_popup.updateContainer('<div id="fix_pro_his" class="popup_container popup-vm-container">' + jQuery('#pvm-container-tmp-his').html() + '</div>');
    pro_his_popup.show().toCenter();
    //jQuery('#fix_pro_his').removeClass();
    // Ajax
    pro_his.send('/modules/property/action.php?action=property_history&property_id=' + property_id);
}
function close_history(property_id) {
    jQuery('#pvm_loading').hide();
    jQuery(pro_his_popup.container).fadeOut('slow', function () {
        pro_his_popup.hide()
    });
}
//****END PROPERTY_HISTORY
//begin sold check
var sold = 0;
function check_sold(data) {
    var new_result = jQuery.parseJSON(data);
    sold = new_result.Sold;
}
//End
//BEGIN MESSAGE confirm
var confirm_delete_popup = null;
var new_url = null;
var property_id_Tr = null;
confirm_delete_popup = new Popup();
confirm_delete_popup.init({id: 'confirm_delete_popup', className: 'popup_overlay'});
function show_confirm(url, msg, id, reg, type) {
    if (url == '') {
    }
    else {
        new_url = url;
        property_id_Tr = id;
        confirm_delete_popup.updateContainer('<div class="popup_container" style="width:356px;height: 122px;min-height: 100px;"><div id="contact-wrapper">\
			 <div class="title"><h2> This page says:<span id="btnclosex" class="btn-x" onclick="close_confirm(\'' + reg + '\',' + type + ')">Close X</span></h2> </div>\
			 <div class="clearthis" style="clear:both;"></div>\
			 <div align="center" style="margin-bottom: 20px; margin-top: 20px;" class="content content-po" id="msg"> ' + msg + '</div>\
			 <div align="center" class="button" style="margin: 5px 25px 0px 30px;"><button class="btn-red" style="margin-right: 25px;" onclick="confirm2()"><span><span>OK</span></span></button>\
             <button style="width:84px;*width:74px;" class="btn-red" onclick="close_confirm(\'' + reg + '\',' + type + ')"><span><span>CANCEL</span></span></button></div>\
			  </div></div></div>');
        confirm_delete_popup.show().toCenter();
        //jQuery('#msg').html(msg);
    }
}
function confirm2() {
    if (typeof new_url == 'object') {
        new_url.click();
        close_confirm();
        confirm_delete_popup.hide();
    } else {
        confirm_delete_popup.hide();
        showLoadingPopup();
        document.location = new_url;
    }
}
function close_confirm(reg, type) {
    if (reg != null && reg == 'step2') {
        if (type != 10) {
            var text = 'Auction';
            jQuery('#blog').html('Auction Blog');
            jQuery('#package_content').html(package_tpl);
            clickPackage(jQuery('input[name=_package]').val());
        } else {
            var text = 'Private Sale';
            jQuery('#blog').html('Property Blog');
            jQuery('#package_content').html('');
            clickPackage(1);
        }
        jQuery('#auction_sale').val(type);
        jQuery('#uniform-auction_sale span').html(text);
        jQuery(confirm_delete_popup.container).fadeOut('slow', function () {
            confirm_delete_popup.hide()
        });
    }
    else {
        jQuery(confirm_delete_popup.container).fadeOut('slow', function () {
            confirm_delete_popup.hide()
        });
        jQuery('#option_id_' + property_id_Tr).val('');
        jQuery('#uniform-option_id_' + property_id_Tr + ' span').html('Select');
    }
}
//END MESSAGE confirm
//BEGIN MESSAGE STOP BIDDING
var stop_bidding_popup = null;
var stop_bidding_url = null;
var act = null;
function show_confirm_stop_bidding(id, url, action) {
    if (action != 'edit') {
        showLoadingPopup();
    }
    ;
    if (id > 0 && url != '') {
        stop_bidding_url = url;
        act = action;
        var url = '/modules/property/action.php?action=check_property';
        $.post(url, {property_id: id}, On_stop_bidding, 'html');
    }
    else {
        showMess(' Error ! ');
    }
}
function On_stop_bidding(data) {
    closeLoadingPopup();
    var jdata = jQuery.parseJSON(data);
    if (jdata.success) {
        if (jdata.confirm_sold == 1) {
            showMess(' This property had been sold! ');
        }
        else {
            if (jdata.stop_bid == 1) {
                showMess(' This property had been stopped bidding!');
            }
            else {
                if (act == 'edit') {
                    document.location = stop_bidding_url;
                }
                else {
                    stop_bidding_popup = new Popup();
                    stop_bidding_popup.init({id: 'stop_bidding_popup', className: 'popup_overlay'});
                    stop_bidding_popup.updateContainer('<div class="popup_container" style="width:356px;height: 122px;min-height: 100px;"><div id="contact-wrapper">\
										<div class="title"><h2 id="txtt"> This page says:<span id="btnclosex" onclick="close_confirm_stop_bidding()">X</span></h2> </div>\
										<div class="clearthis" style="clear:both;"></div>\
										<div align="center" style="margin-bottom: 20px; margin-top: 20px;" class="content content-po" id="msg"> Do you really want to cancel bidding ?</div>\
										<div align="center" class="button" style="margin: 5px 25px 0px 30px;"><button class="btn-red" style="margin-right: 25px;" onclick="confirm_stop_bidding()"><span><span>OK</span></span></button>\
										<button style="width:84px;*width:74px;" class="btn-red" onclick="close_confirm_stop_bidding()"><span><span>CANCEL</span></span></button></div>\
										</div></div></div>');
                    stop_bidding_popup.show().toCenter();
                }
            }
        }
    }
}
function confirm_stop_bidding() {
    document.location = stop_bidding_url;
}
function close_confirm_stop_bidding() {
    jQuery(stop_bidding_popup.container).fadeOut('slow', function () {
        stop_bidding_popup.hide()
    });
}
//END MESSAGE STOP BIDDING
//Begin confirm sold a property
var sold = null;
var new_id, new_targetid;
var ddl_changeType = 'option_id';
function confirm_sold_mess(property_id, target_id, msg, ddl) {
    if (ddl != '') {
        ddl_changeType = ddl;
    }
    if (jQuery('#' + target_id).html() == 'Sold') {
        showMess(' This property had been sold !');
    }
    else {
        new_id = property_id;
        new_targetid = target_id;
        sold = new Popup();
        sold.init({id: 'sold_popup', className: 'popup_overlay'});
        sold.updateContainer('<div class="popup_container" style="width:356px;height: 122px;min-height: 100px;"><div id="contact-wrapper">\
            <div class="title"><h2 id="txtt"> This page says:<span id="btnclosex" onclick="close_confirm_sold()">X</span></h2> </div>\
            <div class="clearthis" style="clear:both;"></div>\
            <div align="center" style="margin-bottom: 20px; margin-top: 20px;" class="content content-po" id="msg"> ' + msg + '</div>\
            <div align="center" class="button" style="margin: 5px 25px 0px 30px;"><button class="btn-red" style="margin-right: 25px;" onclick="confirm_sold()"><span><span>OK</span></span></button>\
            <button style="width:84px;*width:74px;" class="btn-red" onclick="close_confirm_sold()"><span><span>CANCEL</span></span></button></div>\
            </div></div></div>');
        sold.show().toCenter();
    }
}
function confirm_sold() {
    sold.hide();
    showLoadingPopup();
    var sold_url = '/modules/property/action.php?action=sold-property';
    $.post(sold_url, {property_id: new_id, target: new_targetid}, on_confirm_sold, 'html');
}
function on_confirm_sold(data) {
    closeLoadingPopup();
    showMess(' This property had been sold');
    var json = jQuery.parseJSON(data);
    var ddl_changeType = 'option_id';
    if (json.target.length > 0) {
        jQuery('#' + json.target).html(json.msg);
    }
    //jQuery(sold.container).fadeOut('slow',function(){sold.hide()});
    //change stt sold, dropdownlist change Type hide
    jQuery('#uniform-' + ddl_changeType).css('display', 'none');
}
function close_confirm_sold() {
    jQuery(sold.container).fadeOut('slow', function () {
        sold.hide()
    });
}
//END
// BEGIN BUY NOW
var buynow_popup = null;
function show_buynow_popup(property_id, buynow_price) {
    var msg = 'Please confirm you would like to BUY or RENT this property now for ' + buynow_price;
    buynow_popup = new Popup();
    buynow_popup.init({id: 'buynow_popup', className: 'popup_overlay'});
    buynow_popup.updateContainer('<div class="popup_container" style="width:356px;height: 122px;min-height: 100px;"><div id="contact-wrapper">\
                <div class="title"><h2 id="txtt"> Buy It Now<span id="btnclosex" onclick="close_confirm_buynow()">X</span></h2> </div>\
                <div class="clearthis" style="clear:both;"></div>\
                <div align="center" style="margin-bottom: 10px; margin-top: 20px;" class="content content-po" id="msg"> ' + msg + '</div>\
                <div align="center" class="button" style="margin: 5px 25px 0px 30px;"><button class="btn-red" style="margin-right: 25px;" \
                onclick="show_buynow_popup_confirm(' + property_id + ',\'' + buynow_price + '\')"><span><span>OK</span></span></button>\
                <button style="width:95px" class="btn-red-fix" onclick="close_confirm_buynow()">\
                <span><span>CANCEL</span></span></button></div>\
                </div></div></div>');
    buynow_popup.show().toCenter();
}
function show_buynow_popup_confirm(property_id, buynow_price) {
    var msg = 'You are committing to BUY or RENT property at ' + buynow_price + ', click yes to submit offer, no to cancel';
    //buynow_popup.hide();
    //buynow_popup = new Popup();
    //buynow_popup.init({id:'buynow_popup',className:'popup_overlay'});
    buynow_popup.updateContainer('<div class="popup_container" style="width:356px;height: 122px;min-height: 100px;"><div id="contact-wrapper">\
                    <div class="title"><h2 id="txtt"> Buy It Now<span id="btnclosex" onclick="close_confirm_buynow()">X</span></h2> </div>\
                    <div class="clearthis" style="clear:both;"></div>\
                    <div align="center" style="margin-bottom: 10px; margin-top: 20px;" class="content content-po" id="msg"> ' + msg + '</div>\
                    <div align="center" class="button" style="margin: 5px 25px 0px 30px;"><button class="btn-red" style="margin-right: 25px;" \
                    onclick="confirm_buynow(' + property_id + ')"><span><span>YES</span></span></button>\
                    <button style="width:95px" class="btn-red-fix" onclick="close_confirm_buynow()">\
                    <span><span>CANCEL</span></span></button></div>\
                    </div></div></div>');
    //buynow_popup.show().toCenter();
}
function confirm_buynow(property_id) {
    buynow_popup.hide();
    showLoadingPopup();
    var url = '/modules/property/action.php?action=buynow-property';
    $.post(url, {property_id: property_id}, on_confirm_buynow, 'html');
}
function on_confirm_buynow(data) {
    var result = jQuery.parseJSON(data);
    if (result.success) {
        if (result.error) {
            closeLoadingPopup();
            showMess(result.message, '', false);
        } else {
            /*BEGIN PAYMENT FOR BUY NOW*/
            if (!result.hasLoggedIn) {
                closeLoadingPopup();
                showLoginPopup();
            } else {
                if (typeof result.payment_url != 'undefined' && result.payment_url != '') {
                    document.location = result.payment_url;
                } else {
                    /*SUCCESS*/
                    closeLoadingPopup();
                    showMess(result.message, '', false);
                    var buynow_obj = jQuery('#buynow-' + result.property_id);
                    if (buynow_obj.length > 0) {
                        //buynow_obj.remove();
                        buynow_obj.addClass('btn-status-disabled').attr('disabled', 'disabled');
                        ;
                    }
                }
            }
        }
    }
}
function close_confirm_buynow() {
    jQuery(buynow_popup.container).fadeOut('slow', function () {
        buynow_popup.hide()
    });
}
// END
//BEGIN MESSAGE LAN
var mess_popup = new Popup();
var frmurl = ''; //nh add, use when click OK then redirect to a url.
mess_popup.init({id: 'mess_popup', className: 'popup_overlay'});
function showMess(error_to_from, url, show_ok_btn) {
    if (url != null) {
        frmurl = url;
    }
    var btn_str = '';
    var forgot = ROOTURL + '/?module=agent&action=forgot';
    show_ok_btn = typeof(show_ok_btn) != 'undefined' ? show_ok_btn : true;
    if (show_ok_btn == true) {
        btn_str = '<button class="btn-red btn-red-mess-po" onclick="closeMess();"><span><span>OK</span></span></button>';
    }
    //height: 122px;
    mess_popup.updateContainer('<div class="popup_container" style="width:356px;height:auto;min-height: 120px;z-index:1000">\
			 <div id="contact-wrapper"><div class="title"><h2>  This page says:<span id="btnclosex" class="btn-x" onclick="closeMess()">Close X</span></h2> </div>\
			 <div class="clearthis" style="clear:both;"></div>\
			  <div class="content content-po" id="msg">\
                <img src="/modules/property/templates/images/alert.png"/>\
                <span>' + error_to_from + '</span></div>\
			  ' + btn_str + '\
			  </div></div></div>');
    mess_popup.show().toCenter();
    //jQuery('#msg').html(error_to_from);
}
function closeMess() {
    jQuery(mess_popup.container).fadeOut('slow', function () {
        mess_popup.hide()
    });
    if (frmurl != '') {
        Common.redirect(frmurl);
    }
}
//END MESSAGE LAN
//BEGIN VIEW MORE ON TV-SHOW
function showPVM2(property_id) {
    if (document.getElementById('pvm_popup') == null) {
        pvm_popup.init({id: 'pvm_popup', className: 'popup_overlay'});
    }
    pvm_popup.removeChild();
    var tpl = jQuery('#pvm-container-tmp').html();
    tpl = tpl.replace(new RegExp(/\$property_id/g), property_id);
    pvm_popup.updateContainer('<div class="popup_container popup-container-vm popup-vm-container" style="width:750px;left:319.5px;">' + tpl + '</div>');
    pvm.send('/modules/property/action.php?action=vm_media_photos&property_id=' + property_id);
    pvm_popup.show().toCenter();
}
function closePVM2(property_id) {
    jQuery(pvm_popup.container).fadeOut('slow', function () {
        pvm_popup.hide()
    });
}
//END
/*
 function showPVM5(property_id) {
 if (document.getElementById('pvm_popup') == null) {
 pvm_popup.init({id:'pvm_popup',className:'popup_overlay'});
 }

 pvm_popup.removeChild();

 var tpl = jQuery('#pvm-container-tmp').html();
 tpl = tpl.replace(new RegExp(/\$property_id/g),property_id);

 pvm_popup.updateContainer('<div class="popup_container" style="width:750px;left:319.5px;">'+tpl+'</div>');
 pvm.send('/modules/property/action.php?action=vm_media&property_id='+property_id);
 pvm_popup.show().toCenter();
 }

 function closePVM5(property_id) {
 jQuery(pvm_popup.container).fadeOut('slow',function(){pvm_popup.hide()});
 }
 */

// BEGIN PACKAGE
var PropertyPackage = function () {
    this.prepare = null;
    this.finish = null;
    this.type_send = 'html';
}
PropertyPackage.prototype = {
    send: function (url) {
        if (this.prepare != null) {
            this.prepare();
        }
        if (this.finish != null) {
            jQuery.post(url, {}, this.finish, this.type_send);
        } else {
            jQuery.post(url, {}, this.onSend, this.type_send);
        }
    }
    , onSend: function (data) {
        var info = jQuery.parseJSON(data);
        if (info.data) {
            jQuery('#pvm-right').html(info.data);
        } else {
            alert('failure');
        }
    }
    , click: function (obj) {
        jQuery('#frmProperty > #package_id').val(jQuery(obj).val());
    }
}
var package = new PropertyPackage();
var package_popup = new Popup();
package.prepare = function () {
    jQuery('#package_loading').show();
};
package.finish = function (data) {
    var info = jQuery.parseJSON(data);
    if (info.data) {
        jQuery('#package_content').html(info.data);
    } else {
        showMess('Error');
    }
    jQuery('#package_loading').hide();
};
//END
function showPropertyPackage(property_id) {
    //package_popup.show().toCenter();
    package.send('/modules/property/action.php?action=get_package-property&property_id=' + property_id);
}
function closePropertyPackage() {
    jQuery('#package_content').html('');
    //jQuery(package_popup.container).fadeOut('slow',function(){package_popup.hide()});
}
// END
//BEGIN VIEW MORE FOR VIDEOS
var PropertyViewMoreVideos = function () {
    this.prepare = null;
    this.finish = null;
    this.type_send = 'html';
}
PropertyViewMoreVideos.prototype = {
    send: function (url) {
        if (this.prepare != null) {
            this.prepare();
        }
        if (this.finish != null) {
            jQuery.post(url, {}, this.finish, this.type_send);
        } else {
            jQuery.post(url, {}, this.onSend, this.type_send);
        }
    }
    , onSend: function (data) {
        var info = jQuery.parseJSON(data);
        if (info.data) {
            jQuery('#popup-videos-child').html(info.data);
        } else {
            alert('failure');
        }
    }
}
var pvmv = new PropertyViewMoreVideos();
var pvmv_popup = new Popup();
pvmv_popup.init({id: 'pvmv_popup_videos', className: 'popup_overlay_videos'});
function showPVMV(id) {
    pvmv_popup.removeChild();
    var str = jQuery('#' + id).html();
    //jQuery('#viewmore_loading_videos').show();
    //alert(str.replace(/width="250"/g,'width="350"').replace(/height="150"/g,'height="250"'));
    pvmv_popup.updateContainer('<div class="popup_container_videos"><div class="div-close-videos"><span id="btn-close-videos" onclick="closePVMV();"><img src="/modules/general/templates/images/close-video.png"/></span></div><div class="clearthis"></div><div class="popup_content_videos">' + str.replace(/width="100%"/g, 'width="100%"').replace(/height="100%"/g, 'height="100%"') + '</div></div>');
    pvmv_popup.show().toCenter();
}
function closePVMV(property_id) {
    jQuery(pvmv_popup.container).fadeOut('fast', function () {
        pvmv_popup.hide()
    });
    vopen();
}
//END
//BEGIN MAKE AN OFFER
var makeAnOfferGridBox = function () {
    this.prepare = null;
    this.finish = null;
    this.type_send = 'html';
}
makeAnOfferGridBox.prototype = {
    send: function (url) {
        if (this.prepare != null) {
            this.prepare();
        }
        if (this.finish != null) {
            jQuery.post(url, {}, this.finish, this.type_send);
        } else {
            jQuery.post(url, {}, this.onSend, this.type_send);
        }
    }
    , onSend: function (data) {
        var info = jQuery.parseJSON(data);
        if (info.data) {
        } else {
            alert('failure');
        }
    }
    , accept: function (message_id) {
        jQuery('#maogb_minibox_' + message_id).show();
    }
    , refuse: function (message_id, property_id) {
        offerPopup.hide();
        MAOGB_popup.show().toCenter();
        jQuery('#maogb_loading_' + message_id).show();
        this.send('/modules/property/action.php?action=make_an_offer-refuse&message_id=' + message_id + '&property_id=' + property_id);
    }
    , submit: function (message_id, property_id, agent_id, id_moneybox) {
        offerPopup.hide();
        MAOGB_popup.show().toCenter();
        jQuery('#maogb_loading_' + message_id).show();
        var validation = new Validation();
        if (validation['validate-price'](jQuery(id_moneybox))) {
            Common.warningObject(id_moneybox, true);
            var url = '/modules/property/action.php?action=make_an_offer-accept';
            var param = new Object();
            param.money = jQuery(id_moneybox).val();
            param.message_id = message_id;
            param.property_id = property_id;
            param.agent_id = agent_id;
            jQuery.post(url, param, this.onSubmit, this.type_send);
        } else {
            Common.warningObject(id_moneybox, false);
        }
        //jQuery('#maogb_loading_' + message_id).show();
        //this.send('/modules/property/action.php?action=make_an_offer-accept&message_id=' + message_id + '&property_id=' + property_id);
    }
    , onSubmit: function (data) {
        var info = jQuery.parseJSON(data);
        if (info.error) {
            closeMAOGB();
            showMess(info.error, '', false);
        } else if (info.data != null) {
            jQuery('#maogb_container').html(info.data);
        }
        else if (info.offer != null) { // Accept Offer
            jQuery('#auc-price-' + info.property_id).html('Last Bid: ' + info.price);
            jQuery('#bid-price-acc-' + info.property_id).html(info.top_price);
            if (info.isSold) {
                jQuery('#reset_options_' + info.property_id).hide();
            }
            closeMAOGB();
            if (info.num_offer == 0) {
                jQuery('#offer-message-' + info.property_id).hide();
            }
            else {
                jQuery('#offer-message-' + info.property_id).html(info.offer);
            }
        }
    }
    , cancel: function (message_id, property_id) {
        jQuery('#maogb_minibox_' + message_id).hide();
    }
}
var offerPopup = new Popup();
var MAOGridBox = new makeAnOfferGridBox();
MAOGridBox.prepare = function () {
};
MAOGridBox.finish = function (data) {
    var info = jQuery.parseJSON(data);
    if (info.data) {
        jQuery('#offer_loading_' + info.property_id).hide();
        if (info.offer_number > 0) {
            jQuery('#offer-message-' + info.property_id).html('Offer(' + info.offer_number + ')');
            jQuery('#maogb_container').html(info.data);
        }
        else {
            closeMAOGB();
            jQuery('#offer-message-' + info.property_id).hide();
        }
    } else {
    }
}
var MAOGB_popup = null;
function openMAOGB(property_id) {
    MAOGB_popup = new Popup();
    MAOGB_popup.init({id: 'maogb_popup', className: 'popup_overlay'});
    MAOGB_popup.updateContainer('<div class="popup_container" style="width:450px"><div id="contact-wrapper">\
									 <div class="title"><h2><span style="float:left;">Make An Offer Messages</span><span class="btn-x" onclick="closeMAOGB()">Close X</span></h2></div>\
									 <div id="offer_loading_' + property_id + '" style="display:inline;">\
                                     <img src="/modules/general/templates/images/loading.gif" style="height:30px;margin-left: 200px;" alt="" />\
                                     </div><div class="content" style="width:94%;" id="maogb_container"></div>');
    MAOGB_popup.show().toCenter();
    MAOGridBox.send('/modules/property/action.php?action=make_an_offer-list&property_id=' + property_id);
}
function closeMAOGB() {
    jQuery(MAOGB_popup.container).fadeOut('slow', function () {
        MAOGB_popup.hide()
    });
    //jQuery('#note_'+note_id).html(note_count);
}
replaceCufon();
//END MAKE AN OFFER	=======