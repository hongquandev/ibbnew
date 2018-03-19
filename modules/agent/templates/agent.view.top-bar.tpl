
{literal}
<script type="text/javascript">
function OrderChangeStateCode(combo,form_action,mode){
    $('#order_by').val(combo.value);
    document.getElementById('frmSearch').action = '/'+form_action;
    return document.getElementById('frmSearch').submit();
   }
function ActionChange(form_action,mode){
        if (mode == ''){
            document.getElementById('frmSearch').action = '/'+form_action;
        }else{
            document.getElementById('frmSearch').action = '/'+form_action;
        }
        
        return document.getElementById('frmSearch').submit();
    }
</script>
{/literal}
<div class="bar-title">
    <div class="title-top-bar" style="color: white; font-size: 18px;">{localize translate=$property_title_bar}</div>
    <div class="bar-filter" id="bar-filter" style="width:auto !important;">

                {assign var = img_list value = 'list_selected'}
                {assign var = img_grid value = 'grid_up'}
                {assign var = pmode value = ''}
            {if $mode_fix == 'grid'}
                {assign var = img_list value = 'list_up'}
                {assign var = img_grid value = 'grid_selected'}
                {assign var = pmode value = '&mode=grid'}
            {/if}

        <div class="bar-title-view-top">
            <form name='frmGoto' id='frmGoto' method="post" action="/{$form_action}{$pmode}">
                <div style="width:60px;float:left">
                    <select name='len' id='len' onchange="this.form.submit()">
                    {html_options options = $len_ar selected = $len}
                    </select>
                </div>
            {if $order_by_action == 'property_bids'}
                <div style="width: 140px;float:left">
                    <select name="bids_filter" id="bids_filter" onchange="this.form.submit()">
                        {html_options options =  $bids_filter selected = $bids_filter_select}
                    </select>
                </div>
            {/if}
                <div style="width: 98px;float:left">
                    <select name="order_by" id='order_by' onchange="this.form.submit()"
                            style="display:none">
                    {if $order_by_action == 'property_bids'}
                        {html_options options = $search_data.bids_order_by selected = $order_by}
                    {else}
                        {if $order_by_action == 'watchlist'}
                        {html_options options=$search_data.watchlist_order_by selected =$order_by}
                        {else}
                        {if $order_by_action == 'view-auction'}
                            {html_options options=$search_data.agent_auction_order_by selected =$order_by}
                            {else}
                            {html_options options=$search_data.agent_order_by selected =$order_by}
                        {/if}
                    {/if}
                    {/if}
                    </select>
                </div>

            </form>
        </div>
        <div class="bar-title-view-top2">
            <!--<div class="view-as" style="float:left">View as :</div>-->
            <div class="agent-top-bar">
                    <a href="/?module=agent&action={$action}" style="color:#666666;">
                        <img src="/modules/general/templates/images/{$img_list}.png" style="*margin-left:-18px;"/>
                    </a>
                    <a href="/?module=agent&action={$action}&mode=grid" style="color:#666666">
                        <img src="/modules/general/templates/images/{$img_grid}.png" style="padding-left: 2px;*padding-left: 0px;"/>
                    </a>
            </div>
        </div>
    </div>
    <div class="clearthis"></div>
</div>
<script type="text/javascript">
    //Cufon.replace('.title-top-bar');
</script>
