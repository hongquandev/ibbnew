{literal}
<style type="text/css">
</style>
{/literal}
mobile
<div id="guide-content-div">
    <div id="guide-content-div-div">
        <div class="title"><h2 id="txtt">{$site_title_config} Quick Guide<span id="btnclosex" onclick="closeTourGuide()">x</span></h2> </div>
        <div class="content content-po-ie" style="height: 405px;padding: 10px 40px;margin: 0px;">
            <div id="content-right" class="content-menu-right" style="width: 666px;max-height: 400px;">
            {foreach from = $data key = k item = row}
                {assign var = "show" value = "display: none"}
                {assign var = "count" value = $k}
                {if $k == 0 }
                    {assign var = "show" value = "display: block"}
                {/if}
                <div id="{$k}" class="content" style="{$show}">
                    <div class="title_menu" style="padding: 10px 5px 15px 5px;color: #CC8C04;font-size: 14px !important; font-weight: bold;">
                        {$row.title}
                    </div>

                    <div style="padding: 0px 15px 15px 5px; text-align: justify;max-height: 345px;overflow-y: auto;height: 345px;">
                        {$row.content}
                    </div>
                </div>
            {/foreach}
            </div>
        </div>
        <a onclick="guidePrev({$count})" href="javascript:void(0)" class="pre"></a>
        <a onclick="guideNext({$count})" href="javascript:void(0)" class="next"></a>
    </div>
</div>
{literal}
<script type="text/javascript">
</script>
{/literal}