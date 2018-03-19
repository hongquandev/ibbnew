<div class="search-results">
    <ul class="partner-list">
    {if isset($results) and is_array($results) and count($results) > 0}
        {foreach from = $results key = k item = partner}
            <li {if $k == 0} class="first"{/if}>
                <div class="logo" style="float:left;width:35%">
                    <div class="f-right-partner-all" id="f-partner-ie7">
                        <div class="img-partner" id="img-partner-ie7" align="center">
                            <div class="chi-img-partner-ie7" id="chi-img-partner-ie8">
                                <a href="javascript:void(0)" onclick="showPartner({$partner.info.agent_id})">
                                {if $partner.info.partner_logo != ''}
                                        <img style="width: auto;height: auto;max-width: 190px; max-height: 166px;display: block;"
                                         src="{$MEDIAURL}/store/uploads/banner/images/partner/{$partner.info.partner_logo}"
                                         id="partner-logo"
                                         alt="{$partner.info.partner_logo}"/></a>
                                    {else}
                                        <img src="/modules/general/templates/images/ibb-comming.jpg" width="183"
                                         height="154" id="partner-logo"
                                         alt="default"/>
                                {/if}
                                </a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="description" style="float:left;width:64%; margin-left: 5px;">
                        <h3>{$partner.info.firstname}</h3>
                        <!--<span class="sub-head">{$partner.info.website_partner}</span>-->
                        <a href="{$partner.info.website_partner}" target="_blank">{$partner.info.website_partner}</a>
                        <div class="des">{$partner.info.description}</div>
                        <a href="javascript:void(0)" class="read-more" onclick="showPartner({$partner.info.agent_id})"></a>
                    </div>
                    {*<div class="contact" style="float:left;width:25%">
                        <span>{$partner.info.general_contact_partner}</span>
                        <span><strong>Tel:</strong> {$partner.info.telephone}</span>
                        <table>
                            <tr>
                                <td>Address:</td>
                                <td>{$partner.info.full_address}</td>
                            </tr>
                            <tr>
                                <td>Postal Address:</td>
                                <td>{$partner.info.full_postal_address}</td>
                            </tr>
                        </table>
                        <span>{$partner.info.website_partner}</span>
                    </div>*}
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