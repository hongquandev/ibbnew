jQuery('.ld-part2-2-box').hover(
	function() {
		jQuery(jQuery(this).find('.ld-content')).show();
	},
	function() {
		jQuery(jQuery(this).find('.ld-content')).hide();
	}
);

