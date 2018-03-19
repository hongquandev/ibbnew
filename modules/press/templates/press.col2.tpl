<div class="col2-1 f-left">
    {if $entry}
        <span class="title">{$entry.title}</span>

        <div class="sub-info">
            <a class="tag" href="{$ROOTURL}/press/{$entry.key}">{$entry.cat_name}</a>
            <span>{$entry.show_date}</span>

        </div>
        <div class="clearthis"></div>
        
        <div class="content">
            {$entry.content}
        </div>
        <div class="tag">
            {if count($entry.tag) >= 1}
                {foreach from=$entry.tag item=tag}
                    <a class="tag" href="{$ROOTURL}/press/tags/{$tag}">{$tag}</a>
                {/foreach}
            {/if}
            <div class="tw-face f-right" style="width:200px;margin-top:5px">
                <div class="fb-like" style="float:right" data-href="{$entry.url}"
                    data-send="false" data-layout="button_count" data-width="35" data-show-faces="false">
                </div>

                <iframe allowtransparency="true" frameborder="0" scrolling="no"
                        src="//platform.twitter.com/widgets/tweet_button.html"
                        style="float:right;height: 22px;width: 81px;">
                </iframe>
            </div>
        </div>
    {/if}
</div>
<div class="col2-2 f-right">
    {include file="press.side.right.tpl"}
</div>
<div class="clearthis"></div>