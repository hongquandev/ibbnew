<ul>
    {if isset($bar) and is_array($bar) and count($bar) >0}
    	{foreach from = $bar key = k item = v}
        	<li onclick="document.location='{$v.url}'">{$v.title}</li>
        {/foreach}
    {/if}
</ul>