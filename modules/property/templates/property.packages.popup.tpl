<div id="package-container-tmp" style="display:none">
    <div id="package-wrapper" style = "width:300px">
        <div class="title"><h2 id="txtt"> Property Packages <span id="btnclosex" onclick="closePropertyPackage()">x</span></h2> </div>
        <div class="content">
            <div class="content-menu-left">
                <ul class="ul-menu-left popup-vm-menu-left" id = "package_content" style = "margin-left:20px"></ul>
                <i style = "font-size:10px;margin-left:20px;color:#ff0000;">These packages is required with Auction.</i>
            </div>
        </div>
    </div>
    <div id="package_loading" style="display:none;position:absolute;top: 50px; left: 100px;"><img src="/modules/general/templates/images/loading2.gif"/></div>
</div>
{literal}

<script type="text/javascript">
	package_popup.init({id:'package_popup',className:'popup_overlay'});
	package_popup.updateContainer('<div class="popup_container">'+jQuery('#package-container-tmp').html()+'</div>');
</script>
{/literal}	
