<div id="pvm-container-tmp" style="display:none">
    <div id="pvm-wrapper">
        <div class="title"><h2 id="txtt"> Property Details <span id="btnclosex" onclick="closePVM()">x</span></h2> </div>
        <div class="content" style="width:100%">
            <div class="content-menu-left" style="margin-right:10px;margin-bottom:10px;display:block;float: left;margin-left: 4px;text-transform: capitalize;">
                <h2>Property Details</h2>
                <ul class="ul-menu-left" style="list-style: none;margin-top:10px;">
                    <li style="padding-bottom:3px;"><a class="a-lightbox" name="lightbox" href="javascript:void(0)" onclick="pvm.send('/modules/property/action.php?action=vm_media&property_id={$property_id}')">Photos & Videos</a></li>
                    <li style="padding-bottom:3px;"><a class="a-lightbox" name="lightbox" href="javascript:void(0)" onclick="pvm.send('/modules/property/action.php?action=vm_doc&property_id={$property_id}');">Legal Documents</a></li>
                    <li style="padding-bottom:3px;"><a class="a-lightbox" name="lightbox" href="javascript:void(0)" onclick="pvm.send('/modules/property/action.php?action=vm_rating&property_id={$property_id}');">iBB Ratings </a></li>
                    <li style="padding-bottom:3px;"><a class="a-lightbox" name="lightbox" href="javascript:void(0)" onclick="pvm.send('/modules/property/action.php?action=vm_term&property_id={$property_id}');">Auction Terms</a>
                </li></ul>
            </li></div>
            <div id="pvm-right" class="content-menu-right" style="margin-bottom:10px;display:block;float:left;clear:none;overflow-y: auto;width:564px;height: 400px;overflow-y: auto;padding-left:5px;border-left: solid whiteSmoke 2px;">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
{literal}
	mm_popup.init({id:'mm_popup',className:'popup_overlay'});
	mm_popup.updateContainer('<div class="popup_container" style="width:750px;left:319.5px;">'+jQuery('#mm-container-tmp').html()+'</div>');
{/literal}	
	mm.send('/modules/property/action.php?action=vm_media&property_id={$property_id}');
</script>
