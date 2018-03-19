var Term = function () {
    this.property_id = 0;
};
Term.prototype = {
    load: function (url) {
        $.post(url, {}, function (data) {
            closeLoadingPopup();
            $('#popup_term').html(data);
            Cufon.replace('#nh_txt');
            term_popup.show().toCenter();
        });
    },
    showPopup: function (id) {
        showLoadingPopup();
        this.property_id = id;
        this.load('/modules/general/action.php?action=loadTerm&id=' + id);
    },
    closePopup: function () {
        jQuery(term_popup.container).fadeOut('slow', function () {
            term_popup.hide()
        });
    },
    save: function () {
        if (jQuery('#checked_term', '#frmAgent').length > 0) {
            jQuery('#checked_term', '#frmAgent').attr('checked', true);
            this.closePopup();
        }
        //document.location = '/?module=payment&action=option&type=bid&item_id=' + this.property_id;
        /*var url = '/modules/general/action.php?action=acceptTerm';
         $.post(url,{property_id:$('#popup_term [name=id]').val()},function(data){
         var result = jQuery.parseJSON(data);
         if (result.success){
         document.location = result.redirect;
         }
         },'html')*/
    }
};
var term = new Term();
var term_popup = new Popup();
term_popup.init({id: 'term_popup', className: 'popup_overlay'});
term_popup.updateContainer('<div class="popup_container" style="width:300px;"><div id="popup_term"></div></div>');
var CheckSub = function (form) {
    this.form = form
    this.redirect = '';
};
/*var check_sub = new CheckSub();
 var remind_payment = new CheckSub();*/
CheckSub.prototype = {
    showPopup: function (data) {
        $('#popup_sub').html(data);
        Cufon.replace('#popup_sub .title h2');
        check_sub_popup.show().toCenter();
        closeLoadingPopup();
    },
    closePopup: function (callback_fnc) {
        if (callback_fnc) {
            var at_least = $('[name=min]', '#frmSub').val();
            this.change(null, at_least);
        } else {
            if ($('#rlater', this.form).length > 0 && $('#rlater', this.form).is(':checked')) {
                $.post('/modules/general/action.php?action=rlater', {}, function (data) {
                }, 'html');
            }
            jQuery(check_sub_popup.container).fadeOut('slow', function () {
                check_sub_popup.hide()
            });
            $('#popup_sub').html('');
            if (this.redirect != '') {
                document.location = this.redirect;
            }
        }
    },
    save: function () {
        var sub = [];
        $.each($('input[type=checkbox]', '#frmSub'), function () {
            if (!$(this).is(':disabled') && $(this).is(':checked')) {
                sub.push($(this).val());
            }
        });
        var at_least = $('[name=min]', '#frmSub').val();
        if (sub.length < parseInt(at_least)) {
            $('#message', '#frmSub').show().html('Please choose at least ' + at_least + ' account(s).');
        } else {
            $('#message', '#frmSub').hide();
            this.change(sub, at_least);
        }
    },
    change: function (sub, at_least) {
        var url = '/modules/general/action.php?action=changeStatus';
        if (sub != null) {
            sub = sub.join(',');
        }
        $.post(url, {ids: sub, min: at_least}, function (data) {
            var result = jQuery.parseJSON(data);
            if (data.error) {
                $('#message', '#frmSub').show().html('Process fails. Please try again.');
            } else {
                $('#message', '#frmSub').hide();
                self['check_sub'].closePopup(false);
            }
        }, 'html');
    },
    payment: function () {
        var params = new Object();
        var i = 0;
        $.each($('input,select', this.form), function () {
            if ($(this).attr('type') == 'radio') {
                if ($(this).is(':checked')) {
                    i++;
                    params[$(this).attr('name').replace('[]', '')] = $(this).val();
                }
            }
        });
        if (i < 2) {
            $('#message', this.form).show().html('Please select something!');
        } else {
            $('#message', this.form).hide();
            var self = this;
            var url = '/modules/general/action.php?action=payment';
            $.post(url, {param: params}, function (data) {
                var result = $.parseJSON(data);
                if (result.success) {
                    if (result.redirect) {
                        self.redirect = '';
                        document.location = result.redirect;
                    }
                    self.closePopup();
                } else {
                    showMess(result.msg);
                }
            });
        }
    }
};
var check_sub_popup = new Popup();
var check_sub = new CheckSub('#frmSub');
var remind_payment = new CheckSub('#frmPayment');
check_sub_popup.init({id: 'sub_popup', className: 'popup_overlay'});
/*style="width:400px;"*/
check_sub_popup.updateContainer('<div class="popup_container" style="width:auto;"><div id="popup_sub"></div></div>');
var countDown_popup = new Popup();
countDown_popup.init({id: 'countdown_popup', className: 'popup_overlay'});
countDown_popup.updateContainer('<div class="popup_container" style="*width:952px"></div>');






