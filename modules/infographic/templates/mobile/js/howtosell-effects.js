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
    
    jQuery('.howtosell-step-link').on("click",function() {
        jQuery(this).addClass('active');        
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
    //console.log('show');
    jQuery('.howtosell-step-link').each(function() {
            if(jQuery(this).hasClass(step)) {
                jQuery(this).addClass('active');
                var imgElm = jQuery(this).children('img');
                var imgSrc = jQuery(imgElm).attr('src');                
                var filename = imgSrc.substring(imgSrc.lastIndexOf('/')+1);
                var arr = filename.split('.');
                var imgName = '';
                if(arr[0].search('_active') > -1) {
                    imgName = arr[0] + '.' + arr[1];
                } else {
                    imgName = arr[0] + '_active.' + arr[1]
                }
                jQuery(imgElm).attr('src',module_url + '/templates/images/' + imgName);
                //alert(module_url);
            } else {
                jQuery(this).removeClass('active');
                var imgElm = jQuery(this).children('img');
                var imgSrc = jQuery(imgElm).attr('src');  
                              
                //var filename = imgSrc.substring(imgSrc.lastIndexOf('/')+1);
                //var arr = filename.split('.');
                var imgName = imgSrc.replace('_active','');
                jQuery(imgElm).attr('src',imgName);
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
        var imgSrc = jQuery(imgElm).attr('src'); 
        var imgName = imgSrc.replace('_active','');
        jQuery(imgElm).attr('src',imgName);
        jQuery('.howtosell-step-content').each(function() {
            jQuery(this).slideUp();
        });
    });
}