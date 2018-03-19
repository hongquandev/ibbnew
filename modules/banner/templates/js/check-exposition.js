//BEGIN SHOW POPUP CUSTOMIZE
var Customize = function() {
	
}
	 var customize = new Customize();
	 var customize_popup = new Popup();
	
	 customize_popup.init({id:'customize_popup',className:'popup_overlay'});
 	 customize_popup.updateContainer('<div class="popup_container" style="width:340px;height: 185px;"><div id="popup"></div></div>');
	 
	 function showCustomize(){
		//customize_popup.show().toCenter();
		//customize.load('/modules/banner/admin.exsposition.php?action=checkposis');
		//customize.loadData();
		customize_popup.show().toCenter();
		customize.load('/modules/banner/admin.exsposition.php?action=checkposis');
		
	 }

	function closeCustomize(){
		jQuery(customize_popup.container).fadeOut('slow',function(){customize_popup.hide()});
	}
	function submitCustomize(){
		customize.submit();
		customize_popup.hide();
	}
	
	
	

