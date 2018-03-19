{if isset($focus_data) and is_array($focus_data) and count($focus_data) > 0}
{*<link href="utils/slide/style.css" rel="stylesheet" type="text/css" />*}
<div class="focus-watermark" style="position: relative;display: none">
    <div class="hero-box">
        <div class="hero-img">
            {if is_array($focus_data) and count($focus_data) > 0}
                {foreach from = $focus_data key = k item = row}
                    <div class="main-focus">
                        <div class="hero-text">
                            <p class="title">
                                {$row.address_full}
                            </p>
                        </div>
                        <input type="button" class="button" name="ss_button" onclick="document.location = '{$row.href}'"/>
                        <input type="hidden" name="link" value="{$row.href}"/>
                        <img  alt="" src="{$MEDIAURL}/{$row.file_name}" class="hero-slide-img"/>
                        {if $row.isBlock}
                            <div class="focus-owner-block" >
                                <p class="title" style="">
                                    {$row.owner}
                                </p>
                            </div>
                            <img alt="" style="position: absolute; display: block; z-index: 3; left: 210px; top: 0px; right: 432px;" class="focus-watermark-ab" src="/modules/general/templates/images/block.png"/>
                        {/if}
                    </div>
                 {/foreach}
            {/if}
        </div>
    </div>
</div>
{literal}
<script type="text/javascript">
    $(document).ready(function() {
        var width = $('.container').width();
        $('.hero-box img').css({
             'max-width' : width , 'height' : 'auto'
        });
        $('.hero-box .main-focus').css({
            'width': width,'height' : 'auto'
        });
        $(".hero-img").carouFredSel();
        $('.focus-watermark').slideDown();
    });
</script>
{/literal}
{/if}
