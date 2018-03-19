<div id="blogSliderWrap">

    <div id="blogSlider">
        <div class="innerWrap">
            <div class="panelContainer">

                <div class="panel" title="{$info.agent_name}">
                    <div class="wrapper-tabs">
                            <div class="logo-agent">
                            {if $info.logo}
                                <img src="{$MEDIAURL}/{$info.logo}" alt="{$info.logo}"
                                     title="{$info.agent_name}"/>
                            {/if}
                            </div>
                                <div class="info-agent" style="text-align:left">
                                    <div class="main-info">
                                        <p><strong>{$info.full_name}</strong></p>
                                        {php}
                                           // print_r($this->_tpl_vars['info']);
                                        {/php}
                                        <p class="company">{$info.company_name}</p>
                                        <a href="{$info.website}" target="_blank">{$info.website}</a>
                                    </div>

                                    <p class="vector tel">{$info.telephone}</p>

                                    <div><span class="vector" id="span-vector"></span><p class="address" id="p-address">{$info.full_address}</p></div>
                                    <div class="clearthis"></div>
                                    <a class="vector empty empty-w" href="{$info.website}" target="_blank">{$info.website}</a>
                                </div>

                            <div class="buttons-set">
                                <img style="width: 209px;" src="{$MEDIAURL}/{$info.banner}" alt="{$info.company_name}" title="{$info.company_name}"/>
                                <span class="f-left span-user-detail"><a href="{seo}?module=agent&action=view-detail-agency&uid={$info.parent_id}{/seo}" class="vector agent">View Agency profile</a></span>
                            </div>

                           <div class="clearthis"></div>
                           <div class="short">
                                {$info.short_description}
                           </div>

                           <div class="full" style="display:none">
                                {$info.full_description}
                           </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{literal}
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('.stripNav li:first-child a:first-child').text('Profile');
        });
    </script>
{/literal}

{*<div class="col-1 f-left">*}
{*    <div class="logo-agent gradient-box normal-width">*}
{*    {if $info.logo}*}
{*        <img src="{$MEDIAURL}/{$info.logo}" alt="{$info.logo}"*}
{*             title="{$info.agent_name}"/>*}
{*    {/if}*}
{*        <div class="info-agent" style="text-align:left">*}
{*            <div class="main-info">*}
{*                <p><strong>{$info.full_name}</strong></p>*}
{**}
{*                <p class="company">{$info.company_name}</p>*}
{*                <a href="{$info.website}">{$info.website}</a>*}
{*            </div>*}
{**}
{*            <p class="vector tel">{$info.telephone}</p>*}
{**}
{*            <div><span class="vector" id="span-vector"></span><p class="address" id="p-address">{$info.full_address}</p></div>*}
{*            <div class="clearthis"></div>*}
{*            <a class="vector empty empty-w" href="{$info.website}">{$info.website}</a>*}
{*        </div>*}
{**}
{*    </div>*}
{*    <div class="buttons-set">*}
{*        <img style="width: 209px;" src="{$MEDIAURL}/{$info.banner}" alt="{$info.company_name}" title="{$info.company_name}"/>*}
{*        <span class="f-left span-user-detail"><a href="{seo}?module=agent&action=view-detail-agency&uid={$info.parent_id}{/seo}" class="vector agent">View Agency profile</a></span>*}
{*        {*<button class="btn-red f-right"><span><span>Contact</span></span></button>*}
{*    </div>*}
{*</div>*}
{*<div class="col-2 f-left">*}
{*    {$info.description}*}
{*</div>*}
{*<div class="clearthis"></div>*}
{**}
{*<div class="property-box" style="width: 100%;">*}
{*    <h2>RECENTLY ADDED PROPERTIES</h2>*}
{*    {include file="`$ROOTPATH`/modules/agent/templates/agent.detail.property.tpl"}*}
{*</div>*}
