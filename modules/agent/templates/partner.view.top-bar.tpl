{literal}
<style type="text/css">
.view-as {
	color: #CCCCCC;
	float: left;
	font-weight: bold;
	margin-left: -11px;
}
</style>
{/literal}
<div class="bar-title">
    <h2>SERVICES LIST</h2>
    <div class="bar-filter" style="width:auto;">
        {assign var = pmode value = ''}
        {if $mode == 'grid'}
            {assign var = pmode value = '&mode=grid'}
        {/if}
        <div style="float:right;margin-left:4px">
            <form name='frmGoto' id='frmGoto' method="post" action="{$form_action}{$pmode}">
                <div style="width:60px;float:left">
                    <select name='len' id='len' onchange="this.form.submit()">
                    {html_options options = $len_ar selected = $len}
                    </select>
                </div>
                <div style="width:120px;float:left">
                    <select name="order_by" id='order_by' onchange="this.form.submit()" style="display:none">
                    {html_options options=$search_data.banner_order_by selected =$order_by}
                    </select>
                </div>
            </form>
        </div>
        <div style="float:right;margin-left:0px">
            <div class="view-as">View as :</div>
            <div style="float:left; margin-left:22px;width:20px;">
                {if isset($mode) && $mode == 'grid'}
                    <a href="{$form_action}" style="color:#666666;">
                        <img src="'../../modules/general/templates/images/list_up.png" style="margin-left:-20px;"/>
                    </a>
                    <a href="{$form_action}&mode=grid" style="color:#666666">
                        <img src="'../../modules/general/templates/images/grid_selected.png" style="padding-left: 3px;"/>
                    </a>
                {else}
                    <a href="{$form_action}" style="color:#666666;">
                        <img src="'../../modules/general/templates/images/list_selected.png" style="margin-left:-20px;"/>
                    </a>
                    <a href="{$form_action}&mode=grid" style="color:#666666">
                        <img src="'../../modules/general/templates/images/grid_up.png" style="padding-left: 3px;"/>
                    </a>
                {/if}
            </div>
        </div>
    </div>
    <div class="clearthis"></div>
</div>