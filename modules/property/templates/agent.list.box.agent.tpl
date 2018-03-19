<div class="search-results" id="search-results-agent-list">
{if $results and count($results) > 0}
    <ul class="sub-account">
    {foreach from=$results item=row}
       <li class="normal-width">
           <div class="col-1 f-left" style="width:60%">
               <img src="{$MEDIAURL}{$row.logo}" alt="{$row.company_name}" title="{$row.company_name}" class="f-left photo-shadow"/>
               <div class="main-info f-left">
                   <p class="agency_title"><strong>{$row.full_name}</strong></p>
                   <strong><i>{$row.parent.company_name}</i></strong>
                   <br />
                   <p class="vector address">{$row.full_address}</p>
                   <p class="vector tel">{$row.telephone}</p>
                   <p class="p_v_agent">
                     <a href="{$row.parent.link}" class="vector agent">View Agency profile</a>
                   </p>
                   <br />
               </div>
           </div>
           <div class="col-2 f-left" style="width:40%">
               {if $row.parent.logo}
                   <img src="{$MEDIAURL}{$row.parent.logo}" alt="{$row.parent.company_name}" title="{$row.parent.company_name}"
                        style="width:149px;padding-bottom: 5px;"/>
               {/if}
               <div class="clearthis"></div>
               {if $row.parent.logo !=''}
                   <div style="height: auto;" class="short_{$row.agent_id} word-justify">
                       {$row.short_description}
                   </div>
                   {else}
                   <div style="height: auto;" class="short_{$row.agent_id} word-justify">
                       {$row.short_description}
                   </div>
               {/if}

           </div>
           <div class="buttons-set">
               {*<button class="btn-red">
                       <span><span>Contact</span></span>
               </button>*}

                   <button class="btn-red"
                           onclick="document.location='{seo}?module=agent&action=view-detail-agent&uid={$row.agent_id}{/seo}'">
                       <span><span>Properties</span></span>
                   </button>
               </div>
       </li>
    {/foreach}
</ul>
{else}
    <div class="message-box message-box-add" style="width: 608px;"><center><i>Sorry, but there are no agent available based on your selection. Please modify the filters to search again. Thanks!</i></center></div>
{/if}
</div>
<div class="clearthis"></div>
{$pag_str}