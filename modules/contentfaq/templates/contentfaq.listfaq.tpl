{literal}
<!--<link rel="stylesheet" type="text/css" href="modules/general/templates/lightbox/sample.css"/>-->
<link rel="stylesheet" type="text/css" href="modules/general/templates/lightbox/lightbox.css"/>
<script type="text/javascript" src="modules/general/templates/lightbox/lightbox_plus_min.js"></script>
<script type="text/javascript" src="modules/contentfaq/js/jquery.expander.js"></script>
<script type="text/javascript">
    if({/literal}{$isSearchResult}{literal}){
        $(function () {
            var query = $('#query-search').val();
            $('a.faq-title').click();
            $.fn.wrapInTag = function(opts) {
                var tag = opts.tag || 'strong'
                        , words = opts.words || []
                        , regex = RegExp(words.join('|'), 'gi') // case insensitive
                        , replacement = '<'+ tag +' class="query-found">$&</'+ tag +'>';
                return this.html(function() {
                    return $(this).html().replace(regex, replacement);
                });
            };
            // Usage
            $('.faq-title-txt,div.readmore').wrapInTag({
                tag: 'strong',
                words: [query]
            });
            $('div.readmore').expander({
                slicePoint: 500,
                expandText: 'Click Here to Read More',
                userCollapseText: 'Hide Text'
            });
        });
    }
</script>
{/literal}
<div class="common-questions questions">
    {$resultsTitle}
    {if count($rows) >0}
        {foreach from = $rows item = row}
            <div style="border-bottom: 1px dotted #D2D2D2; padding: 15px 0px;">
                <div style="margin-bottom: 15px">
                    <p class="title" >
                        <a href="javascript:void(0)" class="faq-title"  onclick="showNode('{$row.content_id}')" id="q{$row.content_id}" name="q{$row.content_id}">
                            <img src="modules/general/templates/images/IBB_1.png" width="16px;" class="faq" id="img1{$row.content_id}"/>
                            <span class="ttr faq-title-txt">{$row.question}</span>
                        </a>
                    </p>
                    <div class="clearthis"></div>
                </div>
                <div class="content {if $isSearchResult}readmore{/if}"  id="a{$row.content_id}" style="display: none;">
                    <div>{$row.answer}</div>
                </div>
            </div>
        {/foreach}
    {else}
        <div style="border-bottom: 1px dotted #D2D2D2;">
            <div style="margin-bottom: 15px">
                Nothing here matches your search
                <br>
                <br>
                <ul>
                    <li>Make sure all words are spelled correctly</li>
                    <li>Try different search terms</li>
                    <li>Try more general search terms</li>
                    <li>Try fewer search terms</li>
                </ul>
            </div>
        </div>
    {/if}
</div>
