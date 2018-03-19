{literal}
<style type="text/css">
    .title-line {
        margin: 20px 0;
        padding-bottom: 10px;
        border-bottom: 1px solid #cbcbcb;
        font-size: 16px;
        font-weight: bold;
    }
</style>
{/literal}
<div class="container-l">
    <div class="container-r">
        <div class="container">
            <div class="main">
                <div class="col-main-1col user-register-application">
                    <div class="register-application-title">
                        <h1>My Files/Documentation</h1>
                    </div>
                    <div class="register-application-content">
                        {if isset($message) and strlen($message)>0}
                            <div class="message-box message-box-v-ie">
                                {$message}
                            </div>
                        {/if}
                        <form name="frmAgentFilesDocs" id="frmAgentFilesDocs" method="post" action="{$form_action}" enctype="multipart/form-data">
                            <div class="title-line">For Sales/Rental Application Required</div>
                            <div class="rental-row-file">
                                <label>Drivers License</label><span>*</span><br/>
                                <div class="file-box">
                                    <span class="file"><input type="file" class="file-required" name="file_drivers_license"/></span>
                                    <span class="file-name">{$files_user.file_drivers_license}</span>
                                    <span class="file-action">{if $files_user.file_drivers_license}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                                    <input class="file-delete" type="hidden" value="0" name="files_deleted[file_drivers_license]"/>
                                    {if $files_user.file_drivers_license_link}
                                        <span class="file-adds"><a href="{$ROOTURL}{$files_user.file_drivers_license_link}" style="text-decoration: underline;cursor: pointer;" target="_blank">View</a></span>
                                    {/if}
                                </div>
                            </div>
                            <div class="rental-row-file">
                                <label>Passport / Birth Certificate</label><span>*</span><br/>
                                <div class="file-box">
                                    <span class="file"><input type="file" class="file-required" id="file_passport_birth" name="file_passport_birth"/></span>
                                    <span class="file-name">{$files_user.file_passport_birth}</span>
                                    <span class="file-action">{if $files_user.file_passport_birth}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                                    <input class="file-delete" type="hidden" value="0" name="files_deleted[file_passport_birth]"/>
                                    {if $files_user.file_passport_birth_link}
                                        <span class="file-adds"><a href="{$ROOTURL}{$files_user.file_passport_birth_link}" style="text-decoration: underline;cursor: pointer;" target="_blank">View</a></span>
                                    {/if}
                                </div>
                            </div>
                            <div class="title-line">For Rental Application Required </div>
                            <div class="rental-row-file">
                                <label>Rental References</label><br/>
                                <div class="file-box">
                                    <span class="file"><input type="file" id="file_rental_references" name="file_rental_references"/></span>
                                    <span class="file-name">{$files.file_rental_references}</span>
                                    <span class="file-action">{if $files.file_rental_references}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                                    <input class="file-delete" type="hidden" value="0" name="files_deleted[file_rental_references]"/>
                                    {if $files.file_rental_references_link}
                                        <span class="file-adds"><a href="{$ROOTURL}{$files.file_rental_references_link}" style="text-decoration: underline;cursor: pointer;" target="_blank">View</a></span>
                                    {/if}
                                </div>
                            </div>
                            <div class="rental-row-file">
                                <label>Personal References</label><br/>
                                <div class="file-box">
                                    <span class="file"><input type="file" id="file_personal_references" name="file_personal_references"/></span>
                                    <span class="file-name">{$files.file_personal_references}</span>
                                    <span class="file-action">{if $files.file_personal_references}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                                    <input class="file-delete" type="hidden" value="0" name="files_deleted[file_personal_references]"/>
                                    {if $files.file_personal_references_link}
                                        <span class="file-adds"><a href="{$ROOTURL}{$files.file_personal_references_link}" style="text-decoration: underline;cursor: pointer;" target="_blank">View</a></span>
                                    {/if}
                                </div>
                            </div>
                            <div class="rental-row-file">
                                <label>Medicare / Pension card
                                </label><br/>
                                <div class="file-box">
                                    <span class="file"><input type="file" id="file_medicare_pension_card" name="file_medicare_pension_card"/></span>
                                    <span class="file-name">{$files.file_medicare_pension_card}</span>
                                    <span class="file-action">{if $files.file_medicare_pension_card}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                                    <input class="file-delete" type="hidden" value="0" name="files_deleted[file_medicare_pension_card]"/>
                                    {if $files.file_medicare_pension_card_link}
                                    <span class="file-adds"><a href="{$ROOTURL}{$files.file_medicare_pension_card_link}" style="text-decoration: underline;cursor: pointer;" target="_blank">View</a></span>
                                    {/if}
                                </div>
                            </div>
                            <div class="rental-row-file">
                                <label>Bank Statements
                                </label> <br/>
                                <div class="file-box">
                                    <span class="file"><input type="file" id="file_bank_statements" name="file_bank_statements"/></span>
                                    <span class="file-name">{$files.file_bank_statements}</span>
                                    <span class="file-action">{if $files.file_bank_statements}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                                    <input class="file-delete" type="hidden" value="0" name="files_deleted[file_bank_statements]"/>
                                    {if $files.file_bank_statements_link}
                                    <span class="file-adds"><a href="{$ROOTURL}{$files.file_bank_statements_link}" style="text-decoration: underline;cursor: pointer;" target="_blank">View</a></span>
                                    {/if}
                                </div>
                            </div>
                            <div class="rental-row-file">
                                <label>Student Card</label><br/>
                                <div class="file-box">
                                    <span class="file"><input type="file" name="file_student_card"/></span>
                                    <span class="file-name">{$files.file_student_card}</span>
                                    <span class="file-action">{if $files.file_student_card}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                                    <input class="file-delete" type="hidden" value="0" name="files_deleted[file_student_card]"/>
                                    {if $files.file_student_card_link}
                                    <span class="file-adds"><a href="{$ROOTURL}{$files.file_student_card_link}" style="text-decoration: underline;cursor: pointer;" target="_blank">View</a></span>
                                    {/if}
                                </div>
                            </div>
                            <div class="rental-row-file">
                                <label>Pay Slips
                                </label> <br/>
                                <div class="file-box">
                                    <span class="file"><input type="file" name="file_pay_slips"/></span>
                                    <span class="file-name">{$files.file_pay_slips}</span>
                                    <span class="file-action">{if $files.file_pay_slips}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                                    <input class="file-delete" type="hidden" value="0" name="files_deleted[file_pay_slips]"/>
                                    {if $files.file_pay_slips_link}
                                    <span class="file-adds"><a href="{$ROOTURL}{$files.file_pay_slips_link}" style="text-decoration: underline;cursor: pointer;" target="_blank">View</a></span>
                                    {/if}
                                </div>
                            </div>
                            <div class="rental-row-file">
                                <label>Utility Bills (phone, gas, electricity)
                                </label> <br/>
                                <div class="file-box">
                                    <span class="file"><input type="file" id="file_utility_bills" name="file_utility_bills"/></span>
                                    <span class="file-name">{$files.file_utility_bills}</span>
                                    <span class="file-action">{if $files.file_utility_bills}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                                    <input class="file-delete" type="hidden" value="0" name="files_deleted[file_utility_bills]"/>
                                    {if $files.file_utility_bills_link}
                                    <span class="file-adds"><a href="{$ROOTURL}{$files.file_utility_bills_link}" style="text-decoration: underline;cursor: pointer;" target="_blank">View</a></span>
                                    {/if}
                                </div>
                            </div>
                            <div class="rental-row-file">
                                <label>Other supporting files</label><br/>
                                <div class="file-box">
                                    <span class="file"><input type="file" id="file_other_supporting" name="file_other_supporting"/></span>
                                    <span class="file-name">{$files.file_other_supporting}</span>
                                    <span class="file-action">{if $files.file_other_supporting}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                                    <input class="file-delete" type="hidden" value="0" name="files_deleted[file_other_supporting]"/>
                                    {if $files.file_other_supporting_link}
                                    <span class="file-adds"><a href="{$ROOTURL}{$files.file_other_supporting_link}" style="text-decoration: underline;cursor: pointer;" target="_blank">View</a></span>
                                    {/if}
                                </div>
                            </div>
                            <br/><br/>
                            <div>
                                <div class="clearthis"></div>
                                <button type="button" class="btn-green-transact" onclick="SubmitForm('#frmAgentFilesDocs')">
                                    <span><span>Save Files</span></span>
                                </button>
                            </div>
                        </form>
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
                                            //right: '0',
                                            left: '0',
                                            top: ($(this).outerHeight() - settings.height) / 2 + 'px'
                                        }).fadeTo(100, 0);
                                    });
                                    $(".fileWrap input[type='file']").change(function () {
                                        var val = $(this).val().split('\\');
                                        var newVal = val[val.length-1];
                                        $(this).closest('.file-box').find(".file-name").text(newVal);
                                        $(this).closest('.file-box').find(".file-action").text('Delete');
                                        $(this).closest('.file-box').find(".file-delete").val('')
                                    })
                                };
                            })(jQuery);
                            jQuery(".file").customFileInput({
                                'btnText': 'Upload file' //text of the button
                            });
                            jQuery('span.file-action').click(function(){
                                var deleted_obj = jQuery(this).closest('.file-box').find(".file-delete");
                                if(deleted_obj.val() == 'deleted'){}else{
                                    deleted_obj.val('deleted');
                                    $(this).closest('.file-box').find(".file-name").text('');
                                    $(this).closest('.file-box').find(".file-action").text('No file');
                                }
                            });
                        });
                        function SubmitForm(frm){
                            var isSubmit = true;
                            jQuery('input[type=file].file-required',frm).each(function(){
                                if(jQuery(this).closest('.file-box').find(".file-name").text() == ''){
                                    jQuery(this).closest('.file-box').find(".file-name").addClass('file-validation-fail');
                                    isSubmit = false;
                                }else{
                                    jQuery(this).closest('.file-box').find(".file-name").removeClass('file-validation-fail');
                                }
                            });
                            if(isSubmit){
                                jQuery(frm).submit();
                            }
                        }
                        {/literal}
                    </script>
                </div>
                <div class="clearthis"></div>
            </div>
        </div>
    </div>
</div>


