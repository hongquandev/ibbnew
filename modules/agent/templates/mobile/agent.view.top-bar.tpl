
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
    <form name='frmGoto' id='frmGoto' method="post" action="/{$form_action}{$pmode}">
        <h2>{$property_title_bar}</h2>
        <div class="bar-title-view-top">
            <div style=" float:right;">
                <select name='len' id='len' style="-webkit-appearance: menulist-button; height: 20px;"  onchange="this.form.submit()">
                    {html_options options = $len_ar selected = $len}
                </select>
            </div>

        </div>
        <div class="clearthis"></div>
        <div class="bar-filter" id="bar-filter" style="margin:10px 10px 0 0;">

            {assign var = pmode value = ''} 

            <div>{if $order_by_action == 'property_bids'}
                <div style=" float:left">
                    <select name="bids_filter" id="bids_filter" style="-webkit-appearance: menulist-button; height: 20px;"  onchange="this.form.submit()">
                        {html_options options =  $bids_filter selected = $bids_filter_select}
                    </select>
                </div>
                {/if}
                    <div style="width: 98px;float:left">
                        <select name="order_by" id='order_by' style="width:110px;-webkit-appearance: menulist-button; height: 20px;" onchange="this.form.submit()"
                                >
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

                </div>
            </div>
            <div class="clearthis"></div>
        </form>
    </div>
    <script type="text/javascript">
        //Cufon.replace('.title-top-bar');
    </script>
