{literal}
<script type="text/javascript">
    Cufon.now('h2');
</script>
{/literal}
<div id="pvm-container-tmp" style="display:none;">
    <div id="pvm-wrapper">
        <div class="title"><h1 id="txtt" class="h1-cufon">Property Details <span style="float: right;cursor: pointer;" id="btnclosex" onclick="closePVM2()">x</span></h1> </div>
        <div class="content content-po-ie content-popup-vm content-popup-tv" style="width:100%">
            <div class="content-menu-left">
                <h2>Property Details</h2>
                <ul id="nav" class="ul-menu-left" style="list-style: none;margin-top:10px;">
                    <li><a class="a-lightbox" name="lightbox" href="javascript:void(0)" onclick="vmclick(this);pvm.send('/modules/property/action.php?action=vm_media_photos&property_id=$property_id')">Photos</a></li>
                    <li><a class="a-lightbox" name="lightbox" href="javascript:void(0)" onclick="vmclick(this);pvm.send('/modules/property/action.php?action=vm_media_videos&property_id=$property_id')">Videos</a></li>
                    <li><a class="a-lightbox" name="lightbox" href="javascript:void(0)" onclick="vmclick(this);pvm.send('/modules/property/action.php?action=vm_rating&property_id=$property_id');">iBB Ratings </a></li>
                    <li><a class="a-lightbox" name="lightbox" href="javascript:void(0)" onclick="vmclick(this);pvm.send('/modules/property/action.php?action=vm_description&property_id=$property_id');">Descriptions</a></li>
                    <li><a class="a-lightbox" name="lightbox" href="javascript:void(0)" onclick="vmclick(this);pvm.send('/modules/property/action.php?action=vm_term&property_id=$property_id');">Auction Terms</a></li>
                    <li><a class="a-lightbox" name="lightbox" href="javascript:void(0)" onclick="vmclick(this);pvm.send('/modules/property/action.php?action=vm_doc&property_id=$property_id');">Legal Documents</a></li>
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
    function vmclick(obj) {
        jQuery('.ul-menu-left li').bind('click', function () {
            jQuery('.ul-menu-left li').removeClass('active');
            $(this).addClass('active');
        });
    }
    {/literal}
</script>