<link rel="stylesheet" href="{$ROOTURL}/modules/general/templates/js/magnific-popup/magnific-popup.css">
<script type="text/javascript"
        src="{$ROOTURL}/modules/general/templates/js/magnific-popup/jquery.magnific-popup.js"></script>
<div class="content content-po-ie content-popup-vm">
    <ul class="ul-menu-left popup-vm-menu-left">
        <li class="child">
            <div class="label">
                <a class="a-lightbox" href="javascript:void(0)"
                   rel="{$ROOTURL}/modules/property/action.php?action=vm_doc&property_id={$property_data.info.property_id}">Legal
                    Documents<span class="more-vm-p" style="font-size: 30px;float: right;line-height: 10px;color: #0094d8">+</span></a></div>
            <div class="content-menu-right"></div>
        </li>
        <li class="child">
            <div class="label">
                <a class="a-lightbox" href="javascript:void(0)"
                   rel="{$ROOTURL}/modules/property/action.php?action=vm_media_photos&property_id={$property_data.info.property_id}">Photos
                    <span class="more-vm-p" style="font-size: 30px;float: right;line-height: 10px;color: #0094d8">+</span>
                </a>
            </div>
            <div class="content-menu-right"></div>
        </li>
        <li class="child">
            <div class="label"><a class="a-lightbox" href="javascript:void(0)"
                                  rel="{$ROOTURL}/modules/property/action.php?action=vm_media_videos&property_id={$property_data.info.property_id}">Videos
                    <span class="more-vm-p" style="font-size: 30px;float: right;line-height: 10px;color: #0094d8">+</span>
                </a>
            </div>
            <div class="content-menu-right"></div>
        </li>
        <li class="child">
            <div class="label">
                <a class="a-lightbox" href="javascript:void(0)"
                                  rel="{$ROOTURL}/modules/property/action.php?action=vm_description&property_id={$property_data.info.property_id}">Description
                    <span class="more-vm-p" style="font-size: 30px;float: right;line-height: 10px;color: #0094d8">+</span>
                </a>
            </div>
            <div class="content-menu-right"></div>
        </li>
        <li class="child">
            <div class="label">
                <a class="a-lightbox" href="javascript:void(0)"
                   rel="{$ROOTURL}/modules/property/action.php?action=vm_term&property_id={$property_data.info.property_id}">Auction
                    Terms
                    <span class="more-vm-p" style="font-size: 30px;float: right;line-height: 10px;color: #0094d8">+</span>
                </a></div>
            <div class="content-menu-right"></div>
        </li>
    </ul>
</div>
<script type="text/javascript">
    {literal}
    jQuery(document).ready(function (jQuery) {
        jQuery('.ul-menu-left li.child').unbind('click').bind('click', function () {
            if (!jQuery(this).hasClass('active')) {
                jQuery('.ul-menu-left li.child').removeClass('active');
                jQuery('.more-vm-p').show();
                jQuery(this).addClass('active');
                jQuery('.ul-menu-left li.child').find('.content-menu-right').slideUp();
                pvm.send(jQuery(this).find('a').attr('rel'), jQuery('.content-menu-right',this));
                jQuery('.content-menu-right',this).slideDown();
                jQuery('.more-vm-p',this).hide();
            }
        });
        jQuery('.ul-menu-left li.child').first().click();
    });
    {/literal}
</script>
