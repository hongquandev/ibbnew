
<h1 class="rental-step-title">1. Complete your User details</h1>
<br/>
<p>
    Before you can register to transact or apply for a property, you must first complete the mandatory account details
</p>
<br/>
<p> Please confirm the below fields are correct and complete any missing fields. </p>
<br/>
<div class="rental-form-list">
    <div class="rental-row">
        <label for="firstname">First Name</label>
        <input id="firstname" class="input-text validate-require" type="text" value="{$data.firstname}" name="firstname"/>
    </div>
    <div class="rental-row">
        <label for="surname">Surname</label>
        <input id="surname" class="input-text validate-require" type="text" value="{$data.surname}" name="surname"/>
    </div>
    <div class="rental-row">
        <label for="email_address">Email</label>
        <input id="email_address" class="input-text validate-require" type="text" value="{$data.email_address}" name="email_address"/>
    </div>
    <div class="rental-row">
        <label for="phone_number">Phone/Mobile</label>
        <input id="phone_number" class="input-text validate-require" type="text" value="{$data.phone_number}" name="phone_number"/>
    </div>
    <div class="rental-row">
        <label for="street_address">Street Address</label>
        <input id="street_address" class="input-text validate-require" type="text" value="{$data.street_address}" name="street_address"/>
    </div>
    <div class="rental-row">
        <label for="city">City</label>
        <input id="city" class="input-text validate-require" type="text" value="{$data.city}" name="city"/>
    </div>
    <div class="rental-row">
        <label for="">Postcode</label>
        <input id="postcode" class="input-text validate-require" type="text" value="{$data.postcode}" name="postcode"/>
    </div>
    <div class="rental-row">
        <label for="country">Country</label>
        <input id="country" class="input-text validate-require" type="text" value="{$data.country}" name="country"/>
    </div>
    <br/>
    <p>
        If you have not yet done so, you are required to upload photo ID for validation purposes (this will be saved in your account and
        only needs to be done once)
    </p>
    <br/>
    <div class="rental-rows">
        <div class="rental-row-file">
            <label>Drivers License</label><br/>
            <div class="file-box">
                <span class="file"><input type="file" id="file_drivers_license_1" name="file_drivers_license_1"/></span>
                <span class="file-name">{$file.file_drivers_license_1}</span>
                <span class="file-action">{if $file.file_drivers_license_1}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                <input class="file-delete" type="hidden" value="0" name="files_deleted[file_drivers_license_1]"/>
            </div>
        </div>
        <div class="rental-row-file">
            <label>Passport / Birth Certificate</label> <br/>
            <div class="file-box">
                <span class="file"><input type="file" id="file_passport_birth_1" name="file_passport_birth_1"/></span>
                <span class="file-name">{$file.file_passport_birth_1}</span>
                <span class="file-action">{if $file.file_passport_birth_1}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                <input class="file-delete" type="hidden" value="0" name="files_deleted[file_passport_birth_1]"/>
            </div>
        </div>
    </div>
</div>

<h1 class="rental-step-title">2. Rental Application</h1>
<br/>
<p>To apply to rent a property you MUST complete a rental application. </p>
<br/>
<p>This application is an online application and links to your application will be sent to the Property Manager to view (or print)
    only, this is to enable them to be able to review and check your application and then confir with the Landlord.
    You may use our Online Rental Application form, or upload a scanned copy of the Agents rental application form (please note
    in some cases Property Managers will only allow for their Form, and not use our online application form, please check with the
    property manager for their preference)
</p>
<br/>
<p>The more information you provide the Property Manager the easier your application can be processed</p>
<br/>
<p>Please Note : This property may be subject to an online Rental auction, depending on demand and offers, this is managed by
    the Managing Agent and Landlord.</p>
<br>
<p style="line-height: 30px">Before proceeding please acknowledge that you have read and accept the bidRhino <a href="#" class="rental-link">terms and conditions</a>  by ticking the box
    <input type="checkbox" id="accept"/><label for="accept">&nbsp;&nbsp;&nbsp;</label>
</p>
<br/>
<div class="rental-rows">
    <div class="rental-row-file">
        <label>Online Application</label><br/>
        <div class="file-box btn-control" onclick="openApplication('{$link_application_form}')" style="text-align: center">
           <span class="file-text">
               Open / Edit Online Application Form
           </span>
        </div>
    </div>
    <div class="rental-row-file">
        <label>Application form</label> <br/>
        <div class="file-box">
            <span class="file"><input type="file" id="file_application_form" name="file_application_form"/></span>
            <span class="file-name">{$file.file_application_form}</span>
            <span class="file-action">{if $file.file_application_form}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
            <input class="file-delete" type="hidden" value="0" name="files_deleted[file_application_form]"/>
        </div>
    </div>
</div>

<h1 class="rental-step-title" id="rental_application_supporting">3. Rental Application supporting documentation</h1>
<br/>
<p>
    To apply to rent a property you need to meet the minimum requirements of a rental application.
    This requires you provide Photo ID, utility bills, salary and or bank statements, employment status and references
    Please upload pictures or scans for the below listed items. These documents will be saved in your account
    The more information you provide the Property Manager the easier your application can be processed
    You may upload more than 1 file per folder
</p>
<br/>
<div class="rental-rows">
    <div class="rental-row-file">
        <label>Drivers License</label><br/>
        <div class="file-box">
            <span class="file"><input type="file" name="file_drivers_License_2"/></span>
            <span class="file-name">{$file.file_drivers_License_2}</span>
            <span class="file-action">{if $file.file_drivers_License_2}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
            <input class="file-delete" type="hidden" value="0" name="files_deleted[file_drivers_License_2]"/>
        </div>
    </div>
    <div class="rental-row-file">
        <label>Rental References</label><br/>
        <div class="file-box">
            <span class="file"><input type="file" id="file_rental_references" name="file_rental_references"/></span>
            <span class="file-name">{$file.file_rental_references}</span>
            <span class="file-action">{if $file.file_rental_references}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
            <input class="file-delete" type="hidden" value="0" name="files_deleted[file_rental_references]"/>
        </div>
    </div>
</div>
<div class="rental-rows">
    <div class="rental-row-file">
        <label>Passport / Birth Certificate
        </label><br/>
        <div class="file-box">
            <span class="file"><input type="file" id="file_passport_birth_2" name="file_passport_birth_2"/></span>
            <span class="file-name">{$file.file_passport_birth_2}</span>
            <span class="file-action">{if $file.file_passport_birth_2}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
            <input class="file-delete" type="hidden" value="0" name="files_deleted[file_passport_birth_2]"/>
        </div>
    </div>
    <div class="rental-row-file">
        <label>Personal References</label><br/>
        <div class="file-box">
            <span class="file"><input type="file" id="file_personal_references" name="file_personal_references"/></span>
            <span class="file-name">{$file.file_personal_references}</span>
            <span class="file-action">{if $file.file_personal_references}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
            <input class="file-delete" type="hidden" value="0" name="files_deleted[file_personal_references]"/>
        </div>
    </div>
</div>
<div class="rental-rows">
    <div class="rental-row-file">
        <label>Medicare / Pension card
        </label><br/>
        <div class="file-box">
            <span class="file"><input type="file" id="file_medicare_pension_card" name="file_medicare_pension_card"/></span>
            <span class="file-name">{$file.file_medicare_pension_card}</span>
            <span class="file-action">{if $file.file_medicare_pension_card}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
            <input class="file-delete" type="hidden" value="0" name="files_deleted[file_medicare_pension_card]"/>
        </div>
    </div>
    <div class="rental-row-file">
        <label>Bank Statements
        </label> <br/>
        <div class="file-box">
            <span class="file"><input type="file" id="file_bank_statements" name="file_bank_statements"/></span>
            <span class="file-name">{$file.file_bank_statements}</span>
            <span class="file-action">{if $file.file_bank_statements}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
            <input class="file-delete" type="hidden" value="0" name="files_deleted[file_bank_statements]"/>
        </div>
    </div>
</div>
<div class="rental-rows">
    <div class="rental-row-file">
        <label>Student Card</label><br/>
        <div class="file-box">
            <span class="file"><input type="file" name="file_student_card"/></span>
            <span class="file-name">{$file.file_student_card}</span>
            <span class="file-action">{if $file.file_student_card}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
            <input class="file-delete" type="hidden" value="0" name="files_deleted[file_student_card]"/>
        </div>
    </div>
    <div class="rental-row-file">
        <label>Pay Slips
        </label> <br/>
        <div class="file-box">
            <span class="file"><input type="file" name="file_pay_slips"/></span>
            <span class="file-name">{$file.file_pay_slips}</span>
            <span class="file-action">{if $file.file_pay_slips}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
            <input class="file-delete" type="hidden" value="0" name="files_deleted[file_pay_slips]"/>
        </div>
    </div>
</div>
<div class="rental-rows">
    <div class="rental-row-file">
        <label>Other supporting files</label><br/>
        <div class="file-box">
            <span class="file"><input type="file" id="file_other_supporting" name="file_other_supporting"/></span>
            <span class="file-name">{$file.file_other_supporting}</span>
            <span class="file-action">{if $file.file_other_supporting}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
            <input class="file-delete" type="hidden" value="0" name="files_deleted[file_other_supporting]"/>
        </div>
    </div>
    <div class="rental-row-file">
        <label>Utility Bills (phone, gas, electricity)
        </label> <br/>
        <div class="file-box">
            <span class="file"><input type="file" id="file_utility_bills" name="file_utility_bills"/></span>
            <span class="file-name">{$file.file_utility_bills}</span>
            <span class="file-action">{if $file.file_utility_bills}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
            <input class="file-delete" type="hidden" value="0" name="files_deleted[file_utility_bills]"/>
        </div>
    </div>
</div>


<h1 class="rental-step-title">4. User Declaration</h1>
<br/>
<p>
    I acknowledge that by submitting this application, I am applying to lease this property
    I acknowledge and accept that my application is subject to the approval of the Owner (Landlord) of the property, and the
    availability of the property.
    I acknowledge that no action will be taken against the Agent, or the Owner if this application is not successful.
    I declare that all information contained and provided in this application is true and correct to the best of my knowledge and
    has been provided by me freely.
    If the successful applicant, I hereby offer to rent the property from the owner under a lease to be prepared by the Agent
    pursuant to the relevant local tenancies Act.
    I declare that I have inspected the property and am satisfied that the premises are in a reasonable and clean condition and I
    accept the premises as is.
    I authorise the Agent/Property Manager to obtain details of my rental references, my credit worthiness from the agent or
    landlord of my current and or previous residences, references from my current and previous employers, my personal and
    professional referees, and check any record, listing or database of defaults.
</p>
<br/>
<br/>
<p>I have read and accepted the above declaration. <input type="checkbox" id="argee" /><label for="argee">&nbsp;&nbsp;&nbsp;</label></p>
<br/>
<div class="rental-rows">
    <div class="rental-row-file">
        <label>Online Application</label><br/>
        <input type="hidden" id="is_save_application" name="is_save_application" value="0" />
        <div class="file-box btn-control" onclick="saveApplication()">
           <span class="file-text">
               Save Application (to edit and submit later)
           </span>
        </div>
    </div>
    <div class="rental-row-file">
        <label>Application form</label> <br/>
        <div class="file-box btn-control" onclick="submitApplication()">
            <span class="file-text">
               Submit Application
           </span>
        </div>
    </div>
</div>
<br/>
<p>
    By submitting this application, you consent to all the information you have provided, including your personal information
    being collected, used, held and disclosed by LITTLE Real Estate Pty LtidRhino.com Pty Ltd in accordance with its Privacy Policy.
</p>