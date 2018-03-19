var iAlert = function () {
	this.topLabel = 'This page says:';
	this.topTool = '';
	this.iconAlert = '<img src="/modules/property/templates/images/alert.png"></img>';
	this.msg = '';
	this.bottomTool = '';
	this.id = 'ialert_popup';
	this.className = 'popup_overlay';
	this.popupObj = null;
	this.callBackAr = [];
	this.isMove = false;
	
	if (!arguments[0]) return;
	
	if (arguments[0].id) {
		this.id = arguments[0].id;
	}
	
	if (arguments[0].topLabel) {
		this.topLabel = arguments[0].topLabel;
	}
	
	if (arguments[0].topTool) {
		this.topTool = arguments[0].topTool;
	}
	
	if (arguments[0].iconAlert) {
		this.iconAlert = arguments[0].iconAlert;
	}
	
	if (arguments[0].msg) {
		this.msg = arguments[0].msg;
	}
	
	if (arguments[0].bottomTool) {
		this.bottomTool = arguments[0].bottomTool;
	}
}

iAlert.prototype = {
	init : function () {
		iAlertParent = this;
		iAlertParent.popupObj = new Popup();
		iAlertParent.popupObj.init({id : iAlertParent.id, className : iAlertParent.className});
		var msg = iAlertParent.msg;	
		if (iAlertParent.iconAlert.length > 0) {
			msg = '<span>' + iAlertParent.msg + '</span>';
		}
        iAlertParent.popupObj.updateContainer('<div class="popup_container" style="width:356px;height:auto;min-height: 120px;">\
			<div id="contact-wrapper"><div class="title"><h2 id="txtt">' + iAlertParent.topLabel + iAlertParent.topTool + '</h2></div>\
				<div class="clearthis" style="clear:both;"></div>\
				<div class="content content-po" id="msg">' + iAlertParent.iconAlert + msg + '</div>\
				<div class="clearthis" style="clear:both; height:10px"></div>\
				<center>' + iAlertParent.bottomTool + '</center>\
				<div class="clearthis" style="clear:both; height:10px"></div>\
			</div>\
			</div>');
	},
	
	addCallbackFnc : function (key, fnc) {
		if (!iAlertParent.callBackAr[key]) {
			iAlertParent.callBackAr[key] = [];
		}
		iAlertParent.callBackAr[key].push(fnc);
	},
	
	delCallbackFnc : function () {
		if (arguments[0]) {
			if (iAlertParent.callBackAr[key]) 
				iAlertParent.callBackAr[key] = [];
		} else {
			iAlertParent.callBackAr = [];
		}
	},
	
	processCallbackFnc : function () {
		if (arguments[0] && arguments[0].key ) {
			if (iAlertParent.callBackAr[arguments[0].key] != null && iAlertParent.callBackAr[arguments[0].key].length > 0) {
				for (var i in iAlertParent.callBackAr[arguments[0].key]) {
					if (!(i >= 0)) continue;
					if (arguments[0].data !== 'undefined') {
						iAlertParent.callBackAr[arguments[0].key][i](arguments[0].data);
					} else {
						iAlertParent.callBackAr[arguments[0].key][i]();
					}
				}
			}			
		}
	},	
	
	show : function () {
		iAlertParent.processCallbackFnc({'key' : 'show_begin'});
		if (this.isMove) {
			iAlertParent.popupObj.toXY(0, 0).toCenter();			
		} else {
			iAlertParent.popupObj.show().toCenter();
		}
		iAlertParent.processCallbackFnc({'key' : 'show_end'});
	},
	
	hide : function () {
		iAlertParent.processCallbackFnc({'key' : 'hide_begin'});
		/*
		jQuery(iAlertParent.popupObj.container).fadeOut('slow',function() {
			iAlertParent.popupObj.hide();
			iAlertParent.processCallbackFnc({'key' : 'hide_in'});
		});
		*/
		iAlertParent.processCallbackFnc({'key' : 'hide_in'});
		iAlertParent.popupObj.toXY('-5000', '-5000');
		iAlertParent.processCallbackFnc({'key' : 'hide_end'});
		this.isMove = true;
	}
	
}