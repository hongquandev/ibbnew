jQuery(document).ready(function() {
    var cur_url = window.location.href;
    //alert(cur_url);
    var arr = cur_url.split('#');
    //console.log(arr);
    var step = arr[1]; 
    //alert(step);
    if(arr[1] == undefined) {
        step = '';
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
    jQuery('.close-link').on("click",function() {  
        var step = jQuery(this).attr('data-step');
        hideStep(step);
        window.history.pushState("object or string", "Title", arr[0]);
    }); 
});

function showStep(step) {
    //console.log('showStep');
    jQuery('.howtosell-step-link').each(function() {
            if($(this).hasClass(step)) {
                jQuery(this).addClass('active');
                var icon_on_src = jQuery('#icon_on_'+ step).val();
                jQuery(this).children('img').attr('src',icon_on_src);
            } else {
                jQuery(this).removeClass('active');
                var thisstep = jQuery(this).attr('href');
                thisstep = thisstep.substr(1);
                var icon_off_src = jQuery('#icon_off_'+ thisstep).val();
                jQuery(this).children('img').attr('src',icon_off_src);
            }
            
    });
    
    jQuery('.howtosell-step-content').each(function() {
            if($(this).hasClass(step)) {
                jQuery(this).slideDown();
            } else {
                jQuery(this).slideUp();
            }
    });
}

function hideStep() {
    jQuery('.howtosell-step-link').each(function() {            
        jQuery(this).removeClass('active');
        var imgElm = jQuery(this).children('img');
        var thisstep = jQuery(this).attr('href');
            thisstep = thisstep.substr(1);
        var imgSrc = jQuery('#icon_off_'+ thisstep).val();
        jQuery(imgElm).attr('src',imgSrc);        
    });
    jQuery('.howtosell-step-content').each(function() {
        jQuery(this).slideUp();
    });
}