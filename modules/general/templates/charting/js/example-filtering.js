// Run the script on DOM ready:
$(function(){
 	$('#chart')
 		.visualize({
	 		rowFilter: ':not(:last)',
	 		colFilter: ':not(:last-child)'
	 	})
});