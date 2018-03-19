{if is_array($file_ar) and count($file_ar) > 0}
	{foreach from = $file_ar key = k item = item}
    	<div class="media_item" id="item_{$k}">
            <img src="{$item.link}" id="img_{$k}" style="width:100px;height:100px" onclick="imgSelect(this)"/>
            <br/>{$item.file_name}
        </div>
    {/foreach}
{/if}