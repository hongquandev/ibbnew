{if $is_ie}
    <link href="/utils/ajax-upload/flash/css/default.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/utils/ajax-upload/flash/swfupload/swfupload.js"></script>
    <script type="text/javascript" src="/utils/ajax-upload/flash/js/swfupload.queue.js"></script>
    <script type="text/javascript" src="/utils/ajax-upload/flash/js/fileprogress.js"></script>
    <script type="text/javascript" src="/utils/ajax-upload/flash/js/handlers.js"></script>

    <script type="text/javascript" src="modules/property/templates/js/upload-common.js"></script>
    <script type="text/javascript" src="modules/property/templates/js/upload-flash.js"></script>

    <script type="text/javascript">
	sess_id = '{php}echo session_id();{/php}';
	max_allow = '{$max_allow}' == 'all'?0:{$max_allow};
    {literal}
    $(document).ready(function() {
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
{else}
    <link href="{$ROOTURL}/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css" />
    <link href="{$ROOTURL}/modules/property/templates/style/ajax-upload.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{$ROOTURL}/utils/ajax-upload/fileuploader.js"></script>
    <script type="text/javascript" src="{$ROOTURL}/modules/property/templates/js/upload.js"></script>
    <script type="text/javascript" src="{$ROOTURL}/modules/property/templates/js/upload-common.js"></script>
{/if}
<div class="title"><h2>{$upload.title}<span id="btnclosex" class="btnclosex-popup-newsletter" onclick="upload.closePopup()">x</span></h2> </div>
<div class="content" style="padding: 10px">
      <p><strong>{$upload.message}</strong></p>
      <div class="col2-set">
          <div class="col-1">
             <h3>Download RAF/AAF File</h3>
             <p>{$upload.download_msg}</p>
             <button class="btn-red" name="download" id="download" onclick="document.location='{$upload.download_file}'"><span><span>Download</span></span></button>          
          </div>
          <div class="col-2">
              <h3>Upload RAF/AFF File</h3>
              <p>{$upload.upload_msg}</p>
              <form name="frmUpload" method="post" id="frmUpload">
              {if $is_ie}
                  <div style="padding-left: 5px;position: relative;z-index: 0;">
                      <span id="spanButtonPlaceholder1"></span>
                      <input id="btnCancel1" type="button" value="Cancel Uploads" onclick="cancelQueue(upload1);"
                             disabled="disabled" style="height:22px;display:none"/>
                      <br/>
                  </div>
                  <div id="fsUploadProgress1"></div>
              {else}
                  <div class="input-box file-upload">
                      <div id="btn_file" style="float:left"></div>
                      <ul id="lst_file" style="float:left;margin-left:10px" class="qq-upload-list">
                      </ul>
                      <br clear="all"/>

                      <script type="text/javascript">
                          var file = new Media();
                          file.multiple = false;
                          file.max_allow = 'all';
                          file.init();
                          file.uploader('btn_file', 'lst_file', '/modules/general/action.php?action=uploadTerm');
                      </script>
                  </div>
              {/if}
              </form>
          </div>
          <div class="clearthis"></div>
      </div>
      <div class="button-pop-newsletter-customize">
        <input type="hidden" name="id" value="{$upload.property_id}">
        <button class="btn-red f-right" name="cancel" id="cancel" onclick="upload.closePopup()"><span><span>Upload later</span></span></button>
        <button style="margin-right:10px" class="btn-red btn-width f-right" name="submit" id="submit" onclick="upload.save()"><span><span>Upload</span></span</button>
      </div>
</div>