<div class="bar-filter">
    <input type="hidden" name="cv" id="cv" value="{$form_data.state_code}" />
	{if $mode == 'grid'}
        <div class="input-box-search-grid">
            <select id="srs1" name="search[order_by]" onchange="OrderSearch(this,'{$action}')" style="display:none">
                 {html_options options=$search_data.order_by selected =$form_data.order_by}
            </select>
        </div>
        <div class="view-search-grid" id="fixhd1">
            <span> View as : </span>
                <div style="float:left;margin-right:5px;">
                     <a href="javascript:void(0)" onclick="return ActionChange('{$action}',false); " style="color:#666666">
                             <img src="'../../modules/general/templates/images/list_up.png" style="margin-left:5px;"/>      
                     </a>
                     <a href="javascript:void(0)" onclick="return ActionChange('{$action}',true); "  style="color:#666666">
                           <img src="'../../modules/general/templates/images/grid_selected.png" style="margin-left:5px;" />     
                     </a>
                      
                </div>
        </div>
         <span style="color:#CCCCCC" id="fixhd2">{$review_pagging}</span>
    {else}
        <span class="pagging-search-list" style="float: left;margin-right: 23px;">{$review_pagging}</span>
        <div class="input-box">
            <select name="search[order_by]" onchange="OrderSearch(this,'{$action}')" style="display:none">
            {html_options options=$search_data.order_by selected =$form_data.order_by}
            </select>
        </div>
        <div class="view-search-list">
            <span  style="float:left; font-weight:bold; color:#CCCCCC;"> View as : </span>
            <div style="float:left; margin-left:5px; margin-right:5px;">
                <a href="javascript:void(0)" onclick="return ActionChange('{$action}',false); " style="color:#666666">
                <img src="'../../modules/general/templates/images/list_selected.png" style="margin-left:5px;"/>
                </a>
                <a href="javascript:void(0)" onclick="return ActionChange('{$action}',true); " style="color:#666666">
                <img src="'../../modules/general/templates/images/grid_up.png" style="margin-left:5px;" />
                </a>
            </div>
        </div>

    {/if}
    
</div>


