var Property = function() {
	this.country_obj = null;
	this.effect_id = '';
	this.effect_obj = null;
	this.delay_send_friend = '';
	this.callback_func  = [];
	this.pass = false;
}

Property.prototype = {
	
	gotoStep:function(url) {
		document.location = url;
	},
	
	isSubmit:function(form) {
		var _val = jQuery('#is_submit',form).val();
		if (_val == 1) {
			return true;
		}
		return false;
	},
	
	submit:function(form,track) {
		//input:frm='#frmProperty'

		var validation = new Validation(form);
		var ok = true;
		if (this.callback_func['valid'] && this.callback_func['valid'].length > 0) {
			for (i = 0; i < this.callback_func['valid'].length ;i++) {
				if (this.callback_func['valid'][i]() == false) {
					ok = false;
					//break;
				}
			}
		}
		
		if (ok && validation.isValid()) {
			if (track == true) {
				jQuery(form+' [name=track]').val('1');
			}
			jQuery('#is_submit',form).val(1);
			jQuery(form).submit();
			return true;
		}
		jQuery('#is_submit',form).val(0);
		return false;
	},
	
	addCallbackFnc: function(key, fnc) {
		if (!this.callback_func[key]) {
			this.callback_func[key] = [];
		}
		this.callback_func[key].push(fnc);
	},
	
	flushCallback: function() {
		this.callback_func = [];
	},
	
	//BEGIN WATCHLIST
	
	addWatchlist: function(url) {
		jQuery.post(url,{},this.onAddWatchlist,'html');	
	},
	
	onAddWatchlist: function(data) {
		var result = jQuery.parseJSON(data);
		var data = '';
		if (result.success) {
			data = result.success;
			//alert(result.success);
		} else {
			//alert(result.error);
			data = result.error;
		}
		showMess(data);
	},
	
	//BEGIN MAKE AN OFFER
	
	openMakeAnOffer: function(popup_id, property_id) {
		jQuery('#mao_loading_'+property_id).hide();
		jQuery(popup_id).show();
	},
	
	closeMakeAnOffer: function(popup_id) {
		jQuery(popup_id).hide();
	},
	
	makeAnOffer: function(form_id, property_id, popup_id) {
		var url = '/modules/property/action.php?action=make_an_offer';
		var validation = new Validation(form_id);
		if (validation.isValid()) {
			var agent_email = jQuery(form_id+' #agent_email').val();
			var agent_id = jQuery(form_id+' #agent_id').val();
			var content = jQuery(form_id+' #content').val();
			
			jQuery('#mao_loading_'+property_id).show();
			$.post(url,{property_id:property_id, agent_email: agent_email, agent_id: agent_id, content:content, popup_id:popup_id},this.onMakeAnOffer,'html');	
			return true;
		}
	},
	
	onMakeAnOffer: function(data) {
		var result = jQuery.parseJSON(data);
		
		if (result.property_id) {
			jQuery('#mao_loading_'+result.property_id).hide();
		}
		
		if (result.error) {
			showMess(result.error);
		}
		
		if (result.popup_id) {
			//Property.closeMakeAnOffer(result.popup_id);
			jQuery(result.popup_id).hide();
		}
	},
	
	// BEGIN AUTO BID
	
	openAutoBidForm: function(popup_id, property_id) {
		jQuery('#autobid_msg').hide();
		jQuery('#abs_loading_'+property_id).hide();
		jQuery(popup_id).show();
	},
	
	closeAutoBidForm: function(popup_id) {
		jQuery(popup_id).hide();
	},
	
	regAutoBid: function(form_id,property_id,popup_id) {
		
		self['property_cls_'+property_id] = this;
		
		var url = '/modules/property/action.php?action=auto_bid';
		jQuery('#autobid_msg').hide();
		
		
		var is_autobid = jQuery(form_id+' #is_autobid').val();
		if (is_autobid == 1) {//is auto bid, goto REFUSE
			jQuery('#abs_loading_'+property_id).show();
			$.post(url,{property_id:property_id, 
				   		accept: 0 , 
						form_id:form_id},this.onRegAutoBid,'html');	
			
		} else {//is not auto bid, goto ACCEPT
			
			var validation = new Validation(form_id);
			if (validation.isValid()) {
				var agent_auction_step = jQuery(form_id+' #agent_auction_step').val();
				var agent_maximum_bid = jQuery(form_id+' #agent_maximum_bid').val();
				
				jQuery('#abs_loading_'+property_id).show();
				$.post(url,{property_id:property_id, 
					   		agent_auction_step: agent_auction_step, 
							agent_maximum_bid: agent_maximum_bid, 
							accept:1, 
							form_id:form_id},this.onRegAutoBid,'html');	
				return true;
			}
		}
	},
	
	onRegAutoBid: function(data) {
		var output = jQuery.parseJSON(data);
		
		if (output.property_id) {
			jQuery('#abs_loading_'+output.property_id).hide();
		}
		
		if (output.msg) {
			jQuery('#autobid_msg').html(output.msg);
			jQuery('#autobid_msg').show();
		}
		
		if (output.success == 1) {
			if (typeof output.accept != 'undefined') {
				jQuery(output.form_id+' #is_autobid').val(parseInt(output.accept));
			}
			
			if (output.label) {
				jQuery('#reg_autobid_btn').html(output.label);
			}
		}
		
		//BEGIN CALL CALLBACK FUNCTION
		var property_id = output.property_id;
		if (self['property_cls_'+property_id] && self['property_cls_'+property_id].callback_func['reg_auto_bid_before'] && self['property_cls_'+property_id].callback_func['reg_auto_bid_before'].length > 0) {
			for (i = 0; i < self['property_cls_'+property_id].callback_func['reg_auto_bid_before'].length; i++) {
				self['property_cls_'+property_id].callback_func['reg_auto_bid_before'][i](output);
			}
		}
		//END
	},
	
	listenerAutoBid: function(form_id, property_id, bid_obj) {
		if (jQuery(form_id+' #is_autobid').val() == 1) {
			bid_obj.bid(property_id);
		}
	},
	//BEGIN SEND FRIEND
	
	popupSendFriend:function(url, property_url, obj) {
		
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
		div.innerHTML = '<input type="button" value="x" id="btnprox" onclick="Property.delPopupSendFriend(\''+id+'\')"/><label>Email:</label><input type="text" name="email" id="email"/><input type="button" value="Send" onclick="Property.sendFriend(\''+url+'\',\''+property_url+'\',\''+id+'\')"/>';
		
		
		gosPopup.show('#'+id);
		
		var pos = jQuery(obj).position();
		div.style.left = pos.left+'px';
		div.style.top = pos.top+'px';
	},
	
	delPopupSendFriend:function(id) {
		gosPopup.hide('#'+id);
		document.body.removeChild(document.getElementById(id));
	},
	
	sendFriend:function(url,property_url,id) {
		var email = jQuery('#'+id+' input[name=email]').val();
		if (jQuery.trim(email).length > 0) {
			$.post(url,{property_url:property_url,email:email},Property.onSendFriend,'html');	
			return true;
		}
		showMess('Please input email.');
	},
	
	onSendFriend:function(data) {
		var result = jQuery.parseJSON(data);
		if (result.success) {
			Property.delPopupSendFriend(Property.delay_send_friend);
			alert(result.success);
		} else {
			alert(result.error);
		}
	},
	
	//BEGIN DOCUMENT
	
	downDoc:function(url) {
		document.location = url;
		//$.post(url,{},Property.onDownDoc,'html');	
	},
	
	onDownDoc:function(data) {
		
	},
	
	//BEGIN STATUS
	
	status: function(property_id,target) {
		url = '/modules/property/action.php?action=status-property';
		$.post(url,{property_id:property_id,target:target},this.onStatus,'html');	
	},
	
	onStatus: function(data) {
		var json = jQuery.parseJSON(data);
		if (json.target.length > 0) {
			jQuery('#'+json.target).html(json.msg);
		}
	}
}



var ImageShow = function(container,total,child) {
	this.container = container;
	this.total = total;
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
	prev : function() {
		if (this.current > 1) {
			this.current--;
			jQuery('#'+this.container+' div img').each(function() {
				jQuery(this).hide();	
			});
			
			jQuery('#'+this.container+' div #'+this.child+'_'+this.current).show();
			
			jQuery('#'+this.container+' div.toolbar-img span.img-num').text(this.current+'/'+this.total);
		}
		
			
	},
	
	next : function() {
		if (this.current < this.total) {
			this.current++;
			jQuery('#'+this.container+' div img').each(function() {
			jQuery(this).hide();	
			});
			
			jQuery('#'+this.container+' div #'+this.child+'_'+this.current).show();
			
			jQuery('#'+this.container+' div.toolbar-img span.img-num').text(this.current+'/'+this.total);
		}
		
		
	}	
}


//BEGIN BIDHISTORY
	var bh_popup = new Popup();
	var bidhistory = new BidHistory();
	
	bidhistory.prepare = function() {
	
	};
	
	bidhistory.finish = function(data){
		var info = jQuery.parseJSON(data);
		jQuery('#bh_container').html(info);
		//jQuery(bh_popup.container).fadeOut('slow',function(){bh_popup.hide()});									
	}
	
	
	
	bh_popup.init({id:'pro_popup',className:'popup_overlay'});
	
	bh_popup.updateContainer('<div class="popup_container" style="width:600px;"><div id="contact-wrapper">\
					 <div class="title"><h2> Auction / Bid history <span id="btnclosex" onclick="bh_popup.hide()">x</span></h2></div>\
					 <div class="content" style="width:94%;max-height:400px" id="bh_container">\
					 </div></div></div>');	
					 
					 
	function showBidHistory(property_id) {
		bh_popup.show().toCenter();
		bidhistory.send('/modules/general/action.php?action=bid_history&property_id='+property_id);
	}
	
//END BIDHISTORY


//BEGIN SENDFRIEND
	var sendfriend = new SendFriend();
	var sendfriend_popup = new Popup();
	
	//BEGIN SENDFRIEND						
	sendfriend_data = ['property_id','email_from','email_to','message']; 
	
	sendfriend.prepare = function() {
		jQuery('#sendfriend_loading').show();
	};
	
	sendfriend.finish = function(data) {
		var info = jQuery.parseJSON(data);
		if (info.success) {
			
		} else {
			
		}
		jQuery('#sendfriend_loading').hide();
		sendfriend.clear('#frmSendfriend',['email_to','message']);//clear data from SendFriend form
		jQuery(sendfriend_popup.container).fadeOut('slow',function(){sendfriend_popup.hide()});
	};
	
	//END
	sendfriend_popup.init({id:'send_popup',className:'popup_overlay'});
	
	sendfriend_popup.updateContainer('<div class="popup_container" style="width:400px"><div id="contact-wrapper">\
			<div class="title"><h2> Send to a friend <span id="btnclosex" onclick="closeSendfriend()">x</span></h2></div>\
			<div class="content" style="width:94%">\
				<form name="frmSendfriend" id="frmSendfriend">\
				<input type="hidden" name="property_id" id="property_id" value=""/>\
				<div class="input-box">\
				  <label for="subject"><strong id="notify_email_from">Email from <span >*</span></strong></label><br/>\
				  <input type="text" name="email_from" id="email_from" value="" class="input-text validate-email" style="width:100%"/>\
				</div>\
				<div class="input-box">\
				  <label for="subject"><strong id="notify_email_to">Email to <span >*</span></strong></label><br/>\
				  <input type="text" name="email_to" id="email_to" value="" class="input-text validate-email" style="width:100%"/>\
				</div>\
				<div class="input-box">\
					<label for="subject"><strong id="notify_message">Message <span >*</span></strong></label><br/>\
					<textarea rows="5" cols="30" name="message" id="message" class="input-text validate-require" style="width:100%;"></textarea></div></form><button class="btn-red" name="submit" onClick="sendfriend.send(\'#frmSendfriend\',\'/modules/property/action.php?action=share-sendfriend\',sendfriend_data)"><span><span>Submit</span></span></button><div id="sendfriend_loading" style="display:inline;position:absolute"><img src="/modules/general/templates/images/loading.gif" style="height:30px;"/></div></div></div></div></div>');
	
	function showSendfriend(property_id, email) {
		sendfriend_popup.show().toCenter();
		jQuery('#sendfriend_loading').hide();
		jQuery('#frmSendfriend [name=property_id]').val(property_id);
		jQuery('#frmSendfriend [name=email_from]').val(email);
	}
	
	function closeSendfriend() {
		jQuery('#sendfriend_loading').hide();
		sendfriend.clear('#frmSendfriend',['email_to','message']);
		jQuery(sendfriend_popup.container).fadeOut('slow',function(){sendfriend_popup.hide()});
	}
	

//END SENDFRIEND


//BEGIN CONTACT VENDOR
	var contact = new Contact();
	var contact_popup = new Popup();
	
	//BEGIN CONTACT						
	
	var contact_data = ['agent_id_to','email_to','agent_id_from','contactname','subject','email','telephone','message']; 
	
	contact.prepare = function() {
		jQuery('#contact_loading').show();
	};
	
	contact.finish = function(data) {
		var info = jQuery.parseJSON(data);
		if (info.success) {
		
		} else {
		
		}
		jQuery('#contact_loading').hide();
		contact.clear('#frmContact',['message']);//clear data from Contact form
		jQuery(contact_popup.container).fadeOut('slow',function(){contact_popup.hide()});
	}
	
	//END
	
	contact_popup.init({id:'contact_popup',className:'popup_overlay'});
	
	contact_popup.updateContainer('<div class="popup_container" style="width:450px"><div id="contact-wrapper">\
			 <div class="title"><h2 id="txtt"> Contact Information <span id="btnclosex" onclick="closeContact()">x</span></h2> </div>\
			 <div class="content" style="width:94%">\
				<form name="frmContact" id="frmContact">\
				<input type="hidden" name="agent_id_to" id="agent_id_to" value=""/>\
				<input type="hidden" name="email_to" id="email_to" value=""/>\
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
					<textarea rows="5" cols="30" name="message" id="message" class="input-text validate-require" style="width:100%;"></textarea></div></form><div><button class="btn-red" name="submit" onClick="contact.send(\'#frmContact\',\'/modules/property/action.php?action=contact\',contact_data)"><span><span>Submit</span></span></button><div id="contact_loading" style="display:inline;position:absolute"><img src="/modules/general/templates/images/loading.gif" style="height:30px;"/></div></div></div></div>');
	
	function showContact(agent_id_from, contactname, email, telephone, agent_id_to,email_to) {
		contact_popup.show().toCenter();
		jQuery('#contact_loading').hide();
		jQuery('#frmContact [name=agent_id_from]').val(agent_id_from);
		jQuery('#frmContact [name=contactname]').val(contactname);
		jQuery('#frmContact [name=email]').val(email);
		jQuery('#frmContact [name=telephone]').val(telephone);
		
		jQuery('#frmContact [name=agent_id_to]').val(agent_id_to);
		jQuery('#frmContact [name=email_to]').val(email_to);
	}
	
	function closeContact() {
		jQuery('#contact_loading').hide();
		contact.clear('#frmContact',['message']);
		jQuery(contact_popup.container).fadeOut('slow',function(){contact_popup.hide()});
	}
	
//END CONTACT VENDOR

//VIEW MORE 

	
	var PropertyViewMore = function() {
		this.prepare = null;
		this.finish = null;
		this.type_send = 'html';
	}
	
	PropertyViewMore.prototype = {
		send: function(url) {
			if (this.prepare != null) {
				this.prepare();
			}
			
			if (this.finish != null) {
				jQuery.post(url,{},this.finish,this.type_send);
			} else {
				jQuery.post(url,{},this.onSend,this.type_send);
			}
		}
		
		,onSend: function(data) {
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
	
	//sendfriend_data = ['property_id','email_from','email_to','message']; 
	
	pvm.prepare = function() {
		jQuery('#pvm_loading').show();
	};
	
	pvm.finish = function(data) {
		var info = jQuery.parseJSON(data);
		if (info.data) {
			jQuery('#pvm-right').html(info.data);
		} else {
			alert('failure');
		}
		jQuery('#pvm_loading').hide();
		//pvm.clear('#frmPVM',['email_to','message']);//clear data from SendFriend form
		//jQuery(pvm_popup.container).fadeOut('slow',function(){pvm_popup.hide()});
	};
	
	//END
	/*
	pvm_popup.init({id:'pvm_popup',className:'popup_overlay'});
	
	pvm_popup.updateContainer('<div class="popup_container" style="width:400px"></div>');
	*/
	function showPVM(property_id, email) {
		pvm_popup.show().toCenter();
		jQuery('#pvm_loading').hide();
		
		jQuery('#frmPVM [name=property_id]').val(property_id);
		jQuery('#frmPVM [name=email_from]').val(email);
	}
	
	function closePVM() {
		jQuery('#pvm_loading').hide();
		//pvm.clear('#frmPVM',['email_to','message']);
		jQuery(pvm_popup.container).fadeOut('slow',function(){pvm_popup.hide()});
	}
//END VIEW MORE LAN


//BEGIN MESSAGE LAN

	var mess_popup = new Popup();

	mess_popup.init({id:'mess_popup',className:'popup_overlay'});
	
	
	mess_popup.updateContainer('<div class="popup_container" style="width:356px;height: 122px;"><div id="contact-wrapper">\
			 <div class="title"><h2 id="txtt"> That page at Inspect Bid Buy says:<span id="btnclosex" onclick="closeMess()">x</span></h2> </div>\
			 <div class="clearthis" style="clear:both;"></div>\
			  <div class="content content-po" id="msg"></div>\
			  <button class="btn-red btn-red-mess-po" onclick="closeMess()"><span><span>OK</span></span></button>\
			  </div></div></div>');
	
	function showMess(error_to_from) {
		mess_popup.show().toCenter();
		jQuery('#msg').html(error_to_from);
	}
	
	function closeMess() {
		jQuery(mess_popup.container).fadeOut('slow',function(){mess_popup.hide()});
	}
	
//END MESSAGE LAN

//BEGIN MAKE AN OFFER
//END