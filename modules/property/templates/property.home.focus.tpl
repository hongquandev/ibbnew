{if isset($focus_data) and is_array($focus_data) and count($focus_data) > 0}
{*<link href="utils/slide/style.css" rel="stylesheet" type="text/css" />*}
<div class="focus-watermark" style="position: relative;">
    <div class="hero-box">
        <span class="bo"></span>
        <div class="hero-img" id="slideshow">
            <input type="button" class="button" name="ss_button" id="ss_button" onclick="document.location = '{$focus_first_href}'"/>
            {if is_array($focus_data) and count($focus_data) > 0}
                {assign var = i value = 0}
                {foreach from = $focus_data key = k item = row}
                    {if $i == 0}
                        {assign var = cls value = "show"}
                    {else}
                        {assign var = cls value = "hide"}
                    {/if}
                    <div class="{$cls}">
                        <div class="hero-text">
                            <p class="title">
                                {$row.address_full}
                            </p>
                            <p>
                                {$row.description}
                            </p>
                        </div>
                        <input type="hidden" name="link" value="{$row.href}"/>
                        <img alt="" src="{$MEDIAURL}/{$row.file_name}" class="hero-slide-img"/>
                        {if $row.isBlock}
                            <div class="focus-owner-block" >
                                <p class="title" style="">
                                    {$row.owner}
                                </p>
                            </div>
                            <img alt="" style="position: absolute; display: block; z-index: 3; left: 210px; top: 0px; right: 432px;" class="focus-watermark-ab" src="/modules/general/templates/images/block.png"/>
                        {/if}

                    </div>
                    {assign var = i value = $i+1}
                 {/foreach}
            {/if}

        </div>
    </div>
        {if count($focus_data) > 1}
            <script src="utils/slide/slide.js" type="text/javascript"></script>
        {/if}
    
</div>
{/if}
