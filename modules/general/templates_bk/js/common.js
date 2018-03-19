//BEGIN FOR LOGIN
function SubmitLogin()
    {
        var us_def = 'email';
        var pw_def = 'password';
        var frm = document.getElementById('frmLogin');
        var username = jQuery('#username',frm).val();
        var password = jQuery('#password',frm).val();
        var param = new Object();
        param.email = username;
        param.password = password;
        var URL = ROOTURL2 +'/index.php?module=agent& action=log';
        if(username.length > 0 && password.length > 0 && username != us_def && password != pw_def){
            $.post(URL,param,function(result){},'html');
            frm.submit();
            return true;
        }else{
            var forgot = ROOTURL +'/?module=agent& action=forgot';
            showMess('\
            <div style="display:inline;clear: both;">Please enter your email address and password</div>\
            <div style="display:block;clear: both;"><a style="color: #CC8C04;" href="'+forgot+'" >\
            Forgot password?</a></div>');
            return false;
        }
    }
var Common = {
	country_obj:null,
	effect_id:'',
	effect_obj:null,
    effect_obj_1:null,
    effect_obj_2:null,
    form_obj:null,
	
	changeCountry:function(url, obj, effect_id){
		if (jQuery(obj).val() > 0) {
			this.country_obj = obj;
			this.effect_id = effect_id;
			jQuery.post(url,{country_id:jQuery(obj).val()},this.onChangeCountry,'html');		
		}
	},
	
	onChangeCountry:function(data){
		var json = jQuery.parseJSON(data);
		
		if (json.error == 0) {
			form_select.removeAll(Common.effect_id);
			
			/*
			if (json.data.length > 0) {
				for (i in json.data) {
					if (parseInt(i) >= 0) {
						form_select.add(Common.effect_id,{'value':i,'text':json.data[i]})
					}
				}
			}
			*/
			//alert(json.data.length);
			if (json.data.length > 0) {
				for (var i = 0; i < json.data.length; i++ ) {
					if (parseInt(json.data[i].id) >= 0) {
						if (i == 0) {
							jQuery('#uniform-' + Common.effect_id + ' > span').html(json.data[i].name);							
						}
						form_select.add(Common.effect_id,{'value':json.data[i].id,'text':json.data[i].name})
					}
				}
			}
		} else {
			alert('error');
		}
	},
	
	existEmail:function(url,obj,agent_id){
		var value = jQuery(obj).val();
		this.effect_obj = obj;
		if (value.length > 0) {
			jQuery.post(url,{email:value,agent_id:agent_id},this.onExistEmail,'html');
		}
	},
	
	onExistEmail:function(data){
		var JSONobject = jQuery.parseJSON(data);
		if(JSONobject.error==0){
			if(JSONobject.num_rows>0){
				//showMess('This mail existed!');
				var validation = new Validation('');
				validation.showErrorSign(Common.effect_obj);
			}else{
                if (typeof Common.effect_obj == 'object') {
                    jQuery(Common.effect_obj).css({"border":"1px solid #bfbfbf","color":""});
                } else {//string
                    Common.warningObject(Common.effect_obj,true);
                }

			}
		}else{
			alert('error');
		}
	},
    validRegion:function(url,suburb,state,postcode,form,country){
        //alert(suburb);
        if(country != null)
        {
            if(jQuery(country).val() != 1) // Not valid for Other Country : Quan
            {
                return true;
            }
        }
        Common.effect_obj = suburb;
        Common.effect_obj_1 = state;
        Common.effect_obj_2 = postcode;
        this.form_id = form;
        var region = $.trim(jQuery(suburb).val())+" "+$.trim(jQuery(state).val())+" "+$.trim(jQuery(postcode).val());
        jQuery.post(url,{region:region},this.onValidRegion);
    },
    onValidRegion:function(result){
        //alert('onValid');
		
      var info = jQuery.parseJSON(result);
        //alert(Common.effect_obj);
        if (info.value == ''){
           //var validation = new Validation(Common.form_id);
           //alert(validation.form_id);
//           validation.showErrorSign(Common.effect_obj);
//           validation.showErrorSign(Common.effect_obj_1);
//           validation.showErrorSign(Common.effect_obj_2);
            
           Common.warningObject(Common.effect_obj);
           Common.warningObject(Common.effect_obj_1);
           Common.warningObject(Common.effect_obj_2);
           jQuery('#message').val('Wrong suburb/postcode or state!');
		}
        else {
           Common.warningObject(Common.effect_obj,true);
           Common.warningObject(Common.effect_obj_1,true);
           Common.warningObject(Common.effect_obj_2,true);
        }

    },

	
	checkAll:function(obj, child_name) {
		var checked = jQuery(obj).attr('checked');
		jQuery('input[name^='+child_name+']').each(function(){
			jQuery(this).attr('checked',checked);
		});
		
		jQuery('input[name^='+jQuery(obj).attr('name')+']').each(function(){
			jQuery(this).attr('checked',checked);
		})
	},
	
	emptyValues: function(frm, type, require) {
		//type = name | id
		for (i = 0; i < require.length; i++ ) {
			if (typeof require[i] == 'object') {
				jQuery(frm+' ['+type+'='+require[i].key+']').val(require[i].value);	
			} else {
				jQuery(frm+' ['+type+'='+require[i]+']').val('');	
			}
		}
	},
	
	checkPriceRange: function(id_price,id_begin,id_end) {
		var msg = '';
		var max_def = 'etc';
		var price = parseInt(jQuery(id_price).val());
		var begin = jQuery(id_begin).val();
		var end = jQuery(id_end).val();
		
		if (end != max_def && begin > end) {
			msg = '"begin price" is must less than "end price"';
			this.warningObject(id_begin);
			this.warningObject(id_end);
		}
		
		if (begin > price) {
			msg = '"begin price" is must less than "price"';
			this.warningObject(id_price);
			this.warningObject(id_begin);
		}
		
		if (end != max_def && price > end) {
			msg = '"price" is must less than "end price"';
			this.warningObject(id_price);
			this.warningObject(id_end);
		}
		
		
		
		if (msg.length > 0) {
			alert(msg);
			return false;
		}
		return true;
	},
	
	warningObject : function(id_obj,turnoff) {
        //alert(id_obj);
        if(typeof id_obj == 'string')
        {
            id_notify = '#notify_' + id_obj.replace('#','');
            if (turnoff == true) {//
                jQuery(id_obj).css({"border":"1px solid #bfbfbf","color":""});

                if (notify = jQuery(id_notify)) {
                    jQuery(notify).css({"color":""});
                }

            } else { //red color
                jQuery(id_obj).css({"border":"1px dashed #ff0000","color":"#ff0000"});

                if (notify = jQuery(id_notify)) {
                    jQuery(notify).css({"color":"#ff0000"});
                }

            }
        }
	},
	
	del: function(msg,url) {
//		if (confirm('Do you really want to delete ?')) {
//			//document.location = url;
//			this.redirect(url);
//		}
        showConfirm(msg,url);
	},
	
	redirect: function(url) {
		document.location = url;
	},
    checkSub:function(){
        var url = '/modules/general/action.php?action=check-sub';
        $.post(url,{},function(data){
              var result = jQuery.parseJSON(data);
              if (result.error == 1){
                  showLoadingPopup();
                  check_sub.showPopup(result.data);
              }
        });
    },
    remindPayment:function(){
        var url = '/modules/general/action.php?action=remind-payment';
        $.post(url,{psite:psite},function(data){
              var result = jQuery.parseJSON(data);
              if(result == null || typeof result == 'undefined'){
                  return true;
              }
              if (result.error == 1){
                  showLoadingPopup();
                  remind_payment.redirect = result.redirect?result.redirect:'';
                  remind_payment.showPopup(result.data);
              }
        });
    }
}





//BEGIN POPUP
var Popup = function() {
	this.id = '';
	this.child_id = '';
    this.child_name = '';
	this.popup = null;
	this.container = null;
	//this.content = '';
};

Popup.prototype = {
	init: function(o) {
            var div = document.createElement('div');

            if (o.id) {
                div.id = this.id = o.id;
            } else {
                var time = new Date().getTime();
                div.id = this.id = 'popup_'+time;
            }

                //alert('opened');
                this.child_id = div.id+'_child';
                this.child_name = this.child_id;
                if (o.className) {
                    div.className = o.className;
                } else {
                    div.className = 'popup_overlay';
                }
                this.popup = div;
                //alert(o.id);
                //alert(jQuery('#'+o.id).length);
                jQuery('body').append(div);

            return this;

	},
	
	show: function() {

        jQuery(this.popup).show();
		jQuery(this.popup).css({width : jQuery(document.body).width(), height : jQuery(document.body).height()});
		//console.log(this.container);
		if (this.container != null) {
			jQuery(this.container).show();
			this._toCenter(this.container,jQuery('#'+this.id+' div.content'));
		}
		return this;
	},
	
	hide: function() {
		jQuery(this.popup).hide();
		if (this.container != null) {
			jQuery(this.container).hide();
		}
		return this;
	},
	
	_toCenter: function(obj1,obj2) {
		var top = parseInt(jQuery(obj1).scrollTop());
		var left = parseInt(jQuery(obj1).scrollLeft());
		var box_x = parseInt(jQuery(obj2).width());
		var box_y = parseInt(jQuery(obj2).height());
		var center_x = parseInt(jQuery(obj1).width()) / 2 - box_x / 2 + left;
		var center_y = parseInt(jQuery(obj1).height()) / 2 - box_y / 2 + top;
        if(center_y <= 0 )
        {
            center_y = 0 + 10;
        }
		//set center to container
		jQuery(obj2).css({left:center_x+'px', top:center_y+'px'})
	},
    _toCenterXY: function(obj1,obj2,X,Y) {
        var top = parseInt(jQuery(obj1).scrollTop());
        var left = parseInt(jQuery(obj1).scrollLeft());
        var box_x = parseInt(jQuery(obj2).width());
        var box_y = parseInt(jQuery(obj2).height());
        var center_x = parseInt(jQuery(obj1).width()) / 2 - box_x / 2 + left;
        var center_y = parseInt(jQuery(obj1).height()) / 2 - box_y / 2 + top;
        if(center_y <= 0 )
        {
            center_y = 0;
        }
        //set center to container
        jQuery(obj2).css({left:center_x+ parseInt(X) +'px', top:center_y+ parseInt(Y) +'px'})
    },
	
	toXY: function(x, y) {
		jQuery(this.popup).css({left : x + 'px', top : y + 'px'});
		jQuery(this.container).css({left : x + 'px', top : y + 'px'});
		return this;
	},
	
	toCenter: function() {
		if (this.container != null) {
			this._toCenter(window,this.container);
		}
		return this;
	},

    toCenterXY: function(X,Y) {
        if (this.container != null) {
            this._toCenterXY(window,this.container,X,Y);
        }
        return this;
    },
	
	toElement: function(html) {
		var div = document.createElement('div');
		div.innerHTML = html;
		
		var element = div.firstChild;
		element.id = this.child_id;
		div.removeChild(element);
		return element;
	},
	
	updateContainer: function(content) {
		if (this.container == null) {
			//alert(content);
			if (typeof content == 'string') {
                   var parent = document.getElementsByTagName('body')[0];
                    if (parent.firstChild != null) {
					    parent.insertBefore(this.toElement(content),parent.firstChild);
                    } else {
                        parent.appendChild(this.toElement(content));
                    }
				//this.container = jQuery('body').children(':first');
				this.container = jQuery('#'+this.child_id);
			} else if (typeof content == 'object') {
				this.container = content;
			}
			//alert(this.container.html());
			//hide container
			jQuery(this.container).hide();
		} else{
            if ($(this.container).html() != content){
                jQuery(this.container).html(content);
            }

        }
        try{
            Cufon.replace('#txtt');
        }
        catch(err)
        {

        }
		return this;
	},
	
	removeChild: function() {
		if (this.container != null) {
			jQuery(this.container).remove();
			this.container = null;
		}
	}
};
//END
// BEGIN POPUP LOADING
var loading_popup = new Popup();
function showLoadingPopup(){
    loading_popup.removeChild();
    loading_popup.init({id:'loading_popup',className:'popup_overlay'});
    loading_popup.updateContainer('<div class="popup_container" style=""><img src="'+ ROOTURL +'/modules/general/templates/images/loading3.gif" style="" alt="" /></div>');
    loading_popup.show().toCenter();
}
function closeLoadingPopup(){
    loading_popup.hide();
}
// END

// BEGIN POPUP LOADING
var loading_popup2 = new Popup();
function showLoadingPopup2(){
    loading_popup2.removeChild();
    loading_popup2.init({id:'loading_popup',className:'popup_overlay'});
    loading_popup2.updateContainer('<div style="position:absolute;z-index: 999"><img src="'+ ROOTURL +'/modules/general/templates/images/loading2.gif" style="" alt="" /></div>');
    loading_popup2.show().toCenter();
}
function closeLoadingPopup2(){
    loading_popup2.hide();
}
// END

//BEGIN Select PLUGIN
var plugin = {};
var SelectPlugin = function (o) {
	this.opt = {};
    this.opt_ = {};
	if (o.defClassName) {
		this.opt.defClassName = o.defClassName;
	} else {
		this.opt.defClassName = 'text-box-uniform'; 
	}
	
	if (o.targetId) {
		this.opt.targetId = o.targetId;
	}
	if(o.money_step)
    {
        this.opt.money_step = o.money_step;
    }
    this.opt.disable_input = false;
    if(o.disable_input)
    {
        this.opt.disable_input = o.disable_input;
    }

	this.opt.blurClassName = this.opt.defClassName + '-blur';
	this.opt.focusClassName = this.opt.defClassName + '-focus';
	
	if (typeof this.opt.targetId == 'undefined') {
		alert('ERR (SelectPlugin): Error when init object');
	} else {
		this.opt.id = this.opt.targetId + '_txt';
		//CREATE OBJECT ABOVE TARGET
		jQuery('<input type = "text" name = "' + this.opt.id + '" id = "' + this.opt.id + '" class = "' + this.opt.defClassName + '">').insertBefore(jQuery('#' + this.opt.targetId));
        if(this.opt.disable_input)
        {
            jQuery('#' + this.opt.id ).hide();
        }
	}
	plugin = this.opt;
	this.callbackFnc = [];
}

SelectPlugin.prototype = {
    listener: function() {

        self['SelectPlugin_cls_' + this.opt.id] = this.opt;
        var this_ = this;
        var opt_ = this.opt;
        try{
        var obj = document.getElementById(this.opt.id);
        if (obj.addEventListener) {
            obj.addEventListener('blur', this.onBlur, true);
            obj.addEventListener('blur', this.onKeyUp, true);
            obj.addEventListener('focus', this.onFocus, true);
        } else if (obj.attachEvent) {
            obj.attachEvent('onblur', function(){this_.onBlur(opt_)});
            obj.attachEvent('onfocus',function(){this_.onFocus(opt_)});
        }
        }
        catch(er)
        {}

        //SET DEFAULT VALUE TO TXT
        jQuery('#' + this.opt.id).val(jQuery('#' + this.opt.targetId).val());
        jQuery('#uniform-' + this.opt.targetId + ' > span').html('$' + jQuery('#' + this.opt.targetId).val());

        //CHANGE VALUE WHEN ONCHANGE EVENT
        jQuery('#' + this.opt.targetId).change(function() {
            var _id = jQuery(this).attr('id');
            var _opt = self['SelectPlugin_cls_' + _id + '_txt'];
            jQuery('#' + _opt.id).val(jQuery(this).val());
        });
    },

    onBlur: function(opt) {
        var _opt = self['SelectPlugin_cls_' + jQuery(this).attr('id')];
        if(typeof _opt == 'undefined')
        {
            _opt = opt;
        }
        var price = jQuery('#' + _opt.id).val().replace('$','');
        price = parseInt(price.replace(new RegExp(/[^\d+]/g),''));

        if (price > 0) {
            if (price > 10000000000){
                showMess("Oops! You have a very big increment value per bid. Please choose another. Thanks you!");
                jQuery('#' + _opt.id).val(jQuery('#' + _opt.targetId).val());
                jQuery('#uniform-' + _opt.targetId + ' > span').html('$' + jQuery('#' + _opt.targetId).val());
            }else{
                //jQuery('#uniform-' + _opt.targetId + ' > span').html('$' + price);
                jQuery('#' + _opt.id).val(price);
            }
        } else {
            jQuery('#' + _opt.id).val(jQuery('#' + _opt.targetId).val());
            jQuery('#uniform-' + _opt.targetId + ' > span').html('$' + jQuery('#' + _opt.targetId).val());
        }
        jQuery('#' + _opt.id).removeClass(_opt.focusClassName).addClass(_opt.blurClassName);
        /*
         if (/(^\d+$)/.test(price)) {
         if (jQuery.trim(price).length > 0) {
         jQuery('#uniform-' + _opt.targetId + ' > span').html('$' + price);
         }
         jQuery('#' + _opt.id).removeClass(_opt.focusClassName).addClass(_opt.blurClassName);

         } else {
         //Common.warningObject('#' + _opt.targetId,true);
         //showMess('Please enter valid data (It only accepts digits.)');
         //jQuery('#' + _opt.id).val(jQuery('#' + _opt.targetId).val());
         price = price.replace(new RegExp(/[^\d+]/g),'');
         if (price > 0) {
         jQuery('#' + _opt.id).val(price);
         jQuery('#uniform-' + _opt.targetId + ' > span').html('$' + price);
         } else {
         jQuery('#' + _opt.id).val(jQuery('#' + _opt.targetId).val());
         }
         jQuery('#' + _opt.id).removeClass(_opt.focusClassName).addClass(_opt.blurClassName);
         }
         */
    },
    onKeyUp: function (opt)
    {

    },
    onFocus: function(opt) {
        var _opt = self['SelectPlugin_cls_' + jQuery(this).attr('id')];
        if(typeof _opt == 'undefined')
        {
            _opt = opt;
        }
        /*
         var price = jQuery('#uniform-' + _opt.targetId + ' > span').html();
         price = price.replace(new RegExp(/[^\d+]/g),'');
         jQuery('#' + _opt.id).val(price);
         */
        var price = jQuery.trim(jQuery('#' + _opt.id).val());
        price = price.replace(new RegExp(/[^\d+]/g),'');
        if (price.length == 0) {
            jQuery('#' + _opt.id).val(jQuery('#' + _opt.targetId).val());
        }
        jQuery('#' + _opt.id).removeClass(_opt.blurClassName).addClass(_opt.focusClassName);

    },

    flushCallbackFnc: function() {
        this.callbackFnc = [];
    },

    addCallbackFnc: function(key, fnc) {
        if (!this.callbackFnc[key]) {
            this.callbackFnc[key] = [];
        }
        this.callbackFnc[key].push(fnc);
    }
}
//END


function formatCurrency(num,cent) {
    num = num.toString().replace(/\$|\,/g,'');
    if(isNaN(num))
    num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num*100+0.50000000001);
    cents = num%100;
    num = Math.floor(num/100).toString();
    if(cents<10)
    cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
    num = num.substring(0,num.length-(4*i+3))+','+ num.substring(num.length-(4*i+3));
    if(cent != null)
    {
        return (((sign)?'':'-') + '$' + num + '.' + cents);
    }
    else
    {
        return (((sign)?'':'-') + '$' + num);
    }
    //return (((sign)?'':'-') + '$' + num + '.' + cents);
}
function format_price(num, id, form_id, cent) {
    if(typeof num == 'undefined'){return 0;}
    num.toString();
    var price = num;
    if(typeof num == 'string')
    {
        price = num;
        i = price.indexOf("$");
        price = price.substr(i + 1, price.length - i + 1);
        //format price
        var j = 0;
        for (j; j <= price.length; j++) {
            price = price.replace(",", "");
        }
    }
    if (formatCurrency(num) == '$0') price = 0;
    if (form_id == null) {
        jQuery(id).val(price);
    }else {
        jQuery(id, form_id).val(price);
    }
    if (cent != null) {
        return formatCurrency(num, cent);
    }else {
        return formatCurrency(num);
    }
}

function format_showprice(num, id, form_id, cent) {
    if(typeof num == 'undefined'){return 0;}
    var price = num;
    if(typeof num == 'string')
    {
        price = num;
        var i = price.indexOf("$");
        price = price.substr(i + 1, price.length - i + 1);
        //format price
        var j = 0;
        for (j; j <= price.length; j++) {
            price = price.replace(",", "");
        }
    }
    return price;
}

//BEGIN CHECK BASIC
var CheckBasic = function(){
    this.url_to = '';
    this.type = 'property';

}
CheckBasic.prototype = {
    regPro: function(url,type){
        var url1 = '/modules/general/action.php?action=check-basic';
        jQuery.post(url1,{link:url,type:type},this.onReg,'html');
    },
    onReg: function(data){
        var isBasic = jQuery.parseJSON(data);
	    if (isBasic.success) {
			var url = '/?module=agent&action=add-info';
            //showMess('Please complete your information before register a '+isBasic.type+' !',url);
            showMess('This is the first time you register '+isBasic.type+' on iBB. We need your full information before you can proceed.\
                      Please <a href="'+url+'" style="color:#980000;font-weight:bold;font-size:16px">Click Here</a> to complete. Thank you !','',false);
            return;
	    } else {
            var link_as = unescape(isBasic.url);
            //document.location= link_as;
            document.location=isBasic.url.replace(/&amp;/g,"&");
		}
    }
}

function insertAtText(areaId,text) {
    var txtarea = document.getElementById(areaId);
    var scrollPos = txtarea.scrollTop;
    var strPos = 0;
    var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ? "ff" : (document.selection ? "ie" : false ) );
    if (br == "ie")
    {
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart ('character', -txtarea.value.length);
        strPos = range.text.length;
    }
    else if (br == "ff") strPos = txtarea.selectionStart;
    var front = (txtarea.value).substring(0,strPos);
    var back = (txtarea.value).substring(strPos,txtarea.value.length);
    txtarea.value=front+text+back; strPos = strPos + text.length;
    if (br == "ie") { txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart ('character', -txtarea.value.length);
        range.moveStart ('character', strPos); range.moveEnd ('character', 0); range.select();
    } else if (br == "ff") {
        txtarea.selectionStart = strPos;
        txtarea.selectionEnd = strPos;
        txtarea.focus();
    } txtarea.scrollTop = scrollPos; 
}
/*
var Term = function(){
    this.property_id = 0;
};
*/

/*Term.prototype = {
    load:function(url){
        $.post(url,{},function(data){
           $('#popup_term').html(data);
        });
    },
    showPopup:function(id){
        this.property_id = id;
        term_popup.show().toCenter();
        this.load('/modules/general/action.php?action=loadTerm&id='+id);
    },
    closePopup:function(){
        jQuery(term_popup.container).fadeOut('slow',function(){term_popup.hide()});
    }
};
var term = new Term();
var term_popup = new Popup();

term_popup.init({id:'term_popup',className:'popup_overlay'});
term_popup.updateContainer('<div class="popup_container" style="width:500px;"><div id="popup_term"></div></div>');*/


function showMess__(error_to_from,url, show_ok_btn) {
    mess_popup = new Popup();
    me = mess_popup;
    frmurl = ''; //nh add, use when click OK then redirect to a url.
    mess_popup.init({id:'mess_popup', className:'popup_overlay'});
    if (url != null) {
        frmurl = url;
    }
    btn_str = '';
    forgot = ROOTURL + '/?module=agent&action=forgot';
    show_ok_btn = typeof(show_ok_btn) != 'undefined' ? show_ok_btn : true;
    if (show_ok_btn) {
        btn_str = '<button class="btn-red btn-red-mess-po" onclick="closeMess__(mess_popup,frmurl);"><span><span>OK</span></span></button>';
    }
    mess_popup.updateContainer('<div class="popup_container" style="width:356px;height:auto;min-height: 120px;">\
			 <div id="contact-wrapper"><div class="title"><h2 id="txtt">  This page says:<span id="btnclosex" onclick="closeMess__(mess_popup,frmurl)">x</span></h2> </div>\
			 <div class="clearthis" style="clear:both;"></div>\
			 <div class="content content-po" id="msg">\
             <img src="/modules/property/templates/images/alert.png" \>\
                <span>' + error_to_from + '</span></div>\
			  ' + btn_str + '\
			  </div></div></div>');
    mess_popup.show().toCenter();
}
function closeMess__(mess_popup,frmurl) {
    jQuery(mess_popup.container).fadeOut('slow',function(){mess_popup.hide()});
    if (frmurl != ''){
        Common.redirect(frmurl);
    }
}

function getBrowseriOS4(){
    var br = navigator.appVersion;
    return ( br.indexOf('CPU OS 4') > 0 );
}

var IBB = function () {
	this.callBackAr = [];	
}

IBB.prototype = {
	init : function () {
		ibbParent = this;
	},
	
	/*
	object.addCallbackFnc('propose_require_before', function() {
		//show waiting
	});
	*/
	
	addCallbackFnc : function (key, fnc) {
		if (!ibbParent.callBackAr[key]) {
			ibbParent.callBackAr[key] = [];
		}
		ibbParent.callBackAr[key].push(fnc);
	},

	/*
	object.delCallbackFnc({'key' : 'propose_require_before'});
	*/

	delCallbackFnc : function () {
		if (arguments[0]) {
			if (ibbParent.callBackAr[arguments[0].key]) 
				ibbParent.callBackAr[arguments[0].key] = [];
		} else {
			ibbParent.callBackAr = [];
		}
	},

	/*
	object.processCallbackFnc({'key' : 'record'});
	object.processCallbackFnc({'key' : 'maxLimit', 'data' : calcParent.maxLimitMsg.replace('{1}', calcParent.toPrice(calcParent.maxLimit))});		
	*/

	processCallbackFnc : function () {
		if (arguments[0] && arguments[0].key ) {
			if (ibbParent.callBackAr[arguments[0].key] != null && ibbParent.callBackAr[arguments[0].key].length > 0) {
				for (var i in ibbParent.callBackAr[arguments[0].key]) {
					if (!(i >= 0)) continue;
					if (arguments[0].data !== 'undefined') {
						ibbParent.callBackAr[arguments[0].key][i](arguments[0].data);						
					} else {
						ibbParent.callBackAr[arguments[0].key][i]();
					}
				}
			}			
		}
	}
}

var ibb = new IBB();
ibb.init();



