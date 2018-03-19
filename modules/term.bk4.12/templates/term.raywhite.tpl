{if isset($message) and strlen($message) > 0}
    <div class="message-box all-step-message-box">{$message}</div>
{/if}
<form id="frmTerm" name="frmTerm" method="post" action="{$form_action}">
<div class="header-term">
    <table>
        <tr>
            <td valign="bottom">
               <img width="200" alt="logo" title="Ray White" src="http://www.raywhite.com/wp-content/resources/uiframework/img/rwlogo-grey-310.png"/>
            </td>
            <td class="center" valign="bottom">
                <p><u><strong>Residential Tenancy Application Form</strong></u></p>
                <p>For your application to be processed you must answer all questions (including the reverse side)</p>
            </td>
            <td class="right" valign="bottom">
                <p>RAY WHITE ST KILDA </p>
                <p>LEVEL 1, 77 ACLAND ST, ST. KILDA VIC 3182</p>
                <p>PHONE: 8530 9900 FAX: 8530 9901</p>
                <p>EMAIL: <a href="mailto:stkilda.vic@raywhite.com">stkilda.vic@raywhite.com</a></p>
            </td>
        </tr>       
    </table>
</div>
<div class="content col-2set">
    <div class="col-1">
        <div class="block">
            <h3>1. AGENT DETAILS: </h3>
            <div class="content">
                <h5>Port Phillip Estate Agents Pty Ltd Trading as
                <br/>RAY WHITE ST KILDAH</h5>

                <table class="detail">
                    <colgroup>
                        <col style="width:100px"/>
                        <col/>
                    </colgroup>
                    <tr>
                        <td>Address:</td>
                        <td>Level 1, 77 Acland Street</td>
                    </tr>
                    <tr>
                        <td>Phone no:</td>
                        <td>03 8530 9900</td>
                    </tr>
                    <tr>
                        <td>Fax no: </td>
                        <td>03 8530 9901</td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td>stkilda.vic@raywhite.com</td>
                    </tr>
                    <tr>
                        <td>Web:</td>
                        <td>www.raywhitestkilda.com.au</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="block">
            <h3>2. PROPERTY THAT YOU ARE APPLYING FOR: </h3>
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
            <h3>3. PERSONAL DETAILS: </h3>
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
            <h3>4. EMERGENCY CONTACT / NEXT KIN:  </h3>
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
            <h3>5. IF THERE WILL BE GUARANTOR: [PLEASE PROVIDE DETAILS] </h3>
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
    </div>
    <div class="col-2">
        <div class="block">
           <h3>6. UTILITY CONNECTIONS:</h3>
           <div class="content">
                <table class="col2">
                    <tr>
                        <td class="col-1">
                            <img width="136" src="{$ROOTPATH}/modules/term/templates/images/logo_raywhite.png"/>
                        </td>
                        <td class="col-2">
                            <p>Phone: 1300 556 325 Fax: 1300 889 598</p>
                            <p>Email: connect@raywhite.com.au</p>
                            <p>Internet: www.raywhiteconnect.com.au</p>
                        </td>
                    </tr>
                </table>
                <p><span class="double"><strong>Ray White Connect is a simple, free and convenient  time saving service</strong></span> assisting with your Telephone, Electricity & Gas and water connections to some of Australia’s leading providers. connectnow also provide a range of additional
                services to compliment your household utilities, such as Internet &Pay TV. </p>

                <p><strong>This is a value-added service independent of your tenancy application - you are not obligated to use connectnow.</strong></p>

                <p>If you would like Ray White Connect to contact you  to discuss any of the above services please tick the box and a connectnow representative will make all
                reasonable efforts to contact you within one working day of receiving an application. If we are unable to contact you within this period please contact
                connectnow on 1300 554 323 to ensure connection can be completed by your requested date.</p>

                <p>It is the responsibility of the Tenant to ensure that the Main Electricity Switch is in
                the “Off Position” between 7am & 7pm on the day connection is required and that
                there is easy access to the property.</p>

                <p>While the Ray White Connect service is  <strong style="font-size:18px">FREE</strong>, standard service provider
                connection fees and charges still apply.  You pay NO extra charges as a result of
                using the Ray White Connect service.</p>
                <div class="contact">
                    <span>Please Contact Me</span>
                    <input type="checkbox" name="field[contact]" value="1" {if $data.contact == 1}checked="checked"{/if}/><label>Yes</label>
                    <input type="checkbox" name="field[contact]" value="-1" {if $data.contact == -1}checked="checked"{/if}/><label>No</label>
                </div>
           </div>
        </div>
        <div class="block">
           <h3>7. DECLARATION: </h3>
           <div class="content">
               <ul class="alpha-upper">
                   <li>I acknowledge that this is an application to lease  this property and that
                    my application is subject to the owner’s approval and the availability of
                    the premises on the due date.  I hereby offer to rent the property from the
                    owner under a lease to be prepared by the Agent pursuant to the
                    Residential Tenancies Act 1997.</li>
                   <li>I authorise the Agent to obtain details of my credit worthiness from, the
                    owner or Agent of my current or previous residence, my personal
                    referees, any record, listing or database of defaults by tenants.  If I default
                    under a rental agreement, the Agent may disclose details of any such
                    default to any person whom the Agent reasonably considers has an
                    interest receiving such information.</li>
                    <li>If section 6 is complete please note that the following terms will apply if
                    you ask us to contact you. Firstly you will be consenting to connectnow
                    Pty. Ltd. A.B.N. 79 097 398 662 arranging for the connection and
                    disconnection of the nominated home services and to providing
                    information contained in this application to the service providers for this
                    purpose.  I agree that neither connectnow nor the Agent accepts liability
                    for loss caused by delay in, or failure to connect/disconnect or provide the
                    nominated services.  The service will be activated  according to the
                    applicable regulations, service provider time frames and terms and
                    conditions once the client has agreed to use the chosen service provider.
                    I authorise the obtaining of a National Metering Identifier (N.M.I.) on my
                    residential address to obtain supply details.  I acknowledge that the terms
                    and conditions of the service provider bind me and  that after hours
                    connections may incur additional service fees from service providers.  I
                    acknowledge that connectnow Pty Ltd will be paid a  fee by the service
                    provider and will be paying a fee to the Agent in respect of the provision
                    of the service being provided to me by connectnow Pty Ltd.</li>
                   <li>I declare that all information contained in this application (including the
                    reverse side) is true and correct and given of my own free will.  I declare
                    that I have inspected the premises and am not bankrupt.  </li>
               </ul>
               <div class="div-center">
                   <span class="double">PRIVACY POLICY:</span>
               </div>
               <div class="normal-line">
                   <p>The privacy of connectnow customers is of vital importance to connectnow.
                    You have the right to access connectnow records of your information under
                    the Privacy Act. connectnow will not release your personal information to any
                    third party other than for the purposes of connecting the nominated utility
                    service, unless required to do so under law or government order.</p>

                   <p><strong><i>Processing of this application will not commence unless all sections
                    have been completed and relevant documentation provided at the time
                    of submission of the application to the agency.</i></strong></p>
                   <div class="div-center">
                       <span class="double">APPLICATION SUBJECT TO CONSENT</span>
                   </div>
                   <p>I acknowledge and understand  that I will be required to <strong>pay rental in
                    advance</strong> via Payment Gateway – <strong>(direct debit) and a rental bond</strong>, and that
                    this application is subject to approval from the owner/landlord. I/we will utilise
                    the appropriate form supplied by <strong>RAY WHITE ST. KILDA.</strong></p>
                    <p><strong>Payment Gateway charge is: (correct as at 1 September 2012):</strong></p>
                    <p><strong>Bank Account Debit - $1.65 inc GST</strong></p>
                    <p><strong>Credit Card Debit - 2.2% of the monthly rental inc GST.</strong></p>
               </div>
               <div class="large-checkbox input-box">
                   <input type="checkbox" name="field[read]" value="1" {if $data.read == 1}checked="checked"{/if}/><label>I have read and understood this policy (tick).</label>
               </div>
               <div class="row bold">
                   <table>
                       <tr>
                           <td><label>Signed:</label></td>
                           <td>
                               <div class="input-box">
                                   <input type="text" name="field[signed]" value="{$data.signed}" style="width:200px">
                               </div>
                           </td>
                           <td><label>Date:</label></td>
                           <td>
                               <div class="input-box">
                                   <input type="text" name="field[signed_d]" value="{$data.signed_d}" style="width:30px">
                               </div>
                           </td>
                           <td><label>/</label></td>
                           <td>
                               <div class="input-box">
                                   <input type="text" name="field[signed_m]" value="{$data.signed_m}" style="width:30px">
                               </div>
                           </td>
                           <td><label>/</label></td>
                           <td>
                               <div class="input-box">
                                   <input type="text" name="field[signed_y]" value="{$data.signed_y}" style="width:50px">
                               </div>
                           </td>
                       </tr>
                   </table>
               </div>
           </div>
        </div>
    </div>
    <div class="clearthis"></div>
</div>
<div class="content col-2set">
    <div class="col-1">
        <div class="block">
            <h3>8. APPLICANT HISTORY: </h3>
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
        <div class="block">
            <h3>9. WHAT WAS YOUR PREVIOUS RESIDENTIAL ADDRESS: </h3>
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
                            <td><label>Reason for leaving $ </label></td>
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
            <h3>10. CURRENT /SELF EMPLOYMENT DETAILS: </h3>
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
            <h3>11. SELF EMPLOYMENT (ACCOUNTANT) DETAILS: </h3>
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
            <h3>12. PREVIOUS EMPLOYMENT DETAILS:  </h3>
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
    </div>
    <div class="col-2">
        <div class="block">
            <h3>13. IF STUDENT: <br /><small>[COMPLETE THE FOLLOWING]</small></h3>
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
            <h3>14. PERSONAL REFEREES:<br /><small>[NO FAMILY OR CURRENT EMPLOYER CONTACTS PLEASE]</small></h3>
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
        <div class="block">
            <h3>15. ID REQUIREMENTS:   </h3>
            <div class="content">
                <div class="text-center underline title"><strong>PROOF OF INCOME IS COMPULSORY
                AND WILL NOT BE PROCESSED WITHOUT THIS INFORMATION</strong></div>

                <div class="text-center title"><strong>IN THE FORM OF WAGE SLIP, CENTRELINK STATEMENT
                OR BANK STATEMENT.</strong></div>

                <div class="text-center title">Before any application will be considered,
                each applicant must supply a minimum of 100 ID points.</div>

                <div class="text-center underline"><strong>Photo ID is compulsory</strong></div>
                <table class="title">
                    <tr>
                        <td>Drivers Licence</td>
                        <td>40 Points</td>
                    </tr>
                    <tr>
                        <td>Passport </td>
                        <td>40 points</td>
                    </tr>
                    <tr>
                        <td>Other Photo ID</td>
                        <td>30 Points</td>
                    </tr>
                    <tr>
                        <td>Previous Tenancy Reference</td>
                        <td>20 Points</td>
                    </tr>
                    <tr>
                        <td>Copy of Gas/Water/Electricity Bill</td>
                        <td>20 points (each)</td>
                    </tr>
                    <tr>
                        <td>Bank Statement</td>
                        <td>20 Points</td>
                    </tr>
                    <tr>
                        <td>Motor Vehicle Registration</td>
                        <td>20 Points</td>
                    </tr>
                    <tr>
                        <td>Previous 2 Rent Receipts</td>
                        <td>20 Points</td>
                    </tr>
                </table>

                <div class="text-center title font15"><label class="underline"><strong>PLEASE NOTE:</strong></label> PHOTOCOPIES OF ALL DOCUMENTS ARE TO BE
                SUPPLIED BY THE APPLICANT</div>

                <div class="text-center title"><strong>If you are accepted for the property you will be required to pay the bond
                within 24 hours of being notified.</strong></div>
            </div>
        </div>
        <div class="block">
            <h3>16. HOW DID YOU FIND OUT ABOUT THIS PROPERTY? <small>[PLEASE TICK]</small> </h3>
            <div class="content">
                <div class="mgr-12">
                    <label>OFFICE RENTAL LIST</label>
                    <input type="checkbox" name="field[find][]" value="office_rental" {if in_array('office_rental',$data.find)}checked="checked"{/if}/>
                    <label>OFFICE</label>
                    <input type="checkbox" name="field[find][]" value="office" {if in_array('office',$data.find)}checked="checked"{/if}/>
                    <label>LEASE BOARD</label>
                    <input type="checkbox" name="field[find][]" value="lease" {if in_array('lease',$data.find)}checked="checked"{/if}/>
                    <label>INTERNET</label>
                    <input type="checkbox" name="field[find][]" value="internet" {if in_array('internet',$data.find)}checked="checked"{/if}/>
                </div>
                <span style="margin-bottom: 10px;display: block;font-weight: bold;">WHICH SITE?</span>
                <div class="mgr-12">
                    <label>DOMAIN</label>
                    <input type="checkbox" name="field[find][]" value="domain" {if in_array('domain',$data.find)}checked="checked"{/if}/>
                    <label>REALESTATE.COM</label>
                    <input type="checkbox" name="field[find][]" value="realestate" {if in_array('realestate',$data.find)}checked="checked"{/if}/>
                    <label>RENTFIND</label>
                    <input type="checkbox" name="field[find][]" value="rentfind" {if in_array('rentfind',$data.find)}checked="checked"{/if}/>
                    <label>REALESTATEVIEW (REIV) </label>
                    <input type="checkbox" name="field[find][]" value="reiv" {if in_array('reiv',$data.find)}checked="checked"{/if}/>
                    <label>RAY WHITE</label>
                    <input type="checkbox" name="field[find][]" value="ray" {if in_array('ray',$data.find)}checked="checked"{/if}/>
                    <label>HOMEHOUND</label>
                    <input type="checkbox" name="field[find][]" value="homehound" {if in_array('homehound',$data.find)}checked="checked"{/if}/>
                    <label>RAY WHITE PORT PHILLIP</label>
                    <input type="checkbox" name="field[find][]" value="white" {if in_array('white',$data.find)}checked="checked"{/if}/>
                </div>
                <div class="row">
                    <label>OTHER:  [Please describe] </label>
                    <input type="text" name="field[describe_other]" value="{$data.describe_other}"/>
                </div>
            </div>
        </div>
    </div>
    <div class="clearthis"></div>
</div>
<div class="footer-term">
    <div class="line-1">
        <span>PORT PHILLIP</span>
    </div>
    <div class="line-2">
        <table>
            <tr>
                <td class="aleft">© Ray White Real Estate | St Kilda</td>
                <td class="acenter">Application Form – RW (ver. 12.10)</td>
                <td class="aright">Please ensure all relevant details are completed</td>
            </tr>
        </table>
    </div>
</div>
</form>