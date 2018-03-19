{if isset($message) and strlen($message) > 0}
    <div class="message-box all-step-message-box">{$message}</div>
{/if}
<div class="header-term">
    <table>
        <tr>
            <td valign="bottom">
               <div style="font-size:35px;font-weight:bold;font-family:Verdana, Arial, Helvetica, sans-serif">Rental Application Form</div>
            </td>
            <td class="center" valign="bottom">
                <p><u><strong>Residential Tenancy Application Form</strong></u></p>
                <p>For your application to be processed you must answer all questions (including the reverse side)</p>
            </td>
            <!--
            <td class="right" valign="bottom">
                <p>RAY WHITE ST KILDA </p>
                <p>LEVEL 1, 77 ACLAND ST, ST. KILDA VIC 3182</p>
                <p>PHONE: 8530 9900 FAX: 8530 9901</p>
                <p>EMAIL: <a href="mailto:stkilda.vic@raywhite.com">stkilda.vic@raywhite.com</a></p>
            </td>
            -->
        </tr>       
    </table>
</div>

<div class="content col-2set">
    <div class="col-1">
        <div class="block">
            <h3>1. PROPERTY THAT YOU ARE APPLYING FOR: </h3>
            <div class="content">
                <div class="row">
                    <table>
                        <tr>
                            <td>
                                <label >Address</label>
                            </td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[address]" value="{$data.address}" style="width:373px"/>
                                </div>
                            </td>
                        </tr>                        
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Suburb</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[suburb]" value="{$data.suburb}"/>
                                </div>
                            </td>
                            <td><label>Postcode</label></td>
                            <td>
                               <div class="input-box">
                                    <input type="text" name="field[postcode]" value="{$data.postcode}"/>
                               </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label><strong>Date Property is required</strong></label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[date_required]" value="{$data.date_required}" style="width:30px;"/>
                                </div>
                            </td>
                            <td><label>/</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[month_required]" value="{$data.month_required}" style="width:30px"/>
                                </div>
                            </td>
                            <td><label>/</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[year_required]" value="{$data.year_required}" style="width:30px"/>
                                </div>
                            </td>
                            <td><label><span class="double italic">Must be completed</span></label></td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Property  Rental $</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[rental]" value="{$data.rental}"/>
                                </div>
                            </td>
                            <td><label>Per Week</label></td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Required Lease Term </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[term]" value="{$data.term}" style="width:50px"/>
                                </div>
                            </td>
                            <td><label>Years</label></td>
                            <td>
                                <div class="input-box" >
                                    <input type="text" name="field[term_years]" value="{$data.term_years}" style="width:50px"/>
                                </div>
                            </td>
                            <td><label>Months</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[term_months]" value="{$data.term_months}" style="width:50px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <span class="single-line">Number of other Applicants to Occupy the Property </span>
                <div class="row">
                    <label>Other Name(s): </label>
                    <input type="text" name="field[other_name]" value="{$data.other_name}" style="width:329px"/>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Adults  </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[adults]" value="{$data.adults}"/>
                                </div>
                            </td>
                            <td><label>Children: </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[children]" value="{$data.children}" />
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="row-checkbox">
                    <label>Please tick:</label>
                    <label>Smoker:</label>
                    <label>Yes</label><input type="checkbox" name="field[smoker]" value="1" {if $data.smoker == 1}checked="checked"{/if}/>
                    <label>No</label><input type="checkbox" name="field[smoker]" value="-1" {if $data.smoker == -1}checked="checked"{/if}/>
                </div>

                <div class="row-checkbox">
                    <label>Do you have pets?</label>
                    <label>Yes</label><input type="checkbox" name="field[pets]" value="1" {if $data.pets == 1}checked="checked"{/if}/>
                    <label>No</label><input type="checkbox" name="field[pets]" value="-1" {if $data.pets == -1}checked="checked"{/if}/>
                </div>

                <div class="row">
                    <table>
                        <tr>
                            <td><label>If Yes, please specify: </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[specify_1]" value="{$data.specify_1}"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="block">
            <h3>2. PERSONAL DETAILS: </h3>
            <div class="content">
                 <div class="row">
                    <table>
                        <tr>
                            <td><label>Title</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[personal_title]" value="{$data.personal_title}" style="width:39px"/>
                                </div>
                            </td>
                            <td><label>First Name</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[personal_firstname]" value="{$data.personal_firstname}" style="width:100px"/>
                                </div>
                            </td>
                            <td><label>Initial</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[personal_initial]" value="{$data.personal_initial}" style="width:100px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Last Name</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[personal_lastname]" value="{$data.personal_lastname}" style="width:350px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Date of Birth</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" style="width:50px" name="field[personal_dob_d]" value="{$data.personal_dob_d}"/>
                                </div>
                            </td>
                            <td><label>/</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" style="width:50px" name="field[personal_dob_m]" value="{$data.personal_dob_m}"/>
                                </div>
                            </td>
                            <td><label>/</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[personal_dob_y]" value="{$data.personal_dob_y}"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Home Ph</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[personal_homeph]" value="{$data.personal_homeph}"/>
                                </div>
                            </td>
                            <td><label>Mobile Ph</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[personal_mobileph]" value="{$data.personal_mobileph}"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Email</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[personal_email]" value="{$data.personal_email}"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Drivers Licence Number </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[personal_driver]" value="{$data.personal_driver}" style="width:100px"/>
                                </div>
                            </td>
                            <td><label>State of Issue</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[personal_state]" value="{$data.personal_state}" style="width:80px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="row">
                    <table>
                        <tr>
                            <td><label>Alternate ID (eg passport) </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[personal_passport]" value="{$data.personal_passport}" style="width:150px"/>
                                </div>
                            </td>
                            <td><label>No </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[personal_passport_no]" value="{$data.personal_passpory_no}" style="width:80px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <span class="single-line">Please provide a contact number you are available on all day </span>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Contact number: </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[personal_contact_number]" value="{$data.personal_contact_number}" style="width:300px;"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="block">
            <h3>3. EMERGENCY CONTACT / NEXT KIN:  </h3>
            <div class="content">
                <span class="single-line">Please provide an emergency contact not living with you</span>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>First Name</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[contact_firstname]" value="{$data.contact_firstname}" style="width:145px"/>
                                </div>
                            </td>
                            <td><label>Surname</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[contact_surname]" value="{$data.contact_surname}" style="width:150px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Relationship </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[contact_relationship]" value="{$data.contact_relationship}" style="width:145px"/>
                                </div>
                            </td>
                            <td><label>Phone No</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[contact_phoneno]" value="{$data.contact_phoneno}" style="width:130px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Address</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[contact_address]" value="{$data.contact_address}" style="width:373px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Suburb </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[contact_suburb]" value="{$data.contact_suburb}"/>
                                </div>
                            </td>
                            <td><label>Postcode </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[contact_postcode]" value="{$data.contact_postcode}"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="block">
            <h3>4. IF THERE WILL BE GUARANTOR: [PLEASE PROVIDE DETAILS] </h3>
            <div class="content">
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Title</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[guarantor_title]" value="{$data.guarantor_title}" style="width:39px"/>
                                </div>
                            </td>
                            <td><label>First Name</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[guarantor_firstname]" value="{$data.guarantor_firstname}" style="width:100px"/>
                                </div>
                            </td>
                            <td><label>Middle Name</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[guarantor_middlename]" value="{$data.guarantor_middlename}" style="width:100px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Last Name </label></td>
                            <td>
                               <div class="input-box">
                                    <input type="text" name="field[guarantor_lastname]" value="{$data.guarantor_lastname}" style="width:350px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Date of Birth </label></td>
                            <td>
                               <div class="input-box">
                                <input type="text" name="field[guarantor_dob_d]" value="{$data.guarantor_dob_d}" style="width:50px"/>
                            </div>
                            </td>
                            <td><label>/</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[guarantor_dob_m]" value="{$data.guarantor_dob_m}" style="width:50px;"/>
                                </div>
                            </td>
                            <td><label>/</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[guarantor_dob_y]" value="{$data.guarantor_dob_y}" style="width:50px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Current Address </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[guarantor_address]" value="{$data.guarantor_address}" style="width:300px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Suburb </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[guarantor_suburb]" value="{$data.guarantor_suburb}"/>
                                </div>
                            </td>
                            <td><label>Post Code </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[guarantor_postcode]" value="{$data.guarantor_postcode}"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Drivers Licence Number</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="address" name="field[guarantor_driver]" value="{$data.guarantor_driver}" style="width:100px;"/>
                                </div>
                            </td>
                            <td><label>State of Issue</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="address" name="field[guarantor_state_issue]" value="{$data.guarantor_state_issue}" style="width:80px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Home Phone: </label></td>
                            <td>
                               <div class="input-box">
                                    <input type="text" name="field[guarantor_homeph]" value="{$data.guarantor_homeph}" style="width:120px"/>
                               </div>
                            </td>
                            <td><label>Mobile Phone: </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[guarantor_mobileph]" value="{$data.guarantor_mobileph}" style="width:120px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="block">
            <h3>5. APPLICANT HISTORY: </h3>
            <div class="content">
                <div class="row-checkbox">
                    <table>
                        <tr>
                            <td><label>Are you the</label></td>
                            <td><label>Owner</label></td>
                            <td><input type="checkbox" name="field[applicant][]" value="owner" {if in_array('owner',$data.applicant)}checked="checked"{/if}/></td>
                            <td><label>Tenant</label></td>
                            <td><input type="checkbox" name="field[applicant][]" value="tenant" {if in_array('tenant',$data.applicant)}checked="checked"{/if}/></td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Current Address</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[applicant_address]" value="{$data.applicant_address}" style="width:300px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Suburb</label></td>
                            <td>

                                <div class="input-box">
                                    <input type="text" name="field[applicant_suburb]" value="{$data.applicant_suburb}"/>
                                </div>
                            </td>
                            <td><label>Post Code</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[applicant_postcode]" value="{$data.applicant_postcode}"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <span class="single-line">How long have you lived at your current address? </span>
                <div class="row">
                    <table>
                        <tr>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[applicant_live_y]" value="{$data.applicant_live_y}"/>
                                </div>
                            </td>
                            <td><label>Years</label></td>
                            <td>
                               <div class="input-box">
                                    <input type="text" name="field[applicant_live_m]" value="{$data.applicant_live_m}"/>
                               </div>
                            </td>
                            <td><label>Months</label></td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <label>Name of Landlord/Agent (If applicable) </label>
                    <input type="text" name="field[applicant_name]" value="{$data.applicant_name}" style="width:183px"/>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Phone No:  </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[applicant_phoneno]" value="{$data.applicant_phoneno}" style="width:350px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <label>Rent Paid per month $ </label>
                    <input type="text" name="field[applicant_paid]" value="{$data.applicant_paid}" style="width:282px"/>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Reason for leaving </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[applicant_reason]" value="{$data.applicant_reason}" style="width:300px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Was bond repaid in full? </label></td>
                            <td><lable>Yes</lable></td>
                            <td>
                               <div class="input-box">
                                    <input type="checkbox" name="field[bond]" value="1" {if $data.bond == 1}checked="checked"{/if}/>
                               </div>
                            </td>
                            <td><lable>No</lable></td>
                            <td>
                                <div class="input-box">
                                    <input type="checkbox" name="field[bond]" value="-1" {if $data.bond == -1}checked="checked"{/if}/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <label>If No, please specify why:</label>
                    <input type="text" name="field[applicant_specify]" value="{$data.applicant_specify}" style="width:267px"/>
                </div>
            </div>
        </div>        
    </div>
    <div class="col-2">
        <div class="block">
            <h3>6. WHAT WAS YOUR PREVIOUS RESIDENTIAL ADDRESS: </h3>
            <div class="content">
                 <div class="row">
                    <table>
                        <tr>
                            <td><label>Suburb</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[residential_suburb]" value="{$data.residential_suburb}"/>
                                </div>
                            </td>
                            <td><label>Post Code</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[residential_postcode]" value="{$data.residential_postcode}"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <span class="single-line">How long have you lived at your current address? </span>
                <div class="row">
                    <table>
                        <tr>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[residential_live_y]" value="{$data.residential_live_y}"/>
                                </div>
                            </td>
                            <td><label>Years</label></td>
                            <td>
                               <div class="input-box">
                                    <input type="text" name="field[residential_live_m]" value="{$data.residential_live_m}"/>
                               </div>
                            </td>
                            <td><label>Months</label></td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <label>Name of Landlord/Agent (If applicable)</label>
                    <input type="text" name="field[residential_name]" value="{$data.residential_name}"/>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Phone No </label></td>
                            <td>
                               <div class="input-box">
                                    <input type="text" name="field[residential_phoneno]" value="{$data.residential_phoneno}"/>
                               </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Rent Paid per month $  </label></td>
                            <td>
                               <div class="input-box">
                                    <input type="text" name="field[residential_paid]" value="{$data.residential_paid}"/>
                               </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Reason for leaving</label></td>
                            <td>
                               <div class="input-box">
                                    <input type="text" name="field[residential_reason]" value="{$data.residential_reason}"/>
                               </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="block">
            <h3>7. CURRENT /SELF EMPLOYMENT DETAILS: </h3>
            <div class="content">
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Occupation: </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[employment_occupation]" value="{$data.employment_occupation}"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Employers/ Business Name:  </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[employment_name]" value="{$data.employment_name}"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Employment Address  </label></td>
                            <td>
                               <div class="input-box">
                                    <input type="text" name="field[employment_address]" value="{$data.employment_address}"/>
                               </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Suburb </label></td>
                            <td>
                               <div class="input-box">
                                    <input type="text" name="field[employment_suburb]" value="{$data.employment_suburb}"/>
                               </div>
                            </td>
                            <td><label>Post Code </label></td>
                            <td>
                               <div class="input-box">
                                    <input type="text" name="field[employment_postcode]" value="{$data.employment_postcode}"/>
                               </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <label>Employer Phone No </label>
                    <input type="text" name="field[employment_phoneno]" value="{$data.employment_phoneno}"/>
                </div>
                <div class="row">
                    <label>Contact Name </label>
                    <input type="text" name="field[employment_contact]" value="{$data.employment_contact}"/>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Length of current employment</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[employment_y]" value="{$data.employment_y}" style="width:60px"/>
                                </div>
                            </td>
                            <td><label>Years</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[employment_m]" value="{$data.employment_m}" style="width:80px"/>
                                </div>
                            </td>
                            <td><label>Months</label></td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <label>Net Income  Per Week $ </label>
                    <input type="text" name="field[employment_income]" value="{$data.employment_income}"/>
                </div>
            </div>
        </div>
        <div class="block">
            <h3>8. SELF EMPLOYMENT (ACCOUNTANT) DETAILS: </h3>
            <div class="content">
                <div class="row">
                    <label>Contact </label>
                    <input type="text" name="field[accountant_contact]" value="{$data.accountant_contact}"/>
                </div>
                <div class="row">
                    <label>Phone Number: </label>
                    <input type="text" name="field[accountant_phone]" value="{$data.accountant_phone}"/>
                </div>
            </div>
        </div>
        <div class="block">
            <h3>9. PREVIOUS EMPLOYMENT DETAILS:  </h3>
            <div class="content">
                <div class="row">
                    <label>Occupation: </label>
                    <input type="text" name="field[prev_occupation]" value="{$data.prev_occupation}"/>
                </div>
                <div class="row">
                    <label>Employers Name </label>
                    <input type="text" name="field[prev_name]" value="{$data.prev_name}"/>
                </div>
                <div class="row">
                    <label>Employment Address  </label>
                    <input type="text" name="field[prev_address]" value="{$data.prev_address}"/>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Suburb </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[prev_suburb]" value="{$data.prev_suburb}"/>
                                </div>
                            </td>
                            <td><label>Post Code </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[prev_postcode]" value="{$data.prev_postcode}"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <label>Employer Phone No </label>
                    <input type="text" name="field[prev_phone]" value="{$data.prev_phone}"/>
                </div>
                <div class="row">
                    <label>Contact Name </label>
                    <input type="text" name="field[prev_contact_name]" value="{$data.prev_contact_name}"/>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Length of current employment</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[prev_y]" value="{$data.prev_y}" style="width:60px"/>
                                </div>
                            </td>
                            <td><label>Years</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[prev_m]" value="{$data.prev_m}" style="width:85px"/>
                                </div>
                            </td>
                            <td><label>Months</label></td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <label>Net Income: Per Week $ </label>
                    <input type="text" name="field[prev_income]" value="{$data.prev_income}"/>
                </div>
            </div>
        </div>
        
        <div class="block">
            <h3>10. IF STUDENT: <br /><small>[COMPLETE THE FOLLOWING]</small></h3>
            <div class="content">
                <div class="row">
                    <label>Place of Study </label>
                    <input type="text" name="field[student_place]" value="{$data.student_place}"/>
                </div>
                <div class="row">
                    <label>Course details </label>
                    <input type="text" name="field[student_course]" value="{$data.student_course}"/>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Course Length  </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[student_y]" value="{$data.student_y}" style="width:72px"/>
                                </div>
                            </td>
                            <td><label>(years)</label></td>
                            <td><label>Enrolment Number </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[student_enrolment_number]" value="{$data.student_enrolment_number}" style="width:84px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Course Offer Attached: </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[student_course_attached]" value="{$data.student_course_attached}" style="width:170px"/>
                                </div>
                            </td>
                            <td><label>Yes</label></td>
                            <td>
                               <div class="input-box">
                                    <input type="checkbox" name="field[student_course_checkbox]" value="1" {if $data.student_course_checkbox == 1}checked="checked"{/if}/>
                               </div>
                            </td>
                            <td><label>No</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="checkbox" name="field[student_course_checkbox]" value="-1" {if $data.student_course_checkbox == -1}checked="checked"{/if}/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Government Approval Attached:</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[student_government_attached]" value="{$data.student_government_attached}" style="width:116px"/>
                                </div>
                            </td>
                            <td><label>Yes</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="checkbox" name="field[student_government_checkbox]" value="1" {if $data.student_government_checkbox == 1}checked="checked"{/if}/>
                                </div>
                            </td>
                            <td><label>No</label></td>
                            <td>
                                <div class="input-box">
                                    <input type="checkbox" name="field[student_government_checkbox]" value="-1" {if $data.student_government_checkbox == -1}checked="checked"{/if}/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Parents Name </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[student_parrent_name]" value="{$data.student_parrent_name}"/>
                                </div>
                            </td>
                            <td><label>Ph </label></td>
                            <td>
                               <div class="input-box">
                                    <input type="text" name="field[student_parrent_ph]" value="{$data.student_parrent_ph}"/>
                               </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <label>Parents Address Overseas </label>
                    <input type="text" name="field[student_parrent_address]" value="{$data.student_parrent_address}"/>
                </div>
            </div>
        </div>
        <div class="block">
            <h3>11. PERSONAL REFEREES:<br /><small>[NO FAMILY OR CURRENT EMPLOYER CONTACTS PLEASE]</small></h3>
            <div class="content">
                <div class="row">
                    <label>1. Reference name</label>
                    <input type="text" name="field[reference_name]" value="{$data.reference_name}"/>
                </div>
                <div class="row">
                    <label>Occupation </label>
                    <input type="text" name="field[reference_occupation]" value="{$data.reference_occupation}"/>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Relationship  </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[reference_relationship]" value="{$data.reference_relationship}" style="width:130px"/>
                                </div>
                            </td>
                            <td><label>Phone No </label></td>
                            <td>
                               <div class="input-box">
                                    <input type="text" name="field[reference_phoneno]" value="{$data.reference_phoneno}" style="width:150px"/>
                               </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <label>Notes  </label>
                    <input type="text" name="field[reference_notes]" value="{$data.reference_notes}"/>
                </div>
                <div class="row">
                    <input type="text" name="field[reference_notes_2]" value="{$data.reference_notes_2}"/>
                </div>
                <div class="row">
                    <label>2. Reference name</label>
                    <input type="text" name="field[reference_name_2]" value="{$data.reference_name_2}"/>
                </div>
                <div class="row">
                    <label>Occupation </label>
                    <input type="text" name="field[reference_occupation_2]" value="{$data.reference_occupation_2}"/>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <td><label>Relationship  </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[reference_relationship_2]" value="{$data.reference_relationship_2}" style="width:130px"/>
                                </div>
                            </td>
                            <td><label>Phone No </label></td>
                            <td>
                                <div class="input-box">
                                    <input type="text" name="field[reference_phoneno_2]" value="{$data.reference_phoneno_2}" style="width:150px"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <label>Notes  </label>
                    <input type="text" name="field[reference_notes_3]" value="{$data.reference_notes_3}"/>
                </div>
                <div class="row">
                    <div class="input-box">
                        <input type="text" name="field[reference_notes_4]" value="{$data.reference_notes_4}"/>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="clearthis"></div>
</div>
<div class="footer-term">
   <!--
    <div class="line-1">
        <span>PORT PHILLIP</span>
    </div>
	-->
    <div class="line-2" style="margin-top:40px !important">
        <table>
            <tr>
                <td class="aleft"><!--Application Form - RW (ver. 12.10)--></td>
                <td class="acenter"></td>
                <td class="aright">Please ensure all relevant details are completed</td>
            </tr>
        </table>
    </div>
</div>
