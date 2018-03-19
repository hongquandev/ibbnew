<div class="search-results">
    <ul class="partner-grid">
    {if isset($results) and is_array($results) and count($results) > 0}
        {assign var=index value=0}
        {foreach from = $results key = k item = partner}
            {assign var = index value= $index+1}
            {*<li class="{if $index%3 == 0}top-left{/if} {if $index/3 > (count($results)/3) - 1 && $index/3 <= (count($results)/3)}bottom{/if}">*}
               </li><li class="{if $index%3 == 0}top-left{/if} {if floor(($index- 1)/3) == floor((count($results) -1 ) /3) }bottom{/if}">
                    <div class="{*f-right-partner-all*}" id="f-partner-ie7">
                        <div class="img-partner" id="img-partner-ie7" align="center">
                            <div class="chi-img-partner-ie7 hover_em">
                                <a href="javascript:void(0)" onclick="showPartner({$partner.info.agent_id})">
                                {if $partner.info.partner_logo != ''}
                                    <img style="width: auto;height: auto;max-width: 190px; max-height: 166px;display: block;"
                                         src="{$MEDIAURL}/store/uploads/banner/images/partner/{$partner.info.partner_logo}"
                                         id="partner-logo"
                                         alt="{$partner.info.firstname}"
                                         title="{$partner.info.firstname}"   />
                                    {else}
                                    <img src="/modules/general/templates/images/ibb-comming.jpg" width="183"
                                         height="154" id="partner-logo"
                                         alt="{$partner.info.firstname}"
                                         title="{$partner.info.firstname}" />
                                {/if}
                                </a>
                            </div>
                        </div>
                    </div>
                    <a id="a_partner_gird" href="javascript:void(0)" onclick="showPartner({$partner.info.agent_id})">{$partner.info.firstname}</a>
            </li>
        {/foreach}
        {else}
        There is no data.
    {/if}
    </ul>
</div>
<div class="clearthis"></div>
{if isset($pag_str)}
    {$pag_str}
{/if}
<script type="text/javascript" src="/modules/agent/templates/js/partner.popup.js"></script>
{literal}
    <!--<script type="text/javascript">
         $(document).ready(function(){
            $(".hover_em a").append("<em></em>");
                $(".hover_em a").hover(function() {
                $(this).find("em").animate({opacity: "show", margin: "-8"}, "slow");
                var hoverText = $(this).attr("title");
                $(this).find("em").text(hoverText);
            }, function() {
                $(this).find("em").animate({opacity: "hide", margin: "5"}, "100");
            });
         });
    </script>-->
{/literal}