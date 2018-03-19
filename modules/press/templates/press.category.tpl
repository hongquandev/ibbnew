{if $options_category && count($options_category) > 0}
    <h3 class="press_tsb_categories"><span>Categories</span></h3>
    <ul class="list-category list-entries">
    {foreach from=$options_category item=cat}
        <li><a class="{if isset($catID) && $catID == $cat.cat_id}selected{/if}" href="{$ROOTURL}/press/{$cat.key}">{$cat.title}</a></li>
    {/foreach}
    </ul>
{/if}
