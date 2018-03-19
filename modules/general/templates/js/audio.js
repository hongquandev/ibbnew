var Audio = function () {
	this.callBackObjAr = [];
	this.callBackAr = [];
	this.currentBtnLabel = '';
	this.recordBtn = null;
	this.playBtn = null;
	if (arguments[0].recordBtn) {
		this.recordBtn = arguments[0].recordBtn;
	}

	if (arguments[0].playBtn) {
		this.playBtn = arguments[0].playBtn;
	}
}

Audio.prototype = {
	init : function () {
		audioParent = this;
		jQuery(audioParent.recordBtn).click(function() {
			audioParent.processCallbackFnc({'key' : 'record'});						 
		});
		
		jQuery(audioParent.playBtn).click(function() {
			audioParent.processCallbackFnc({'key' : 'play'});
		});
	},
	
	addCallbackFnc : function (key, fnc) {
		if (!audioParent.callBackAr[key]) {
			audioParent.callBackAr[key] = [];
		}
		audioParent.callBackAr[key].push(fnc);
	},
	
	delCallbackFnc : function () {
		if (arguments[0]) {
			if (audioParent.callBackAr[key]) 
				audioParent.callBackAr[key] = [];
		} else {
			audioParent.callBackAr = [];
		}
	},
	
	processCallbackFnc : function () {
		if (arguments[0] && arguments[0].key ) {
			if (audioParent.callBackAr[arguments[0].key] != null && audioParent.callBackAr[arguments[0].key].length > 0) {
				for (var i in audioParent.callBackAr[arguments[0].key]) {
					if (!(i >= 0)) continue;
					if (arguments[0].data !== 'undefined') {
						audioParent.callBackAr[arguments[0].key][i](arguments[0].data);
					} else {
						audioParent.callBackAr[arguments[0].key][i]();
					}
				}
			}			
		}
	}
}