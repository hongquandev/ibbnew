{if $action == 'faq'}
    {include file = 'cms.faq.tpl'}
{elseif $action == 'view-landing-page'}
    {include file = "cms.landing-page.tpl"}
{elseif $action == 'landing'}
    {include file= "cms.landing.greg.tpl"}
{elseif TRUE}
    {include file = 'cms.page.tpl'}
{/if}



