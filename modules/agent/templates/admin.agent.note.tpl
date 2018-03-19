<table width="100%" cellspacing="10">
    <tr>
    	<td colspan="2">
        
        {if isset($notes) and is_array($notes) and count($notes) > 0}
        	<div class="note-list" style="max-height:400px">
        	{assign var = i value = 0}
        	{foreach from = $notes key = k item = note}
            {assign var = i value = $i+1}
            <div class="note-item{if $i%2==0}1{else}2{/if}">
            	<p>{$note.time} <span> on <a href="{$note.property_link}">property #{$note.property_id}</a></span>
                	<span class="link">
                    	{*<a href="{$note.active_link}" {if $note.active == 0} style="color:#ff0000;"{/if}>{$note.active_label}</a> | *}
                        <a href="javascript:void(0)" onclick ="deleteItem2('{$note.delete_link}')">delete</a>
                    </span></p>
                <div>
                {$note.content}
                </div>
            </div>
            {/foreach}
            </div>
        {else}
            
        {/if}
        
        </td>
    </tr>
</table>

