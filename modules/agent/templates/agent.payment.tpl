<div class="bar-title">
    <h2>MANAGE PACKAGE OF MY ACCOUNT</h2>
</div>

<div class="ma-info mb-20px">
    <div class="col2-set mb-20px">
        <div class="col">
            {if isset($message) and strlen($message)>0}
                <div class="message-box message-box-ie">
                    {$message}
                </div>
            {/if}
                <ul class="tabs">
                     <li><a href="javascript:void(0)" rel="upgrade" class="defaulttab">Package Information</a></li>
                     {if $authentic.parent_id == 0}
                        <li><a href="javascript:void(0)" rel="invoice">History Package & Billing</a></li>
                     {/if}
                </ul>
                <div id="upgrade" class="tab-content">
                    {include file="agent.package.info.tpl"}
                </div>
                {if $authentic.parent_id == 0}
                    <div id="invoice" class="tab-content">
                        {include file="agent.payment.invoice.tpl"}
                    </div>
                {/if}
        </div>
    </div>
</div>
<script type="text/javascript">
     var country_default = '{$country_default}';
     {literal}
     $(document).ready(function() {
                $('.tabs a').click(function(){
                       switch_tabs($(this));
                });
                switch_tabs($('.defaulttab'));
     });

     function switch_tabs(obj) {
         var id = obj.attr("rel");
         $('.tab-content').hide();
         $('.tabs a').removeClass("selected");
         $('#' + id).show();
         obj.addClass("selected");
         /*$('.message-box').hide();*/
     }
     {/literal}
</script>