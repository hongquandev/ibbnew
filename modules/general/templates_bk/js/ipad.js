var iPad = function () {
	this.targetRef = '';
	this.targetAr = [];
	this.callBackAr = [];
	if (arguments[0].targetRef) {
		this.targetRef = arguments[0].targetRef;
	}
}

iPad.prototype = {
	init : function () {
		iPadParent = this;
	},
	
	setupTarget : function () {
		if (arguments[0]) {
			iPadParent.targetAr = arguments[0];
			if (iPadParent.targetAr.length > 0) {
				for (var i in iPadParent.targetAr) {
					jQuery(iPadParent.targetAr[i]).focus(function() {
						iPadParent.processCallbackFnc({'key' : 'focus_before'});										  
						iPadParent.setTargetRef('focus');
						iPadParent.processCallbackFnc({'key' : 'focus_after'});
					});
					
					jQuery(iPadParent.targetAr[i]).keyup(function() {
						iPadParent.processCallbackFnc({'key' : 'keyup_before'});
						iPadParent.setTargetRef('keyup');
						iPadParent.processCallbackFnc({'key' : 'keyup_after'});
					});

					jQuery(iPadParent.targetAr[i]).keydown(function() {
						iPadParent.processCallbackFnc({'key' : 'keydown_before'});
						iPadParent.setTargetRef('keydown');
						iPadParent.processCallbackFnc({'key' : 'keydown_after'});
					});

					jQuery(iPadParent.targetAr[i]).keypress(function() {
						iPadParent.processCallbackFnc({'key' : 'keypress_before'});
						iPadParent.setTargetRef('keypress');
						iPadParent.processCallbackFnc({'key' : 'keypress_after'});
					});
					
					jQuery(iPadParent.targetAr[i]).click(function() {
						iPadParent.processCallbackFnc({'key' : 'click_before'});
						iPadParent.setTargetRef('click');
						iPadParent.processCallbackFnc({'key' : 'click_after'});
					});
					
					jQuery(iPadParent.targetAr[i]).dblclick(function() {
						iPadParent.processCallbackFnc({'key' : 'dblclick_before'});											 
						iPadParent.setTargetRef('dblclick');
						iPadParent.processCallbackFnc({'key' : 'dblclick_after'});
					});
				}
			}
		}
	},
	
	setTargetRef : function (eventName) {
		jQuery(iPadParent.targetRef).focus();
	},
	
	addCallbackFnc : function (key, fnc) {
		if (!iPadParent.callBackAr[key]) {
			iPadParent.callBackAr[key] = [];
		}
		iPadParent.callBackAr[key].push(fnc);
	},
	
	delCallbackFnc : function () {
		if (arguments[0]) {
			if (iPadParent.callBackAr[key]) 
				iPadParent.callBackAr[key] = [];
		} else {
			iPadParent.callBackAr = [];
		}
	},
	
	processCallbackFnc : function () {return ;
		if (arguments[0] && arguments[0].key ) {
			if (iPadParent.callBackAr[arguments[0].key] != null && iPadParent.callBackAr[arguments[0].key].length > 0) {
				for (var i in iPadParent.callBackAr[arguments[0].key]) {
					if (!(i >= 0)) continue;
					if (arguments[0].data !== 'undefined') {
						iPadParent.callBackAr[arguments[0].key][i](arguments[0].data);
					} else {
						iPadParent.callBackAr[arguments[0].key][i]();
					}
				}
			}			
		}
	}
}