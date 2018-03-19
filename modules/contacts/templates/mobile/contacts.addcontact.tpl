{literal}
<script src="/modules/contacts/templates/js/contact.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../modules/contacts/templates/css/style.css"/>
<!--<link href="../modules/general/templates/style/styles.css" type="text/css" rel="stylesheet" /> -->
<!--<script type="text/javascript">
			$(document).ready(function() {
				$("#contactform").validate();
			});
			$(":submit").button();
   		 </script>-->
<style type="text/css">

#notify_auction_sale
{
     color: #FF0000;
}
#contactform label.error
{
    display:none !important;
}

input.error {
    border: 1px dashed #FF0000;
     color: #FF0000
}
textarea.error {
    border: 1px dashed #FF0000;
     color: #FF0000
}
h3{
    color: #980000;
    font-size: 20px;
    font-weight: normal;
    margin-bottom: 10px;
}
#messtext
{
    font-size:11px;
    font-weight:bold;

}
#recaptcha_area,#recaptcha_table{width:318px !important}
.recaptchatable td img {
    display: block;
}
div#recaptcha_area table#recaptcha_table.recaptchatable tbody tr td div.recaptcha_input_area input#recaptcha_response_field {
    width: 150px !important
}
.recaptchatable .recaptcha_r1_c1 {
    background: url("http://www.google.com/recaptcha/api/img/white/sprite.png") no-repeat scroll 0 -63px transparent;
    height: 9px;
}
.recaptchatable .recaptcha_r2_c1 {
    background: url("http://www.google.com/recaptcha/api/img/white/sprite.png") no-repeat scroll -18px 0 transparent;
    height: 57px;
    width: 9px;
}
.recaptchatable .recaptcha_r2_c2 {
    background: url("http://www.google.com/recaptcha/api/img/white/sprite.png") no-repeat scroll -27px 0 transparent;
    height: 57px;
    width: 9px;
}
.recaptchatable .recaptcha_r3_c1 {
    background: url("http://www.google.com/recaptcha/api/img/white/sprite.png") no-repeat scroll 0 0 transparent;
    height: 63px;
    width: 9px;
}
.recaptchatable .recaptcha_r3_c2 {
    background: url("http://www.google.com/recaptcha/api/img/white/sprite.png") no-repeat scroll -18px -57px transparent;
    height: 6px;
}
.recaptchatable .recaptcha_r3_c3 {
    background: url("http://www.google.com/recaptcha/api/img/white/sprite.png") no-repeat scroll -9px 0 transparent;
    height: 63px;
    width: 9px;
}
.recaptchatable .recaptcha_r4_c1 {
    background: url("http://www.google.com/recaptcha/api/img/white/sprite.png") no-repeat scroll -43px 0 transparent;
    height: 49px;
    width: 171px;
}
.recaptchatable .recaptcha_r4_c2 {
    background: url("http://www.google.com/recaptcha/api/img/white/sprite.png") no-repeat scroll -36px 0 transparent;
    height: 57px;
    width: 7px;
}
.recaptchatable .recaptcha_r4_c4 {
    background: url("http://www.google.com/recaptcha/api/img/white/sprite.png") no-repeat scroll -214px 0 transparent;
    height: 57px;
    width: 97px;
}
.recaptchatable .recaptcha_r7_c1 {
    background: url("http://www.google.com/recaptcha/api/img/white/sprite.png") no-repeat scroll -43px -49px transparent;
    height: 8px;
    width: 171px;
}
.recaptchatable .recaptcha_r8_c1 {
    background: url("http://www.google.com/recaptcha/api/img/white/sprite.png") no-repeat scroll -43px -49px transparent;
    height: 8px;
    width: 25px;
}
.recaptchatable .recaptcha_image_cell center img {
    height: 57px;
}
.recaptchatable .recaptcha_image_cell center {
    height: 57px;
}
.recaptchatable .recaptcha_image_cell {
    background-color: white;
    height: 57px;
}
.recaptchatable, #recaptcha_area tr, #recaptcha_area td, #recaptcha_area th {
    border: 0 none !important;
    border-collapse: collapse !important;
    margin: 0 !important;
    padding: 0 !important;
    vertical-align: middle !important;
}
.recaptchatable * {
    border: 0 none;
    bottom: auto;
    color: black;
    font-family: helvetica,sans-serif;
    font-size: 8pt;
    left: auto;
    margin: 0;
    padding: 0;
    position: static;
    right: auto;
    text-align: left !important;
    top: auto;
}
.recaptchatable #recaptcha_image {
    margin: auto;
}
.recaptchatable img {
    border: 0 none !important;
    margin: 0 !important;
    padding: 0 !important;
}
.recaptchatable a, .recaptchatable a:hover {
    background: none repeat scroll 0 0 transparent !important;
    border: 0 none !important;
    color: blue;
    font-weight: normal;
    outline: medium none;
    padding: 0 !important;
    text-decoration: none;
}
.recaptcha_input_area {
    background: none repeat scroll 0 0 transparent !important;
    height: 45px !important;
    margin-left: 20px !important;
    margin-right: 5px !important;
    margin-top: 4px !important;
    margin-bottom: 0px !important;
    position: relative !important;
    width: 146px !important;
}
.recaptchatable label.recaptcha_input_area_text {
    background: none repeat scroll 0 0 transparent !important;
    bottom: auto !important;
    height: auto !important;
    left: auto !important;
    margin: 0 !important;
    padding: 0 !important;
    position: static !important;
    right: auto !important;
    top: auto !important;
    width: auto !important;
}
.recaptcha_theme_red label.recaptcha_input_area_text, .recaptcha_theme_white label.recaptcha_input_area_text {
    color: black !important;
}
.recaptcha_theme_blackglass label.recaptcha_input_area_text {
    color: white !important;
}
.recaptchatable #recaptcha_response_field {
    bottom: 7px !important;
    font-size: 10pt;
    margin: 0 !important;
    padding: 0 !important;
    position: absolute !important;
    width: 145px !important;
}
.recaptcha_theme_blackglass #recaptcha_response_field, .recaptcha_theme_white #recaptcha_response_field {
    border: 1px solid gray;
}
.recaptcha_theme_red #recaptcha_response_field {
    border: 1px solid gray;
}
.recaptcha_audio_cant_hear_link {
    color: black;
    font-size: 7pt;
}
.recaptchatable {
    line-height: 1em;
}
#recaptcha_instructions_error {
    color: red !important;
}
.recaptcha_is_showing_audio .recaptcha_only_if_image, .recaptcha_isnot_showing_audio .recaptcha_only_if_audio, .recaptcha_had_incorrect_sol .recaptcha_only_if_no_incorrect_sol, .recaptcha_nothad_incorrect_sol .recaptcha_only_if_incorrect_sol {
    display: none !important;
}
</style>
{/literal}
{*{if $emailSent == "emailSent" and $error == false}
<div class="container-l">
    <div class="container-r">
    	<div class="container col2-right-layout">
            <div class="main">


 					 <div class="col-main cms">
                         <div style="clear:both"> </div>
                            <div id="contact-wrapperx">
                                <p id="messtext"><strong>The information has been sent!</strong></p>
                                <p><strong>Thank you for your contact!</strong></p>
              	      </div>
                    <div class="col-right">
                               <div class="advertisement-box">
                              </div>
                    </div>
                    <div class="clearthis">
                    </div>
			</div>
		</div>
	</div>
</div>
</div>
{/if} *}
	  <div class="container-l">
		<div class="container-r">
			<div class="container">
				<div class="main">
                   <div class="col-main">
                   		<div id="contact-wrapper">
                            {if $emailSent == "emailSent" and $error == false}
                                 <div style="clear:both"> </div>
                                    <div id="contact-wrapperx" style="padding: 10px;">
                                        <p id="messtext"><strong>The information has been sent!</strong></p>
                                        <p><strong>Thank you for your contact!</strong></p>
                                 </div>
                            {/if}
                            <h3> Contact Information </h3>
     						{literal}
                            <script  type="text/javascript">
                            var contactForm = new ContactForm('#contactform');
							</script>
                            {/literal}
                            <form method="post" action="?module=contacts&action=contacts" name="contactform" id="contactform" onsubmit="return contactForm.isSubmit();">
                                <ul class="form-list">

                                {if isset($message) and strlen($message)>0 and $error == true}
                                    <div class="message-box message-box-v-ie">
                                        {$message}
                                    </div>
                                {/if}
                                    <li class="wide">
                                        <label for="contactname"><strong>Name <span
                                                id="notify_contactname">*</span></strong></label>

                                        <div class="input-box">
                                            <input type="text" size="50" name="contactname" id="contactname" value=""
                                                   class="input-text validate-require"/>
                                        </div>
                                    </li>

                                    <li class="wide">
                                        <label for="subject"><strong>Subject <span id="notify_subject">*</span></strong></label>

                                        <div class="input-box">
                                            <input type="text" size="50" name="subject" id="subject" value=""
                                                   class="input-text validate-require"/>
                                        </div>
                                    </li>

                                    <li class="wide">
                                        <label for="email"><strong>Email <span
                                                id="notify_email">*</span></strong></label>

                                        <div class="input-box">
                                            <input type="text" size="50" name="email" id="email" value=""
                                                   class="input-text validate-require"/>
                                        </div>
                                    </li>

                                    <li class="wide">
                                        <label><strong>Telephone </strong></label>

                                        <div class="input-box">
                                            <input type="text" size="50" name="telephone" id="telephone" value=""
                                                   class="input-text"/>
                                        </div>
                                    </li>

                                    <li class="wide">
                                        <label for="message"><strong>Message <span id="notify_message">*</span></strong></label>

                                        <div class="input-box">
                                            <textarea style="height:80px" rows="10" cols="38" name="message"
                                                      id="message" class="input-text validate-require"></textarea>
                                        </div>
                                    </li>

                                    <li class="wide">
                                        <label for="message"><strong>Captcha <span>*</span></strong></label>
                                        <div id="input-box-contact" class="input-box">
                                            <div id="contact-captcha">
                                            {if $captcha_enable == 1}
                                                <center>
                                                    <div id="captcha_">
                                                        {$captcha_form}
                                                    </div>
                                                </center>
                                            {/if}
                                            </div>
                                        </div>
                                    </li>
                                </ul>


                                <button id="submit-contact" class="btn-red f-right"
                                        onclick="contactForm.submit('#contactform');">
                                    <span><span>Submit</span></span>
                                </button>
                                <div class="clearthis"></div>
                                
                                <input type="hidden" name="ok" value="submit"/>
                                <input type="hidden" name="is_submit" id="is_submit" value="0"/>
                            </form>
                 	  </div>
                   </div>
			</div>
		</div>
	</div>
</div>

{literal}
<SCRIPT TYPE="text/javascript">
	<!--
	function submitenter(myfield,e)
	{
		var keycode;
		if (window.event) keycode = window.event.keyCode;
		else if (e) keycode = e.which;
		else return true;

		if (keycode == 13)
		   {
		   myfield.form.submit();
		   return false;
		   }
		else
		   return true;
	}
    jQuery(document).ready(function(){
        jQuery('#contact-captcha').css('width',(jQuery('#contact-wrapper').innerWidth() - 20)+'px !important');
    });
	//-->
</script>
{/literal}

