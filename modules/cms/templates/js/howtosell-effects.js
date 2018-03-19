jQuery(document).ready(function() {
    jQuery('.howtosell-step-link').hover(function() {
        jQuery(this).addClass('onhover');
        var step = jQuery(this).attr('href');
        step = step.substr(1);
        var icon_on_src = jQuery('#icon_on_'+ step).val();
        jQuery(this).css('background',"url('"+icon_on_src+"') 0 0 no-repeat");
    }, function() {
        jQuery(this).removeClass('onhover');
        if(jQuery(this).hasClass('active')) {
            
        } else {
            var step = jQuery(this).attr('href');
            step = step.substr(1);
            var icon_off_src = jQuery('#icon_off_'+ step).val();
            jQuery(this).css('background',"url('"+icon_off_src+"') 0 0 no-repeat");
        }
        
    });
    var cur_url = window.location.href;
    //alert(cur_url);
    var arr = cur_url.split('#');
    //console.log(arr);
    var step = arr[1]; 
    //alert(step);
    if(arr[1] == undefined) {
        step = 'step1';
        showStep(step);
    }  else {
        showStep(step);
    } 
    
    jQuery('.howtosell-step-link').click(function() {
        //jQuery(this).addClass('active');        
        var step = jQuery(this).attr('href');
        step = step.substr(1);
        showStep(step);
    });     
});

function showStep(step) {
    //console.log('showStep');
    jQuery('.howtosell-step-link').each(function() {
            if($(this).hasClass(step)) {
                jQuery(this).addClass('active');
                var icon_on_src = jQuery('#icon_on_'+ step).val();
                jQuery(this).css('background',"url('"+icon_on_src+"') 0 0 no-repeat");
            } else {
                jQuery(this).removeClass('active');
                var thisstep = jQuery(this).attr('href');
                thisstep = thisstep.substr(1);
                var icon_off_src = jQuery('#icon_off_'+ thisstep).val();
                jQuery(this).css('background',"url('"+icon_off_src+"') 0 0 no-repeat");
            }
            
    });
    
    jQuery('.howtosell-step-content').each(function() {
            if($(this).hasClass(step)) {
                jQuery(this).show();
            } else {
                jQuery(this).hide();
            }
    });
}