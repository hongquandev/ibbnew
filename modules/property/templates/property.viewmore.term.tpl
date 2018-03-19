{literal}
        <script type="text/javascript">
            replaceCufon('lightbox-cufon');
        </script>
{/literal}
{*<h2 class="lightbox-cufon lightbox-vm-h2">Auction Terms</h2>*}
<div class="lightbox-vmm-term">
	{if isset($info) && count($info) > 0}
    	{foreach from = $info key = k item = row}
        	<ul>
                <li>
                    {if ($row.code == "deposit_required")}
                        {$row.title}: {$row.value} %
                    {/if}
                    {if ($row.code == "settlement_period")}
                        {$row.title}: {$row.value} days
                    {/if}
                    {if ($row.code == "contract_and_deposit_timeframe")}
                        {$row.title}: {$row.value} days
                    {/if}
                    {if ($row.code == "schedule")}
                        {$row.title}:
                        {if $row.value|strstr:"/store/uploads/files_schedule/"}
                            <a name="activedoc" style="color: #00a6d5; text-decoration: underline;"
                            target="_blank" href="{$ROOTURL}{$row.value}">Download file here</a>
                        {else}
                            <br>
                            <div class="rules"> {$row.rules} </div>
                        {/if}
                    {/if}
                </li>
            </ul>
        {/foreach}
    {/if}
</div>
{literal}
<style type="text/css">
    div.rules{
        text-align:  justify;
        padding: 15px !important;
        max-height: 270px;
        overflow-y: scroll;
        overflow:auto;
    }
</style>
{/literal}
<div class="clearthis"></div>