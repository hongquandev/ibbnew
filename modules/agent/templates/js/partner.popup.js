var Partner_info = function(){
};

Partner_info.prototype = {
    load: function(id) {
        var url = '/modules/agent/action.php?action=partner_info';
        $.post(url,{id:id},function(data){
                    var info = jQuery.parseJSON(data);
                    closeLoadingPopup();
                    jQuery('#partner_pu').html(info.html);
                    partner_popup.show().toCenter();
               },'html');
    }
};


var partner_info = new Partner_info();
var partner_popup = new Popup();

partner_popup.init({id:'partner_popup',className:'popup_overlay'});
partner_popup.updateContainer('<div class="popup_container" style="width:700px;"><div id="partner_pu"></div></div>');

function showPartner(id){
    showLoadingPopup();
    partner_info.load(id);
}

function closePartner(){
    jQuery(partner_popup.container).fadeOut('slow',function(){$('#partner_pu').html('');partner_popup.hide()});
}
