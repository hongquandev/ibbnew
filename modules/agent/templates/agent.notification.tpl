<div class="bar-title">
    <h2>{localize translate="MY COMMUNICATIONS & NOTIFICATIONS"}</h2>
</div>

<div class="ma-info mb-20px">
    <div class="col2-set mb-20px">

        <div class="col">
            <div>
            	{if strlen($message)>0}
                	<div class="message-box message-box-ie">{$message}</div><br/>
                {/if}
            	<form name="frmAgent" id="frmAgent" class="frmagent-ie" method="post" action="{$form_action}">
                <span sty>{$description}</span>
                <br />
                <p class="mb-5px" style="margin-top:10px;">
                    <label>
                    	{assign var='ch' value=''}
                        {if isset($form_data.notify_email) and $form_data.notify_email == 1}
                        	{assign var='ch' value='checked'}
                        {/if}
                    
	                    <input type="checkbox" name="field[notify_email]" id="notify_email" value="Notification email address" {$ch}/>
                        {localize translate="Notification by email address"}
                    </label>
                </p>
                <p class="mb-5px">
                    <label>
                    	{assign var='ch' value=''}
                        {if isset($form_data.notify_email_bid) and $form_data.notify_email_bid == 1}
                        	{assign var='ch' value='checked'}
                        {/if}
                    
	                    <input type="checkbox" name="field[notify_email_bid]" id="notify_email_bid" value="Notification email address" {$ch}/>
                        {localize translate="Notification email address on each bid"}
                    </label>
                </p>
                
                <p class="mb-5px">
                    <label>
                    	{assign var='ch' value=''}
                        {if isset($form_data.notify_sms) and $form_data.notify_sms == 1}
                        	{assign var='ch' value='checked'}
                        {/if}
                    
	                    <input type="checkbox" name="field[notify_sms]" id="notify_sms" value="Notification SMS number" {$ch}/>
                        {localize translate="Notification by SMS number"}
                    </label>
                </p>
                {*
                <p class="mb-5px" style="display:none">
                    <label>
                    	{assign var='ch' value=''}
                        {if isset($form_data.notify_turnon_sms) and $form_data.notify_turnon_sms == 1}
                        	{assign var='ch' value='checked'}
                        {/if}
                    
						<input type="checkbox" name="field[notify_turnon_sms]" id="notify_turnon_sms" value="Turn on SMS Notification $$$ per xxx" {$ch}/>
                        Turn on SMS Notification $$$ per xxx
                    </label>
                </p>
                *}
                {*subscribe*}
                 <p class="mb-5px">
                    <label>
                    	{assign var='ch' value=''}
                        {if isset($form_data.subscribe) and $form_data.subscribe == 1}
                        	{assign var='ch' value='checked'}
                        {/if}

	                    <input type="checkbox" name="field[subscribe]" id="subscribe" value="Subscriber for newsletter" {$ch}/>
                        {localize translate="Subscribe to newsletter"}
                    </label>
                </p>
                </form>
            </div>
            
            <div class="buttons-set">
                <button class="btn-red btn-red-no-cre" onclick="agent.submit('#frmAgent')">
                    <span><span>{localize translate="Save"}</span></span>
                </button>
            </div>
            
        </div>
        <div class="clearthis">
        </div>
    </div>
</div>