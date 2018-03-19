<script type="text/javascript">
    var pro = new Property();
    var restrict = '{$restrict_register}';
	var is_basic = '{$is_basic}';
    {literal}
    jQuery(document).ready(function(){
        /*if (restrict.length > 0){
			showMess('Payment before continue!','/?module=agent&action=view-dashboard');
        }*/
		
		if (is_basic == 1) {
			var url='?module=agent&action=add-info';
			showMess('This is the first time you register property on iBB. We need your full information before you can proceed.\
					  Please <a href="'+url+'" style="color:#980000;font-weight:bold;font-size:16px">Click Here</a> to complete. Thank you !','',false);
		}
    });
    {/literal}
</script>
<div class="container-l">
    <div class="container-r">
        <div class="container col1-layout">
            <div class="property-register-title">
               <h3>
                   {localize translate="PROPERTY REGISTRATION"}
               </h3>
            </div>
            <div class="col-main auction-register">
                <div class="step-property-panel">
                    <ul>
                        <li>
                            <div class="step-label">{localize translate="Step"}</div>
                        </li>
                        {section name = bar start = 1 loop = 7 step = 1}
                            {assign var="step_css_default" value="step-`$smarty.section.bar.index`"}
                            {if $default_step < $smarty.section.bar.index }
                                {assign var="step_css" value = "`$step_css_default`-unhover"}
                            {/if}
                            {if $smarty.section.bar.index==$step}
                                {assign var="step_css" value="`$step_css_default`-active"}
                            {/if}
                            {if !isset($step_css) or $step_css ==''}
                                {assign var = "step_css" value = "$step_css_default"}
                            {/if}
                            {assign var="onclick" value = ""}
                            {if $smarty.section.bar.index <= $default_step}
                                {assign var="onclick" value = "pro.gotoStep('?module=`$module`&action=register&step=`$smarty.section.bar.index`')"}
                            {/if}
                            <li>
                                <div class="step-number {if $smarty.section.bar.index==$step} step-number-active {/if} {$step_css}"  onclick="{$onclick}">{localize translate=$smarty.section.bar.index}</div>
                            </li>
                            {assign var = "step_css" value = ""}
                        {/section}

                    </ul>
                </div>
                <div class="clearthis"></div>
                <div class="step-info">
                    {if $step>=1 and $step<=8}
                        {include file = "`$module`.register.step`$step`.tpl"}
                    {else}
                        Can not find the template with this request.
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>