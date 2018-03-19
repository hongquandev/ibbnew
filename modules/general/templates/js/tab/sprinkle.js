//var noConflict = jQuery.noConflict();
jQuery(document).ready(function(){
    tabIndex= 2;
    jQuery('#tabvanilla > ul').tabs({
        fx: {
            height: 'toggle', 
            opacity: 'toggle'
        }
    }); 
});
