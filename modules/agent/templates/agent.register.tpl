<script type="text/javascript" src="/modules/agent/templates/js/file.js"></script>
<script type="text/javascript">
var agent = new Agent();
</script>
<div class="container-l">
    <div class="container-r">
        <div class="container col2-right-layout">
            <div class="main">
                <div class="col-main user-register">
                	<div class="ur-bar-title">
                        {if $type == "buyer"}
                            <h1>STEP 1. USER REGISTRATION</h1>
                        {else}
                            <h1>{$_type} {localize translate="REGISTRATION"} </h1>
                        {/if}
                	</div>
                    <!--<div class="{if in_array($type,array('vendor','buyer'))}ureg-panel{elseif $type == 'partner'}ureg-panel2{else}ureg-agent{/if}">-->
                    {if $register_kind != 'transact'}
                    <div class="ureg-panel">
                    	<div class="step-text">{localize translate="Step"}</div>
                        {section name = bar start = 1 loop = 6 step = 1}
                            {if in_array($smarty.section.bar.index,$array)}

                                {*allow hover*}
                                {assign var="step_css_default" value="step-`$smarty.section.bar.index`"}
                                {*unallow hover*}
                                {if $stepped < $smarty.section.bar.index }
                                    {assign var="step_css" value = "`$step_css_default`-unhover"}
                                {/if}
                                {*unallow revert thier order of up and down tag*}
                                {*hover default*}

                                {if $smarty.section.bar.index==$step}
                                    {assign var="step_css" value="`$step_css_default`-active"}
                                {/if}
                                {if !isset($step_css) or $step_css ==''}
                                    {assign var = "step_css" value = "$step_css_default"}
                                {/if}

                                {assign var="onclick" value = ""}
                                {if $smarty.section.bar.index <= $stepped}
                                    {assign var="onclick" value = "agent.gotoStep('?module=agent&action=`$action`&step=`$smarty.section.bar.index`')"}
                                {/if}
                                
                                <div class="step {$step_css}" onclick="{$onclick}">{$smarty.section.bar.index}</div>
                                {assign var = "step_css" value = ""}
                            {/if}
                        {/section}
                    </div>
                    {/if}
                    <div class="step-info">
                    	{if $step>=1 and $step<=5}
                        	{include file = "`$module`.register.step`$step`.tpl"}
                        {else}
                            {localize translate="Can not find the template with this request"}.
                        {/if}
                    </div>
                </div>
                <div class="col-right">
                    {include file = "`$ROOTPATH`/modules/general/templates/side.right2.tpl"}
                </div>
                <div class="clearthis"></div>
            </div>
        </div>
    </div>
</div>
{literal}
<script>
jQuery('body').addClass('agent-register');
</script>
{/literal}

