<ul>
	<li class="title">Property information</li>
    {if isset($bar_data) and is_array($bar_data) and count($bar_data) >0}
    	{foreach from = $bar_data key = i item = v}
        	<li id="left_{$i}" 
            	{if in_array($i,$limit_click_ar)} onclick="document.location='{$v.link}'" {/if} 
                {if $action_ar[1] == $i} class="select" {/if}>{$v.title}</li>
        {/foreach}
    {/if}
</ul>