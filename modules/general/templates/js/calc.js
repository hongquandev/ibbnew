var Calc = function () {
	this.inc = 0;
	this.total = 0;
	this.maxLimit = 0;
	this.maxLimitMsg = 'Money price is not larger than {1}.';
	this.boardScan = '';
	this.boardManualScan = '';
	
	this.targetCurrent = '';
	this.valueCurrent = 0;
	this.targetAr = [];
	this.targetObj = new Object();
	this.callBackAr = [];
	this.currentBtnLabel = '';
	if (arguments[0].boardScan) {
		this.boardScan = arguments[0].boardScan;
	}

	if (arguments[0].boardManualScan) {
		this.boardManualScan = arguments[0].boardManualScan;
	}

	if (arguments[0].maxLimit) {
		this.maxLimit = this.toValid(arguments[0].maxLimit);
	}
}

Calc.prototype = {
	init : function () {
		calcParent = this;
		
		jQuery(calcParent.boardScan).click(function() {
			switch (this.title) {
				case '+':
					/*
					var total = calcParent.toValid(calcParent.targetObj[calcParent.targetCurrent]) + calcParent.toValid(calcParent.inc);
					if (calcParent.maxLimit == 0 || calcParent.maxLimit >= total) {
						calcParent.targetObj[calcParent.targetCurrent] = total;
						jQuery(calcParent.targetCurrent).val(calcParent.toPrice(total));
					} else if (calcParent.maxLimit < total) {
						calcParent.processCallbackFnc({'key' : 'maxLimit', 'data' : calcParent.maxLimitMsg.replace('{1}', calcParent.toPrice(calcParent.maxLimit))});						
					}
					*/
				break;
				case 'bid':
					calcParent.resetInfo();
					calcParent.processCallbackFnc({'key' : 'bid'});					
				break;
				default:
					if (parseInt(this.title) < 0) 
						return;
					calcParent.inc = calcParent.toValid(this.title);
					var total = calcParent.toValid(calcParent.targetObj[calcParent.targetCurrent]) + calcParent.toValid(calcParent.inc);
					if (calcParent.maxLimit == 0 || calcParent.maxLimit >= total) {
						calcParent.targetObj[calcParent.targetCurrent] = total;
						jQuery(calcParent.targetCurrent).val(calcParent.toPrice(total));
					} else if (calcParent.maxLimit < total) {
						calcParent.processCallbackFnc({'key' : 'maxLimit', 'data' : calcParent.maxLimitMsg.replace('{1}', calcParent.toPrice(calcParent.maxLimit))});						
					}
					
				break;
				case 'reset':
					calcParent.resetInfo();
					calcParent.processCallbackFnc({'key' : 'reset'});					
				break;
			}
			calcParent.currentBtnLabel = this.title;
		});
		
		jQuery(calcParent.boardManualScan).click(function() {
			switch (this.title) {
				case 'delete':
					calcParent.deleteInfo();
					calcParent.processCallbackFnc({'key' : 'delete'});					
				break;
				default:
					if (parseInt(this.title) < 0) 
						return ;
					var value = '';
					var totalLabel = value.concat(calcParent.targetObj[calcParent.targetCurrent]);
					if (totalLabel == '0') {
						totalLabel = '';
					}
					calcParent.inc = calcParent.toValid(this.title);
					
					if (calcParent.currentBtnLabel == '+') {
						totalLabel = calcParent.toValid(totalLabel) + calcParent.inc;
					} else {
						totalLabel = value.concat(totalLabel , calcParent.inc);
					}
					var total = calcParent.toValid(totalLabel);
					
					if (calcParent.maxLimit == 0 || calcParent.maxLimit >= total) {
						calcParent.targetObj[calcParent.targetCurrent] = total;
						jQuery(calcParent.targetCurrent).val(calcParent.toPrice(calcParent.targetObj[calcParent.targetCurrent]));
					} else if (calcParent.maxLimit < total) {
						calcParent.processCallbackFnc({'key' : 'maxLimit', 'data' : calcParent.maxLimitMsg.replace('{1}', calcParent.toPrice(calcParent.maxLimit))});						
					}
				break;
			}
			calcParent.currentBtnLabel = this.title;
		});	
		
	},
	
	setupTarget : function () {
		if (arguments[0]) {
			calcParent.targetAr = arguments[0];
			if (calcParent.targetAr.length > 0) {
				for (var i in calcParent.targetAr) {
					if (jQuery(calcParent.targetAr[i]).length > 0){
                        jQuery(calcParent.targetAr[i]).bind('focus',function() {
                            calcParent.targetCurrent = '#' + this.id;
                            calcParent.targetObj[calcParent.targetCurrent] = calcParent.valueCurrent = calcParent.toValid(jQuery(this).val());
                        });

                        jQuery(calcParent.targetAr[i]).keyup(function() {
                            if(jQuery(this).val() == "$$"){ jQuery(this).val(""); return true; }
                            var price = calcParent.toValid(jQuery(this).val());
                            if (calcParent.maxLimit == 0 || calcParent.maxLimit >= price) {
                                calcParent.targetObj[calcParent.targetCurrent] = calcParent.valueCurrent = price;
                                jQuery(this).val(calcParent.toPrice(price));
                            } else {
                                if (calcParent.valueCurrent > 0) {
                                    jQuery(this).val(calcParent.toPrice(calcParent.valueCurrent));
                                }else{
                                    jQuery(this).val(calcParent.toPrice(0));
                                }
                                calcParent.processCallbackFnc({'key' : 'maxLimit', 'data' : calcParent.maxLimitMsg.replace('{1}', calcParent.toPrice(calcParent.maxLimit))});
                            }
                        });

					    calcParent.targetObj[calcParent.targetAr[i]] = 0;
                    }
				}
			}
			
			calcParent.targetCurrent = calcParent.targetAr[0];
			calcParent.targetObj[calcParent.targetCurrent] = calcParent.valueCurrent = calcParent.toValid(jQuery(calcParent.targetCurrent).val());
		}
	},
	
	updateNextPrice : function (fnc, time) {
		setInterval(fnc, time);
	},
	
	addCallbackFnc : function (key, fnc) {
		if (!calcParent.callBackAr[key]) {
			calcParent.callBackAr[key] = [];
		}
		calcParent.callBackAr[key].push(fnc);
	},
	
	delCallbackFnc : function () {
		if (arguments[0]) {
			if (calcParent.callBackAr[key]) 
				calcParent.callBackAr[key] = [];
		} else {
			calcParent.callBackAr = [];
		}
	},
	
	processCallbackFnc : function () {
		if (arguments[0] && arguments[0].key ) {
			if (calcParent.callBackAr[arguments[0].key] != null && calcParent.callBackAr[arguments[0].key].length > 0) {
				for (var i in calcParent.callBackAr[arguments[0].key]) {
					if (!(i >= 0)) continue;
					if (arguments[0].data !== 'undefined') {
						calcParent.callBackAr[arguments[0].key][i](arguments[0].data);
					} else {
						calcParent.callBackAr[arguments[0].key][i]();
					}
				}
			}			
		}
	},
	
	resetInfo : function () {
		//calcParent.inc = 0;
		calcParent.targetObj[calcParent.targetCurrent] = 0;
		jQuery(calcParent.targetCurrent).val('');
	},
	
	deleteInfo : function () {
		var val = this.toValid(jQuery(calcParent.targetCurrent).val());
		val = Math.floor( val/ 10);
		calcParent.targetObj[calcParent.targetCurrent] = val;
		jQuery(calcParent.targetCurrent).val(this.toPrice(val));
	},
	
	toPrice : function (price) {
        //if(price == "$$"){return "";}
		return formatCurrency(price);
	},
	
	toValid: function (value) {
		if (value == undefined) return 0;
        if (value == "$$"){ return "$$";}
		value = value.toString().replace(new RegExp(/[^\d+]/g), '');
		if (value.length == 0) {
			value = 0;
		}

		return parseInt(value);
	}
}