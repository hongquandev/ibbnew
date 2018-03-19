{if $is_ie}
    <link href="/utils/ajax-upload/flash/css/default.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/utils/ajax-upload/flash/swfupload/swfupload.js"></script>
    <script type="text/javascript" src="/utils/ajax-upload/flash/js/swfupload.queue.js"></script>
    <script type="text/javascript" src="/utils/ajax-upload/flash/js/fileprogress.js"></script>
    <script type="text/javascript" src="/utils/ajax-upload/flash/js/handlers.js"></script>
    
    <script type="text/javascript" src="/modules/{$module}/templates/js/upload-common.js"></script>
    <script type="text/javascript" src="/modules/{$module}/templates/js/upload-flash.js"></script>
    
    <script type="text/javascript">
	sess_id = '{php}echo session_id();{/php}';
	max_allow = '{$max_allow}' == 'all'?0:{$max_allow};
	property_id = '{$property_id}';
    {literal}
    $(document).ready(function() {
        var upload1 = new SWFUpload({
            /* Backend Settings*/
            upload_url: "/modules/property/action.admin.php?action=upload-media&property_id="+property_id+"&type=photo&target=photo-container&flash=1",
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
			button_image_url : "/utils/ajax-upload/flash/browser78_19.gif",
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
{else}
    <link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css" />
    <link href="/modules/{$module}/templates/style/ajax-upload.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
    <script type="text/javascript" src="/modules/{$module}/templates/js/upload.js"></script>
    <script type="text/javascript" src="/modules/{$module}/templates/js/upload-common.js"></script>    
{/if}
<link href="/modules/general/templates/style/youtube.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/modules/general/templates/js/youtube.js"></script>
<table width="100%" cellspacing="5" class="media">
	<tr>
    	<td>
            <li class="wide">
                <label>
                    <strong>Upload Photo</strong>
                </label>
                
                <div class="input-box file-upload">
                	{if $is_ie}
                        <div style="padding-left: 5px;position: relative;z-index: 0;">
                            <span id="spanButtonPlaceholder1"></span>
                            <input id="btnCancel1" type="button" value="Cancel Uploads" onclick="cancelQueue(upload1);" disabled="disabled" style="height:22px;display:none"/>
                            <br/>
                        </div>
                        <div id="fsUploadProgress1"></div>
                    {else}
                        <div id="btn_photo" style="float: left;"></div>
                        <ul id="lst_photo" style="float:left;margin-left:10px" class="qq-upload-list">
                            {if count($photos)==0}No file chosen{/if}
                        </ul>
                        <br clear="all"/>
                        <script type="text/javascript">
                            var photo = new Media();
                            photo.multiple = true;
                            photo.max_allow = '{$max_allow}';
                            photo.init();
                            photo.uploader('btn_photo','lst_photo','/modules/property/action.admin.php?action=upload-media&type=photo&target=photo-container&property_id={$property_id}&token={$token}',1);
                        </script>
                    {/if}    
                </div>
            </li>
            <li class="wide">
                <div class="upload-img">
                    <ul class="photoupload-list" id="photo-container">
                        {if isset($photos) and is_array($photos) and count($photos)>0}
                            {foreach from = $photos key = k item = row}
                                <li id="photo_{$row.media_id}" style="width:180px;">
                                    <img src="{$row.file_name}" style='width:180px;height:115px'/><br/>
                                    <div class="photoupload-admin">
                                    <a class="photoupload-admin-delete" href="javascript:void(0)" onclick="deleteAction('{$row.action}','photo_{$row.media_id}','1')">Delete</a>
                                    <div class="photoupload-admin-default">
                                        <select name="fields[default]" id="default_{$row.media_id}" class="input-select" onchange="defaultAction('/modules/property/action.admin.php?action=default-media&media_id={$row.media_id}&property_id={$property_id}&default='+this.value,'default_{$row.media_id}',1)">
                                            <option value="0" {if $row.default == 0}selected{/if}>none</option>
                                            <option value="1" {if $row.default == 1}selected{/if}>default</option>
                                        </select>
                            		</div>
                                    </div>
                                </li>
                            {/foreach}
                        {/if}
                    </ul>
                </div>
            </li>
            <br clear="all"/>
            {if $is_yt == false}
            <li class="wide">
                {if $yt_form != ''}
                    {$yt_form}
                {else}
                    <label>
                        <strong>Upload Video</strong>
                    </label>
                    <div class="input-box file-upload">
                        <div id="btn_video" style="float: left;"></div>
                        
                        <ul id="lst_video" style="float:left;margin-left:10px" class="qq-upload-list">
                            {if count($videos)==0}No file chosen{/if}
                        </ul>
                        <br clear="all"/>
                        <script type="text/javascript">
                            var video = new Media();
                            video.uploader('btn_video','lst_video','/modules/property/action.admin.php?action=upload-media&type=video&target=video-container&property_id={$property_id}&token={$token}',1);
                        </script>
                    </div>
               {/if}
            </li>
            	{/if}
            <li class="wide">
                <div class="upload-video" id="video-container">
                    	{*if $is_yt == true*}
                        	<div id="yt_id" class="yt-container">
                            {if isset($videos) and is_array($videos) and count($videos) > 0}
                                {foreach from = $videos key = k item = row}
                                    <div id="{$row.file_name}"> 
                                    <img src="http://i.ytimg.com/vi/{$row.file_name}/0.jpg" style="height:20px" /> 
                                    <!--<img src="{$row.datas}" style="height:20px"/>-->
                                    [http://www.youtube.com/watch?v={$row.file_name}]                                
                                    <a href="javascript:void(0)" onclick="yt.del('{$row.file_name}')" >Delete</a></div>    
                                {/foreach}
                            {/if}
                            </div>
                        {*else}
                        	{if isset($videos) and is_array($videos) and count($videos) > 0}
                                {foreach from = $videos key = k item = row}
                                    <div id="video_{$row.media_id}" style="float:left;margin-right:10px;z-index:0">
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
                                        <object id="player{$row.media_id}" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player{$row.media_id}" width="328" height="200"> 
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
                                                    wmode="transparent"
                                                /> 
                                         </object> 
                                         {/if}
                                         <br/>
                                         <a href="javascript:void(0)" onclick="deleteAction('{$row.action}','video_{$row.media_id}','1')">Delete</a>
                                     </div>
                                    
                                {/foreach}
                        {/if}
                    {/if*}
                    
                    {if $is_yt == true}
                     
                    <div class="yt-container-button">
                        <input type="button" value="Upload to Youtube" onclick="yt.getForm()" class="yt-button"/>
                        <img src="/modules/general/templates/images/loading.gif" id="yt_loading" class="yt-loading" style="display:none"/><div id="yt_form"></div>
                        <br clear="all"/>
                        <h2 style="margin-top:10px">Video will be valid a short time after uploading.</h2>
                        
                    </div>
                    
                    {/if}
                    
                </div>
            </li>
         </td>
     </tr>
    <tr>
     	<td align="right">
        	<hr/>
        	<input type="button" class="button" value="Next" onclick="/*pro.submit(true);*/pro.goto('{$form_action}')"/>
        </td>
    </tr>
</table>