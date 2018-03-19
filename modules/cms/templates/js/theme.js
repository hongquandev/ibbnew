jQuery(document).ready(function () {
    jQuery('.step-link').hover(function () {
        jQuery(this).addClass('onhover');
    }, function () {
        jQuery(this).removeClass('onhover');
        if (jQuery(this).hasClass('active')) {

        }
    });
    var cur_url = window.location.href;
    //alert(cur_url);
    var arr = cur_url.split('#');
    //console.log(arr);
    var step = arr[1];
    //alert(step);
    if (arr[1] == undefined) {
        step = 'step1';
        showStep(step);
    } else {
        showStep(step);
    }

    jQuery('.step-link').click(function () {
        //jQuery(this).addClass('active');        
        var step = jQuery(this).attr('href');
        step = step.substr(1);
        showStep(step);
    });
});

function showStep(step) {
    jQuery('.step-link').each(function () {
        if ($(this).hasClass(step)) {
            jQuery(this).addClass('active');
        } else {
            jQuery(this).removeClass('active');
        }
    });
    jQuery('.step-content').each(function () {
        if ($(this).hasClass(step)) {
            jQuery(this).show();
        } else {
            jQuery(this).hide();
        }
    });
}