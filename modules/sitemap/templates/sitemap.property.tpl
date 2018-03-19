<a href="#"><b>PROPERTIES SITEMAP</b></a><br/>
<div class="sm-property">
{if count($property_ar) > 0}
	{foreach from = $property_ar key = k item = row}
    	<a href="{$row.detail_link}">{$row.address_full}</a>
    {/foreach}
{/if}
</div>
<br/>
<span>{$pag_str}</span>