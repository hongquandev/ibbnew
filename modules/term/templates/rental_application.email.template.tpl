<div>
    <br/>
    <span style="text-decoration: underline">From:</span><br/>
    <span><strong>User ID - </strong>{$bidder.agent_id}</span><br/>
    <span><strong>Name - </strong>{$bidder.firstname} {$bidder.lastname}</span><br/><br/>
    <table>
        <tbody>
        <tr>
            <td><strong>Application Form</strong></td>
            <td><a href="{$ROOTURL}{$term.file_application}">{$ROOTURL}{$term.file_application}</a></td>
        </tr>
        <tr>
            <td><br/><br/></td>
        </tr>
        <tr>
            <td>Supporting Documents:</td>
            <td></td>
        </tr>
        <tr>
            <td>Drivers License</td>
            <td>{if $files.file_drivers_license}<a href="{$ROOTURL}{$files.file_drivers_license}">{$ROOTURL}{$files.file_drivers_license}</a>{else}N/A{/if}</td>
        </tr>
        <tr>
            <td>Rental References</td>
            <td>{if $files.file_rental_references}<a href="{$ROOTURL}{$files.file_rental_references}">{$ROOTURL}{$files.file_rental_references}</a>{else}N/A{/if}</td>
        </tr>
        <tr>
            <td style="padding: 10px 10px 10px 0">Passport / Birth Certificate</td>
            <td>{if $files.file_passport_birth}<a href="{$ROOTURL}{$files.file_passport_birth}">{$ROOTURL}{$files.file_passport_birth}</a>{else}N/A{/if}</td>
        </tr>
        <tr>
            <td>Personal References</td>
            <td>{if $files.file_personal_references}<a href="{$ROOTURL}{$files.file_personal_references}">{$ROOTURL}{$files.file_personal_references}</a>{else}N/A{/if}</td>
        </tr>
        <tr>
            <td>Medicare / Pension card</td>
            <td>{if $files.file_medicare_pension_card}<a href="{$ROOTURL}{$files.file_medicare_pension_card}">{$ROOTURL}{$files.file_medicare_pension_card}</a>{else}N/A{/if}</td>
        </tr>
        <tr>
            <td>Bank Statements</td>
            <td>{if $files.file_bank_statements}<a href="{$ROOTURL}{$files.file_bank_statements}">{$ROOTURL}{$files.file_bank_statements}</a>{else}N/A{/if}</td>
        </tr>
        <tr>
            <td>Student Card</td>
            <td>{if $files.file_student_card}<a href="{$ROOTURL}{$files.file_student_card}">{$ROOTURL}{$files.file_student_card}</a>{else}N/A{/if}</td>
        </tr>
        <tr>
            <td>Pay Slips</td>
            <td>{if $files.file_pay_slips}<a href="{$ROOTURL}{$files.file_pay_slips}">{$ROOTURL}{$files.file_pay_slips}</a>{else}N/A{/if}</td>
        </tr>
        <tr>
            <td>Utility Bills (phone, gas, electricity)</td>
            <td>{if $files.file_utility_bills}<a href="{$ROOTURL}{$files.file_utility_bills}">{$ROOTURL}{$files.file_utility_bills}</a>{else}N/A{/if}</td>
        </tr>
        <tr>
            <td>Other supporting files</td>
            <td>{if $files.file_other_supporting}<a href="{$ROOTURL}{$files.file_other_supporting}">{$ROOTURL}{$files.file_other_supporting}</a>{else}N/A{/if}</td>
        </tr>
        <tr>
            <td><br/><br/><br/>Enable or Reject User</td>
            <td><br/><br/><br/>{$link_registered_user}</td>
        </tr>
        </tbody>
    </table>
    <br/>
    <span>Please review this application and enable or reject this application to transact on this property<br/></span>
    <span>Thank you.</span>
</div>