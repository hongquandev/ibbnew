{literal}
    <style type="text/css">
        .acution-media{}
        .rrssb-buttons {margin-bottom: 20px;}
        .property-view-detail .img-list-box{
            margin-top: 15px;
        }
    </style>
{/literal}
<link rel="stylesheet" href="/modules/property/templates/style/flexslider.css" type="text/css" media="screen" />
{if isset($property_data.photo) and is_array($property_data.photo) and count($property_data.photo)>0}
    <div id="slider" class="flexslider" style="margin-bottom: 15px">
        <ul class="slides">
            {foreach from = $property_data.photo.photo key = k item = row}
                <li itemscope itemtype="http://schema.org/ImageObject">
                    <img src="{$MEDIAURL}/{$row.photo_file}" alt="photos" />
                </li>
            {/foreach}
        </ul>
    </div>
    <div id="carousel" class="flexslider" style="margin-bottom: 25px">
        <ul class="slides">
            {foreach from = $property_data.photo.photo_thumb key = k item = row}
                <li itemscope itemtype="http://schema.org/ImageObject">
                    <img src="{$MEDIAURL}/{$row.file_name}" alt="photos" />
                </li>
            {/foreach}
        </ul>
    </div>
{/if}
<script defer src="/modules/property/templates/js/jquery.flexslider.js"></script>
{literal}
<script type="text/javascript">
    jQuery(window).load(function(){
        jQuery('#carousel').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 140,
            itemMargin: 20,
            asNavFor: '#slider'
        });
        jQuery('#slider').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel"
        });
    });
</script>
{/literal}
<div class="property-desc">
    <div class="div-des-detail" style="font-size:12px;">
        <p class="word-wrap-all word-justify">
            {$property_data.info.description}
        </p>
        <div class="clearthis"></div>
    </div>
</div>
