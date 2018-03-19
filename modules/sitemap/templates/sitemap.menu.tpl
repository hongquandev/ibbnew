<div class="sm-menu">
{if count($menu_ar) > 0}
	{foreach from = $menu_ar key = k item = row}
    	{if $row.parent_id == 0}
    		<div><a href="{$ROOTURL}/{$row.url}">{$row.title}</a></div>
        {else}
        	<a href="{$ROOTURL}/{$row.url}">{$row.title}</a>
        {/if}
    {/foreach}
{/if}
</div>