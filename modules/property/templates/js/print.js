function prints_(){
document.getElementById('prt').style.display='none';
	//window.print();
	if (window.print()) {
		self.print();
	} else {
		document.getElementById('prt').style.display='block';	
	}
}
jQuery('.buttons-set','.col-main-print').remove();
jQuery('.bar-title h2','.col-main-print').html(title_bar);
jQuery('.property-desc h2','.col-main-print').html(' PROPERTY DESCRIPTION');
jQuery('.logo-agent h2','.col-main-print').html(' AGENT DETAILS');

jQuery('#btn-offer-' + property_id,'.col-main-print').remove();
jQuery('#bid_button_'+ property_id,'.col-main-print').remove();
jQuery('#bid_room_button','.col-main-print').remove();
jQuery('.btn-autobid','.col-main-print').remove();
jQuery('div.property-detail-a','.col-main-print').remove();
jQuery('#btn_count_'+ property_id,'.col-main-print').remove();
jQuery('#btn_no_'+ property_id,'.col-main-print').remove();

// MOHA
// MOVE AGENT'S LOGO TO SITE'S LOGO
var logo = jQuery('.property-desc a img').attr('src');
jQuery('#print_logo').attr('src', logo);
// HIDE WATERMARK

jQuery('#print_content .img-main-watermark img.watermark_ebidda').hide();
// HIDE AGENT'S LOGO
jQuery('#print_content .property-desc a img').hide();
// HIDE GOOGLE MAP
jQuery('#print_content .google-map').hide();


