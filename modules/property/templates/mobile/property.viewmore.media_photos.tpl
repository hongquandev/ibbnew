<script type="text/javascript" src="/modules/general/templates/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="/modules/general/templates/shadowbox/demo.js"></script>
{literal}
    <script type="text/javascript">
        Shadowbox.init({
            overlayOpacity: 0.8
        }, setupDemos);
    </script>
    <script type="text/javascript">
        replaceCufon('lightbox-cufon');
    </script>
{/literal}
<h2 class="lightbox-cufon lightbox-vm-h2">Photos</h2>
<div class="lightbox-vmm-ing">
    <div class="gallery">
        {if isset($info.photo) and count($info.photo) > 0}
            {foreach from = $info.photo key = k item = row}
                <ul class="photos">
                    <li class="li-media lightbox-vmm-li">
                        <a class="mustang-gallery" href="{$MEDIAURL}/{$row.overlay_file_name}">
                            <img class="border img-media" src="{$MEDIAURL}/{$row.file_name}"/>
                        </a>
                    </li>
                </ul>
            {/foreach}
        {elseif count($info.photo) == 0}
            <span>No content provided.</span>
        {/if}
    </div>
</div>
{literal}
    <script type="text/javascript">
        $(function () {
            jQuery('.popup-vm-container').css('width', jQuery(window).width() - 20);
        });
    </script>
{/literal}