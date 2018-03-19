<div class="bar-filter" style="width:auto;">
    <input type="hidden" name="cv" id="cv" value="{$form_data.state_code}" />
    <div style="float:right;margin-left:4px">
        <form name='frmGoto' id='frmGoto' method="post" action="{$form_action}{$mode}">
            <div class="input-box{$box}" style="width:100px">
                <select onchange="OrderSearch(this,'frmAdvanceSearch')" style="display:none">
                    {html_options options=$search_data.banner_order_by selected =$order_by}
                </select>
            </div>
        </form>
    </div>
    <div class="view-search-list" style="float: right;">
        <span  style="float:left; font-weight:bold; /*color:#CCCCCC;*/"> View as : </span>
        <div style="float:left; margin-left:5px; margin-right:5px;">
            <span class="pagging-search-list" style="float: left;margin-right: 23px;">{$review_pagging}</span>
            {if $mode == 'grid'}
            <a href="javascript:void(0)" onclick="return ActionChange('{$form_action}',false); " style="color:#666666">
                <img src="/modules/general/templates/images/list_{if $mode == 'grid'}up{else}selected{/if}.png" style="margin-left:5px;"/>
            </a>
            {else}
            {assign var=box value="-grid"}
            <a href="javascript:void(0)" onclick="return ActionChange('{$form_action}',true); " style="color:#666666">
                <img src="/modules/general/templates/images/grid_{if $mode == 'grid'}selected{else}up{/if}.png" style="margin-left:5px;" />
            </a>
            {/if}
        </div>
    </div>
</div>

