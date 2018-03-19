<div class="popup_container make-an-offer-popup" id="makeanoffer_{$property_id}" style="display:none;z-index:100 !important; position: absolute !important;">
    <div id="contact-wrapper" class="make-an-offer-popup-a"  style="padding-bottom:0px;">
		<div class="title"><h2>MAKE AN OFFER <span onclick="pro.closeMakeAnOffer('#makeanoffer_{$property_id}')" class="btn-x"  id="fridx" style="color:#ffffff">Close X</span></h2></div>
        <div style="margin:4px;padding: 5px;" class="ma-messages make-an-offer-popup-b" id="fridmess">
        	<form name="frmMakeAnOffer_{$property_id}" class="frm-mao frm-make-an-offer-popup" id="frmMakeAnOffer_{$property_id}">
	            <div class="input-box">
                    <label><strong>From:</strong></label><br/>
                    <input type="hidden" id="agent_email_active" value="{$agent_email}"/>
                    <input type="text" id="agent_email" name="agent_email" value="{$agent_email}" class="input-text validate-email validate-agentEmail" style="width:98%"/>
				</div>
                <div class="input-box">
                    <label><strong>Subject:</strong></label><br/>
                    <input type="text" id="subject_email" readonly="readonly" name="agent_email" value="Offer ID: {$property_id}" class="input-text" style="width:98%"/>
				</div>
                <div class="input-box">                
                    <label><strong>Offer with price AU $ :</strong></label><br/>
                    <input type="text" id="offer_price_show"  name="offer_price_show" onkeyup="this.value=Make_offer_price(this.value,{$property_id});" class="input-text validate-require" style="width:98%"/>
                    <input type="hidden" id="offer_price"  name="offer_price" class="" style="width:100%;"/>
				</div>
                <div class="input-box">                
                    <label><strong>Message:</strong></label><br/>
                    <textarea id="content" name="content" class="input-text validate-require" style="width:98%;height:45px;"></textarea>
				</div>                
                <input type="hidden" id="agent_id" name="agent_id" value="{$agent_id}"/>
                <input type="hidden" id="property_id" name="property_id" value="{$property_id}"/>
            </form>

             <div class="button-set">
             	 <!--
                 <button class="btn-red btn-makeanoffer" name="submit" onClick="pro.makeAnOffer('#frmMakeAnOffer_{$property_id}','{$property_id}','#makeanoffer_{$property_id}')">
                    <span><span>Submit</span></span>
                 </button>
                 -->
                 <button class="btn-submit" onClick="pro.makeAnOffer('#frmMakeAnOffer_{$property_id}','{$property_id}','#makeanoffer_{$property_id}')"><span><span>SUBMIT</span></span></button>
                 <div id="mao_loading_{$property_id}" style="display:inline;position: absolute;margin-left: 5px">
                    <img src="/modules/general/templates/images/loading.gif" style="height:25px;" alt="" />
                 </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="/modules/property/templates/js/offer.js"></script>

