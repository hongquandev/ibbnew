{*
<div class="popup_container not_address_popup" id = "not_found_address_{$property_id}" style="display:none;z-index:89 !important; position: absolute !important;">
    <div id="contact-wrapper" class="myaccount make-an-offer-popup-a"  style="padding-bottom:0px;width:420px">
		<div class="title"><h2>MAKE AN OFFER <span onclick="pro.closeMakeAnOffer('#makeanoffer_{$property_id}')"  id="fridx" style="color:#ffffff">Close X</span></h2> </div>
        <div class="ma-messages make-an-offer-popup-b" id="fridmess">
        	<form name="frmMakeAnOffer_{$property_id}" class="frm-mao frm-make-an-offer-popup" id="frmMakeAnOffer_{$property_id}" style="width:410px;margin:4px;">
            	<span style="clear:both"><b>From:</b></span>
                <input type="hidden" id="agent_email_active" value="{$agent_email}"/>
                <input type="text" id="agent_email" name="agent_email" value="{$agent_email}" class="validate-email validate-agentEmail" style="width:100%;"/>

                <span style="clear:both"><b>Subject:</b></span>
                <input type="text" id="subject_email" readonly="readonly" name="agent_email" value="Offer ID: {$property_id}" class="" style="width:100%;"/>

                <span style="clear:both"><b>Offer with price AU $ :</b></span>
               <input type="text" id="offer_price"  name="offer_price" value="" class="validate-price" style="width:100%;"/>

                <span style="clear:both"><b>Message :</b></span>
            	<textarea id="content" name="content" class="validate-require" style="width:100%;height:55px;"></textarea>
                <input type="hidden" id="agent_id" name="agent_id" value="{$agent_id}"/>

                <input type="hidden" id="property_id" name="property_id" value="{$property_id}"/>
            </form>

             <div>
                 <button class="btn-red btn-makeanoffer" name="submit" onClick="pro.makeAnOffer('#frmMakeAnOffer_{$property_id}','{$property_id}','#makeanoffer_{$property_id}')">
                    <span><span>Submit</span></span>
                 </button>
                 <div id="mao_loading_{$property_id}" style="display:inline;">
                    <img src="/modules/general/templates/images/loading.gif" style="height:30px;"/>
                 </div>
            </div>
        </div>
    </div>
</div>
*}
<script type="text/javascript">
    var pro = Property();
</script>
<div class="popup_container google_popup" id="google_popup" style="width:356px;height: 122px;display: none">
    <div id="contact-wrapper">
        <div class="title">
            <h2 id="txtt">  This page says:
                <span id="btnclosex" onclick="close_popup()">x</span>
            </h2>
        </div>
        <div class="clearthis" style="clear:both;"></div>
        <div class="content content-po" id="msg">
            <img src="/modules/property/templates/images/alert.png">
                <span>{$address} Not found. Please check property address again !</span>
        </div>
                <button class="btn-red btn-red-mess-po" onclick="close_popup()"><span><span>OK</span></span></button>
    </div>
</div>
    {if $check_address == false}
        <script type="text/javascript">
            jQuery('#google_popup').show();
        </script>
    {/if}

<script type="text/javascript">
    {literal}
        function close_popup()
        {
          jQuery('#google_popup').hide();
        }
    {/literal}
</script>