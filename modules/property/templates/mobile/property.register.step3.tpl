{*if $is_ie}
    <link href="/utils/ajax-upload/flash/css/default.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/utils/ajax-upload/flash/swfupload/swfupload.js"></script>
    <script type="text/javascript" src="/utils/ajax-upload/flash/js/swfupload.queue.js"></script>
    <script type="text/javascript" src="/utils/ajax-upload/flash/js/fileprogress.js"></script>
    <script type="text/javascript" src="/utils/ajax-upload/flash/js/handlers.js"></script>
    
    <script type="text/javascript" src="modules/{$module}/templates/js/upload-common.js"></script>
    <script type="text/javascript" src="modules/{$module}/templates/js/upload-flash.js"></script>
    <!--B-->
    <link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css" />
    <link href="modules/{$module}/templates/style/ajax-upload.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
    <script type="text/javascript" src="modules/{$module}/templates/js/upload.js"></script>
    <script type="text/javascript" src="modules/{$module}/templates/js/upload-common.js"></script>    
    <!--E-->
    <script type="text/javascript">
	sess_id = '{php}echo session_id();{/php}';
	max_allow = ('{$max_allow}' == 'all' ) ? 0 : {$max_allow};
	
    {literal}
    jQuery(document).ready(function() {
        var upload1 = new SWFUpload({
            /* Backend Settings*/
            upload_url: "/modules/property/action.php?action=upload-media&type=photo&target=photo-container&flash=1",
            post_params: {"PHPSESSID" : sess_id},
			file_post_name: 'qqfile',
    
            /* File Upload Settings*/
            file_size_limit : "102400",	/* 100MB*/
            file_types : "*.gif;*.jpg;*.jpeg;*.bmp;*.png",
            file_types_description : "All Files",
            file_upload_limit : max_allow,
            file_queue_limit : max_allow,
    
            /* Event Handler Settings (all my handlers are in the Handler.js file)*/
            file_dialog_start_handler : fileDialogStart,
            file_queued_handler : fileQueued,
            file_queue_error_handler : fileQueueError2,
            file_dialog_complete_handler : fileDialogComplete,
            upload_start_handler : uploadStart,
            upload_progress_handler : uploadProgress,
            upload_error_handler : uploadError,
            upload_success_handler : uploadSuccess2,
            upload_complete_handler : uploadComplete,
    
            /* Button Settings*/
            /*button_image_url : "utils/ajax-upload/flash/XPButtonUploadText_61x22.png",*/
			button_image_url : "utils/ajax-upload/flash/browser78_19.gif",
            button_placeholder_id : "spanButtonPlaceholder1",
			/*
            button_width: 61,
            button_height: 22,
            */
            button_width: 78,
            button_height: 19,
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,

			
            /* Flash Settings*/
            flash_url : "/utils/ajax-upload/flash/swfupload/swfupload.swf",
    
            custom_settings : {
                progressTarget : "fsUploadProgress1",
                cancelButtonId : "btnCancel1"
            },
            
            /* Debug Settings*/
            debug: false
        });
		
        
    });
    {/literal} 
    </script>
{else*}
    <link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css" />
    <link href="modules/{$module}/templates/style/ajax-upload.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
    <script type="text/javascript" src="modules/{$module}/templates/js/upload.js"></script>
    <script type="text/javascript" src="modules/{$module}/templates/js/upload-common.js"></script>    
{*/if*}

<link href="/modules/general/templates/style/youtube.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/modules/general/templates/js/youtube.js"></script>

<div class="step-3-info">
    <div class="step-name">
        <h2>{localize translate="Photos and Video"}</h2>
    </div>
    <div class="step-detail col2-set">
        <div class="col-1">
            <p style="text-align: justify">
                Please upload photo's of your property, the number as per your selected package.
            </p>
            <br/>
            <p style="text-align: justify">
                Please upload video of your property, as per your selected package.
                For photo's and video, remember the quality, clarity, light and what people will want to see, show the highlights of your property, the special features, but remember the basisc, kitchen, lounge, bedrooms and the exterior.  Your images promote your property for you, a picture is worth a thousand words.
            </p>
        </div>
        <div class="col-2 bg-f7f7f7">
        		{if strlen($message)>0}
                    <div class="message-box all-step-message-box">{$message}</div>
                {/if}
                        
              	<ul class="form-list form-property">
                <form name="frmProperty" id="frmProperty" method="post" action="{$form_action}" onsubmit="return pro.isSubmit('#frmProperty')">
                {if $can_upload_photo}
                <li class="wide">
                    <label>
                        <strong>{localize translate="Upload Photo"} </strong>(Allow format: .gif, .jpg, .jpeg, .bmp, .png; Max size:5M)
                    </label>
                
                	{*if $is_ie}
                        <div style="padding-left: 5px;position: relative;z-index: 0;">
                            <span id="spanButtonPlaceholder1"></span>
                            <input id="btnCancel1" type="button" value="Cancel Uploads" onclick="cancelQueue(upload1);" disabled="disabled" style="height:22px;display:none"/>
                            <br/>
                        </div>
                        <div id="fsUploadProgress1"></div>
                    {else*}
                        <div class="input-box file-upload">
                            <div id="btn_photo" style="float:left"></div>
                            <ul id="lst_photo" style="float:left;margin-left:10px" class="qq-upload-list">
                                {if count($photos)==0}
                                    {localize translate="No file chosen"}
                                {/if}
                            </ul>
                            <br clear="all"/>
                            
                            <script type="text/javascript">
                                var photo = new Media();
                                photo.multiple = true;
                                photo.max_allow = '{$max_allow}';
								photo.ie = {$is_ie};
                                photo.init();
                                photo.uploader('btn_photo', 'lst_photo', '/modules/property/action.php?action=upload-media&type=photo&target=photo-container');
                            </script>
                        </div>
                    {*/if*}
                </li>
                {/if}
                <li class="wide">
                    <div class="upload-img">
                        <ul class="photoupload-list" id="photo-container">
                        	{if isset($photos) and is_array($photos) and count($photos)>0}
                            	{foreach from = $photos key = k item = row}
                                	<li id="photo_{$row.media_id}">
                                    	<img src="{$row.file_name}" /> <br />                          
                               			<div class="photoupload-selects"> 
                                        
                                        <select name="fields[default]" id="default_{$row.media_id}" class="input-select" onchange="defaultAction('modules/property/action.php?action=default-media&media_id={$row.media_id}&property_id={$id}&default='+this.value,'default_{$row.media_id}',0)">
                                                <option value="0" {if $row.default == 0}selected{/if}>none</option>
                                                <option value="1" {if $row.default == 1}selected{/if}>default</option>
                               			 </select>
                                         
              						   	<a id="delete-selects" href="javascript:void(0)" onclick="deleteAction('{$row.action}','photo_{$row.media_id}')">Delete</a>
                                        </div>
                                    </li>
                                {/foreach}
                            {/if}
                        </ul>
                    </div>
                </li>
                <br clear="all"/>
                {*and $is_yt == false*}
                {if $can_upload_video }
                <li class="wide">
					{if $yt_form != ''}
                    	{$yt_form}
                    {else}                
                        <label>
                            <strong>{localize translate="Upload Video"} </strong>(Allow format: .flv, .mp4 {$video_max_size})
                        </label>
                        {*if $is_ie}
                            <div style="padding-left: 5px;position: relative;z-index: 0;">
                                <span id="spanButtonPlaceholder2"></span>
                                <input id="btnCancel2" type="button" value="Cancel Uploads" onclick="cancelQueue(upload2);" disabled="disabled" style="height:22px;display:none"/>
                                <br/>
                            </div>
                            <div id="fsUploadProgress2"></div>
                        
                        {else*}
                            <div class="input-box file-upload">
                                <div id="btn_video" style="float:left"></div>
                                <ul id="lst_video" style="float:left;margin-left:10px" class="qq-upload-list">
                                    {if count($videos)==0}No file chosen{/if}
                                </ul>
                                <br clear="all"/>
                                <script type="text/javascript">
                                    var video = new Media();
                                    video.max_allow = 'all';
                                    video.uploader('btn_video','lst_video', '/modules/property/action.php?action=upload-media&type=video&target=video-container');
                                </script>
                            </div>                    
                        {*/if*}
                   
                    {/if}
                </li>
                {/if}
                
                 <br clear="all"/>
                <input type="hidden" name="track" id="track" value="0"/>
                <input type="hidden" name="is_submit2" id="is_submit2" value="0"/>
                <input type="hidden" name="p_id" id="p_id" value="{$property_id}"/>
				</form>
                <li class="wide"></li>
                <li class="wide">
                    <div class="upload-video" id="video-container">
                    	
                        
                        	{*if $is_yt == true*}
                            	
                            	<div id="yt_id" class="yt-container">
                                {if isset($videos) and is_array($videos) and count($videos)>0}
                                    {foreach from = $videos key = k item = row}
                                        <div id="{$row.file_name}"> 
                                    
                                            <img src="http://i.ytimg.com/vi/{$row.file_name}/0.jpg" style="height:20px"/>
                                            <!--<img src="{$row.datas}" style="height:20px"/>-->
    										<!--<iframe width="560" height="315" src="https://www.youtube.com/embed/{$row.file_name}" frameborder="0" allowfullscreen></iframe>-->	
                                            <a href="javascript:void(0)" onclick="yt.del('{$row.file_name}')" >Delete</a></div>                                            
                                    {/foreach}
                                {/if}
                                </div>
                            {*else}
                            	{if isset($videos) and is_array($videos) and count($videos)>0}
                                    {foreach from = $videos key = k item = row}
                                        
                                       <div id="video_{$row.media_id}" style="z-index:0">
                                            {if $row.ext == 'wmv'}
                                                <object id="player{$row.media_id}" width='328' height='200' 
                                                classid='CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95' 
                                                standby='Loading Windows Media Player components...' type='application/x-oleobject' 
                                                codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112'>
                                                <param name='filename' value="{$row.file_name}" />
                                                <param name='Showcontrols' value='True' />
                                                <param name='autoStart' value='True' />
                                                <param name="wmode" value="transparent" />
                                                <embed type='application/x-mplayer2' src="{$row.file_name}" name='MediaPlayer' width='328' height='200' wmode="transparent"></embed>
                                                </object>
                                            {else}
                                                <object id="player{$row.media_id}"  name="player{$row.media_id}" width="328" height="200"> 
                                                        <param name="movie" value="/utils/flash-player/jwplayer/player.swf" />
                                                        <param name="allowfullscreen" value="true" /> 
                                                        <param name="allowscriptaccess" value="always" />
                                                        <param name="flashvars" value="file={$row.file_name}" />
                                                        <param name="wmode" value="transparent" />
                                                        <embed 
                                                            type="application/x-shockwave-flash"
                                                            id="player_{$row.media_id}"
                                                            name="player_{$row.media_id}"
                                                            src="/utils/flash-player/jwplayer/player.swf" 
                                                            width="328" 
                                                            height="200"
                                                            allowscriptaccess="always" 
                                                            allowfullscreen="true"
                                                            flashvars="file={$row.file_name}"
                                                            wmode="transparent"/>
                                                 </object>                                     
                                            {/if}
                                             <br/>
                                             <a href="javascript:void(0)" onclick="deleteAction('{$row.action}','video_{$row.media_id}')">Delete</a>
                                         </div> 
                                    {/foreach}
                                {/if}
                        {/if*}
                       
                        {*if $is_yt == true}
                        <div class="yt-container-button">
                            <input type="button" value="Upload to Youtube" onclick="yt.getForm()" class="yt-button" style="float:left;"/>
                            <img src="/modules/general/templates/images/loading.gif" id="yt_loading" class="yt-loading" style="display:none;float:left;"/>
                            <div id="yt_form"></div>
                            <br clear="all"/>
                            <h2 style="margin-top:10px">Video will be valid a short time after uploading.</h2>
                            <div>
	                            Here is a list of some well-known formats that YouTube supports:<br/>
                                <div style="margin-left:10px">
                                <i><b>WebM files</b> - Vp8 video codec and Vorbis Audio codecs</i><br/>
                                <i><b>.MPEG4</b>, 3GPP and MOV files - Typically supporting h264, mpeg4 video codecs, and AAC audio codec</i><br/>
                                <i><b>.AVI</b> - Many cameras output this format - typically the video codec is MJPEG and audio is PCM</i><br/>
                                <i><b>.MPEGPS</b> - Typically supporting MPEG2 video codec and MP2 audio</i><br/>
                                <i><b>.WMV</b></i><br/>
                                <i><b>.FLV</b> - Adobe-FLV1 video codec, MP3 audio</i><br/>
                                </div>
                            </div>
                        </div>
                        {/if*}
                    </div>
                </li>
                <!--end form-->
                </ul>
               <br clear="all"/>
            <script type="text/javascript">pro.is_submit = 'is_submit2';</script>
            <div class="buttons-set">
                <button class="btn-red step-eight-btn-red" onclick="(document.location.href='/?module=property&action=register&step=2')"><span><span>Back</span></span></button>
                <button class="btn-red" onclick="pro.submit('#frmProperty',true)">
                    <span><span>{localize translate="Save"}</span></span>
                </button>
                 <button class="btn-red" onclick="pro.submit('#frmProperty')">
                    <span><span>{localize translate="Next"}</span></span>
                </button>
            </div>
        </div>
        <div class="clearthis">
        </div>
    </div>
</div>
{literal}
<script type="text/javascript">
</script>
{/literal}