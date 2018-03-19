<div class="bar-title">
    <h2>{$property_title_bar}</h2>
    <div class="bar-filter">
        <div class="view-as">View as :</div>
        <div style="float:left; margin-left:18px;">
            <a href="/?module=property&action=view-{$actions[1]}-list" style="color:#666666;">
                <img src="'../../modules/general/templates/images/list_up.png" style="margin-left:-20px;"/>
             </a>
            <a href="/?module=property&action=view-{$actions[1]}-list&mode=grid" style="color:#666666">
                <img src="'../../modules/general/templates/images/grid_selected.png" style="padding-left: 3px;"/>
            </a>
        </div>
        {assign var = pmode value = ''}
        {if $mode == 'grid'}
            {assign var = pmode value = '&mode=grid'}
        {/if}
        
        <form name='frmGoto' id='frmGoto' method="post" action="{$form_action}{$pmode}" style="float:right;width: 60px;">
            <select name='len' id='len' onchange="this.form.submit()">
                {html_options options = $len_ar selected = $len}
            </select>

            <div class="input-box">
                <select name="order_by" id='order_by' onchange="this.form.submit()">
                    {html_options options=$search_data.order_by selected =$order_by}
                </select>
            </div>
        </form>
    </div>
    <div class="clearthis"></div>
</div>