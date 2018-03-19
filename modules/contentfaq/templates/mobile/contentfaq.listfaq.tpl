{literal}
<!--<link rel="stylesheet" type="text/css" href="modules/general/templates/lightbox/sample.css"/>-->
<link rel="stylesheet" type="text/css" href="modules/general/templates/lightbox/lightbox.css"/>
<script type="text/javascript" src="modules/general/templates/lightbox/lightbox_plus_min.js"></script>    
{/literal}
<div class="common-questions questions" >
    {foreach from = $rows item = row}
        <div style="border-bottom: 1px dotted #D2D2D2; padding: 15px 0px;">
            <div style="margin-bottom: 15px">
                <p class="title" >
                    <a href="javascript:void(0)"  onclick="showNode('{$row.content_id}')" id="q{$row.content_id}" name="q{$row.content_id}">
                        <img src="modules/general/templates/images/IBB_1.png" width="16px;" class="faq" id="img1{$row.content_id}"/>
                        <span class="ttr">{$row.question}</span>
                    </a>
                </p>
                <div class="clearthis"></div>
            </div>
            <div class="content"  id="a{$row.content_id}" style="display: none;">
                <div>{$row.answer}</div>
            </div>
        </div>
    {/foreach}
</div>
{literal}
<script type="text/javascript">
    jQuery(document).ready(function() {
        var width = $('.common-questions').width();
        $('.content img').removeAttr('width');
        $('.content img').removeAttr('height');
        $('.content img').css({
            'max-width' : width , 'height' : 'auto'
        });
    });
</script>
{/literal}
