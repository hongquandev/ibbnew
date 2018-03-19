{literal}        
        <script type="text/javascript">
            replaceCufon('lightbox-cufon');
        </script>
{/literal}
 
{*<h2  class="lightbox-cufon lightbox-vm-h2">Videos</h2>*}
<div  class="lightbox-vmm-col" id="lightbox-vmm-col"> 
    <div id="popup-videos" class="popup-videos">
            <div id="flash">
            		{if $is_yt}
                        {if isset($info.video) && count($info.video)>0}
                            {foreach from = $info.video key = k item = row}
								<iframe width="560" height="315" src="https://www.youtube.com/embed/{$row.file_name}" frameborder="0" allowfullscreen></iframe>				
                            {/foreach}
                        {elseif count($info.video)==0}
                            <span>No content provided</span>
                        {/if}                    
                    {else}
                        {if isset($info.video) && count($info.video)>0}
                            {foreach from = $info.video key = k item = row}
                                    <div id = "video_container_{$row.media_id}" class="video_container_flash">
                                        <div class="video_container-zoom"> <a href="javascript:void(0)"  onClick="showPVMV('video_container_sub_{$row.media_id}');vclose()" class="viewmorevideos" style="clear:both;">Zoom</a></div>
                                            <div id="video_container_sub_{$row.media_id}">
                                              {*classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"*}
    
                                            <object id="player{$row.media_id}" name="player{$row.media_id}" width="100%" height="100%">
                                                    <param name="movie" value="/utils/flash-player/jwplayer/player.swf" />
                                                    <param name="allowfullscreen" value="true" />
                                                    <param name="allowscriptaccess" value="always" />
                                                    <param name="flashvars" value="file={$row.file_name}" />
                                                    <embed
                                                        type="application/x-shockwave-flash"
                                                        id="player_{$row.media_id}"
                                                        name="player_{$row.media_id}"
                                                        src="/utils/flash-player/jwplayer/player.swf"
                                                        width="100%"
                                                        height="100%"
                                                        allowscriptaccess="always"
                                                        allowfullscreen="true"
                                                        flashvars="file={$row.file_name}"/>
                                             </object>
                                        
                                           </div>
                                     </div> 
                                      
                            {/foreach}
                        {elseif count($info.video)==0}
                            <span>No content provided.</span>
                        {/if}
                        {/if}
             </div>
    </div>
</div>
<div class="clearthis"></div>

{literal}        
        <script type="text/javascript">
            function vclose(){document.getElementById("lightbox-vmm-col").style.display="none";}
			function vopen(){document.getElementById("lightbox-vmm-col").style.display="block";}
        </script>
{/literal}