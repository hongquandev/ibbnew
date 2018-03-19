<!--
<div class="title"><h2 class="p-cufon" id="txtt">{$company.firstname_bar}<span id="btnclosex" class="btnclosex-popup-newsletter" onclick="closePartner()">x</span></h2> </div>
-->
<div class="title"><h2>{$company.firstname_bar}<span id="btnclosex" class="btn-x" onclick="closePartner()">Close X</span></h2> </div>

<div class="content content-partner">
    {if isset($company) && count($company) > 0}
    <div class="content-partner-sub">
        <div class="logo">
            <div class="f-right-partner-all" id="f-partner-ie7">
                <div class="img-partner" id="img-partner-ie7" align="center">
                    <div class="chi-img-partner-ie7" id="chi-img-partner-ie8">
                    {if $company.partner_logo != ''}
                        <img style="width: auto;height: auto;max-width: 190px; max-height: 166px;display: block;"
                             src="{$MEDIAURL}/store/uploads/banner/images/partner/{$company.partner_logo}"
                             id="partner-logo"
                             alt="{$company.partner_logo}"/>
                        {else}
                        <img src="/modules/general/templates/images/ibb-comming.jpg" width="183"
                             height="154" id="partner-logo"
                             alt="default"/>
                    {/if}
                    </div>
                </div>
            </div>
        </div>
        <div class="contact">
            <h3>{$company.firstname}</h3>
            <p><span class="span-partner-list">Website: </span><a target="_blank" href="{$company.website_partner}">{$company.website_partner}</a></p>
            <!--<p><strong>{$company.firstname}</strong></p>-->
            <p><strong>Email: </strong><a href="mailto:{$company.general_contact_partner}">{$company.general_contact_partner}</a></p>
            <p><strong>Telephone: </strong> {$company.telephone}</p>
            <div>
                <p>
                    <strong>Address: </strong>
                    <span>{$company.street}</span><br />
                    <span>{$company.full_address}</span>
                </p>
                <p>
                    <strong>Postal Address: </strong>
                    <span>{$company.postal_address}</span><br />
                    <span>{$company.full_postal_address}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="clearthis"></div>
    <div class="description">
        <div class="des">{$company.description}</div>
    </div>
    {/if}
</div>
<script type="text/javascript">
    Cufon.replace('.p-cufon');
</script>