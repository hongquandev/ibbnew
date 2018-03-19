var DEFINE = {
    COMMENT_SELF: null
}
var us_def = 'email';
var pw_def = 'password';
var timer_global = null;
var timer_watermark = null;
var locked = false;
var d = new Date();
var t = d.getTime();
var last_time = t;
var ape_enable = false;
var ape_data = null;
var ape_fire = '#ape-get-bid';
var ape_nick = '';
function onFocusBlur(obj, eventName) {
    switch (obj.id) {
        case 'username':
            if (eventName == 'focus') {
                if (obj.value == us_def) {
                    obj.value = '';
                }
            } else if (eventName == 'blur') {
                if (obj.value == '') {
                    obj.value = us_def;
                }
            }
            break;
        case 'password':
            if (eventName == 'focus') {
                if (obj.value == pw_def) {
                    obj.value = '';
                }
            } else if (eventName == 'blur') {
                if (obj.value == '') {
                    obj.value = pw_def;
                }
            }
            break;
    }
}
function login(frmId) {
    var frm = document.getElementById(frmId);
    var username = jQuery('#username', frm).val();
    var password = jQuery('#password', frm).val();
    if (username.length > 0 && password.length > 0 && username != us_def && password != pw_def) {
        frm.submit();
        return true;
    } else {
        showMess('Please enter your email address and password.');
        return false;
    }
}
//END 
var SlideShow = {
    container: '',
    target: '',
    current_item: 0,
    max_show: 4,
    max_item: 0,
    init: function (container, target, max_show, max_item) {
        this.container = container;
        this.target = target;
        if (max_show != null) {
            this.max_show = max_show;
        }
        if (max_item != null) {
            this.max_item = max_item;
        }
        //HIDE ELEMENT OUT MAX LEN
        jQuery(this.container + ' .img-list div.item').each(function (index) {
            SlideShow.max_item++;
            if (index > (SlideShow.max_show - 1)) {
                //jQuery(this).hide();
            }
            /*if(jQuery(this).hasClass('active')){
             SlideShow.current_item = index;
             }*/
        });
        //FOR PREV BUTTON
        jQuery('.img-prev', this.container).click(function () {
            if (SlideShow.current_item > 0) {
                SlideShow.current_item--;
                //if(SlideShow.current_item <0 ){SlideShow.current_item = 0;}
                console.log(SlideShow.current_item);
                jQuery('#img-list-slide div:eq(' + SlideShow.current_item + ')').fadeIn();
            }
        });
        //FOR NEXT BUTTON
        jQuery('.img-next', this.container).click(function () {
            //if (SlideShow.current_item > 0) {
            if ((SlideShow.current_item + SlideShow.max_show) < SlideShow.max_item && SlideShow.current_item >= 0) {
                console.log(SlideShow.current_item);
                jQuery('#img-list-slide div:eq(' + SlideShow.current_item + ')').fadeOut();
                SlideShow.current_item++;
            }
        });
        //FOR LIST
        jQuery('.img-list div div', this.container).click(function () {
            //DE-ACTIVE ALL
            jQuery(this).parent().children().each(function () {
                jQuery(this).removeClass('active');
            });
            //ACTICE THIS ONLY
            jQuery(this).removeClass('active').addClass('active');
            //REPLACE MAIN IMAGE
            var url = jQuery('img', this).attr('src').replace('/thumbs', '');
            jQuery(SlideShow.target).attr('src', url);
            //jQuery(SlideShow.target+' > img').attr('src',jQuery('img',this).attr('src'));
        });
    }
}
var SlideShow2 = function (container, target, max_show, max_item) {
    this.container = container;
    this.target = target;
    this.current = 0;
    this.max_show = (typeof max_show == 'int' ? max_show : 3);
    this.max_item = (typeof max_item == 'int' ? max_item : 0);
}
SlideShow2.prototype = {
    init: function () {
        var i = 0;
        jQuery('div', this.container + ' #img-list-slide').each(function () {
            //this.max_item++;
            i++;
        });
        i = this.max_item;
    },
    prev: function () {
        this.init();
        //alert( 'curent'+this.current + 'max show'+this.max_show + 'max item'+this.max_item);
        if ((this.current + this.max_item + 1) < this.max_show) {
            jQuery('div.img-list > div > div:eq(' + this.current + ')', this.container).fadeOut();
            this.current++;
        }
    },
    next: function () {
        this.init();
        if (this.current >= 0) {
            this.current--;
            jQuery('div.img-list > div > div:eq(' + this.current + ')', this.container).fadeIn();
        }
    },
    item_click: function (obj, item_id, id, max) {
        this.init();
        var i = 0;
        max_ = parseInt(max);
        for (i; i < max_; i++) {
            jQuery('#item-' + i + '-' + id).removeClass('active');
        }
        jQuery(item_id, this.container).removeClass('active').addClass('active');
        jQuery(this.target).attr('src', jQuery('img', obj).attr('src'));
    }
}
//CONSTRUCT OF BID
var Bid = function (o) {
    this._options = {
        container_obj: null,
        time_obj: null,
        timer: null,
        timer_lastbidder: null,
        property_id: 0,
        last_bidder_id: 0,
        last_time: 0,
        callback_fnc: [],
        stop_bid: false,
        after_price: '',
        mine: false,
        container: null,
        theblock: false,
        countdown: '',
        sold: false,
        type: '',
        inRoom: false,
        showPopup: true,
        transfer: false,
        transfer_container: '',
        transfer_template: '',
        check: 0
    };
}
Bid.prototype = {
    setContainerObj: function (container) {//ID NAME
        if (typeof container == 'string') {
            this._options.container_obj = jQuery('#' + container);
        }
        else if (typeof container == 'object') {
            this._options.container_obj = container;
        }
        return this;
    },
    setTimeObj: function (time,selector_type) {
        if(typeof selector_type == 'string' && selector_type == 'class'){
            this._options.time_obj = jQuery('.' + time);
            return this;
        }
        if (typeof time == 'string') {
            this._options.time_obj = jQuery('#' + time);
        }
        else if (typeof time == 'object') {
            this._options.time_obj = time;
        }
        else {
            this._options.time_obj = jQuery('p.time', this._options.container_obj);
        }
        return this;
    },
    setBidderObj: function (bidder) {
        if (typeof bidder == 'string') {
            this._options.bidder_obj = jQuery('#' + bidder);
        }
        else if (typeof bidder == 'object') {
            this._options.bidder_obj = bidder;
        }
        else {
            this._options.bidder_obj = jQuery('p.lastbidder', this._options.container_obj);
        }
        return this;
    },
    setPriceObj: function (price) {
        if (typeof price == 'string') {
            this._options.price_obj = jQuery('#' + price);
        }
        else if (typeof price == 'object') {
            this._options.price_obj = price;
        }
        else {
            this._options.price_obj = jQuery('p.bid', this._options.container_obj);
        }
        return this;
    },
    setTimeValue: function (t) {

        //this._options.time_value = parseInt(t);
        this._options.time_value = t;
        if (this._options.time_value <= 0) {
            this._options.stop_bid = true;
        }
        if (this._options.theblock) this._options.stop_bid = false;
        //jQuery('p.time').text();
        return this;
    },
    setLastBidderId: function (last_bidder_id) {
        if (last_bidder_id > 0) {
            this._options.last_bidder_id = last_bidder_id;
        }
    },
    getLastBidderId: function () {
        return this._options.last_bidder_id;
    },
    setLastTime: function (last_time) {
        if (last_time > 0) {
            this._options.last_time = last_time;
        }
    },
    getLastTime: function () {
        return this._options.last_time;
    },
    addCallbackFnc: function (key, fnc) {
        if (!this._options.callback_fnc[key]) {
            this._options.callback_fnc[key] = [];
        }
        this._options.callback_fnc[key].push(fnc);
    },
    flushCallbackFnc: function () {
        this._options.callback_fnc = [];
    },
    setContainer: function (container) {
        this._options.container = container;
        return this;
    },
    /*
     calTime: function(id) {
     var t = window['time_'+id];
     var d = parseInt(t / (60 * 60 * 24));
     var h = parseInt((t - (d * 60 * 60 * 24)) / (60 * 60));
     var m = parseInt((t - (d * 60 * 60 * 24) - (h * 60 * 60)) / 60);
     var s = t - (d * 60 * 60 * 24) - (h * 60 * 60) - (m * 60);

     if (h < 10) {
     h = '0' + h;
     }

     if (m < 10) {
     m = '0' + m;
     }

     if (s < 10) {
     s = '0' + s;
     }

     var time_str = d + 'd:' + h + ':' + m + ':' + s;
     //jQuery(this._options.time_obj).text(time_str);


     var d = new Date();
     //self['time_'+id] = t-1;
     //jQuery('p.time').text();
     //jQuery('#time_'+id).html(d.getSeconds());
     //jQuery('p.time',this._options.container_obj).text(jQuery(this._options.time_obj).attr('class'));
     //jQuery(this._options.time_obj).text(d.getSeconds());
     //jQuery('p.time',this._options.container_obj).text(d.getSeconds());
     //jQuery('p.time',this._options.container_obj).text(jQuery(this._options.container_obj).attr('class')+'-'+d.getSeconds());
     //this._options.time_value--;
     //document.getElementById('test').innerHTML += t+'|';

     },
     */
    test: function (id) {
        var d = new Date();
        var t = d.getSeconds() + id;
        jQuery('#test_' + id).text(t);
        //t = this._options.time_value;
        //t = t-1;
        //jQuery('p.time',this._options.container_obj).text(t);
        //jQuery(this._options.time_obj).text(t);
    },
    bid: function (property_id) {
        var args = {property_id: property_id, mine: this._options.mine == true ? 1 : 0};
        //BEGIN CALLBACK
        if (self['bid_' + property_id]._options.callback_fnc['bid_before'] && self['bid_' + property_id]._options.callback_fnc['bid_before'].length > 0) {
            for (i = 0; i < self['bid_' + property_id]._options.callback_fnc['bid_before'].length; i++) {
                _args = self['bid_' + property_id]._options.callback_fnc['bid_before'][i]();
                for (var attr in _args) {
                    args[attr] = _args[attr];
                    //alert(_args[attr]);
                }
            }
        }
        //END
        jQuery.post('/modules/general/action.php?action=bid', args, this.onBid, 'html');
        //jQuery.post(ROOTURL2 + '/modules/general/action.php?action=bid', args, this.onBid, 'html');
    },
    onBid: function (data) {
        var json = jQuery.parseJSON(data);
        closeLoadingPopup();
        if (json.success == 1 && json.data.property_id) {

            //RESET TIME VALUE
            if (json.data.time) {
                self['time_' + json.data.property_id] = parseInt(json.data.time);
            }
        } else if (json.autobid) {
            //BEGIN CALLBACK FOR BID
            var property_id = json.property_id;
            if (self['bid_' + property_id]._options.callback_fnc['bid_after'] && self['bid_' + property_id]._options.callback_fnc['bid_after'].length > 0) {
                for (i = 0; i < self['bid_' + property_id]._options.callback_fnc['bid_after'].length; i++) {
                    self['bid_' + property_id]._options.callback_fnc['bid_after'][i](json);
                }
            }
            //END
            //BEGIN check bid
        } else if (json.login) {
            if (json.isBlock) {
                showLoginPopup_block();
            }
            else {
                showLoginPopup();
            }
        } else if (json.is_confirm) {
            show_confirm(self['bid_' + json.id], json.msg);
        } else if (json.error == 1) {
            //alert(json.msg);
            if (json.term == 1) {
                term.showPopup(json.id);
            } else if (json.redirect != null) {
                document.location = json.redirect;
            } else {
                showMess(json.msg, '', false);
            }
        } else {
            var obj = '';
            showConfirm(json.msg, '', '', 'ok/cancel');
            obj = '#OK';
            jQuery(obj).bind('click', function () {
                var property_id = json.id;
                var money_step = json.money ? json.money : 0;
                var args = {
                    property_id: property_id,
                    mine: self['bid_' + property_id]._options.mine,
                    money: money_step,
                    room: self['bid_' + property_id]._options.inRoom
                };
                //BEGIN CALLBACK
                if (self['bid_' + property_id]._options.callback_fnc['bid_before'] && self['bid_' + property_id]._options.callback_fnc['bid_before'].length > 0) {
                    for (i = 0; i < self['bid_' + property_id]._options.callback_fnc['bid_before'].length; i++) {
                        _args = self['bid_' + property_id]._options.callback_fnc['bid_before'][i]();
                        for (var attr in _args) {
                            args[attr] = _args[attr];
                        }
                    }
                }
                //END
                closeConfirm();
                showLoadingPopup();
                jQuery.post('/modules/general/action.php?action=on-bid', args, self['bid_' + json.id].onRealBid, 'html');
            });
        }
    },
    onRealBid: function (data) {
        closeLoadingPopup();
        var result = jQuery.parseJSON(data);
        if (result.success == true) {
            closeConfirm();
            showMess(result.msg, '', false);
            /*if (self['bid_' + result.property_id]._options.showPopup == true){
             showMess(result.msg,'',false);
             }else{
             jQuery('.popup-countdown-child #remind-box').show().html(result.msg);
             }*/
            if (result.property_id) {
                //$('#'+result.clear).val('');
                // Update Bid Number
                var bid = parseInt(jQuery('#bid-no-' + result.property_id).html());
                if (true) {
                    bid++;
                    jQuery('#bid-no-' + result.property_id).html(bid);
                }
                if (!$('#uniform-step_option_' + result.property_id).length > 0) {
                    $('#step_option_' + result.property_id + '_txt').val('');
                    $('#step_option1_' + result.property_id).val('');
                }
                if (!$('#uniform-step_option').length > 0) {
                    $('#step_option_txt').val('');
                    $('#step_option1').val('');
                }
                if (ape_enable && result.ape) {
                    ape_data = result.ape;
                    jQuery(ape_fire).click();
                }
                if (typeof updateBidHistory == 'function') {
                    updateBidHistory('', result.property_id);
                }
            }
            /*if (self['bid_'+result.property_id].theblock){
             if ($('#count_popup_'+result.property_id).length > 0){
             var array = {'btn-countdown-step1':'btn-step1-disable.png',
             'btn-countdown-step2':'btn-step2-disable.png',
             'btn-countdown-step3':'btn-step3-disable.png',
             'btn-countdown-sold':'btn-sold-disable.png'};
             $.each(array, function(key,value){
             $('#count_popup_'+result.property_id+' input.'+key).css('background','url(\'../images/'+value+'\') !important;')
             });
             }
             }*/
        } else {
            showMess(result.msg, '', false);
        }
    },
    click: function (room) {
        showLoadingPopup();
        /*if (this._options.showPopup == true){
         showLoadingPopup();
         }
         */
        if ($('#email_address').val() == '' && $('#login').val() == true) {
            confirmEmail('');
            $('span.notification').html('Please confirm your email address to access all of iBB\'s features.');
            closeLoadingPopup();
            return;
        }
        if (this._options.stop_bid) {
            if (this._options.showPopup == true) {
                closeLoadingPopup();
                showMess('Bidding stopped.');
            } else {
                jQuery('.popup-countdown-child #remind-box').show().html('Bidding stopped');
            }
            return;
        }
        this._options.inRoom = (room) ? true : false;
        this.bid(this._options.property_id);
    },
    onClick: function (data) {
        var ok = jQuery.parseJSON(data);
        if (ok) {
            this.bid(this._options.property_id);
        }
    },
    startTimer: function (id) {
        if ( self['time_' + id] > 0) {
            this._options.property_id = id;
            this._options.stop_bid = false;
            this._options.timer = setInterval('calcTime(' + id + ')', 1000);
        }
    },
    stopTimer: function () {
        if (!this._options.theblock) {
            this._options.stop_bid = true;
        }
        //jQuery(this._options.time_obj).html('Sold');
        //jQuery(this._options.time_obj).html(this._options.str_countdown);
        clearInterval(this._options.timer);
    },
    getLastBidder: function (id) {
        //this._options.timer_lastbidder = setInterval('lastBidder()',1000);
    },
    onGetLastBidder: function (data) {
        /*
         var JSONobject = jQuery.parseJSON(data);
         if (JSONobject.success) {
         jQuery(self['bid_'+JSONobject.property_id]._options.time_obj).addClass('bid-focus');
         jQuery(self['bid_'+JSONobject.property_id]._options.bidder_obj).html('Last bidder: '+JSONobject.bidder);
         jQuery(self['bid_'+JSONobject.property_id]._options.price_obj).html('Bid: '+JSONobject.price);
         }
         else if (JSONobject.error) {

         }
         */
    },
    pauseBid: function () {
        /*var url = '/modules/property/action.php?action=getTooltip';
         $.post(url,{key:'no_more_bids_msg'},function(data){
         showConfirm(data,'','','yes/no');
         },'html');*/
        //
        showConfirm($('#no_more_bid_msg').html(), '', '', 'yes/no');
        self['confirm_nh'].flushCallback();
        self['confirm_nh'].property_id = this._options.property_id;
        self['confirm_nh'].addFunc(function () {
            self['bid_' + self['confirm_nh'].property_id].onPauseBid();
        });
    },
    onPauseBid: function () {
        var url = '/modules/general/action.php?action=no-more-bids';
        var bids = this;
        $.post(url, {property_id: this._options.property_id}, function (data) {
            var result = $.parseJSON(data);
            if (result.success) {
                $('#btn_no_' + bids._options.property_id).remove();
                if ($('#popup_btn_no_' + bids._options.property_id).length > 0) {
                    $('#popup_btn_no_' + bids._options.property_id).remove();
                }
                return true;
            } else {
                return false;
            }
        }, 'html');
    },
    disable: function (agent_id, obj) {
        showLoadingPopup();
        var url = '/modules/general/action.php?action=disableBidder';
        $.post(url, {pid: this._options.property_id, aid: agent_id}, function (data) {
            closeLoadingPopup();
            var result = $.parseJSON(data);
            var name = $(obj).parents('tr').find('a.name');
            if (result.success) {
                if (result.status == 1) {
                    $(obj).html('No');
                } else {
                    $(obj).html('Yes');
                }
                if (result.status == 1 || result.astatus == 0) {
                    name.html('<s>' + name.html() + '</s>');
                } else {
                    name.html(name.html().replace(/<.s?>/g, ''));
                    if ($('#countdown_popup_child #report-register-bid').length > 0) {
                        reloadReportNoMoreBid('');
                    }
                }
            } else {
            }
        }, 'html');
    },
    allow: function (agent_id, obj) {
        var url = '/modules/general/action.php?action=allowBidder';
        showLoadingPopup();
        $.post(url, {pid: this._options.property_id, aid: agent_id}, function (data) {
            closeLoadingPopup();
            var result = $.parseJSON(data);
            var name = $(obj).parents('tr').find('a.name');
            if (result.success) {
                if (result.status == 0) {
                    $(obj).html('No');
                } else {
                    $(obj).html('Yes');
                }
                if (result.status == 0 || result.astatus == 1) {
                    name.html('<s>' + name.html() + '</s>');
                } else {
                    name.html(name.html().replace(/<.s?>/g, ''));
                    if ($('#countdown_popup_child #report-register-bid').length > 0) {
                        reloadReportNoMoreBid('');
                    }
                }
            } else {
            }
        }, 'html');
    },
    transfer: function (template) {
        var url = '/modules/general/action.php?action=transferTemplate';
        //template:detail,list,grid;
        var bid = this;
        $.post(url, {tpl: template, property_id: this._options.property_id}, function (data) {
            var result = $.parseJSON(data);
            $('#' + bid._options.transfer_container).html(jQuery(result.html));
            if (template == 'list' && (result.reg || result.vendor)) {
                var html = '<button id = "btn_bid_' + bid._options.property_id + '" class="btn-bid f-left btn-bid-auc-list btn-list-box4" onclick="bid_' + bid._options.property_id + '.click()"></button>';
                $('#' + bid._options.transfer_container).closest('li').find('.btn-list2').prepend(html);
            }
            if (template == 'theblock') {
                $('#' + bid._options.transfer_container).parent().find('.tv-show-top').removeClass('tv-forth-height').addClass('tv-live-height');
            }
            closeLoadingPopup();
        }, 'html');
    }
}
function calcTime(id) {
    if (self['time_' + id] >= 0) {
        //console.log(self['time_'+id]);
        var t = self['time_' + id];
        var d = parseInt(t / (60 * 60 * 24));
        var h = parseInt((t - (d * 60 * 60 * 24)) / (60 * 60));
        var m = parseInt((t - (d * 60 * 60 * 24) - (h * 60 * 60)) / 60);
        var s = t - (d * 60 * 60 * 24) - (h * 60 * 60) - (m * 60);
        if (h < 10) {
            h = '0' + h;
        }
        if (m < 10) {
            m = '0' + m;
        }
        if (s < 10) {
            s = '0' + s;
        }
        var time_str = d + 'd:' + h + ':' + m + ':' + s;
        try {
            if (self['bid_' + id]._options.countdown != '' && !self['bid_' + id]._options.theblock) {
                jQuery(self['bid_' + id]._options.time_obj).html(self['bid_' + id]._options.countdown);
                self['timer_' + id] = '';
            } else if (self['timer_' + id] && !self['bid_' + id]._options.theblock) {
                if (self['timer_' + id] != '') {
                    jQuery(self['bid_' + id]._options.time_obj).html(self['timer_' + id]);
                }
            } else {
                jQuery(self['bid_' + id]._options.time_obj).html(time_str);
                self['timer_' + id] = '';
            }
            if (self['time_' + id] == 0) {
                jQuery(self['bid_' + id]._options.time_obj).html("Ended");
            }
            jQuery(self['bid_' + id]._options.time_obj).removeClass('bid-focus');
            self['time_' + id]--;
        }
        catch (e) {
        }
    } else {
        try {
            if (self['bid_' + id]._options.theblock) // Update Time for Block
            {
                self['ids'].push(id);
                lastBidder();
            }
            jQuery(self['bid_' + id]._options.time_obj).removeClass('bid-focus');
            self['bid_' + id].stopTimer();
        } catch (e) {

        }
    }
}
//BEGIN GETTING DATA FROM IDS
function lastBidder() {
    if (!Array.prototype.filter) // Quan: for all browser
    {
        Array.prototype.filter = function (fun /*, thisp*/) {
            var len = this.length;
            if (typeof fun != "function")
                throw new TypeError();
            var res = new Array();
            var thisp = arguments[1];
            for (var i = 0; i < len; i++) {
                if (i in this) {
                    var val = this[i]; // in case fun mutates this
                    if (fun.call(thisp, val, i, this))
                        res.push(val);
                }
            }
            return res;
        };
    }
    var unique = self['ids'].filter(function (itm, i, a) {
        return i == a.indexOf(itm);
    });
    self['ids'] = unique;
    if (self['ids'].length > 1) {
        var str = self['ids'].join('-');
    } else {
        var str = self['ids'][0];
    }
    if (self['ids'].length > 0) {
        //JSONstring = JSON.stringify(JSONObject);
        var d = new Date();
        var t = d.getTime();
        var args = {ids: str};
        var d = new Date();
        var t = d.getTime();
        if (self.locked == false || (t - self.last_time) > 10000) {
            self.locked = true;
            self.last_time = t;
            jQuery.post('/modules/general/action.php?action=get-bid&t=' + t, args, onLastBidder, 'html');
            /*
             $.getJSON(ROOTURL2 + "/modules/general/action.php?action=get-bid&jsoncallback=?",
             {ids:str},
             function(data) {}
             );
             */
            /*$.ajax({type: "GET",
             url: "http://staging.ibb.hue/test.php?callback={ttest}",
             data: "name=John&location=Boston",
             crossDomain :true,
             success: function(html){
             alert('a');
             }
             });*/
            //jQuery.post(ROOTURL2 + '/modules/general/action.php?action=get-bid&t='+t,args,onLastBidder,'html');
            //jQuery.post('/modules/general/action.php?action=get-bid&t='+t,args,onLastBidder,'html');
            //jQuery.get(ROOTURL2 + '/test.php?'+t,args,function() {alert('a')},'html');
            //jQuery.post(ROOTURL2 + '/test.php?&t='+t, args, onLastBidder, 'json');
            //crossDomain: true,
            /*
             var xhr = new XMLHttpRequest();
             //xhr.open('POST', '/modules/general/action.php?action=get-bid&t='+t, true);
             //xhr.open('POST', 'http://staging.ibb.hue/modules/general/action.php?action=get-bid&t='+t, true);
             xhr.open('POST', 'http://staging.ibb.hue/test.php?action=get-bid&t='+t, true);
             xhr.onreadystatechange = function() {
             if (xhr.readyState == 4) {
             //alert('resp received, status:' + xhr.status + ', responseText: ' + xhr.responseText);
             //onLastBidder(xhr.response);
             //alert(xhr.responseText);
             }
             };
             xhr.send();
             */
        }
    } else {
        self.locked = false;
        clearInterval(self['timer_global']);
    }
}
/*
 function _test(t) {
 console.log(t);
 }
 */
function onLastBidder(data) {
    var JSONobject = ape_enable == true ? data : jQuery.parseJSON(data);
    //JSONobject = jQuery.parseJSON(data);
    var txt = '';
    var bid_text = 'Bid';
    var array = [];
    try {
        if (JSONobject.success) {
            if (JSONobject.data) {
                for (var property_id in JSONobject.data) {
                    if (JSONobject.data[property_id].stop_bid == 0) {
                        try {
                            if (JSONobject.data[property_id].remain_time <= JSONobject.data[property_id].count['once'] && JSONobject.data[property_id].remain_time > JSONobject.data[property_id].count['twice']) {
                                self['bid_' + property_id]._options.countdown = 'Going Once';
                            } else if (JSONobject.data[property_id].remain_time <= JSONobject.data[property_id].count['twice'] && JSONobject.data[property_id].remain_time > JSONobject.data[property_id].count['third']) {
                                self['bid_' + property_id]._options.countdown = 'Going Twice';
                            } else if (JSONobject.data[property_id].remain_time <= JSONobject.data[property_id].count['third'] && JSONobject.data[property_id].type_property != 'stop_auction') {
                                self['bid_' + property_id]._options.countdown = 'Third and Final call';
                            } else {
                                self['bid_' + property_id]._options.countdown = '';
                            }
                        } catch (err) {
                        }
                        //PREPARE FORTHCOMING TO LIVE
                        if (JSONobject.data[property_id].live_time && JSONobject.data[property_id].live_time <= 0 && self['bid_' + property_id]._options.transfer === false) {
                            //BEGIN LIVE
                            showLoadingPopup();
                            self['bid_' + property_id].transfer(self['bid_' + property_id]._options.transfer_template);
                            self['bid_' + property_id]._options.transfer = true;
                        }
                    }
                    //eBidda Watermark
                    if (JSONobject.data[property_id].ebidda_watermark != "") {
                        jQuery('#img_ebidda_mark_' + property_id).attr('src', JSONobject.data[property_id].ebidda_watermark).css('display', 'block');
                    }
                    array = ['bid_button_' + property_id,
                        'btn_bid_' + property_id,
                        'btn-wht-' + property_id,
                        'btn-offer-' + property_id,
                        'view-button-' + property_id,
                        'bid_room_button_' + property_id];
                    //CHECK RESERVE
                    try {
                        var bp = parseFloat(JSONobject.data[property_id].bid_price);
                        var sp = parseFloat(JSONobject.data[property_id].reserve_price);
                        if (bp >= sp && sp > 0 && JSONobject.data[property_id].type_property == 'live_auction') {//ON THE MARKET
                            jQuery('#img_mark_' + property_id).attr('src', '/modules/general/templates/images/onthemarket_list.png').css('display', 'block');
                            jQuery('#img_mark_fix_' + property_id).attr('src', '/modules/general/templates/images/onthemarket_list.png').css('display', 'block');
                            jQuery('#img_mark_detail_' + property_id).attr('src', '/modules/general/templates/images/onthemarket_detail.png').css('display', 'block');
                            jQuery('#mark').attr('src', '/modules/general/templates/images/onthemarket_detail.png').css('display', 'block');
                            jQuery('#bid_button_' + property_id).removeClass('btn-bid');
                            jQuery('#btn_bid_' + property_id).removeClass('btn-bid');
                            jQuery('#btn-wht-' + property_id).removeClass('btn-wht-home').removeClass('btn-add-to-wtachlist').addClass('btn-wht-home-green');
                            jQuery('#btn-offer-' + property_id).removeClass('btn-make-an-ofer').addClass('btn-make-an-ofer-green');
                            jQuery('#view-button-' + property_id).removeClass('btn-view').addClass('btn-view-green');
                            //CHANGE COLOR BUTTON
                            if (JSONobject.data[property_id].isVendor) {
                                $('#btn_bid_' + property_id).removeClass('btn-bid-vendor').removeClass('btn-bid-green-reg').addClass('btn-bid-vendor-green');
                                $('#bid_button_' + property_id).removeClass('btn-bid-vendor').removeClass('btn-bid-green-reg').addClass('btn-bid-vendor-green');
                            } else {
                                if (JSONobject.data[property_id].register_bid) {
                                    $('#btn_bid_' + property_id).removeClass('btn-bid').removeClass('btn-bid-vendor-green').removeClass('btn-bid-green-reg').addClass('btn-bid-green');
                                    $('#bid_button_' + property_id).removeClass('btn-bid').removeClass('btn-bid-vendor-green').removeClass('btn-bid-green-reg').addClass('btn-bid-green');
                                } else {
                                    $('#btn_bid_' + property_id).removeClass('btn-bid-reg').removeClass('btn-bid-vendor-green').addClass('btn-bid-green-reg');
                                    $('#bid_button_' + property_id).removeClass('btn-bid-reg').removeClass('btn-bid-vendor-green').addClass('btn-bid-green-reg');
                                    bid_text = "Register to Bid";
                                }
                                //for mobile
                                jQuery('#bid_button_' + property_id + ', #btn_bid_' + property_id).each(function () {
                                    if (jQuery(this).length > 0 && jQuery(this).hasClass('btn-bid-new')) {
                                        jQuery(this).val(bid_text);
                                    }
                                });
                            }
                            //update color last bid
                            jQuery(".lastbid").addClass('current-bid-over');
                            if (self['bid_' + property_id]._options.theblock) {//Properties of the block or Agent
                                jQuery('#auc-time-' + property_id).addClass('change').css('color', '#007700');
                                jQuery('#count-' + property_id).addClass('change').css('color', '#007700');
                                if ($('#popup-auc-' + property_id).length > 0) {//manage bids popup is showing
                                    jQuery('#bid_button_' + property_id).removeClass('btn-bid-vendor').removeClass('btn-bid-green-reg').addClass('btn-bid-vendor-green');
                                    jQuery('#bid_room_button_' + property_id).removeClass('btn-bid').removeClass('btn-bid-green-reg').addClass('btn-bid-green');
                                    jQuery('#popup-auc-time-' + property_id).addClass('change').css('color', '#007700');
                                }
                                //WATERMARK && CHANGE BUTTON COLOR
                                jQuery('#view-button-' + property_id).removeClass('btn-view').addClass('btn-view-green');
                                jQuery('#img_mark_detail_' + property_id).show().attr('src', '/modules/general/templates/images/onthemarket_detail.png');
                                jQuery('#img_mark_' + property_id).show().attr('src', '/modules/general/templates/images/onthemarket_list.png');
                                jQuery('#img_mark_fix_' + property_id).show().attr('src', '/modules/general/templates/images/onthemarket_list.png');
                                jQuery('#mark').attr('src', '/modules/general/templates/images/onthemarket_detail.png').css('display', 'block');
                                AddWatermarkReaXml('#img_mark_rea_xml_' + property_id, 'onmarket', property_id);
                                array.push(self['count_' + property_id].bid_button);
                                if (JSONobject.data[property_id].isVendor) {
                                    $('#' + self['count_' + property_id].bid_button).removeClass('btn-bid-vendor').removeClass('btn-bid-green-reg').addClass('btn-bid-vendor-green');
                                    bid_text = 'Vendor Bid';
                                } else {
                                    if (JSONobject.data[property_id].register_bid == true) {
                                        $('#' + self['count_' + property_id].bid_button).removeClass('btn-bid').removeClass('btn-bid-green-reg').removeClass('btn-bid-vendor-green').addClass('btn-bid-green');
                                        bid_text = 'Bid';
                                    } else {
                                        $('#' + self['count_' + property_id].bid_button).removeClass('btn-bid-reg').removeClass('btn-bid-vendor-green').addClass('btn-bid-green-reg');
                                        bid_text = 'Register To Bid';
                                    }
                                }
                                //for mobile
                                /*if ($('#' + self['count_' + property_id].bid_button).length > 0 && $('#' + self['count_' + property_id].bid_button).hasClass('btn-bid-new')) {
                                 jQuery(this).val(bid_text);
                                 }*/
                                jQuery('#view-button-' + property_id).removeClass('btn-view').addClass('btn-view-green');
                            }
                            //CHANGE COLOR BUTTON MOBILE
                            jQuery('input,button').each(function () {
                                if (jQuery.inArray($(this).attr('id'), array) != -1 && jQuery(this).hasClass('btn-orange')) {
                                    jQuery(this).removeClass('btn-orange').addClass('btn-green');
                                }
                            });
                        }
                    } catch (err) {
                    }
                    //END CHECK RESERVE
                    //BEGIN change text Current Bidder Last Bidder Current Bid Last Bid
                    try {
                        if (typeof JSONobject.data[property_id].set_count != 'undefined') {
                            jQuery('#' + self['bid_' + property_id]._options.container).html(JSONobject.data[property_id].set_count);
                            if ($('#popup-auc-' + property_id).length > 0) {
                                jQuery('#popup-auc-time-' + property_id).html(JSONobject.data[property_id].set_count);
                            }
                            try {
                                if (JSONobject.data[property_id].set_count.length > 14)
                                //jQuery('#'+self['count_'+ property_id].container).css('font-size','16px !important');
                                    jQuery('#' + self['count_' + property_id].container);
                            } catch (er) {
                            }
                        } else {
                            /*jQuery('#'+self['count_'+ property_id].container).html('Auction Live');*/
                        }
                        if ((JSONobject.data[property_id].bidder && JSONobject.data[property_id].bidder.length > 0) || (JSONobject.data[property_id].price && JSONobject.data[property_id].price.length > 0)) {
                            //jQuery(self['bid_' + property_id]._options.time_obj).addClass('bid-focus');
                            if (JSONobject.data[property_id].isLastBidVendor) {
                                if (JSONobject.data[property_id].inRoom) {
                                    jQuery(self['bid_' + property_id]._options.bidder_obj).html('In Room Bid');
                                    jQuery('#auc-bidder-' + property_id + '-grid').html('In Room Bid');
                                    if ($('#popup-auc-' + property_id).length > 0) {
                                        jQuery('#popup-auc-bidder-' + property_id).html('In Room Bid');
                                    }
                                } else {
                                    jQuery(self['bid_' + property_id]._options.bidder_obj).html('Vendor Bid');
                                    jQuery('#auc-bidder-' + property_id + '-grid').html('Vendor Bid');
                                    if ($('#popup-auc-' + property_id).length > 0) {
                                        jQuery('#popup-auc-bidder-' + property_id).html('Vendor Bid');
                                    }
                                }
                            } else {
                                if (JSONobject.data[property_id].stop_bid == 1 || parseInt(JSONobject.data[property_id].confirm_sold) == 1) {
                                    var parent = jQuery(self['bid_' + property_id]._options.bidder_obj).parent();
                                    if (jQuery(parent).hasClass('col-span-2')) {
                                        jQuery(self['bid_' + property_id]._options.bidder_obj).html(JSONobject.data[property_id].bidder);
                                        jQuery(self['bid_' + property_id]._options.bidder_obj).closest('li').find('.col-span-1').html('Last Bidder:');
                                    } else {
                                        jQuery(self['bid_' + property_id]._options.bidder_obj).html(JSONobject.data[property_id].bidder);
                                        jQuery('#label-auc-bidder-' + property_id).html('Last Bidder:');
                                        jQuery('#auc-bidder-' + property_id + '-grid').html('Last Bidder: ' + JSONobject.data[property_id].bidder_short);
                                        if ($('#popup-auc-' + property_id).length > 0) {
                                            jQuery('#popup-auc-bidder-' + property_id).html('Last Bidder: ' + JSONobject.data[property_id].bidder_short);
                                        }
                                    }
                                } else {
                                    //for list
                                    var parent = jQuery(self['bid_' + property_id]._options.bidder_obj).parent();
                                    if (jQuery(parent).hasClass('col-span-2')) {
                                        jQuery(self['bid_' + property_id]._options.bidder_obj).html(JSONobject.data[property_id].bidder);
                                        jQuery(self['bid_' + property_id]._options.bidder_obj).closest('li').find('.col-span-1').html('Current Bidder:');
                                    } else {
                                        jQuery(self['bid_' + property_id]._options.bidder_obj).html(JSONobject.data[property_id].bidder);
                                        jQuery('#label-auc-bidder-' + property_id).html('Current Bidder:');
                                        jQuery('#auc-bidder-' + property_id + '-grid').html('Current Bidder: ' + JSONobject.data[property_id].bidder_short);
                                        if ($('#popup-auc-' + property_id).length > 0) {
                                            jQuery('#popup-auc-bidder-' + property_id).html('Current Bidder: ' + JSONobject.data[property_id].bidder_short);
                                        }
                                    }
                                }
                            }
                            if (JSONobject.data[property_id].price) {
                                if (JSONobject.data[property_id].stop_bid == 1 || parseInt(JSONobject.data[property_id].confirm_sold) == 1) {
                                    var parent = jQuery(self['bid_' + property_id]._options.price_obj).parent();
                                    if (jQuery(parent).hasClass('col-span-2')) {
                                        jQuery(self['bid_' + property_id]._options.price_obj).html(JSONobject.data[property_id].price);
                                        jQuery(self['bid_' + property_id]._options.price_obj).closest('li').find('.col-span-1').html('Last Bid:');
                                    } else {
                                        /*if(jQuery(self['bid_' + property_id]._options.price_obj,'.bidding-frame-info2-content').length > 0){
                                         jQuery('.bid-text',self['bid_' + property_id]._options.price_obj).html('Last Bid:');
                                         jQuery('.bid-num',self['bid_' + property_id]._options.price_obj).html(JSONobject.data[property_id].price);
                                         }else{
                                         jQuery(self['bid_' + property_id]._options.price_obj).html('Last Bid: ' + JSONobject.data[property_id].price);
                                         jQuery('#auc-price-' + property_id).html('Last Bid: ' + JSONobject.data[property_id].price);
                                         }*/
                                        jQuery(self['bid_' + property_id]._options.price_obj).html(JSONobject.data[property_id].price);
                                        jQuery('#label-auc-price-' + property_id).html('Last Bid:');
                                        if ($('#popup-auc-' + property_id).length > 0) {
                                            jQuery('#popup-auc-price-' + property_id).html('Last Bid: ' + JSONobject.data[property_id].price);
                                        }
                                    }
                                } else {
                                    var parent = jQuery(self['bid_' + property_id]._options.price_obj).parent();
                                    if (jQuery(parent).hasClass('col-span-2')) {
                                        jQuery(self['bid_' + property_id]._options.price_obj).html(JSONobject.data[property_id].price);
                                        jQuery(self['bid_' + property_id]._options.price_obj).closest('li').find('.col-span-1').html('Current Bid:');
                                    } else {
                                        /*change layout Bid Price on Detail Page*/
                                        /*if(jQuery(self['bid_' + property_id]._options.price_obj,'.bidding-frame-info2-content').length > 0){
                                         jQuery('.bid-text',self['bid_' + property_id]._options.price_obj).html('Current Bid:');
                                         jQuery('.bid-num',self['bid_' + property_id]._options.price_obj).html(JSONobject.data[property_id].price);
                                         }else{
                                         jQuery(self['bid_' + property_id]._options.price_obj).html('Current Bid: ' + JSONobject.data[property_id].price);
                                         }*/
                                        jQuery(self['bid_' + property_id]._options.price_obj).html(JSONobject.data[property_id].price);
                                        jQuery('#label-auc-price-' + property_id).html('Current Bid:');
                                        if ($('#popup-auc-' + property_id).length > 0) {
                                            jQuery('#popup-auc-price-' + property_id).html('Current Bid: ' + JSONobject.data[property_id].price);
                                        }
                                    }
                                }
                                /*if (jQuery('#price-' + property_id).length > 0 && typeof JSONobject.data[property_id].price != 'undefined') {
                                    jQuery('#price-' + property_id).html(JSONobject.data[property_id].price)
                                }
                                if (jQuery('#price-bold-' + property_id).length > 0 && typeof JSONobject.data[property_id].price != 'undefined') {
                                    jQuery('#price-bold-' + property_id).html(JSONobject.data[property_id].price)
                                }*/
                            }
                            //END change text Current Bidder Last Bidder Current Bid Last Bid
                            if (JSONobject.data[property_id].stop_bid == 1 || parseInt(JSONobject.data[property_id].confirm_sold) == 1) {
                                jQuery(self['bid_' + property_id]._options.time_obj).removeClass('bid-focus');
                            }
                        }
                        if (self['bid_' + property_id]._options.callback_fnc['getBid_before'] && self['bid_' + property_id]._options.callback_fnc['getBid_before'].length > 0) {
                            for (i = 0; i < self['bid_' + property_id]._options.callback_fnc['getBid_before'].length; i++) {
                                self['bid_' + property_id]._options.callback_fnc['getBid_before'][i](JSONobject.data[property_id]);
                            }
                        }
                    } catch (err) {
                    }
                    //END
                    if (parseInt(JSONobject.data[property_id].confirm_sold) == 1) { // SOLD
                        if (parseInt(JSONobject.data[property_id].rent) == 1) {
                            jQuery('#img_mark_' + property_id).show().attr({src: '../modules/general/templates/images/RENT.png'});
                            jQuery('#img_mark_fix_' + property_id).show().attr({src: '../modules/general/templates/images/RENT.png'});
                            jQuery('#img_mark_detail_' + property_id).show().attr({src: '../modules/general/templates/images/rent_detail.png'});
                            jQuery('#mark').attr('src', '/modules/general/templates/images/rent_detail.png');
                        } else {
                            jQuery('#img_mark_' + property_id).show().attr({src: '../modules/general/templates/images/SOLD.png'});
                            jQuery('#img_mark_fix_' + property_id).show().attr({src: '../modules/general/templates/images/SOLD.png'});
                            jQuery('#img_mark_detail_' + property_id).show().attr({src: '../modules/general/templates/images/sold_detail.png'});
                            jQuery('#mark').attr('src', '/modules/general/templates/images/sold_detail.png').addClass('img-detail-sold-watermark');
                        }
                        jQuery('#mark').css('display', 'block');
                        //hide Button
                        jQuery('#btn-offer-' + property_id).hide();
                        jQuery('#bid_button_' + property_id).hide();
                        jQuery('#bid_room_button').hide();
                        jQuery('.btn-autobid').hide();
                        jQuery('div.property-detail-a').hide();
                        jQuery('#btn_count_' + property_id).hide();
                        jQuery('#btn_no_' + property_id).hide();
                        if ($('#countdown_' + property_id).length > 0) {//manage popup
                            $('#countdown_' + property_id).remove();
                            $('#bid_button_' + property_id).remove();
                            $('#bid_room_button_' + property_id).remove();
                            //remove button Pre Amble, Start Auction
                            $('.action-panel-agent').html('');
                        }
                        if (bp >= sp && sp > 0) {
                            //update color last bid
                            jQuery(".lastbid").addClass('current-bid-over');
                        }
                        //
                        var sold_status = JSONobject.data[property_id].rent && parseInt(JSONobject.data[property_id].rent) == 1 ? 'Leased' : 'Sold';
                        if (self['bid_' + property_id]) {
                            jQuery(self['bid_' + property_id]._options.time_obj).html(sold_status);
                            jQuery('#passedin-' + property_id).html(sold_status);
                        }
                        if (self['count_' + property_id]) {
                            jQuery('#' + self['count_' + property_id].container).html(sold_status);
                            //Agent && TheBlock: Sold - Hide button
                            if ($('#bid_button_' + property_id).length > 0) {//detail page
                            }
                            if ($('#auc-' + property_id).length > 0) {//theblock page
                                jQuery('#auc-' + property_id + ' .tv-show-vm-b').remove();
                            }
                        }
                        try {
                            self['bid_' + property_id].stopTimer();
                        } catch (err) {
                        }
                    } else {//LIVE || FORTH || PASSEDIN
                        switch (JSONobject.data[property_id].type_property) {
                            case "stop_auction":

                                //Agent && TheBlock:passedIn - Hide button
                                if ($('#bid_button_' + property_id).length > 0) {//detail page
                                    jQuery('#bid_button_' + property_id).remove();
                                    jQuery('#bid_room_button').remove();
                                    jQuery('#btn_count_' + property_id).remove();
                                    jQuery('#btn_no_' + property_id).remove();
                                    jQuery('div.property-detail-a').remove();
                                    jQuery('.btn-autobid').hide();
                                }
                                if ($('#countdown_' + property_id).length > 0) {//manage popup
                                    $('#countdown_' + property_id).remove();
                                    $('#bid_button_' + property_id).remove();
                                    $('#bid_room_button_' + property_id).remove();
                                    //remove button Pre Amble, Start Auction
                                    $('.action-panel-agent').html('');
                                }
                                if ($('#auc-' + property_id).length > 0) {//theblock page
                                    jQuery('#auc-' + property_id + ' .tv-show-vm-b').remove();
                                }
                                //update color last bid
                                jQuery(".lastbid").addClass('current-bid-passedin');
                                // ADD Watermark Passed in (Stopped and not SOld)
                                jQuery('#img_mark_' + property_id).attr({src: '/modules/general/templates/images/passedin_list.png'}).css('display', 'block');
                                jQuery('#img_mark_detail_' + property_id).attr({src: '/modules/general/templates/images/passedin_detail.png'}).css('display', 'block');
                                jQuery('#img_mark_fix_' + property_id).attr({src: '/modules/general/templates/images/passedin_list.png'}).css('display', 'block');
                                jQuery('#mark').attr({src: '/modules/general/templates/images/passedin_detail.png'}).css('display', 'block');
                                //AddWatermark('','PassedIn',property_id);
                                if (self['bid_' + property_id]) self['bid_' + property_id]._options.time_obj.html('Passed In');
                                try {
                                    self['bid_' + property_id].stopTimer();
                                } catch (err) {
                                }
                                break;
                            case 'live_auction':

                                //SET INCREMENT FOR THE BLOCK:UPDATE NHUNG
                                if (typeof self['count_' + property_id] != 'undefined' && typeof JSONobject.data[property_id].min_increment != 'undefined') {
                                    //$('#min-incre-'+property_id).val(JSONobject.data[property_id].min_increment);
                                    //$('#max-incre-'+property_id).val(JSONobject.data[property_id].max_increment);
                                    //$('#frmInc_'+property_id+' [name=min-incre]').val(format_price(JSONobject.data[property_id].min_increment,'#min-incre-'+property_id));
                                    //$('#frmInc_'+property_id+' [name=max-incre]').val(format_price(JSONobject.data[property_id].max_increment,'#max-incre-'+property_id));
                                }
                                //END
                                // Update min max increment Mess
                                if (self['bid_' + property_id]._options.theblock && ( jQuery('#uniform-step_option').length > 0 || jQuery('#uniform-step_option_' + property_id).length > 0 )) {
                                    jQuery('#MinMax_mess_' + property_id).html(JSONobject.data[property_id].MinMax_mess);
                                    // Update Price Options
                                    var options = "";
                                    var i_ = 1;
                                    var id_op = '#step_option';
                                    var op_ = jQuery('#step_option1').val();
                                    if (typeof op_ == 'undefined' || op_ == null) {
                                        op_ = jQuery('#step_option1_' + property_id).val();
                                        id_op = '#step_option_' + property_id;
                                    }
                                    var ch = false;
                                    var min_ = "";
                                    var min_value = "";
                                    var bf_ar = [];
                                    var af_ar = [];
                                    for (var option in JSONobject.data[property_id].MinMax_options) {
                                        af_ar.push(option);
                                        if (i_ == 1) {
                                            min_ = option;
                                            min_value = JSONobject.data[property_id].MinMax_options[option];
                                        }
                                        if (op_ == option) {
                                            ch = true;
                                        }
                                        i_++;
                                        options = options + '<option value=\'' + option + '\'> ' + JSONobject.data[property_id].MinMax_options[option] + '</option>';
                                    }
                                    //
                                    jQuery('option', 'select' + id_op).each(function () {
                                        bf_ar.push(jQuery(this).val());
                                    });
                                    jQuery.fn.compare = function (t) {
                                        if (this.length != t.length) {
                                            return false;
                                        }
                                        var a = this.sort(),
                                            b = t.sort();
                                        for (var i = 0; t[i]; i++) {
                                            if (a[i] !== b[i]) {
                                                return false;
                                            }
                                        }
                                        return true;
                                    };
                                    if (options != "" && af_ar.length > 0 && bf_ar.length > 0 && !jQuery(af_ar).compare(bf_ar)) {
                                        jQuery('#step_option').html(options);
                                        jQuery('#step_option_' + property_id).html(options);
                                        if (!ch) {
                                            jQuery('#step_option').parent().children('span').html(min_value);
                                            jQuery('#step_option1').val(min_);
                                            jQuery('#step_option_' + property_id).parent().children('span').html(min_value);
                                            jQuery('#step_option1_' + property_id).val(min_);
                                        }
                                    }
                                }
                                // Forthcoming become to Live In Block
                                /*if (typeof JSONobject.data[property_id].set_count != 'undefined' && (self['bid_' + property_id]._options.theblock)){
                                 jQuery('#auc-time-' + property_id).html(JSONobject.data[property_id].set_count);
                                 }*/
                                //for confirm Bid
                                try {
                                    self["bid_" + property_id]._options.after_price = JSONobject.data[property_id].after_price;
                                }
                                catch (err) {
                                }
                                //BEGIN CALLBACK FOR GETBID BEFORE EVENT
                                if (JSONobject.data[property_id].bidder_id) {
                                    try {
                                        if (self['bid_' + property_id].getLastBidderId() != parseInt(JSONobject.data[property_id].bidder_id)
                                            || self['bid_' + property_id].getLastTime() != parseInt(JSONobject.data[property_id].last_time)) {
                                            //Update Bid history Data in Property Detail
                                            if (typeof updateBidHistory == 'function') {
                                                updateBidHistory('', property_id);
                                            }
                                            self['bid_' + property_id].setLastBidderId(parseInt(JSONobject.data[property_id].bidder_id));
                                            self['bid_' + property_id].setLastTime(JSONobject.data[property_id].last_time);
                                            //RESET TIME WHEN < 5 MINUTES
                                            self['time_' + property_id] = JSONobject.data[property_id].remain_time;
                                        } else {
                                            continue;
                                        }
                                    } catch (err) {
                                    }
                                    try {
                                        //BEGIN CALLBACK FOR GETBID AFTER EVENT
                                        if (self['bid_' + property_id]._options.callback_fnc['getBid_after'] && self['bid_' + property_id]._options.callback_fnc['getBid_after'].length > 0) {
                                            for (i = 0; i < self['bid_' + property_id]._options.callback_fnc['getBid_after'].length; i++) {
                                                self['bid_' + property_id]._options.callback_fnc['getBid_after'][i](JSONobject.data[property_id]);
                                            }
                                        }
                                    }
                                    catch (er) {
                                    }
                                    //END
                                }
                                break;
                            default:
                                break;
                        }
                    }// end no confirm sold
                    //console.log(property_id+'#add watermark_'+JSONobject.data[property_id].reaxml_status);
                    var reaxml_status = JSONobject.data[property_id].reaxml_status.replace(' ', '');
                    AddWatermarkReaXml('#img_mark_rea_xml_' + property_id, reaxml_status, property_id);
                }
            }
        }
    } catch (e) {
        //alert('Error:' + e.message);
    }
    self.locked = false;
}
function updateLastBidder() {
    //lastBidder();
    if (ape_enable) {
        if (!jQuery(ape_fire).is('div')) {
            jQuery('body').append('<div id="' + ape_fire.replace("#", "") + '"></div>');
        }
        if (ape_nick == '') ape_nick = new Date().getTime().toString();
        if (typeof self.client == 'object') return;
        try {
            var client = new APE.Client();
            self.client = client;
            client.load({'channel': 'getBidChannel'});
            client.addEvent('load', function () {
                if (client.core.options.restore) {
                    client.core.start();
                } else {
                    client.core.start({'name': ape_nick});
                }
            });
            client.addEvent('multiPipeCreate', function (pipe) {
                $(ape_fire).click(function () {
                    pipe.request.send('newBid', {'bid_data': JSON.stringify(ape_data)});
                });
            });
            client.onRaw('changeBid', function (params) {
                var data = decodeURIComponent(params.data.bid_data);
                eval('var rs=' + data);
                onLastBidder(rs);
            });
            client.onRaw('ERR', function (params) {
                var code = decodeURIComponent(params.data.code);
                var value = decodeURIComponent(params.data.value);
                if (code == '004') {
                    client.core.start({'name': ape_nick});
                }
            });
        } catch (e) {
        }
    } else {
        self['timer_global'] = setInterval('lastBidder()', 1000 * 2);
    }
}
function AddWatermark__() {
    self['timer_watermark'] = setInterval('watermark()', 1000);
}
function stopTimerGlobal() {
    clearInterval(self['timer_global']);
}
//END BID
//BEGIN ADVANCE SEARCH
var Search = function () {
    this._item = [];
    this._current = -1;
    this._total = 0;
    this._frm = '';
    this._text_search = '';
    this._text_obj_1 = '';
    this._text_obj_2 = '';
    this._success = null;
    this._overlay_container = '';
    this._url_suff = '';
    this._name_id = 'sitem_';
}
Search.prototype = {
    submit: function () {
        var validation = new Validation(this._frm);
        if (validation.isValid()) {
            jQuery('#is_submit', this._frm).val(1);
            jQuery(this._frm).submit();
            return true;
        }
        jQuery('#is_submit', this._frm).val(0);
        return false;
    },
    fromMap: function (code) {
        //document.location = '/?module=property&action=search&state_code='+code;
        document.location = '/view-search-advance.html&rs=1&state_code=' + code;
    },
    fromMapPartner: function (code) {
        //document.location = '/?module=property&action=search-partner&state_code='+code;
        document.location = '/search-partner.html&rs=1&state_code=' + code;
    },
    fromMapAgent: function (code) {
        //document.location = '/?module=property&action=search-agent&state_code='+code;
        document.location = '/search-agent.html&rs=1&state_code=' + code;
    },
    getData: function (obj) {
        var val = jQuery(obj).val();
        var url = '/modules/property/action.php?action=search';
        this._text_search = obj;
        if (this._url_suff.length > 0) {
            url = url + this._url_suff;
        }
        if (val.length > 0) {
            jQuery(obj).removeClass('search_loading').addClass('search_loading');
            if (this._success != null) {
                jQuery.post(url, {region: val}, this._success, 'html');
            } else {
                jQuery.post(url, {region: val}, this.onGetData, 'html');
            }
        }
    },
    onGetData: function (data) {
    },
    set2SearchText: function (obj) {
        jQuery(this._text_search).val(jQuery(obj).text());
    },
    //suburb
    setValue: function (obj) {
        var value = jQuery(obj).text();
        var word = value.split(" ");
        var l = word.length;
        jQuery(this._text_obj_2).val(word[l - 1]);
        var state = word[l - 2];
        var suburb = value.substring(0, value.indexOf(state));
        jQuery(this._text_search).val(suburb);
        var url = '/modules/property/action.php?action=search&type=region';
        jQuery.post(url, {region: state}, this._getValue);
        this.closeOverlay();
    },
//    moveKey:function(e){
//        var KeyID = (window.event) ? event.keyCode : e.keyCode;
//        alert(this._total);
//        switch (KeyID)
//        {
//            case 40://down
//				if (this._current < this._total) {
//					this._current++;
//				}
//			break;
//			case 38://up
//				if (this._current > 0) {
//					this._current--;
//				}
//
//			break;
//			case 13://enter
//                alert(this._name_id+this._current);
//			    this.setValue(this._name_id+this._current);
//			break;
//        }
//    },
    //end suburb
    moveByKey: function (e) {
        /*if (window.event) {
         e = window.event;
         }*/
        var keynum;
        if (window.event) // IE
        {
            keynum = e.keyCode;
        }
        else if (e.which) // Netscape/Firefox/Opera
        {
            keynum = e.which;
        }
        switch (keynum) {
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
                //alert(keynum);
                if (this._current < 0) {
//					jQuery('#is_submit',this._frm).val(1);
//					jQuery(this._frm).submit();
                    this.closeOverlay();
                    return true;
                } else {
                    var _tmp = jQuery('[id=' + this._name_id + this._current + ']').html();
                    if (this._text_obj_1 != '') {
                        this.setValue('#' + this._name_id + this._current);
                    } else {
                        jQuery(this._text_search).val(_tmp);
                    }
                    //this._current = -1;
                    this.closeOverlay();
                    //this.setValue('#'+this._name_id+this._current);
                    //jQuery('#suburb').val(_tmp);
                    //this.isSubmit();
                    return false;
                }
                //alert(keynum);
                //document.getElementById('frmSearch').submit();
                break;
            default:
                var up = this;
                var obj = e.target ? e.target : e.srcElement;
                var time_key_press = setTimeout(function () {
                    up.getData(obj);
                }, 3000);
                //console.log(jQuery(obj).data('time_key_press'));
                clearTimeout(jQuery(obj).data('time_key_press'));
                jQuery(obj).data('time_key_press', time_key_press);
                //this.getData(obj);
                break;
        }
        if (this._total > 0) {
            jQuery('[id^=' + this._name_id + ']').removeClass('search_move');
            jQuery('[id=' + this._name_id + this._current + ']').addClass('search_move');
            //div scroll
        }
    },
    keypress: function (e, obj) {
        var keynum;
        var keychar;
        var numcheck;
        if (window.event) // IE
        {
            keynum = e.keyCode;
        }
        else if (e.which) // Netscape/Firefox/Opera
        {
            keynum = e.which;
        }
        //keychar = String.fromCharCode(keynum);
        if (keynum == 13) {
            //alert(keynum);
            //document.getElementById('frmSearch').submit()
            var _tmp = jQuery('[id=' + this._name_id + this._current + ']').html();
            if (this._current < 0) {
                document.getElementById('frmSearch').submit();
            }
            else {
                this.closeOverlay();
                this.setValue('#' + this._name_id + this._current);
                //jQuery('#suburb').val(_tmp);
                jQuery(this._text_search).val(_tmp);
                //this.isSubmit();
                //document.getElementById('frmSearch').submit();
            }
        }
    },
    closeOverlay: function () {
        this._current = -1;
        jQuery(this._overlay_container).hide();
    },
    isSubmit: function () {
        if (jQuery('#is_submit', this._frm).val() == 1) {
            return true;
        } else {
            return false;
        }
    }
}
//END
//BEGIN SENDFRIEND
var SendFriend = function () {
    this.frm = '';//id of form (#frm)
    this.require = [];//required field list
    this.prepare = null;
    this.finish = null;
    this.type_send = 'html';
}
SendFriend.prototype = {
    clear: function (frm, require) {
        if (frm != undefined) {
            this.frm = frm;
        }
        if (require != undefined) {
            this.require = require;
        }
        for (i = 0; i < this.require.length; i++) {
            jQuery(this.frm + ' [name=' + this.require[i] + ']').val('');
        }
    },
    send: function (frm, url, require) {
        var validation = new Validation(frm);
        if (validation.isValid()) {
            this.frm = frm;
            this.require = require;
            if (this.prepare != null) {
                this.prepare();
            }
            var obj = {};
            for (i = 0; i < this.require.length; i++) {
                obj[this.require[i]] = jQuery(this.frm + ' [name=' + this.require[i] + ']').val();
            }
            if (this.finish != null) {
                jQuery.post(url, obj, this.finish, this.type_send);
            } else {
                jQuery.post(url, obj, this.onSend, this.type_send);
            }
        }
    },
    onSend: function (data) {
        var info = jQuery.parseJSON(data);
        if (info.success) {
            alert('success');
        } else {
            alert('failure');
        }
    }
}
//END
//BEGIN CONTACT
var Contact = function () {
    this.frm = '';//id of form (#frm)
    this.require = [];//required field list
    this.prepare = null;
    this.finish = null;
    this.type_send = 'html';
}
Contact.prototype = {
    clear: function (frm, require) {
        if (frm != undefined) {
            this.frm = frm;
        }
        if (require != undefined) {
            this.require = require;
        }
        for (i = 0; i < this.require.length; i++) {
            jQuery(this.frm + ' [name=' + this.require[i] + ']').val('');
        }
    },
    send: function (frm, url, require) {
        var validation = new Validation(frm);
        if (validation.isValid()) {
            this.frm = frm;
            this.require = require;
            if (this.prepare != null) {
                this.prepare();
            }
            var obj = {};
            for (i = 0; i < this.require.length; i++) {
                obj[this.require[i]] = jQuery(this.frm + ' [name=' + this.require[i] + ']').val();
            }
            if (this.finish != null) {
                jQuery.post(url, obj, this.finish, this.type_send);
            } else {
                jQuery.post(url, obj, this.onSend, this.type_send);
            }
        }
    },
    onSend: function (data) {
        var info = jQuery.parseJSON(data);
        if (info.success) {
            alert('success');
        } else {
            alert('failure');
        }
    }
}
//END
//BEGIN Bid History
var BidHistory = function () {
    this.prepare = null;
    this.finish = null;
    this.type_send = 'html';
}
BidHistory.prototype = {
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
        if (info.success) {
            alert('success');
        } else {
            alert('failure');
        }
    }
}
//END
//BEGIN LOGIN
var Log = function () {
    this.prepare = null;
    this.finish = null;
    this.content_type = 'html';
    this.data = null;
    this.frm = '';
}
Log.prototype = {
    clear: function (frm, require) {
        if (frm != undefined) {
            this.frm = frm;
        }
        if (require != undefined) {
            this.require = require;
        }
        for (i = 0; i < this.require.length; i++) {
            jQuery(this.frm + ' [name=' + this.require[i] + ']').val('');
        }
    },
    login: function (frm, url, re_url) {
        var validation = new Validation(frm);
        param = new Object();
        param.url = url;
        param.re_url = re_url
        if (validation.isValid()) {
            if (this.prepare != null) {
                this.prepare();
            }
            var _data = {};
            if (this.data != null) {
                _data = this.data;
            }
            if (this.finish != null) {
                jQuery.post(url, _data, this.finish, this.content_type);
            } else {
                jQuery.post(url, _data, this.onLogin, this.content_type);
            }
        }
    },
    onLogin: function (data) {
        var info = jQuery.parseJSON(data);
        if (info.success) {
            alert('success');
        } else {
            alert('failure');
        }
    }
}
//END LOGIN
//BEGIN NOTE
var Note = function () {
    this.frm = '';//id of form (#frm)
    this.require = [];//required field list
    this.prepare = null;
    this.finish = null;
    this.type_send = 'html';
}
Note.prototype = {
    clear: function (frm, require) {
        if (frm != undefined) {
            this.frm = frm;
        }
        if (require != undefined) {
            this.require = require;
        }
        for (i = 0; i < this.require.length; i++) {
            jQuery(this.frm + ' [name=' + this.require[i] + ']').val('');
        }
    },
    send: function (frm, url, require) {
        var validation = new Validation(frm);
        if (validation.isValid()) {
            this.frm = frm;
            this.require = require;
            if (this.prepare != null) {
                this.prepare();
            }
            var obj = {};
            for (i = 0; i < this.require.length; i++) {
                obj[this.require[i]] = jQuery(this.frm + ' [name=' + this.require[i] + ']').val();
            }
            if (this.finish != null) {
                $.post(url, obj, this.finish, this.type_send);
            } else {
                $.post(url, obj, this.onSend, this.type_send);
            }
        }
    },
    onSend: function (data) {
        var info = jQuery.parseJSON(data);
        if (info.success) {
            alert('success');
        } else {
            alert('failure');
        }
    },
    list: function (frm, url, require) {
        this.frm = frm;
        this.require = require;
        if (this.prepare != null) {
            this.prepare();
        }
        var obj = {};
        for (i = 0; i < this.require.length; i++) {
            obj[this.require[i]] = jQuery(this.frm + ' [name=' + this.require[i] + ']').val();
        }
        if (this.finish != null) {
            $.post(url, obj, this.finish, this.type_send);
        } else {
            $.post(url, obj, this.onList, this.type_send);
        }
    },
    onList: function (data) {
        var info = jQuery.parseJSON(data);
        if (info.success) {
            alert('success');
        } else {
            alert('failure');
        }
    },
    del: function (frm, url, require) {
        this.frm = frm;
        this.require = require;
        if (this.prepare != null) {
            this.prepare();
        }
        var obj = {};
        for (i = 0; i < this.require.length; i++) {
            obj[this.require[i]] = jQuery(this.frm + ' [name=' + this.require[i] + ']').val();
        }
        if (this.finish != null) {
            $.post(url, obj, this.finish, this.type_send);
        } else {
            $.post(url, obj, this.onDel, this.type_send);
        }
    },
    onDel: function (data) {
        var info = jQuery.parseJSON(data);
        if (info.success) {
            alert('success');
        } else {
            alert('failure');
        }
    }
}
//END NOTE
var CountDown = function () {
    this.container = '',
        this.bid_button = null,
        this.timer = null,
        this.property_id = 0,
        this.button = null,
        this.stop = false,
        this.popup_type = '',
        this.reloadBidReport = '',
        this.reloadNoMoreReport = '',
        this.reloadRegisterBid = '',
        this.stepp = ''
};
CountDown.prototype = {
    showPopup: function (type_popup) {

        //switch_tabs($('#count_popup_'+this.property_id+' .defaulttab'));
        //$('#count_popup_'+this.property_id).show();
        showLoadingPopup();
        var url = '/modules/general/action.php?action=loadCountDown&type_popup=' + type_popup;
        self['bid_' + this.property_id]._options.showPopup = false;
        $.post(url, {id: this.property_id}, function (data) {
            $('#countdown_popup_child').html(data);
            Cufon.replace('#countdown_popup_child .title h2');
            closeLoadingPopup();
            countDown_popup.show().toCenterXY(0, 10);
        }, 'html');
    },
    sold: function () {
        this.close();
    },
    reset: function () {
        jQuery('#' + this.container).removeClass('bid-focus');
        this.close();
    },
    step: function (step) {
        self['confirm_nh'].flushCallback();
        self['confirm_nh'].property_id = this.property_id;
        this.stepp = step;
        if (step == 'passedin') {
            showConfirm('Click Passed In means you stop the auction, no sell & no way back. Please confirm that you\'re happy to close this auction?',
                '',
                '',
                'ok/cancel');
            self['confirm_nh'].addFunc(function () {
                self['count_' + self['confirm_nh'].property_id].onStep(self['count_' + self['confirm_nh'].property_id].stepp, self['confirm_nh'].property_id);
            });
        } else if (step == 'sold') {
            showConfirm('Click Sold means you stop the auction, sell this property & no way back. Please confirm !',
                '',
                '',
                'ok/cancel');
            self['confirm_nh'].addFunc(function () {
                self['count_' + self['confirm_nh'].property_id].onStep(self['count_' + self['confirm_nh'].property_id].stepp, self['confirm_nh'].property_id);
            });
        } else {
            this.onStep(step, this.property_id);
        }
    },
    onStep: function (step, property_id) {
        var url = '/modules/general/action.php?action=setCount';
        $.post(url, {step: step, property_id: property_id}, function (data) {
            var result = jQuery.parseJSON(data);
            if (result.success) {
                if (result.step == 3) {
                    jQuery('#' + self['count_' + result.property_id].container).css('font-size', '21px !important');
                } else if (result.step != 1 && result.step != 2) {
                    //self['count_'+result.property_id].reset();
                }
            }
            if (result.error) {
                showMess(result.msg, '', false);
            }
        }, 'html');
    },
    close: function () {
        var property_id = this.property_id;
        self['bid_' + this.property_id].addCallbackFnc('bid_before', function (obj) {
            if (jQuery('#step_option1').length > 0) {
                return {money_step: jQuery('#step_option1').val()}
            } else {
                return {money_step: jQuery('#step_option1_' + property_id).val()}
            }
        });
        self['bid_' + this.property_id]._options.showPopup = true;
        clearInterval(this.reloadBidReport);
        clearInterval(this.reloadNoMoreReport);
        clearInterval(this.reloadRegisterBid);
        $(".tipsy").remove();
        jQuery(countDown_popup.container).fadeOut('slow', function () {
            countDown_popup.hide()
        });
        //$('#count_popup_'+this.property_id).fadeOut('slow',function(){$('#count_popup_'+this.property_id).hide()});
    },
    setIncrement: function (frm) {
        var that = this;
        var url = '/modules/property/action.php?action=set-incre';
        par = new Object();
        ibb.processCallbackFnc({'key': 'set_increment_before'});
        $.post(url, {
                'min-incre': $('#min-incre-' + this.property_id, frm).val()
                , 'max-incre': $('#max-incre-' + this.property_id, frm).val()
                , 'property_id': this.property_id
            },
            function (data) {
                var result = jQuery.parseJSON(data);
                if (result.success) {
                    if (result.msg) {
                        $('#msg_inc_' + that.property_id).show();
                        $('#msg_inc_' + that.property_id).html(result.msg);
                    }
                    var step_val = self['calc'].toValid(jQuery('#popup_step_option_' + that.property_id).val());
                    var min_val = self['calc'].toValid($('#min-incre-' + that.property_id, frm).val());
                    var max_val = self['calc'].toValid($('#max-incre-' + that.property_id, frm).val());
                    if (step_val < min_val) {
                        jQuery('#popup_step_option_' + that.property_id).val(calc.toPrice(min_val));
                    }
                    if (step_val > max_val && max_val != '') {
                        jQuery('#popup_step_option_' + that.property_id).val(calc.toPrice(max_val));
                    }
                    ibb.processCallbackFnc({'key': 'set_increment_receive_data'});
                }
            });
    },
    resetIncrement: function () {
        /*$('#price_inc_default_'+this.property_id).val();
         $('#min-incre-'+this.property_id).val(0);*/
        ibb.processCallbackFnc({'key': 'reset_increment_before'});
        $('#frmInc_' + this.property_id + ' [name=max-incre]').val("");
        $('#frmInc_' + this.property_id + ' [name=min-incre]').val($('#price_inc_default_' + this.property_id).val());
        /*this.setIncrement('#frmInc_'+this.property_id);*/
        var frm = '#frmInc_' + this.property_id;
        var self = this;
        var url = '/modules/property/action.php?action=set-incre';
        par = new Object();
        $.post(url, {
                'min-incre': $('#inc_default_' + this.property_id).val()
                , 'max-incre': 0
                , 'property_id': this.property_id, 'is_reset': 1
            },
            function (data) {
                var result = jQuery.parseJSON(data);
                if (result.success) {
                    if (result.msg) {
                        $('#msg_inc_' + self.property_id).show();
                        $('#msg_inc_' + self.property_id).html(result.msg);
                    }
                }
                ibb.processCallbackFnc({'key': 'reset_increment_receive_data'});
            });
    }
};
function AddWatermarkReaXml(img_id, watermark, property_id) {
    if (typeof watermark != 'undefined' && watermark.length > 0) {
        if (jQuery(img_id).length > 0) {
        } else if(property_id > 0) {
            //add img watermark
            if (jQuery('#img_mark_rea_xml_' + property_id, '.img-big-watermark-' + property_id + ' a').length == 0) {
                var img = '<img id="img_mark_rea_xml_' + property_id + '" alt="Watermark" src="" class="img-watermark img-watermark-rea-xml" />';
                jQuery('.img-big-watermark-' + property_id + ' a').append(img);
            }
            if (jQuery('#img_mark_rea_xml_' + property_id, '.auction-media #slider .flex-viewport').length == 0) {
                var img = '<img id="img_mark_rea_xml_' + property_id + '" alt="Watermark" src="" class="img-watermark img-watermark-rea-xml" />';
                jQuery('.auction-media #slider .flex-viewport').append(img);
            }
            img_id = '#img_mark_rea_xml_' + property_id;
        }
        jQuery(img_id).show();
        jQuery(img_id).attr('src', '/modules/general/templates/images/watermark_' + watermark + '.png');
        jQuery(img_id).addClass('watermark-' + watermark);
    }
}
function AddWatermark(img_id, watermark, property_id) {
    return true;
    if (typeof watermark != 'undefined' && watermark.length > 0) {
        if (jQuery(img_id).length > 0) {
        } else {
            //add img watermark
            if (property_id.length > 0 && jQuery('.img-watermark', '.pro-item-' + property_id + ' .img-big-watermark').length == 0) {
                var img = '<img id="img_mark_' + property_id + '" alt="Watermark" src="" class="img-watermark" />';
                jQuery('.pro-item-' + property_id + ' .img-big-watermark a').append(img);
            }
            img_id = '#img_mark_' + property_id;
        }
        jQuery(img_id).css('display', 'block');
        /*console.log(img_id);console.log(watermark);*/
        switch (watermark) {
            case 'OnTheMarket':
                jQuery(img_id).attr('src', '../modules/general/templates/images/onthemarket_list.png');
                jQuery(img_id).addClass('watermark-top-left');
                break;
            case 'OnTheMarket_detail':
                jQuery(img_id).attr('src', '../modules/general/templates/images/onthemarket_detail.png');
                break;
            case 'Sold':
                jQuery(img_id).attr({src: '../modules/general/templates/images/SOLD.png'});
                break;
            case 'Rent':
                jQuery(img_id).attr({src: '../modules/general/templates/images/RENT.png'});
                break;
            case 'Sold_detail':
                jQuery(img_id).attr({src: '../modules/general/templates/images/sold_detail.png'});
                break;
            case 'Rent_detail':
                jQuery(img_id).attr({src: '../modules/general/templates/images/rent_detail.png'});
                break;
            case 'WaitForActivation':
                jQuery(img_id).attr('src', '../modules/general/templates/images/wait-for-activation.png');
                break;
            case 'NotComplete':
                jQuery(img_id).attr('src', '../modules/general/templates/images/nopayment.png');
                break;
            case 'PassedIn':
                jQuery(img_id).attr('src', '../modules/general/templates/images/passedin_list.png');
                break;
            case 'PassedIn_detail':
                jQuery(img_id).attr('src', '../modules/general/templates/images/passedin_detail.png');
                break;
            default :
        }
    }
}
function PaymentBid(id, type) {
    var args = new Object();
    args.property_id = id;
    args.mime = 0;
    args.func = 'PaymentBid';
    jQuery.post('/modules/general/action.php?action=bid', args, function (data) {
            json = jQuery.parseJSON(data);
            if (json.login) {
                if (json.isBlock) {
                    showLoginPopup_block();
                }
                else {
                    showLoginPopup();
                }
            } else if (json.error == 1) {
                if (json.term == 1) {
                    term.showPopup(json.id);
                } else if (json.redirect != null) {
                    document.location = json.redirect;
                }
                else {
                    showMess(json.msg, '', false);
                }
            }
        }
        , 'html');
    //document.location = ROOTURL + '/?module=payment&action=option&type=bid&item_id=' + id;
}
var user_log_popup = new Popup();
function showUserLogPopup(content){
    user_log_popup.removeChild();
    user_log_popup.init({id:'user_log_popup',className:'popup_overlay'});
    user_log_popup.updateContainer('<div class="popup_container" style="width:100%;max-width: 305px;height: auto;min-height: 100px;"><div id="user_log_popup-wrapper">\
			 <div class="title"><h2>User Login<span id="btnclosex" class="btn-x" onclick="closeUserLogPopup()">Close X</span></h2> </div>\
			 <div class="clearthis" style="clear:both;"></div>\
			 <div class="content" style="width:95%">\
				<form name="frmLoginPopup" id="frmLoginPopup" onsubmit="return false;" method="post">\
                    <div id="login_msg" class="login-msg-all"></div>\
                    <div class="div-login-msg"></div>\
				    <div class="input-box">\
				        <label for="subject"><strong id="notify_email">Email<span >*</span></strong></label><br/>\
				        <input type="text" name="email" id="email" value="" class="input-text validate-email" style="width:94%" onKeyUp="handlerLoginPopup(event)"/>\
				    </div>\
				    <div class="input-box">\
				        <label for="subject"><strong id="notify_password">Password<span >*</span></strong></label><br/>\
				        <input type="password" name="password" id="password" value="" class="input-text validate-require" style="width:94%" onKeyUp="handlerLoginPopup(event)"/>\
				    </div>\
				</form>\
				<p>\
				    <button class="btn-submit" onClick="clickLoginPopup()"><span><span>SUBMIT</span></span></button><br/><br/>\
				    <span class="question">Not registered? </span><a id="link_reg_now" style="font-weight: bold" href="' + ROOTURL + '/?module=agent&action=register-buyer&step=1&kind=transact">Register now</a>\
				    <div id="login_loading" style="display:none;position:absolute"><img src="/modules/general/templates/images/loading.gif" style="height:30px;" alt="" /></div>\
				</p>\
			</div>\
             </div></div></div></div>');
    user_log_popup.show().toCenter();
}
function closeUserLogPopup(){
    user_log_popup.hide();
}
function registerToTransact(id, type) {
    showLoadingPopup();
    var url = ROOTURL + '/modules/general/action.php?action=registerToTransact';
    jQuery.post(url, {property_id: id, type: type}, function (data) {
        closeLoadingPopup();
        var result = jQuery.parseJSON(data);
        if (result.success) {
            if(!result.hasLogIn){
                login_cls.callback_fnc = function(){
                    document.location = result.redirect_link_logged;
                };
                //showLoginPopup();
                showUserLogPopup();
            }else{
                document.location = result.redirect_link; 
            }    
        } else {
            showMess__(result.message);
        }
    }, 'html');
}
