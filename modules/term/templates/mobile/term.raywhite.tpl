{if isset($message) and strlen($message) > 0}
    <div class="message-box all-step-message-box">{$message}</div>
{/if}
<form id="frmTerm" name="frmTerm" method="post" action="{$form_action}">
<div class="input-box">
    <input type="checkbox" name="remember" value="1"/>
    <label>Remember for another register bid after.</label>
</div>
<link rel="stylesheet" type="text/css" href="/modules/term/templates/mobile/style/raywhite.css"/>
<div class="header-term">
    <div class="center">
        <p><u><strong>Residential Tenancy Application Form</strong></u></p>
        <p>For your application to be processed you must answer all questions (including the reverse side)</p>
    </div>
</div>
<div class="content">
    <div class="block">
        <h3>1. PROPERTY THAT YOU ARE APPLYING FOR:</h3>
        <div class="content">
            <div class="row">
                <label>Address</label>
                <div class="input-box">
                    <input type="text" name="field[address]" value="{$data.address}" style="width:244px"/>
                </div>
            </div>
            <div class="row">
                <label>Suburb</label>
                <div class="input-box">
                    <input type="text" name="field[suburb]" value="{$data.suburb}" style="width:100px;"/>
                </div>
                <label>Postcode</label>
                <div class="input-box">
                    <input type="text" name="field[postcode]" value="{$data.postcode}" style="width:85px"/>
                </div>
            </div>
            <div class="row">
                <label><strong>Date Property is required</strong></label>
                <div class="input-box">
                    <input type="text" name="field[date_required]" value="{$data.date_required}" style="width:30px;"/>
                </div>
                <label>/</label>
                <div class="input-box">
                    <input type="text" name="field[month_required]" value="{$data.month_required}" style="width:30px"/>
                </div>
                <label>/</label>
                <div class="input-box">
                    <input type="text" name="field[year_required]" value="{$data.year_required}" style="width:30px"/>
                </div>
            </div>
            <span class="double italic">Must be completed</span>
            <div class="row">
                <label>Property  Rental $</label>
                <div class="input-box">
                    <input type="text" name="field[rental]" value="{$data.rental}" style="width:118px"/>
                </div>
                <label>Per Week</label>
            </div>
            <div class="row">
                <label>Required Lease Term </label>
                <div class="input-box">
                    <input type="text" name="field[term]" value="{$data.term}" style="width:50px"/>
                </div>
            </div>
            <div class="row">
                <label>Years</label>
                <div class="input-box" >
                    <input type="text" name="field[term_years]" value="{$data.term_years}" style="width:50px"/>
                </div>
                <label>Months</label>
                <div class="input-box">
                    <input type="text" name="field[term_months]" value="{$data.term_months}" style="width:50px"/>
                </div>
            </div>
            <span class="single-line">Number of other Applicants to Occupy the Property </span>
            <div class="row">
                <label>Other Name(s): </label>
                <div class="input-box">
                    <input type="text" name="field[other_name]" value="{$data.other_name}" style="width:200px"/>
                </div>
            </div>
            <div class="row">
                <label>Adults  </label>
                <div class="input-box">
                    <input type="text" name="field[adults]" value="{$data.adults}" style="width:100px"/>
                </div>
                <label>Children: </label>
                <div class="input-box">
                    <input type="text" name="field[children]" value="{$data.children}" style="width:95px" />
                </div>
            </div>

            <div class="row-checkbox">
                <label>Please tick:</label>
                <label>Smoker:</label>
                <label>Yes</label><input type="checkbox" name="field[smoker]" value="1" {if $data.smoker == 1}checked{/if}/>
                <label>No</label><input type="checkbox" name="field[smoker]" value="-1" {if $data.smoker == -1}checked{/if}/>
            </div>

            <div class="row-checkbox">
                <label>Do you have pets?</label>
                <label>Yes</label><input type="checkbox" name="field[pets]" value="1" {if $data.pets == 1}checked{/if}/>
                <label>No</label><input type="checkbox" name="field[pets]" value="-1" {if $data.pets == -1}checked{/if}/>
            </div>

            <div class="row">
                <label>If Yes, please specify: </label>
                <div class="input-box">
                    <input type="text" name="field[specify_1]" value="{$data.specify_1}"/>
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <h3>2. PERSONAL DETAILS: </h3>
        <div class="content">
            <div class="row">
                <label>Title</label>
                <div class="input-box">
                    <input type="text" name="field[personal_title]" value="{$data.personal_title}" style="width:39px"/>
                </div>
                <label>First Name</label>
                <div class="input-box">
                    <input type="text" name="field[personal_firstname]" value="{$data.personal_firstname}" style="width:155px"/>
                </div>
            </div>
            <div class="row">
                <label>Initial</label>
                <div class="input-box">
                    <input type="text" name="field[personal_initial]" value="{$data.personal_initial}" style="width:100px"/>
                </div>
                <label>Last Name</label>
                <div class="input-box">
                    <input type="text" name="field[personal_lastname]" value="{$data.personal_lastname}" style="width:92px"/>
                </div>
            </div>
            <div class="row">
                <label>Date of Birth</label>
                <div class="input-box">
                    <input type="text" style="width:60px" name="field[personal_dob_d]" value="{$data.personal_dob_d}"/>
                </div>
                <label>/</label>
                <div class="input-box">
                    <input type="text" style="width:60px" name="field[personal_dob_m]" value="{$data.personal_dob_m}"/>
                </div>
                <label>/</label>
                <div class="input-box">
                    <input type="text" style="width:60px" name="field[personal_dob_y]" value="{$data.personal_dob_y}"/>
                </div>
            </div>
            <div class="row">
                <label>Home Ph</label>
                <div class="input-box">
                    <input type="text" style="width:85px" name="field[personal_homeph]" value="{$data.personal_homeph}"/>
                </div>
                <label>Mobile Ph</label>
                <div class="input-box">
                    <input type="text" style="width:85px" pname="field[personal_mobileph]" value="{$data.personal_mobileph}"/>
                </div>
            </div>
            <div class="row">
                <label>Email</label>
                <div class="input-box">
                    <input type="text" name="field[personal_email]" value="{$data.personal_email}" style="width:261px"/>
                </div>
            </div>
            <div class="row">
                <label>Drivers Licence Number </label>
                <div class="input-box">
                    <input type="text" name="field[personal_driver]" value="{$data.personal_driver}" style="width:145px"/>
                </div>
            </div>
            <div class="row">
                <label>State of Issue</label>
                <div class="input-box">
                    <input type="text" name="field[personal_state]" value="{$data.personal_state}" style="width:209px"/>
                </div>
            </div>

            <div class="row">
                <label>Alternate ID (eg passport) </label>
                <div class="input-box">
                    <input type="text" name="field[personal_passport]" value="{$data.personal_passport}" style="width:133px"/>
                </div>
            </div>
            <div class="row">
                <label>No </label>
                <div class="input-box">
                    <input type="text" name="field[personal_passport_no]" value="{$data.personal_passpory_no}" style="width:278px"/>
                </div>
            </div>
            <span class="single-line">Please provide a contact number you are available on all day </span>
            <div class="row">
                <label>Contact number: </label>
                <div class="input-box">
                    <input type="text" name="field[personal_contact_number]" value="{$data.personal_contact_number}" style="width:190px;"/>
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <h3>3. EMERGENCY CONTACT / NEXT KIN:  </h3>
        <div class="content">
            <span class="single-line">Please provide an emergency contact not living with you</span>
            <div class="row">
                <label>First Name</label>
                <div class="input-box">
                    <input type="text" name="field[contact_firstname]" value="{$data.contact_firstname}" style="width:227px"/>
                </div>
            </div>
            <div class="row">
                <label>Surname</label>
                <div class="input-box">
                    <input type="text" name="field[contact_surname]" value="{$data.contact_surname}" style="width:238px"/>
                </div>
            </div>
            <div class="row">
                <label>Relationship </label>
                <div class="input-box">
                    <input type="text" name="field[contact_relationship]" value="{$data.contact_relationship}" style="width:219px"/>
                </div>
            </div>
            <div class="row">
                <label>Phone No</label>
                <div class="input-box">
                    <input type="text" name="field[contact_phoneno]" value="{$data.contact_phoneno}" style="width:220px"/>
                </div>
            </div>
            <div class="row">
                <label>Address</label>
                <div class="input-box">
                    <input type="text" name="field[contact_address]" value="{$data.contact_address}" style="width:245px"/>
                </div>
            </div>
            <div class="row">
                <label>Suburb </label>
                <div class="input-box">
                    <input type="text" name="field[contact_suburb]" value="{$data.contact_suburb}" style="width:105px"/>
                </div>
                <label>Postcode </label>
                <div class="input-box">
                    <input type="text" name="field[contact_postcode]" value="{$data.contact_postcode}" style="width:80px"/>
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <h3>4. IF THERE WILL BE GUARANTOR: [PLEASE PROVIDE DETAILS] </h3>
        <div class="content">
            <div class="row">
                <label>Title</label>
                <div class="input-box">
                    <input type="text" name="field[guarantor_title]" value="{$data.guarantor_title}" style="width:39px"/>
                </div>
                <label>First Name</label>
                <div class="input-box">
                    <input type="text" name="field[guarantor_firstname]" value="{$data.guarantor_firstname}" style="width:157px"/>
                </div>
            </div>
            <div class="row">
                <label>Middle Name</label>
                <div class="input-box">
                    <input type="text" name="field[guarantor_middlename]" value="{$data.guarantor_middlename}" style="width:214px"/>
                </div>
            </div>
            <div class="row">
                <label>Last Name </label>
                <div class="input-box">
                    <input type="text" name="field[guarantor_lastname]" value="{$data.guarantor_lastname}" style="width:229px"/>
                </div>
            </div>
            <div class="row">
                <label>Date of Birth </label>
                <div class="input-box">
                    <input type="text" name="field[guarantor_dob_d]" value="{$data.guarantor_dob_d}" style="width:50px"/>
                </div>
                <label>/</label>
                <div class="input-box">
                    <input type="text" name="field[guarantor_dob_m]" value="{$data.guarantor_dob_m}" style="width:50px;"/>
                </div>
                <label>/</label>
                <div class="input-box">
                    <input type="text" name="field[guarantor_dob_y]" value="{$data.guarantor_dob_y}" style="width:50px"/>
                </div>
            </div>
            <div class="row">
                <label>Current Address </label>
                <div class="input-box">
                    <input type="text" name="field[guarantor_address]" value="{$data.guarantor_address}" style="width:190px"/>
                </div>
            </div>
            <div class="row">
                <label>Suburb </label>
                <div class="input-box">
                    <input type="text" name="field[guarantor_suburb]" value="{$data.guarantor_suburb}" style="width:100px"/>
                </div>
                <label>Post Code </label>
                <div class="input-box">
                    <input type="text" name="field[guarantor_postcode]" value="{$data.guarantor_postcode}" style="width:78px"/>
                </div>
            </div>
            <div class="row">
                <label>Drivers Licence Number</label>
                <div class="input-box">
                    <input type="text" name="address" name="field[guarantor_driver]" value="{$data.guarantor_driver}" style="width:145px"/>
                </div>
            </div>
            <div class="row">
                <label>State of Issue</label>
                <div class="input-box">
                    <input type="text" name="address" name="field[guarantor_state_issue]" value="{$data.guarantor_state_issue}" style="width:209px"/>
                </div>
            </div>
            <div class="row">
                <label>Home Phone: </label>
                <div class="input-box">
                    <input type="text" name="field[guarantor_homeph]" value="{$data.guarantor_homeph}" style="width:210px"/>
                </div>
            </div>
            <div class="row">
                <label>Mobile Phone: </label>
                <div class="input-box">
                    <input type="text" name="field[guarantor_mobileph]" value="{$data.guarantor_mobileph}" style="width:200px"/>
                </div>
            </div>
        </div>
    </div>

    <div class="block">
        <h3>5. APPLICANT HISTORY: </h3>
        <div class="content">
            <div class="row-checkbox">
                <label>Are you the</label>
                <label>Owner</label>
                <input type="checkbox" name="field[applicant][]" value="owner" {if in_array('owner',$data.applicant)}checked{/if}/>
                <label>Tenant</label>
                <input type="checkbox" name="field[applicant][]" value="tenant" {if in_array('tenant',$data.applicant)}checked{/if}/>
            </div>
            <div class="row">
                <label>Current Address</label>
                <div class="input-box">
                    <input type="text" name="field[applicant_address]" value="{$data.applicant_address}" style="width:191px"/>
                </div>
            </div>
            <div class="row">
                <label>Suburb</label>
                <div class="input-box">
                    <input type="text" name="field[applicant_suburb]" value="{$data.applicant_suburb}" style="width:100px"/>
                </div>
                <label>Post Code</label>
                <div class="input-box">
                    <input type="text" name="field[applicant_postcode]" value="{$data.applicant_postcode}" style="width:78px"/>
                </div>
            </div>
            <span class="single-line">How long have you lived at your current address? </span>
            <div class="row">
                <div class="input-box">
                    <input type="text" name="field[applicant_live_y]" value="{$data.applicant_live_y}" style="width:100px;"/>
                </div>
                <label>Years</label>
                <div class="input-box">
                    <input type="text" name="field[applicant_live_m]" value="{$data.applicant_live_m}" style="width:100px"/>
                </div>
                <label>Months</label>
            </div>
            <div class="row">
                <label>Name of Landlord/Agent (If applicable) </label>
                <div class="input-box" style="width:100%">
                    <input type="text" name="field[applicant_name]" value="{$data.applicant_name}" style="width:100%"/>
                </div>
            </div>
            <div class="row">
                <label>Phone No:  </label>
                <div class="input-box">
                    <input type="text" name="field[applicant_phoneno]" value="{$data.applicant_phoneno}" style="width:229px"/>
                </div>
            </div>
            <div class="row">
                <label>Rent Paid per month $ </label>
                <div class="input-box">
                    <input type="text" name="field[applicant_paid]" value="{$data.applicant_paid}" style="width:153px"/>
                </div>
            </div>
            <div class="row">
                <label>Reason for leaving </label>
                <div class="input-box" style="width:100%">
                    <input type="text" name="field[applicant_reason]" value="{$data.applicant_reason}" style="width:100%"/>
                </div>
            </div>
            <div class="row">
                <label>Was bond repaid in full? </label>
                <lable>Yes</lable>
                <div class="input-box">
                    <input type="checkbox" name="field[bond]" value="1" {if $data.bond == 1}checked{/if}/>
                </div>
                <lable>No</lable>
                <div class="input-box">
                    <input type="checkbox" name="field[bond]" value="-1" {if $data.bond == -1}checked{/if}/>
                </div>

            </div>
            <div class="row">
                <label>If No, please specify why:</label>
                <div class="input-box" style="width:100%">
                    <input type="text" name="field[applicant_specify]" value="{$data.applicant_specify}" style="width:100%" />
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <h3>6. WHAT WAS YOUR PREVIOUS RESIDENTIAL ADDRESS: </h3>
        <div class="content">
            <div class="row">
                <label>Suburb</label>
                <div class="input-box">
                    <input type="text" name="field[residential_suburb]" value="{$data.residential_suburb}" style="width:100px"/>
                </div>

                <label>Post Code</label>
                <div class="input-box">
                    <input type="text" name="field[residential_postcode]" value="{$data.residential_postcode}" style="width:78px"/>
                </div>
            </div>
            <span class="single-line">How long have you lived at your current address? </span>
            <div class="row">
                <div class="input-box">
                    <input type="text" name="field[residential_live_y]" value="{$data.residential_live_y}" style="width:100px"/>
                </div>

                <label>Years</label>
                <div class="input-box">
                    <input type="text" name="field[residential_live_m]" value="{$data.residential_live_m}" style="width:100px"/>
                </div>
                <label>Months</label>
            </div>
            <div class="row">
                <label>Name of Landlord/Agent (If applicable)</label>
                <div class="input-box" style="width:100%">
                    <input type="text" name="field[residential_name]" value="{$data.residential_name}" style="width:100%"/>
                </div>
            </div>
            <div class="row">
                <label>Phone No </label>
                <div class="input-box">
                    <input type="text" name="field[residential_phoneno]" value="{$data.residential_phoneno}" style="width:233px"/>
                </div>
            </div>
            <div class="row">
                <label>Rent Paid per month $  </label>
                <div class="input-box">
                    <input type="text" name="field[residential_paid]" value="{$data.residential_paid}"/>
                </div>
            </div>
            <div class="row">
                <label>Reason for leaving</label>
                <div class="input-box">
                    <input type="text" name="field[residential_reason]" value="{$data.residential_reason}"/>
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <h3>7. CURRENT /SELF EMPLOYMENT DETAILS: </h3>
        <div class="content">
            <div class="row">
                <label>Occupation: </label>
                <div class="input-box">
                    <input type="text" name="field[employment_occupation]" value="{$data.employment_occupation}" style="width:219px"/>
                </div>
            </div>
            <div class="row">
                <label>Employers/ Business Name:  </label>
                <div class="input-box" style="width:100%">
                    <input type="text" name="field[employment_name]" value="{$data.employment_name}" style="width:100%"/>
                </div>
            </div>
            <div class="row">
                <label>Employment Address  </label>
                <div class="input-box" style="width:100%">
                    <input type="text" name="field[employment_address]" value="{$data.employment_address}" style="width:100%"/>
                </div>
            </div>
            <div class="row">
                <label>Suburb </label>
                <div class="input-box">
                    <input type="text" name="field[employment_suburb]" value="{$data.employment_suburb}" style="width:100px"/>
                </div>
                <label>Post Code </label>
                <div class="input-box">
                    <input type="text" name="field[employment_postcode]" value="{$data.employment_postcode}" style="width:78px"/>
                </div>
            </div>
            <div class="row">
                <label>Employer Phone No </label>
                <div class="input-box">
                    <input type="text" name="field[employment_phoneno]" value="{$data.employment_phoneno}" style="width:160px"/>
                </div>
            </div>
            <div class="row">
                <label>Contact Name </label>
                <div class="input-box">
                    <input type="text" name="field[employment_contact]" value="{$data.employment_contact}"/>
                </div>
            </div>
            <div class="row">
                <label>Length of current employment</label>
                <div class="input-box">
                    <input type="text" name="field[employment_y]" value="{$data.employment_y}" style="width:127px"/>
                </div>

                <label>Years</label>
                <div class="input-box">
                    <input type="text" name="field[employment_m]" value="{$data.employment_m}" style="width:80px"/>
                </div>
                <label>Months</label>
            </div>
            <div class="row">
                <label>Net Income  Per Week $ </label>
                <div class="input-box">
                    <input type="text" name="field[employment_income]" value="{$data.employment_income}"/>
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <h3>8. SELF EMPLOYMENT (ACCOUNTANT) DETAILS: </h3>
        <div class="content">
            <div class="row">
                <label>Contact </label>
                <div class="input-box">
                    <input type="text" name="field[accountant_contact]" value="{$data.accountant_contact}" style="width:246px"/>
                </div>
            </div>
            <div class="row">
                <label>Phone Number: </label>
                <div class="input-box">
                    <input type="text" name="field[accountant_phone]" value="{$data.accountant_phone}" style="width:196px"/>
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <h3>9. PREVIOUS EMPLOYMENT DETAILS:  </h3>
        <div class="content">
            <div class="row">
                <label>Occupation: </label>
                <div class="input-box">
                    <input type="text" name="field[prev_occupation]" value="{$data.prev_occupation}" style="width:206px"/>
                </div>
            </div>
            <div class="row">
                <label>Employers Name </label>
                <div class="input-box">
                    <input type="text" name="field[prev_name]" value="{$data.prev_name}" style="width:189px"/>
                </div>
            </div>
            <div class="row">
                <label>Employment Address  </label>
                <div class="input-box">
                    <input type="text" name="field[prev_address]" value="{$data.prev_address}" style="width:162px"/>
                </div>
            </div>
            <div class="row">
                <label>Suburb </label>
                <div class="input-box">
                    <input type="text" name="field[prev_suburb]" value="{$data.prev_suburb}" style="width:100px;"/>
                </div>
                <label>Post Code </label>
                <div class="input-box">
                    <input type="text" name="field[prev_postcode]" value="{$data.prev_postcode}" style="width:78px"/>
                </div>
            </div>
            <div class="row">
                <label>Employer Phone No </label>
                <div class="input-box">
                    <input type="text" name="field[prev_phone]" value="{$data.prev_phone}" style="170px"/>
                </div>
            </div>
            <div class="row">
                <label>Contact Name </label>
                <div class="input-box">
                    <input type="text" name="field[prev_contact_name]" value="{$data.prev_contact_name}" style="width:207px"/>
                </div>
            </div>
            <div class="row">
                <label>Length of current employment</label>
                <div class="input-box">
                    <input type="text" name="field[prev_y]" value="{$data.prev_y}" style="width:118px"/>
                </div>

                <label>Years</label>
                <div class="input-box">
                    <input type="text" name="field[prev_m]" value="{$data.prev_m}" style="width:85px"/>
                </div>
                <label>Months</label>
            </div>
            <div class="row">
                <label>Net Income: Per Week $ </label>
                <div class="input-box" style="width:100%">
                    <input type="text" name="field[prev_income]" value="{$data.prev_income}" style="width:100%"/>
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <h3>10. IF STUDENT: <br /><small>[COMPLETE THE FOLLOWING]</small></h3>
        <div class="content">
            <div class="row">
                <label>Place of Study </label>
                <div class="input-box">
                    <input type="text" name="field[student_place]" value="{$data.student_place}" style="width:204px"/>
                </div>
            </div>
            <div class="row">
                <label>Course details </label>
                <div class="input-box">
                    <input type="text" name="field[student_course]" value="{$data.student_course}" style="width:204px"/>
                </div>
            </div>
            <div class="row">
                <label>Course Length  </label>
                <div class="input-box">
                    <input type="text" name="field[student_y]" value="{$data.student_y}" style="width:153px"/>
                </div>
                <label>(years)</label>
            </div>
            <div class="row">
                <label>Enrolment Number </label>
                <div class="input-box">
                    <input type="text" name="field[student_enrolment_number]" value="{$data.student_enrolment_number}" style="width:84px"/>
                </div>
            </div>
            <div class="row">
                <label>Course Offer Attached: </label>
                <label>Yes</label>
                <div class="input-box">
                    <input type="checkbox" name="field[student_course_checkbox]" value="1" {if $data.student_course_checkbox == 1}checked{/if}/>
                </div>
                <label>No</label>
                <div class="input-box">
                    <input type="checkbox" name="field[student_course_checkbox]" value="-1" {if $data.student_course_checkbox == -1}checked{/if}/>
                </div>
            </div>
            <div class="row">
                <label>Government Approval Attached:</label>
                <label>Yes</label>
                <div class="input-box">
                    <input type="checkbox" name="field[student_government_checkbox]" value="1" {if $data.student_government_checkbox == 1}checked{/if}/>
                </div>
                <label>No</label>
                <div class="input-box">
                    <input type="checkbox" name="field[student_government_checkbox]" value="-1" {if $data.student_government_checkbox == -1}checked{/if}/>
                </div>
            </div>
            <div class="row">
                <label>Parents Name </label>
                <div class="input-box">
                    <input type="text" name="field[student_parrent_name]" value="{$data.student_parrent_name}" style="width:206px"/>
                </div>
            </div>
            <div class="row">
                <label>Phone</label>
                <div class="input-box">
                    <input type="text" name="field[student_parrent_ph]" value="{$data.student_parrent_ph}" style="width:255px"/>
                </div>
            </div>
            <div class="row">
                <label>Parents Address Overseas </label>
                <div class="input-box" style="width:100%">
                    <input type="text" name="field[student_parrent_address]" value="{$data.student_parrent_address}" style="width:100%"/>
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <h3>11. PERSONAL REFEREES:<br /><small>[NO FAMILY OR CURRENT EMPLOYER CONTACTS PLEASE]</small></h3>
        <div class="content">
            <div class="row">
                <label>1. Reference name</label>
                <div class="input-box">
                    <input type="text" name="field[reference_name]" value="{$data.reference_name}" style="width:174px"/>
                </div>
            </div>
            <div class="row">
                <label>Occupation </label>
                <div class="input-box">
                    <input type="text" name="field[reference_occupation]" value="{$data.reference_occupation}" style="width:224px"/>
                </div>
            </div>
            <div class="row">
                <label>Relationship  </label>
                <div class="input-box">
                    <input type="text" name="field[reference_relationship]" value="{$data.reference_relationship}" style="width:210px"/>
                </div>
            </div>
            <div class="row">
                <label>Phone No </label>
                <div class="input-box">
                    <input type="text" name="field[reference_phoneno]" value="{$data.reference_phoneno}" style="width:233px"/>
                </div>
            </div>
            <div class="row">
                <label>Notes  </label>
                <div class="input-box">
                    <input type="text" name="field[reference_notes]" value="{$data.reference_notes}" style="width:259px"/>
                </div>
            </div>
            <div class="row">
                <div class="input-box" style="width:100%">
                    <input type="text" name="field[reference_notes_2]" value="{$data.reference_notes_2}" style="width:100%"/>
                </div>
            </div>
            <div class="row">
                <label>2. Reference name</label>
                <div class="input-box">
                    <input type="text" name="field[reference_name_2]" value="{$data.reference_name_2}" style="width:174px"/>
                </div>
            </div>
            <div class="row">
                <label>Occupation </label>
                <div class="input-box">
                    <input type="text" name="field[reference_occupation_2]" value="{$data.reference_occupation_2}" style="width:224px"/>
                </div>
            </div>
            <div class="row">
                <label>Relationship  </label>
                <div class="input-box">
                    <input type="text" name="field[reference_relationship_2]" value="{$data.reference_relationship_2}" style="width:210px"/>
                </div>
            </div>
            <div class="row">
                <label>Phone No </label>
                <div class="input-box">
                    <input type="text" name="field[reference_phoneno_2]" value="{$data.reference_phoneno_2}" style="width:233px"/>
                </div>
            </div>
            <div class="row">
                <label>Notes  </label>
                <div class="input-box">
                    <input type="text" name="field[reference_notes_3]" value="{$data.reference_notes_3}" style="width:259px"/>
                </div>
            </div>
            <div class="row">
                <div class="input-box" style="width:100%">
                    <input type="text" name="field[reference_notes_4]" value="{$data.reference_notes_4}" style="width:100%"/>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer-term">
    <div class="line-2">
        <span class="aright">Please ensure all relevant details are completed</span>
    </div>
</div>
</form>
