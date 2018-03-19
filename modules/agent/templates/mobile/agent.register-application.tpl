<script type="text/javascript" src="/modules/agent/templates/js/file.js"></script>
<div class="container-l">
    <div class="container-r">
        <div class="container">
            <div class="main">
                <div class="col-main user-register-application">
                    {if $transact_step && $transact_type}
                        {include file = "agent.register-application.`$transact_type`.step`$transact_step`.tpl"}
                    {else}
                        {localize translate="Can not find the template with this request"}.
                    {/if}
                </div>
                <div class="clearthis"></div>
            </div>
        </div>
    </div>
</div>

