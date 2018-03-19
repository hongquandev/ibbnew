
<div itemscope itemtype="http://schema.org/ItemList">
<meta itemprop="itemListOrder" content="Descending"/>
</div>

<script type="text/javascript" src="/modules/property/templates/js/topbar.js"></script>
<div class="bar-title">
    <h2>{$property_title_bar}</h2>
</div>
<div class="bar-action">
    <div class="bar-filter">
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
                {if $isKindTitleBar }
                    <div style="width:90px;float:left">
                        <select name="property_kind" id='property_kind' onchange="this.form.submit()" style="display:none">
                            {html_options options=$search_data.kinds selected =$property_kind}
                        </select>
                    </div>
                {/if}

                <div style="width:100px;float:left">
                    <select name="order_by" id='order_by' onchange="this.form.submit()" style="display:none">
                        {html_options options=$search_data.order_by selected =$order_by}
                    </select>
                </div>
                {else}
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
    </div>
    <div class="clearthis"></div>
</div>
