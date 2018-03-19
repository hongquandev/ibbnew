{literal}
<style type="text/css">
    .user-declaration-content {
        font-family: ProximaNova-Light, Helvetica, sans-serif;
        font-size: 15px;
        padding: 0 10px;
        text-align: left;
    }
    .user-declaration-content p{
        line-height: 20px;
        margin: 20px 0;
    }
    .user-declaration-content p:first-child{
        margin-top: 0;
    }
</style>
{/literal}
<div class="user-declaration-content">
    <p>To register to transact on a property you MUST provide photo ID to comply with legal requirements.</p>
    <p>This registration is to enable you to transact online and links to your registration will be sent to the Agent to view (or print) only, this is to enable them to be able to review and validate your registration.</p>
    <p>I acknowledge that by submitting this registration, I am applying to be enabled to transact on this property
        This registration does not imply a commitment on my part to purchase this property.</p>
    <p>I acknowledge and accept that my registration is subject to the approval of the Managing Agent of the property, and the availability of the property.</p>
    <p>I acknowledge that no action will be taken against the Agent, or the Owner if this registration is not successful.</p>
    <p>I declare that all information contained and provided in this application is true and correct to the best of my knowledge and has been provided by me freely.</p>
    <p>I declare that I have inspected the property and am satisfied that the premises are in a reasonable and clean condition and I accept the premises as is.</p>
    <p>
        <input id="declared" type="checkbox" name="declared"><label style="display: none; color: red;margin-left: 20px" id="notify_declared">Please check here. Thanks</label>
    </p>
    <p>I have read and accepted the above declaration.</p>
    <p>
        <input id="accepted" type="checkbox" name="accepted"><label  style="display: none; color: red;margin-left: 20px" id="notify_accepted">Please check here. Thanks</label>
    </p>
    <div>
        <div class="clearthis"></div>
        <button class="btn-green-transact" onclick="submitRegistration('{$agent_id}')">
            <span style="position: relative;left: auto;top: auto;"><span style="position: relative;left: auto;top: auto;">Submit Registration</span></span>
        </button>
    </div>
    <p>Before proceeding please acknowledge that you have read and accept the bidRhino terms and conditions  by ticking the box</p>
    By submitting this registration, you consent to all the information you have provided, including your personal information being collected, used, held and disclosed by bidRhino.com Pty Ltd in accordance with its Privacy Policy.
</div>

