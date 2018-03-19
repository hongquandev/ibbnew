<link rel="stylesheet" type="text/css" href="{$ROOTURL}/modules/term/templates/style/rental.css"/>
<div class="container-l">
    <div class="container-r">
        <div class="rental-content">
            {if isset($message) and strlen($message) > 0}
                <div class="message-box all-step-message-box">{$message}</div>
            {/if}
            <form id="frmTerm" name="frmTerm" method="post" action="{$form_action}" enctype="multipart/form-data">
                {*Complete your User details*}
                {include file="rental.view.form.application.tpl"}
            </form>
        </div>

    </div>
</div>
<script type="text/javascript">
    {literal}
    jQuery(document).ready(function () {
        (function ($) {
            $.fn.customFileInput = function (options) {
                var settings = $.extend({
                    'width': '108px', //width of button
                    'height': '29px',  //height of text
                    'btnText': 'Upload file' //text of the button
                }, options);
                this.each(function () {
                    $(this).addClass('fileWrap').css({width: settings.width})
                            .append("<input type='button' class='file-button' value='" + settings.btnText + "' style='height:" + settings.height + "' />")
                            .find("input[type='file']").css({
                        height: settings.height,
                        width: settings.width,
                        zIndex: '99',
                        position: 'absolute',
                        right: '0px',
                        top: ($(this).outerHeight() - settings.height) / 2 + 'px'
                    }).fadeTo(100, 0);
                });
                $(".fileWrap input[type='file']").change(function () {
                    var val = $(this).val().split('\\');
                    var newVal = val[val.length-1];
                    $(this).closest('.file-box').find(".file-name").text(newVal);
                    $(this).closest('.file-box').find(".file-action").text('delete');
                })
            };
        })(jQuery);
        jQuery(".file").customFileInput({
            'btnText': 'Upload file' //text of the button
        });
        jQuery('span.sp-delete').click(function(){
            jQuery(this).closest('.file-box').find(".file-delete").val('deleted');
            $(this).closest('.file-box').find(".file-name").text('');
            $(this).closest('.file-box').find(".file-action").text('No file');
        });
    });
    function saveApplication(){
        jQuery('#is_save_application').val(1);
        submitApplication();
    }
    function submitApplication(){
        /**/
        var validation = new Validation('#frmTerm');
        if(validation.isValid()){
            if(jQuery('#argee').attr('checked') == 'checked'){
                /*if(){

                }else{
                    showMess__('Please edit Online Rental Application form, or upload a scanned copy of the Agents rental application form.')
                }*/
                jQuery('#frmTerm').submit();
            }else{
                showMess__('Plese check the box "I have read and accepted the above declaration."');
            }
        }else{
            jQuery("html, body").animate({ scrollTop: 0 }, "fast");
        }
    }
    function openApplication(link){
        if(jQuery('#accept').attr('checked') == 'checked'){
           document.location = link;
        }else{
            showMess__('Plese check the box "Before proceeding please acknowledge that you have read and accept the bidRhino terms and conditions by ticking the box."');
        }
    }
    {/literal}
</script>
