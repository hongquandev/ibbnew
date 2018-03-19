<div class="container-l">
    <div class="container-r">
        <div class="container col2-right-layout">
            <div class="main">
                <div class="col-main cms">
                <h3>Management my newsletter</h3>
                    <b>You have successfully been unsubscribed from {$site_title_config}.</b>
                    <br>
                    <br>
                        {if $result == true}
                            You can resubscribe to {$site_title_config} <a href="{$link_sub}" style="color: #980000;">here</a>.
                        {else}
                            You are not an iBB's member. <a href="{$link_reg}" style="color: #980000;">Register here</a> to use iBB system.
                        {/if}
                 </div>
                <div class="clearthis"></div>
            </div>
        </div>
    </div>
</div>

