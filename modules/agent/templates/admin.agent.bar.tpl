<ul>
	<li class="title">Agent information</li>
    {if isset($bar_data) and is_array($bar_data) and count($bar_data) >0}
    	{foreach from = $bar_data key = i item = v}
        	<li rel="{$v.rel}" {*{if in_array($i,$limit_click_ar)}*} {if $id > 0}onclick="document.location='{$v.link}'" {/if}{*{/if}*}
		{if $action_ar[1] == $v.key} class="select" {/if}>{$v.title}</li>
        {/foreach}
    {/if}
</ul>