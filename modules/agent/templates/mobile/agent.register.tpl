<script type="text/javascript" src="/modules/agent/templates/js/file.js"></script>
<script type="text/javascript">
    var agent = new Agent();
</script>
<div class="container-l">
    <div class="container-r">
        <div class="container ">
            <div class="col-main">
                <div>
                    {if $type == "buyer"}
                        <h1>STEP 1. USER REGISTRATION</h1>
                    {else}
                        <h1>{$_type} {localize translate="REGISTRATION"} </h1>
                    {/if}
                    {if $register_kind != 'transact'}
                    <div class="{if in_array($type,array('vendor','buyer'))}nreg-panel{elseif $type == 'partner'}nreg-panel2{else}nreg-agent{/if}">
                        <div class="step-text">Step</div>
                        {section name = bar start = 1 loop = 6 step = 1}
                            {if in_array($smarty.section.bar.index,$array)}
                                {*allow hover*}
                                {assign var="step_css_default" value="step-`$smarty.section.bar.index`"}
                                {if $step - 1 == $smarty.section.bar.index}
                                    {assign var="step_css" value = "lastdone"}
                                {/if}
                                {*unallow revert thier order of up and down tag*}
                                {*hover default*}
                                {if $smarty.section.bar.index==$step}
                                    {assign var="step_css" value="active"}
                                {/if}
                                {if !isset($step_css) or $step_css ==''}
                                    {assign var = "step_css" value = "$step_css_default"}
                                {/if}
                                {assign var="onclick" value = ""}
                                {if $smarty.section.bar.index<=$stepped}
                                    {assign var="onclick" value = "agent.gotoStep('?module=agent&action=`$action`&step=`$smarty.section.bar.index`')"}
                                {/if}
                                <div class="nstep {if $smarty.section.bar.index <= $stepped }done{/if} {$step_css} {if $smarty.section.bar.index == 4}last{/if} step{$smarty.section.bar.index}"
                                     onclick="{$onclick}">
                                    <em>{$smarty.section.bar.index}</em>
                                </div>
                                {assign var = "step_css" value = ""}
                            {/if}
                        {/section}
                        <div class="clearthis"></div>
                    </div>
                    {/if}
                    <div class="step-info">
                        {if $step>=1 and $step<=5}
                            {include file = "`$module`.register.step`$step`.tpl"}
                        {else}
                            Can not find the template with this request.
                        {/if}
                    </div>
                </div>
                {*<div class="col-right">
                    {include file = "`$ROOTPATH`/modules/general/templates/side.right.tpl"}
                </div>*}
                <div class="clearthis">
                </div>
            </div>
        </div>
    </div>
</div>
{literal}
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('.nstep').hover(
                function () {
                    if (!jQuery(this).hasClass('step1') && jQuery(this).hasClass('done')) {
                        if (!jQuery(this).prev().hasClass('active')) {
                            jQuery(this).prev().addClass('prev-hover');
                        } else {
                            jQuery(this).prev().addClass('next-hover');
                        }
                    }
                },
                function () {
                    if (!jQuery(this).hasClass('step1')) {
                        jQuery(this).prev().removeClass('prev-hover');
                        jQuery(this).prev().removeClass('next-hover');
                    }
                });
        });
    </script>
{/literal}
