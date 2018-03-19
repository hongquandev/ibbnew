<div style="margin:40px 0px">
	{if $row.video_id > 0}
    <div class="video-box" style="width:460px;float:left">
    	<!--
        <img src="/modules/general/templates/images/video-big.jpg" border="0"/>
        -->
        {$row.video_file}        
        <div class="vd-bottom">
            <span><b>FIND OUT MORE</b> - <i>WATCH THE VIDEO</i></span>
        </div>
    </div>
    
    <div class="" style="width:470px;float:right;text-align:center">
    	<h2>{$row.video_name}</h2>
        {$row.video_content}
    </div>
    <div class="clearthis"></div>
    {/if}
</div>



