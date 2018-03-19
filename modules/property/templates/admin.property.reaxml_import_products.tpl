<!-- Bootstrap styles -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="../modules/property/templates/style/jquery.fileupload.css">
<form method="post" name="frmProperty" id="frmProperty" action="{$form_action}" enctype="multipart/form-data">
    <table width="1140px" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr >
            <td colspan=2 align="center"><font color="#FF0000"></font></td>
        </tr>
        <tr>
            <td colspan=2 >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white">
                            <span class="adm-left">{$prev}</span>
                            REAXML IMPORT PRODUCTS
                            <span class="adm-right">{$next}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="1" bgcolor="#CCCCCC"></td>
                        <td align="left" valign="top" class="padding1">
                            <table width="100%" cellspacing="15">
                                <tr>
                                    <td valign="top">
                                        <div>
                                            <div class="container">
                                                <blockquote>
                                                    <p>
                                                        Please select a xml file and upload.
                                                    </p>
                                                </blockquote>
                                                <br>
                                                <!-- The fileinput-button span is used to style the file input field as button -->
                                                <span class="btn btn-success fileinput-button">
                                                    <i class="glyphicon glyphicon-plus"></i>
                                                    <span>Select files...</span>
                                                    <!-- The file input field used as target for the file upload widget -->
                                                    <input id="fileupload" type="file" name="files[]" multiple>
                                                </span>
                                                <br>
                                                <br>
                                                <!-- The global progress bar -->
                                                <div id="progress" class="progress">
                                                    <div class="progress-bar progress-bar-success"></div>
                                                </div>
                                                <!-- The container for the uploaded files -->
                                                <div id="files" class="files"></div>
                                                <br>

                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">Import Notes</h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <ul>
                                                            <li>The maximum file size for uploads in this demo is <strong>5 MB</strong> (default
                                                                file size is unlimited).
                                                            </li>
                                                            <li>You can <strong>drag &amp; drop</strong> files from your desktop on this webpage
                                                                (see
                                                                <a href="https://github.com/blueimp/jQuery-File-Upload/wiki/Browser-support">Browser
                                                                    support</a>).
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <script type="text/javascript">jQuery.noConflict();</script>
                                            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                                            <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
                                            <script src="../modules/property/templates/js/jquery.ui.widget.js"></script>
                                            <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
                                            <script src="../modules/property/templates/js/jquery.iframe-transport.js"></script>
                                            <!-- The basic File Upload plugin -->
                                            <script src="../modules/property/templates/js/jquery.fileupload.js"></script>
                                            <!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
                                            <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
                                            {literal}
                                                <script>
                                                    /*jslint unparam: true */
                                                    /*global window, $ */
                                                    $(function () {
                                                        'use strict';
                                                        // Change this to the location of your server-side upload handler:
                                                        var url = '{/literal}{$ROOTURL}{literal}'+'/api.property-import-xml.php';
                                                        $('#fileupload').fileupload({
                                                            url: url,
                                                            dataType: 'json',
                                                            done: function (e, data) {
                                                                $.each(data.result.files, function (index, file) {
                                                                    $('<p/>').text(file.name).appendTo('#files');
                                                                });
                                                            },
                                                            progressall: function (e, data) {
                                                                var progress = parseInt(data.loaded / data.total * 100, 10);
                                                                $('#progress .progress-bar').css(
                                                                        'width',
                                                                        progress + '%'
                                                                );
                                                            }
                                                        }).prop('disabled', !$.support.fileInput)
                                                                .parent().addClass($.support.fileInput ? undefined : 'disabled');
                                                    });
                                                </script>
                                            {/literal}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="1" bgcolor="#CCCCCC"></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="12" align="left" valign="top"><img src="/modules/general/templates/images/left_bot.jpg" width="16" height="16" /></td>
                        <td background="/modules/general/templates/images/bgd_bot.jpg">&nbsp;</td>
                        <td width="12" align="right" valign="top"><img src="/modules/general/templates/images/right_bot.jpg" width="16" height="16" /></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
