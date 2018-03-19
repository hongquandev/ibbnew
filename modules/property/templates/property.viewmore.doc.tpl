{literal}
    <style type="text/css">
        .actived {
            font-weight: normal;
            color: #980000;
        }
    </style>
{/literal}
{literal}
    <script type="text/javascript">
        replaceCufon('lightbox-cufon');
    </script>
    <script type="text/javascript">
        function messlogin() {
            alert("You must login to download this file !");
        }
    </script>
{/literal}
{*<h2 class="lightbox-cufon lightbox-vm-h2">Legal Documents</h2>*}
<div class="lightbox-vmm-term">
    {if count($info)>0}
        <ul>
            {foreach from = $info key = k item = row}
                <li>
                    {$row.title|replace:'Download':''}:
                    {if $agent_id > 0}
                        <a name="activedoc" style="color: #00a6d5; text-decoration: underline;" href="javascript:void(0)"
                           onclick="pro.downDoc('/modules/property/action.php?action=down-doc&property_id={$row.property_id}&document_id={$row.document_id}');loading.hide(jQuery(this).parents('.lightbox-vmm-term'));">Download {$row.file_name}</a>
                    {else}
                        <a name="activedoc" style="color: #00a6d5; text-decoration: underline;" href="javascript:void(0)"
                           onclick="closePVM();showLoginPopup();">Download {$row.file_name}</a>
                    {/if}
                    {if $row.link_name}
                        or View {*{$row.title|replace:'Download':''}*} at <a name="activedoc" style="color: #00a6d5; text-decoration: underline;" target="_blank" href="{$row.link_name}">link here</a>
                    {/if}
                </li>
            {/foreach}
        </ul>
    {elseif count($info)==0}
        <span>No content provided.</span>
    {/if}
</div>
<div class="clearthis"></div>
<script type="text/javascript">
    {literal}
    var timer;
    var loading = new Loading();
    jQuery(document).ready(function ($) {
        jQuery('[name=activedoc]').click(function () {
            //jQuery('[name=activedoc]').each(function(){
            //	$(this).removeClass('actived');
            //});
            jQuery(this).addClass('actived');
            jQuery(this).parents('.lightbox-vmm-term').find('.contain-loading').remove();
        });
    });
    {/literal}
</script>