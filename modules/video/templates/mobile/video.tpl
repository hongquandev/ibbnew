<div class="container-l">
    <div class="container-r">
    	<img id="banner-header" src="" style="width:100%;display:none">
        <div class="container">
            {if $row.video_id > 0}
            <div class="video-box">
                <!--
                <img src="/modules/general/templates/images/video-big.jpg" border="0"/>
                -->
                {$row.video_file}
                {*<div class="vd-bottom">
                    <span><b>FIND OUT MORE</b> - <i>WATCH THE VIDEO</i></span>
                </div>*}

            </div>

            <div class="video-content">
                <h2>{$row.video_name}</h2>
                {$row.video_content}
            </div>
            {/if}
        </div>
    </div>
</div>









