<link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css" />
<link href="/modules/property/templates/style/ajax-upload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
<script type="text/javascript" src="/modules/property/templates/js/upload.js"></script>
<script type="text/javascript" src="/modules/property/templates/js/upload-common.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/modcoder_excolor/jquery.modcoder.excolor.js"></script>

<table width="100%" cellspacing="10" class="edit-table edit-table-personal-detail">
    <colgroup>
        <col width="19%">
        <col width="30%">
        <col width="19%">
        <col width="30%">
    </colgroup>
    <tbody>
        <tr>
            <td>
                <strong>Username</strong>
            </td>
            <td colspan="2">
                <div class="input-box">
                    <input type="text" name="fields[name]" id="name" style="width:100%"
                           value="{$form_data.name}"
                           class="input-text"/>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4" align="center">
                <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                    <legend><small>Logo</small></legend>
                </fieldset>
            </td>
        </tr>

        <tr>
            <td colspan="2" id="logo">
                <div class="input-box input-checkbox">
                    <input type="radio" name="fields[logo][]" id="default" value="default"
                           {if $form_data.logo == 'default'}checked{/if}/> <span>Use company's logo</span>
                    <br/>
                    <input type="radio" name="fields[logo][]" id="upload" value="upload"
                           {if $form_data.logo == 'upload'}checked{/if}/> <span>Upload new logo.</span>
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
                            photo_logo.uploader('btn_photo_logo', 'lst_photo_logo', '/modules/agent/action.admin.php?action=upload-background-top&target=container-photo-logo&token={$token}');
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
                {literal}
                <script type="text/javascript">
                    $('#logo input[type=radio]').bind('click',function(){
                        if ($(this).is(':checked')){
                            if ($(this).attr('id') == 'default'){
                                $('#logo-detail').hide();
                            }else{
                                $('#logo-detail').show();
                            }
                        }
                    })
                </script>
                {/literal}
            </td>
        </tr>
        <tr>
            <td>
                <strong>Background</strong>
            </td>
            <td>
                <input type="text" name="fields[background_logo]" id="background_logo" class="input-text"
                           value="{$form_data.background_logo}"/>
            </td>
        </tr>
        <tr>
            <td colspan="4" align="center">
                <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                    <legend><small>Background</small></legend>
                </fieldset>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <strong>Background Left</strong>
                <div class="input-box">
                    <div class="input-box file-upload">
                        <div id="btn_photo_left" style="float:left"></div>
                        <ul id="lst_photo_left" style="float:left;margin-left:10px" class="qq-upload-list">
                            No file chosen
                        </ul>
                        <br clear="all"/>
                        <script type="text/javascript">
                            var photo = new Media();
                            photo.uploader('btn_photo_left', 'lst_photo_left', '/modules/agent/action.admin.php?action=upload-background-left&target=container-photo-left&agent_id={$agent_id}&token={$token}');
                        </script>
                        <div id="container-photo-left">
                        {if $form_data.background_left != ''}
                            <a class="photoThumbDiv">
                                <i style="background-image: url('{$form_data.background_left}');
                                        class=" photoThumbImg"></i>
                                <span class="icons close-btn" lang="background-left"></span>
                            </a>
                        {*<img src="{$form_data.background_left}" alt="left" title="left"/>*}
                        {/if}
                        </div>
                    </div>
                </div>
            </td>

            <td colspan="2">
                <strong>Background Right</strong>
                <div class="input-box">
                    <div class="input-box file-upload">
                        <div id="btn_photo_right" style="float:left"></div>
                        <ul id="lst_photo_right" style="float:left;margin-left:10px" class="qq-upload-list">
                            No file chosen
                        </ul>
                        <br clear="all"/>
                        <script type="text/javascript">
                            var photo_right = new Media();
                            photo_right.uploader('btn_photo_right', 'lst_photo_right', '/modules/agent/action.admin.php?action=upload-background-right&target=container-photo-right&agent_id={$agent_id}&token={$token}');
                        </script>
                        <div id="container-photo-right">
                        {if $form_data.background_right != ''}
                            <a class="photoThumbDiv">
                                <i style="background-image: url('{$form_data.background_right}');
                                        class=" photoThumbImg"></i>
                                <span class="icons close-btn" lang="background-right"></span>
                            </a>
                        {/if}
                        </div>
                    </div>

                </div>
            </td>
        </tr>

        <tr>
            <td><strong>Settings</strong></td>
            <td>
                <div class="input-box input-checkbox">
                    <input type="checkbox" name="fields[repeat]" {if $form_data.repeat == 1}checked{/if}/>
                    <span>Repeat</span>
                    <br/>
                    <input type="checkbox" name="fields[fixed]" {if $form_data.fixed == 1}checked{/if} /> <span>Disable scroll background</span>
                </div>
                <div class="input-box">
                    <label><strong>Background</strong></label>
                    <input type="text" name="fields[background_color]" id="background" class="input-text"
                           value="{$form_data.background_color}"/>
                </div>
            </td>

        </tr>

        <tr>
            <td colspan="4" align="right">
                <hr/>
                <input type="hidden" name="next" id="next" value="0"/>
                <input type="hidden" name="cc_id" id="cc_id" value=""/>
                <input type="button" class="button" value="Save" onclick="agent.submit(false)" />
            </td>
        </tr>
    </tbody>
</table>

{literal}
<style type="text/css">
    #modcoder_colorpicker{z-index:2000;margin-top:5px !important}
</style>
{/literal}
<script type="text/javascript">
    var token = '{$token}';
    agent.init('name','{$form_data.site_id}','{$agent_id}');
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