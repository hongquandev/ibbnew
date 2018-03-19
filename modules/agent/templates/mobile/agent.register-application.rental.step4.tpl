{literal}
<style type="text/css">
</style>
{/literal}
<div class="register-application-title">
    <h1>Step 4. Rental Application Supporting Documentation</h1>
</div>
<div class="register-application-content">
    {if isset($message) and strlen($message)>0}
    <div class="message-box message-box-v-ie">
        {$message}
    </div>
    {/if}
    <form name="frmAgentTransact" id="frmAgentTransact" method="post" action="{$form_action_transact}" enctype="multipart/form-data">
        <input type="hidden" id="step" name="step"/>
        <input type="hidden" id="continue" name="continue" value="0"/>
        <p>To apply to rent a property you need to meet the minimum requirements of a rental application.</p>
        <p>This requires you provide Photo ID, utility bills, salary and or bank statements, employment status and references</p>
        <p>Please upload pictures or scans for the below listed items.  These documents will be saved in your account.</p>
        <p>The more information you provide the Property Manager the easier your application can be processed
            You may upload more than 1 file per folder</p>
        <div class="rental-row-file">
            <label>Drivers License</label><br/>
            <div class="file-box">
                <span class="file"><input type="file" name="file_drivers_license"/></span>
                <span class="file-name">{$files.file_drivers_license}</span>
                <span class="file-action">{if $files.file_drivers_license}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                <input class="file-delete" type="hidden" value="0" name="files_deleted[file_drivers_license]"/>
            </div>
        </div>
        <div class="rental-row-file">
            <label>Passport / Birth Certificate
            </label><br/>
            <div class="file-box">
                <span class="file"><input type="file" id="file_passport_birth" name="file_passport_birth"/></span>
                <span class="file-name">{$files.file_passport_birth}</span>
                <span class="file-action">{if $files.file_passport_birth}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                <input class="file-delete" type="hidden" value="0" name="files_deleted[file_passport_birth]"/>
            </div>
        </div>
        <div class="rental-row-file">
            <label>Rental References</label><br/>
            <div class="file-box">
                <span class="file"><input type="file" id="file_rental_references" name="file_rental_references"/></span>
                <span class="file-name">{$files.file_rental_references}</span>
                <span class="file-action">{if $files.file_rental_references}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                <input class="file-delete" type="hidden" value="0" name="files_deleted[file_rental_references]"/>
            </div>
        </div>
        <div class="rental-row-file">
            <label>Personal References</label><br/>
            <div class="file-box">
                <span class="file"><input type="file" id="file_personal_references" name="file_personal_references"/></span>
                <span class="file-name">{$files.file_personal_references}</span>
                <span class="file-action">{if $files.file_personal_references}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                <input class="file-delete" type="hidden" value="0" name="files_deleted[file_personal_references]"/>
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
            </div>
        </div>
        <div class="rental-row-file">
            <label>Student Card</label><br/>
            <div class="file-box">
                <span class="file"><input type="file" name="file_student_card"/></span>
                <span class="file-name">{$files.file_student_card}</span>
                <span class="file-action">{if $files.file_student_card}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                <input class="file-delete" type="hidden" value="0" name="files_deleted[file_student_card]"/>
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
            </div>
        </div>
        <div class="rental-row-file">
            <label>Other supporting files</label><br/>
            <div class="file-box">
                <span class="file"><input type="file" id="file_other_supporting" name="file_other_supporting"/></span>
                <span class="file-name">{$files.file_other_supporting}</span>
                <span class="file-action">{if $files.file_other_supporting}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                <input class="file-delete" type="hidden" value="0" name="files_deleted[file_other_supporting]"/>
            </div>
        </div>
        <br/><br/>
        <div>
            <div class="clearthis"></div>
            <button type="button" class="btn-green-transact" onclick="continueTransact('#frmAgentTransact',{$transact_step})">
                <span><span>Continue</span></span>
            </button>
        </div>
    </form>
</div>
<script type="text/javascript">
{literal}
function continueTransact(frm,transact_step){
    var isSubmit = true;
    if(isSubmit){
        jQuery('#step',frm).val(transact_step);
        jQuery('#continue',frm).val(1);
        jQuery(frm).submit();
    }
}
{/literal}
</script>

