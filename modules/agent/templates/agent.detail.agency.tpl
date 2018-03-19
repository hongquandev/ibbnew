<div id="blogSliderWrap">

    <div id="blogSlider">
        <div class="innerWrap">
            <div class="panelContainer">

                <div class="panel" title="Profile">
                    <div class="wrapper-tabs">
                           <img style="width: 209px;" src="{$MEDIAURL}/{$info.banner}" alt="{$info.company_name}" title="{$info.company_name}"/>
                           <p class="agency_title"><strong>{$info.company_name}</strong></p>
                           <div><span class="vector" id="span-vector"></span><p class="address" id="p-address">{$info.full_address}</p></div><div class="clearthis"></div>
                           <p class="vector tel">{$info.telephone}</p><div class="clearthis"></div>
                           <div class="buttons-set">
                               <span class="f-left span-user-detail"><a href="{$info.website}" target="_blank">{$info.website}</a></span>

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

                <div class="panel" title="agent" id="agent">
                    {include file = 'agent.detail.agent-list.tpl'}
                </div>

            </div>
        </div>
    </div>
</div>

{*<div id="col-agency-1" class="col-1 f-left property-box tab-container">*}
{*    <h2>AGENT LIST</h2>*}
{*    {if $sub_account}*}
{*    {if count($sub_account) > 2}*}
{*           {* <button class="prev">«</button>*}
{*            <button class="next">»</button>*}
{*            <button class="prev"></button>*}
{*            <button class="next"></button>*}
{*    {/if}*}
{*    <div class="pro-list">*}
{*        <ul class="sub-account pro-review">*}
{*            {foreach from=$sub_account item=account}*}
{*                <li id="gradient-box-agent">*}
{*                   <a href="{seo}?module=agent&action=view-detail-agent&uid={$account.agent_id}{/seo}" title="View Profile Detail" class="f-left">*}
{*                       <img style="width: 84px;" src="{$MEDIAURL}/{$account.logo}" alt="" title="" class="photo-shadow"/>*}
{*                   </a>*}
{*                   <div class="main-info f-left">*}
{*                       <p><span class="title"><strong>{$account.full_name}</strong></span></p>*}
{*                       <p class="vector tel">{$account.telephone}</p>*}
{*                       <p class="vector address">{$account.full_address}</p><br />*}
{*                       {*<p class="p_e_agent"><a href="javascript:voice();" class="vector mail">Email</a></p>*}
{*                   </div>*}
{*                   <div class="clearthis"></div>*}
{*                </li>*}
{*            {/foreach}*}
{*        </ul>*}
{*    </div>*}
{*    {/if}*}
{*</div>*}
{*<div class="clearthis"></div>*}
{**}
{*<div id="col-agency-2" class="col-2 f-left property-box tab-container">*}
{*    {*<h2>RECENTLY ADDED PROPERTIES</h2>*}
{*    {include file="`$ROOTPATH`/modules/agent/templates/agent.detail.property.tpl"}*}
{*</div>*}
<div class="clearthis"></div>

<script type="text/javascript">
    {literal}
   $(function() {
       $("#col-agency-1 .pro-list").jCarouselLite({
           btnNext: "#col-agency-1 .next",
           btnPrev: "#col-agency-1 .prev",
           circular: false,
           auto: false,
           visible: 2,
           speed: 300,
           pause: true
       });
   });

   function viewAgent(url){
       $('#agent').css('text-align','center').html('<img src="{/literal}{$ROOTURL}{literal}/modules/general/templates/images/loading3.gif"/>');
       $.post(url,{},function(data){
                  $('#agent').css('text-align','left').html(data);
               },'html');
   }
    {/literal}
</script>