{if $property_data.info.show_agent_logo == 1}
<div class="agentdetail-block">
    <h3 class="agentdetail-title">Agent Details</h3>
    <div class="agentdetail-content">
        <div class="agentdetail-image">
            {if $property_data.agent.logo != ''}
                <a href="{$property_data.me.link}">
                    <img width="192" height="auto" src="{$MEDIAURL}{$property_data.agent.logo}" alt="{$property_data.info.agent_name}" title="{$property_data.info.agent_name}"/>
                </a>
            {/if}
        </div>
        <div class="agentdetail-info">
            {*<p style="font-size: 15px"><strong>{$property_data.me.full_name}</strong></p>*}
            <p style="font-size: 15px;font-family: ProximaNova-Bold, Sans-serif"><strong>{$property_data.agent.company_name}</strong></p>
            <a style="font-size: 14px;color: #0094d8;font-family: ProximaNova-Bold, Sans-serif" href="http://{$property_data.agent.website}" target="_blank"><strong>{$property_data.agent.website}</strong></a>
            <br>
            <br>
            <p style="font-size: 14px">{$property_data.me.telephone}</p>
            <p style="font-size: 14px">{$property_data.me.full_address}</p>
            {*<a href="mailto:{$property_data.me.email_address}">{$property_data.me.email_address}</a>*}
            {*<a style="font-size: 14px" href="http://{$property_data.me.website}" target="_blank">{$property_data.me.website}</a>*}
            <br>
            <br>
            <div class="format-desc">
                <div id="short_des">
                    {$property_data.me.short_description}
                </div>
                <div id="full_des" style="display:none">
                    {$property_data.me.description}
                </div>
                {literal}
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $('.seemore-des').unbind('click').bind('click', function () {
                                $('#short_des').toggle();
                                $('#full_des').toggle();
                            });
                        });
                    </script>
                {/literal}
            </div>
        </div>
        <div class="clearthis"></div>
    </div>
</div>
    <div class="view-all-agents"><a href="{$property_data.me.link}">View all this Agents listings</a> </div>
{/if}