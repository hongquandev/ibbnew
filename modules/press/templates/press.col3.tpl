{*<div class="col-1 f-left">
    {include file="press.category.tpl"}
</div>*}
<div class="col-2 f-left">
    {if $entries}
    <ul class="list-entry" style="margin-top:-4px;clear:both">
        {foreach from=$entries key=k item=entry}
            <li class="normal-width {if $k != 0}not-first{/if}" style="width:100%">
                <span class="title"><a href="{$entry.url}">{$entry.title}</a></span>
                <div class="sub-info">
                    <a class="tag" href="{$ROOTURL}/press/{$entry.key}">{$entry.cat_name}</a>
                    <span>{$entry.show_date}</span>
                </div>
                <div class="clearthis"></div>
                <div class="content">
                    {if $entry.photo != ''}
                        <img class="shadow_photo f-left" src="{$entry.photo}" alt="{$entry.title}" width="160">
                    {/if}
                    {$entry.content}
                </div>
                <div class="clearthis" ></div>
                <div class="f-right" style="clear:both">
                    <a class="read-more" href="{$entry.url}">
                        <span>Read More</span>
                    </a>
                    {*<button type="button" onclick="document.location='{$entry.url}'">More...</button>*}
                </div>
                <div class="tag" style="clear:both">
                    {if count($entry.tag) >= 1}
                        {foreach from=$entry.tag item=tag}
                            <a class="tag" href="{$ROOTURL}/press/tags/{$tag}">{$tag}</a>
                        {/foreach}
                    {/if}
                </div>

            </li>
        {/foreach}
    </ul>
    {$pag_str}
    {/if}

</div>
<div class="col-3 f-right">
    {include file="press.side.right.tpl"}
</div>
<div class="clearthis"></div>