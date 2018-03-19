var ProposeIncrement = function () {
	this.submitBtn = '';
	this.setBtn = '';
	this.resetBtn = '';
	
	this.requireTxt = '';
	this.incTxt = '';
	this.maxTxt = '';
	
	this.propertyId = 0;
	this.fromId = 0;
	this.isShowed = false;
	this.callBackObjAr = [];
	this.callBackAr = [];
	
	if (arguments[0].submitBtn) {
		this.submitBtn = arguments[0].submitBtn;
	}
	
	if (arguments[0].setBtn) {
		this.setBtn = arguments[0].setBtn;
	}

	if (arguments[0].resetBtn) {
		this.resetBtn = arguments[0].resetBtn;
	}

	if (arguments[0].acceptBtn) {
		this.acceptBtn = arguments[0].acceptBtn;
	}

	if (arguments[0].refuseBtn) {
		this.refuseBtn = arguments[0].refuseBtn;
	}

	if (arguments[0].requireTxt) {
		this.requireTxt = arguments[0].requireTxt;
	}

	if (arguments[0].incTxt) {
		this.incTxt = arguments[0].incTxt;
	}

	if (arguments[0].maxTxt) {
		this.maxTxt = arguments[0].maxTxt;
	}
	
	if (arguments[0].propertyId) {
		this.propertyId = arguments[0].propertyId;
	}

	if (arguments[0].fromId) {
		this.fromId = arguments[0].fromId;
	}
}

ProposeIncrement.prototype = {
	
	init : function () {
		proposeIncParent = this;
		
		jQuery(this.submitBtn).click(function() {
			proposeIncParent.require();								  
		});
	},
	
	addCallbackFnc : function (key, fnc) {
		if (!proposeIncParent.callBackAr[key]) {
			proposeIncParent.callBackAr[key] = [];
		}
		proposeIncParent.callBackAr[key].push(fnc);
	},
	
	delCallbackFnc : function () {
		if (arguments[0]) {
			if (proposeIncParent.callBackAr[key]) 
				proposeIncParent.callBackAr[key] = [];
		} else {
			proposeIncParent.callBackAr = [];
		}
	},
	
	processCallbackFnc : function () {
		if (arguments[0] && arguments[0].key ) {
			if (proposeIncParent.callBackAr[arguments[0].key] != null && proposeIncParent.callBackAr[arguments[0].key].length > 0) {
				for (var i in proposeIncParent.callBackAr[arguments[0].key]) {
					if (!(i >= 0)) continue;
					if (arguments[0].data !== 'undefined') {
						proposeIncParent.callBackAr[arguments[0].key][i](arguments[0].data);						
					} else {
						proposeIncParent.callBackAr[arguments[0].key][i]();
					}
				}
			}			
		}
	},
	
	require : function () {
		proposeIncParent.processCallbackFnc({'key' : 'propose_require_before'});
		var args = new Object();
		args.amount = jQuery(proposeIncParent.requireTxt).val();
		args.property_id = proposeIncParent.propertyId;
		args.from_id = proposeIncParent.fromId;
		jQuery.post('/modules/general/action.php?action=propose_require', args, this.onRequire, 'html');	
	},
	
	onRequire : function (data) {
		data = jQuery.parseJSON(data);
		proposeIncParent.processCallbackFnc({'key' : 'propose_require_after', 'data' : data});
	},
	
	accept : function () {
		proposeIncParent.processCallbackFnc({'key' : 'propose_accept_before'});		
		var args = new Object();
		args.from_id = this.fromId;
		args.to_id = this.toId;		
		args.property_id = this.propertyId;
		jQuery.post('/modules/general/action.php?action=propose_accept', args, this.onAccept, 'html');	
	},
	
	onAccept : function (data) {
		data = jQuery.parseJSON(data);
		proposeIncParent.processCallbackFnc({'key' : 'propose_accept_after', 'data' : data});
	},

	refuse : function () {
		proposeIncParent.processCallbackFnc({'key' : 'propose_refuse_before'});
		var args = new Object();
		args.from_id = this.fromId;
		args.to_id = this.toId;		
		args.property_id = this.propertyId;
		jQuery.post('/modules/general/action.php?action=propose_refuse', args, this.onRefuse, 'html');	
	},
	
	onRefuse : function (data) {
		data = jQuery.parseJSON(data);
		proposeIncParent.processCallbackFnc({'key' : 'propose_refuse_after', 'data' : data});			
	},
	
	finish : function () {
		proposeIncParent.processCallbackFnc({'key' : 'propose_finish_before'});
		var args = new Object();
		args.from_id = 0;
		args.to_id = 0;
		args.property_id = 0;
		
		if (arguments[0]) {
			if (arguments[0].fromId) {
				args.from_id = arguments[0].fromId;
			}

			if (arguments[0].toId) {
				args.to_id = arguments[0].toId;
			}

			if (arguments[0].propertyId) {
				args.property_id = arguments[0].propertyId;
			}
		}
		
		jQuery.post('/modules/general/action.php?action=propose_finish', args, this.onFinish, 'html');	
	},
	
	onFinish : function (data) {
		data = jQuery.parseJSON(data);
		proposeIncParent.processCallbackFnc({'key' : 'propose_finish_after', 'data' : data});			
	}
}