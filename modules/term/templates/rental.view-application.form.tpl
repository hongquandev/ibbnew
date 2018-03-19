<link rel="stylesheet" type="text/css" href="{$ROOTURL}/modules/term/templates/style/raywhite.css"/>
<div class="container-l">
    <div class="container-r" style="padding-top: 30px">
        {include file="term.buttons.tpl"}
        <form id="frmTerm" name="frmTerm" method="post" action="{$form_action}">
            {*{include file="term.remember.tpl"}*}
            <div class="container">
                <div class="main">
                    {include file="term.raywhite.tpl"}
                </div>
            </div>
            {*{include file="term.remember.tpl"}*}
        </form>
        {include file="term.buttons.tpl"}
    </div>
</div>
<script type="text/javascript">
    {literal}
    jQuery(document).ready(function(){
        jQuery('input[name=remember]').bind('click',function(){
            if (jQuery(this).is(':checked')){
                jQuery('input[name=remember]').each(function(){
                    jQuery(this).attr('checked','checked');
                })
            }else{
                jQuery('input[name=remember]').each(function(){
                    jQuery(this).removeAttr('checked');
                })
            }
        })
    });
    {/literal}
</script>
{literal}
    <script type="text/javascript">
        jQuery('[name="remember"]').attr('checked',true);
    </script>
{/literal}
