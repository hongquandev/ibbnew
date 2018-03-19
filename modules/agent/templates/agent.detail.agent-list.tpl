<div class="wrapper-tabs">
    <ul class="list">
    {foreach from=$sub_account item=account}
        <li>
            <a href="/?module=agent&action=view-detail-agent&uid={$account.agent_id}"
               title="View Profile Detail" class="f-left">
                <img style="width: 84px;" src="{$MEDIAURL}/{$account.logo}" alt="" title="" class="photo-shadow"/>
            </a>

            <div class="main-info f-left">
                <p><span class="title"><strong>{$account.full_name}</strong></span></p>

                <p class="vector tel">{$account.telephone}</p>

                <p class="vector address">{$account.full_address}</p><br/>
            {*<p class="p_e_agent"><a href="javascript:voice();" class="vector mail">Email</a></p>*}
            </div>
            <div class="clearthis"></div>
        </li>
    {/foreach}
    </ul>
{$sub_pag_str}
</div>