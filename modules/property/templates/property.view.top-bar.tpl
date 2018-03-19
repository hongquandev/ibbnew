
<div itemscope itemtype="http://schema.org/ItemList">
<meta itemprop="itemListOrder" content="Descending"/>
</div>

<script type="text/javascript" src="/modules/property/templates/js/topbar.js"></script>
<div class="bar-title">
    <h1>{$property_title_bar}</h1>
    <div class="bar-filter" style="width:auto !important;*width: 280px !important;">

        {assign var = img_list value = 'list_up'}
        {assign var = img_grid value = 'grid_selected'}
        {assign var = pmode value = '&mode=grid'}
        {if $mode == 'list'}
            {assign var = img_list value = 'list_selected'}
            {assign var = img_grid value = 'grid_up'}
            {assign var = pmode value = ''}
        {/if}

        <div class="bar-title-view-top3">
            <form name='frmGoto' id='frmGoto' method="post" action="{$pag_link}">
            	{if !in_array($action, array('search', 'search-auction', 'search-sale','search-agent','search-ebiddar','search-agent-auction'))}
                    <div style="width:40px;float:left">
                        <select name='len' id='len' onchange="this.form.submit()">
                            {html_options options = $len_ar selected = $len}
                        </select>
                    </div>
                    {if $isKindTitleBar}
                        <div style="width:90px;float:left">
                            <select name="property_kind" id='property_kind' onchange="this.form.submit()" style="display:block">
                                {html_options options=$search_data.kinds selected = $property_kind}
                            </select>
                        </div>
                    {/if}

                    <div style="width:100px;float:left">
                        <select name="order_by" id='order_by' onchange="this.form.submit()" style="display:none">
                            {html_options options=$search_data.order_by selected =$order_by}
                        </select>
                    </div>
                {else}
                    {if TRUE}
                        <div style="width:110px;float:left">
                            <select name="property_kind" id='property_kind' onchange="KindChangeCode(this,'{$form_action}','{$pmode}')" style="display:block">
                                {html_options options=$search_data.kinds selected = $property_kind}
                            </select>
                        </div>
                    {/if}
                    <div style="width:120px;float:left">
                        <!--
                        <select name="order_by" onchange="OrderChangeStateCode(this,'{$form_action}','{$pmode}')" style="display:none">
                        -->
                        <select name="order_by" onchange="OrderChangeStateCode(this,'{$form_action}','{$pmode}')" style="display:none">
                            {html_options options=$search_data.order_by selected =$order_by}
                        </select>
                    </div>
                {/if}
            </form>
        </div>
        <div class="bar-title-view-top4">
            <div class="view-as" style="float:left"><!--View as :--></div>
            <div style="float:left;">

                {if in_array($action, array('search', 'search-auction', 'search-sale','search-agent'))}
                    <span class="pagging-search-list" style="float: left;margin-right: 23px;">{$review_pagging}</span>
                    <a href="javascript:void(0)" onclick="ActionChange('{$pag_link_list}','')" style="color:#666666;">
                        <img src="/modules/general/templates/images/{$img_list}.png" style="margin-left:-20px;"/>
                    </a>
                    <a href="javascript:void(0)" onclick="ActionChange('{$pag_link_grid}','')" style="color:#666666">
                        <img src="/modules/general/templates/images/{$img_grid}.png" style="padding-left: 3px;"/>
                    </a>
                {else}
                    <a href="{$pag_link_list}" style="color:#666666;">
                        <img src="/modules/general/templates/images/{$img_list}.png" style="*margin-left:-18px;"/>
                    </a>
                    <a href="{$pag_link_grid}" style="color:#666666">
                        <img src="/modules/general/templates/images/{$img_grid}.png" style="padding-left: 2px;*padding-left: 0px;"/>
                    </a>
                {/if}
            </div>
        </div>
    </div>
    <div class="clearthis"></div>
</div>
