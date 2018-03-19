var abc = new Popup();

	abc.init({id:'abc_popup',className:'popup_overlay'});

	function openabc(error_to_from) {

        mess_popup.updateContainer('<div class="popup_container" style="width:300px;height: 122px;min-height: 120px;"><div id="contact-wrapper">\
			 <div class="title"><h2 id="txtt"> That page at bidRhino says:<span id="btnclosex" onclick="closeMess()">x</span></h2> </div>\
			 <div class="clearthis" style="clear:both;"></div>\
			  <div class="content content-po" id="msg">\
                <img src="/modules/property/templates/images/alert.png"></img>\
                <span>'+error_to_from+'</span></div>\
			  <button class="btn-red btn-red-mess-po" onclick="closeabc()"><span><span>OK</span></span></button>\
			  </div></div></div>');
        abc.show().toCenter();
	}

	function closeabc() {
		jQuery(abc.container).fadeOut('slow',function(){abc.hide()});
	}