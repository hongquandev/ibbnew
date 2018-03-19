<ul class="tabs-bar">
	<li class="title">Group information</li>
    {if isset($bar_data) and is_array($bar_data) and count($bar_data) > 0}
    	{foreach from = $bar_data key = i item = v}
        	<li ref="{$v.ref}">{$v.title}</li>
        {/foreach}
    {/if}
</ul>