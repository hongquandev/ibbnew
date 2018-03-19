<link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css" />
<link href="/modules/property/templates/style/ajax-upload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
<script type="text/javascript" src="/modules/property/templates/js/upload.js"></script>
<script type="text/javascript" src="modules/property/templates/js/upload-common.js"></script>
<script type="text/javascript" src="modules/general/templates/js/modcoder_excolor/jquery.modcoder.excolor.js"></script>
<div class="bar-title">
    <h2>MY SITE</h2>
</div>

<div class="ma-info mb-20px">

    <div class="col2-set mb-20px">
        <div class="col">
            {if isset($message) and strlen($message)>0}
                <div class="message-box message-box-ie">
                    {$message}
                </div>
            {/if}
            <div id="message_content" class="message-box message-box-ie" style="display: none;">
            </div>
            <ul class="tabs">
                    <li><a href="/?module=agent&action=edit-company">Company Information</a></li>
                    <li><a href="/?module=agent&action=edit-site" class="defaulttab">Advanced Configurations</a></li>
            </ul>
        </div>

        <form name="frmAgent" id="frmAgent" method="post" action="{$form_action}">
        <ul class="form-list form-company" id="form-lper">
            <li class="wide">
                <label>
                    <strong>Your username<span id="notify_name">*</span></strong>
                </label>

                <div class="input-box">
                    <input type="text" name="fields[name]" id="name" {if $form_data.name != '' && !(isset($message) && strlen($message) > 0 )}disabled{/if} value="{$form_data.name}"
                           class="input-text"/>
                </div>
            </li>
            <li class="wide">
                <div class="des">
                    {$description}
                </div>
            </li>
        </ul>
        <fieldset class="top">
            <legend>Logo</legend>
        </fieldset>
            <ul class="form-list" name="logo">
                <li class="wide">
                    <div class="input-box input-checkbox">
                        <input type="radio" name="fields[logo][]" id="default" value="default" {if $form_data.logo == 'default'}checked{/if}/> <span>Use company's logo</span>
                        <br/>
                        <input type="radio" name="fields[logo][]" id="upload" value="upload" {if $form_data.logo == 'upload'}checked{/if}/> <span>Upload new logo.</span>
                    </div>
                    <div class="input-box" id="logo-detail" style="display:none">
                            <div class="input-box file-upload">
                                <div id="btn_photo_logo" style="float:left"></div>
                                <ul id="lst_photo_logo" style="float:left;margin-left:10px" class="qq-upload-list">
                                    No file chosen
                                </ul>
                                <br clear="all"/>
                                <script type="text/javascript">
                                    var photo_logo = new Media();
                                    photo_logo.uploader('btn_photo_logo', 'lst_photo_logo', '/modules/agent/action.php?action=upload_background_top&target=container-photo-logo');
                                </script>
                                <div id="container-photo-logo">
                                    {if $form_data.background_top != ''}
                                        <img src="{$form_data.background_top}" alt="top" title="top"/>
                                    {/if}
                                </div>
                            </div>
                            <i> You must upload with one of the following extensions: jpg, jpeg, gif, png. </i> <br
                                style="margin-bottom:5px;"/>
                            <i> Max size: 2Mb.</i>
                    </div>
                    <div class="input-box">
                        <label><strong>Background</strong></label>
                        <input type="text" name="fields[background_logo]" id="background_logo" value="{$form_data.background_logo}"/>
                    </div>
                </li>
            </ul>
            {literal}
            <script type="text/javascript">
                $('ul[name=logo] input[type=radio]').bind('click',function(){
                    if ($(this).is(':checked')){
                        if ($(this).attr('id') == 'default'){
                            $('#logo-detail').hide();
                        }else{
                            $('#logo-detail').show();
                        }
                    }
                });
                jQuery('ul[name=logo] input[type=radio]').each(function(){
                    if(jQuery(this).is(':checked')){
                        jQuery(this).click();
                    }
                })
            </script>
            {/literal}
        <fieldset class="top">
            <legend>Background</legend>
        </fieldset>

            <ul class="form-list">
                <li class="fields">
                    <div class="field">
                        <label>
                            <strong>Background Left </strong>
                        </label>

                        <div class="input-box">
                            <div class="input-box file-upload">
                                <div id="btn_photo_left" style="float:left"></div>
                                <ul id="lst_photo_left" style="float:left;margin-left:10px" class="qq-upload-list">
                                    No file chosen
                                </ul>
                                <br clear="all"/>
                                <script type="text/javascript">
                                    var photo = new Media();
                                    photo.uploader('btn_photo_left', 'lst_photo_left', '/modules/agent/action.php?action=upload_background_left&target=container-photo-left');
                                </script>
                                <div id="container-photo-left">
                                    {if $form_data.background_left != ''}
                                        <a class="photoThumbDiv">
                                            <i style="background-image: url('{$form_data.background_left}');
                                               class="photoThumbImg"></i>
                                            <span class="icons close-btn" lang="background_left"></span>
                                        </a>
                                        {*<img src="{$form_data.background_left}" alt="left" title="left"/>*}
                                    {/if}
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="field">
                        <label>
                            <strong>Background Right</strong>
                        </label>

                        <div class="input-box">
                            <div class="input-box file-upload">
                                <div id="btn_photo_right" style="float:left"></div>
                                <ul id="lst_photo_right" style="float:left;margin-left:10px" class="qq-upload-list">
                                    No file chosen
                                </ul>
                                <br clear="all"/>
                                <script type="text/javascript">
                                    var photo_right = new Media();
                                    photo_right.uploader('btn_photo_right', 'lst_photo_right', '/modules/agent/action.php?action=upload_background_right&target=container-photo-right');
                                </script>
                                <div id="container-photo-right">
                                     {if $form_data.background_right != ''}
                                        <a class="photoThumbDiv">
                                            <i style="background-image: url('{$form_data.background_right}');
                                               class="photoThumbImg"></i>
                                            <span class="icons close-btn" lang="background_right"></span>
                                        </a>
                                        {*<img src="{$form_data.background_right}" alt="right" title="right"/>*}
                                     {/if}
                                </div>
                            </div>

                        </div>
                    </div>
                </li>
                <li class="wide">
                    <label><strong>Settings</strong></label>
                    <div class="input-box input-checkbox">
                        <input type="checkbox" name="fields[repeat]" {if $form_data.repeat == 1}checked{/if}/> <span>Repeat</span>
                        <br />
                        <input type="checkbox" name="fields[fixed]" {if $form_data.fixed == 1}checked{/if} /> <span>Disable scroll background</span>
                    </div>
                    <div class="input-box">
                        <label><strong>Background</strong></label>
                        <input type="text" name="fields[background_color]" id="background" value="{$form_data.background_color}"/>
                    </div>
                </li>
            </ul>

        </form>
        <div id="button-set-myacc" class="buttons-set buttons-set-a">
            <button class="btn-red f-right btn-red-a" onclick="agent.submit('#frmAgent')">
                <span><span>Save</span></span>
            </button>
            <button style="margin-right:10px" class="btn-red f-right btn-red-a" onclick="document.location='{seo}?module=agent&action=view-detail-agency&uid={$authentic.id}{/seo}'">
                <span><span>View</span></span>
            </button>
            <div class="clearthis"></div>
        </div>
    </div>
</div>

{literal}
<style type="text/css">
    #modcoder_colorpicker{z-index:2000;margin-top:5px !important}
</style>
{/literal}
<script type="text/javascript">
    agent.init('name','{$form_data.site_id}');
    {literal}
        $("#background").modcoder_excolor({
               border_color : '#6b676b',
               shadow : false,
               background_color : '#fcfafc',
               backlight : false
        });
        $("#background_logo").modcoder_excolor({
               border_color : '#6b676b',
               shadow : false,
               background_color : '#fcfafc',
               backlight : false
        });
    {/literal}
</script>