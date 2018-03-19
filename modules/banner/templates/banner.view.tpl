<script src="modules/banner/templates/js/banner.js" type="text/javascript" charset="utf-8"> </script>
<script src="modules/banner/templates/js/banner-checkimage.js" type="text/javascript"> </script>
<script src="modules/general/templates/calendar/js/jscal2.js"></script>
<script src="modules/general/templates/calendar/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="modules/general/templates/calendar/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="modules/general/templates/calendar/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="modules/general/templates/calendar/css/steel/steel.css" />

<div class="container-l">
    <div class="container-r">
        <div class="container col2-right-layout">
            <div class="main">
                <div class="col-main">
                {if $action == 'edit-advertising'}
                    {include file = 'banner.edit.tpl'}
                {elseif $action == 'my-banner'}
                  	{include file = 'banner.my-banner.tpl'}
                {/if}          
                </div>
                <div class="col-right">         
                	{include file = "`$ROOTPATH`/modules/agent/templates/agent.side.right.tpl"}
                	{include file = "`$ROOTPATH`/modules/general/templates/side.right.tpl"}
                </div>
                <div class="clearthis"></div>
            </div>
        </div>
    </div>
</div>

{literal}
<script type="text/javascript">
function validDate(){
	var my_string = document.getElementById("postcode").value;
	if (jQuery('#postcode').val() != '') {
		if(!isNaN(my_string)){
			if(my_string.length != 4) {
				Common.warningObject('#postcode');
				return false;	
			}
			return true;
		} else {
			Common.warningObject('#postcode');
			return false;	
		}	
	} 
	
	if (jQuery('#postcode').val() == '') {
		$('#postcode').removeClass('input-text validate-postcode');
		jQuery('#postcode').css({"border":"","color":""});
		$("#postcode").addClass('input-text validate-number');
	}
	return true;
}
</script>
{/literal}

{if $action != 'my-banner'}
    {literal}
	<script type="text/javascript">
        if (jQuery('#date_from').length) {
            banner.flushCallback();
            banner.callback_func.push(function(){return validDate();});
            Calendar.setup({
                inputField : 'date_from',
                trigger    : 'date_from',
                onSelect   : function() { this.hide() },
                showTime   : true,
                dateFormat : "%Y-%m-%d"
            });
        
            Calendar.setup({
                inputField : 'date_to',
                trigger    : 'date_to',
                onSelect   : function() { this.hide() },
                showTime   : true,
                dateFormat : "%Y-%m-%d"
            });
        }
    </script>
    {/literal}
{/if}