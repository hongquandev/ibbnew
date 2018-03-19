<link rel="stylesheet" href="{$ROOTURL}/modules/general/templates/js/magnific-popup/magnific-popup.css">
<script type="text/javascript" src="{$ROOTURL}/modules/general/templates/js/magnific-popup/jquery.magnific-popup.js"></script>
{literal}
{/literal}
<div id="pvm-container-tmp" style="display:none">
    <div id="pvm-wrapper">
        <div class="title"><h2 id="txtt">Property Details <span id="btnclosex" onclick="closePVM()">x</span></h2> </div>
        <div class="content content-po-ie content-popup-vm">
            <div class="content-menu-left">
                <ul class="ul-menu-left popup-vm-menu-left">
                    <li><a class="a-lightbox" name="lightbox" href="javascript:void(0)" rel="/modules/property/action.php?action=vm_media_photos&property_id={$property_id}">Photos</a></li>
                    <li><a class="a-lightbox" name="lightbox" href="javascript:void(0)" rel="/modules/property/action.php?action=vm_media_videos&property_id={$property_id}">Videos</a></li>
                    <li><a class="a-lightbox" name="lightbox" href="javascript:void(0)" rel="/modules/property/action.php?action=vm_description&property_id={$property_id}">Description</a></li>
					{if $data.pro_type == 'sale'}
						<li style="display:none;"><a class="a-lightbox" name="lightbox" href="javascript:void(0)" rel="/modules/property/action.php?action=vm_term&property_id={$property_id}">Auction Terms</a>
						</li>
					{else}
						<li><a class="a-lightbox" name="lightbox" href="javascript:void(0)" rel="/modules/property/action.php?action=vm_term&property_id={$property_id}">Auction Terms</a>
						</li>
					{/if}
                    <li><a class="a-lightbox" name="lightbox" href="javascript:void(0)" rel="/modules/property/action.php?action=vm_doc&property_id={$property_id}">Legal Documents</a></li>
                </ul>
            </div>
            <div id="pvm-right" class="content-menu-right">
            </div>
        </div>
    </div>
     <div id="viewmore_loading" style="display:none;position:absolute;top: 200px; left: 400px;"><img src="/modules/general/templates/images/loading2.gif"/></div>
</div>
<script type="text/javascript">
    {literal}
    pvm_popup.init({id: 'pvm_popup', className: 'popup_overlay'});
    pvm_popup.updateContainer('<div class="popup_container popup-container-vm popup-vm-container">' + jQuery('#pvm-container-tmp').html() + '</div>');
    {/literal}
    {literal}
    jQuery(document).ready(function ($) {
        jQuery('.ul-menu-left li').bind('click', function () {
            jQuery('.ul-menu-left li').removeClass('active');
            $(this).addClass('active');
            pvm.send($(this).find('a').attr('rel'));
        });
        jQuery('.ul-menu-left li').first().click();
    });
    {/literal}
</script>
