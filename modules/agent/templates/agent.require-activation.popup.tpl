<div class="popup_container make-an-offer-popup popup_container_require" id="requireActive_{$property_id}" style="display:none;">
    <!--<div id="contact-wrapper" class="myaccount make-an-offer-popup-a"  style="padding-bottom:0px;width:313px;">-->
	    <div id="contact-wrapper" class="make-an-offer-popup-a"  style="padding-bottom:0px;width:313px;">
		<div class="title">
            <h2>
            	REQUIRE ACTIVATION
                <span onclick="pro.closeRequireActive('#requireActive_{$property_id}')" class="btn-x"  id="fridx" style="color:#ffffff">Close X</span>
            </h2>
        </div>

        <div class="ma-messages make-an-offer-popup-b" id="fridmess">
        	<form name="frmRequireActive_{$property_id}" class="frm-mao frm-make-an-offer-popup" id="frmRequireActive_{$property_id}" style="width:97%;margin:4px;">
            	<!--
            	<span style="clear:both"><b>From:</b></span>
                <input type="text" id="agent_email" name="agent_email" disabled="disabled" value="{$agent_email}" class="validate-email validate-agentEmail" style="width:100%;"/>


                <span style="clear:both"><b>Subject:</b></span>
                <input type="text" id="subject_email" disabled="disabled" name="agent_email" value="REQUIRE ACTIVATION FOR ID: {$property_id}" class="" style="width:100%;"/>

                <span style="clear:both"><b>Message :</b></span>
            	<textarea id="content" name="content" class="validate-require" style="width:100%;height:55px;"></textarea>
				-->
				<div class="input-box">
				  <label><strong>From:</strong></label><br/>
                  <input type="text" id="agent_email" name="agent_email" disabled="disabled" value="{$agent_email}" class="input-text validate-email validate-agentEmail" style="width:98%;"/>
				</div>

				<div class="input-box">
				  <label><strong>Subject:</strong></label><br/>
                  <input type="text" id="subject_email" disabled="disabled" name="agent_email" value="REQUIRE ACTIVATION FOR ID: {$property_id}" class="input-text" style="width:98%;"/>
				</div>

				<div class="input-box">
				  <label><strong>Message:</strong></label><br/>
                  <textarea id="content" name="content" class="input-text validate-require" style="width:98%;height:55px;"></textarea>
				</div>
                
                <input type="hidden" id="agent_id" name="agent_id" value="{$agent_id}"/>
                <input type="hidden" id="property_id" name="property_id" value="{$property_id}"/>
            </form>

            <div>
            	<!--
                 <button class="btn-red btn-makeanoffer" name="submit" onClick="pro.requireActive('#frmRequireActive_{$property_id}','{$property_id}','#requireActive_{$property_id}');">
                    <span><span>Send</span></span>
                 </button>
				-->
                 <button class="btn-blue" name="submit" onClick="pro.requireActive('#frmRequireActive_{$property_id}','{$property_id}','#requireActive_{$property_id}');">
                    <span><span>Send</span></span>
                 </button>
                
                 <div id="mao_loading_{$property_id}" style="display:none;">
                    <img src="/modules/general/templates/images/loading.gif" style="height:30px;"/>
                 </div>
            </div>
        </div>
    </div>
</div>
{literal}
    <script type="text/javascript">
        pro = new Property();
    </script>
{/literal}