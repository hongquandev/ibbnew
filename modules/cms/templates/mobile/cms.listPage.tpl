{literal}
    <script type="text/javascript" src="../../modules/property/templates/js/property.js"></script>
    <script type="text/javascript">
        var pro = new Property();
    </script>
    <link href="/modules/cms/templates/css/style.css" type="text/css" rel="stylesheet"/>
{/literal}
<div class="container-l">
    <div class="container-r">
        <div class="container col2-right-layout">
            <div class="main">
                {if isset($error)}
                    {include file = 'cms.errorPage.tpl'}
                {else}
                    {include file = 'cms.content.tpl'}
                {/if}
                <div class="clearthis"></div>
            </div>
        </div>
    </div>
</div>
