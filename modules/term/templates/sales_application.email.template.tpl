<div>
    <br/>
    <span style="text-decoration: underline">From:</span><br/>
    <span><strong>User ID - </strong>{$bidder.agent_id}</span><br/>
    <span><strong>Name - </strong>{$bidder.firstname} {$bidder.lastname}</span><br/><br/>
    <table>
        <tbody>
        <tr>
            <td width="200px">Supporting Documents:</td>
            <td></td>
        </tr>
        <tr>
            <td>Drivers License</td>
            <td>{if $files_user.file_drivers_license}<a href="{$ROOTURL}{$files_user.file_drivers_license}">{$ROOTURL}{$files_user.file_drivers_license}</a>{else}N/A{/if}</td>
        </tr>
        <tr>
            <td>Passport / Birth Certificate</td>
            <td>{if $files_user.file_passport_birth}<a href="{$ROOTURL}{$files_user.file_passport_birth}">{$ROOTURL}{$files_user.file_passport_birth}</a>{else}N/A{/if}</td>
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