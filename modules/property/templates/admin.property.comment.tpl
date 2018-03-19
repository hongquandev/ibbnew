<table width="100%" cellspacing="10" style="overflow:hidden;">
    <tr>
    	<td colspan="2">
        
        {if isset($comments) and is_array($comments) and count($comments) > 0}
        	<div class="note-list" style="max-height:400px">
        	{assign var = i value = 0}
        	{foreach from = $comments key = k item = comment}
            {assign var = i value = $i+1}
            <div class="note-item{if $i%2==0}1{else}2{/if}">
            	<p>{$comment.title} <span>on {$comment.time}</span>
                	<span class="link">
                    	<a href="{$comment.active_link}" {if $comment.active == 0} style="color:#ff0000;"{/if}>{$comment.active_label}</a> | 
                        <a href="javascript:void(0)" onclick ="deleteItem2('{$comment.delete_link}')">delete</a>
                    </span>
                </p>
                <div>
                {$comment.content}
                
                <p class="note-item-bottom">
                    <span>
                    Comment by {$comment.name}<br/>
                    {$comment.email}<br/>
                    </span>
                </p>
                </div>
            </div>
            {/foreach}
            </div>
        {else}    
        	There are not any comments.
        {/if}
        
        </td>
    </tr>
</table>

