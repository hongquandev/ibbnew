{literal}
    <style type="text/css">
        .tbl-info ul li{padding: 8px 5px !important;}
    </style>
    <script type="text/javascript">
		var pro = new Property();
		$(function() {
			$('#focus_tooltip').tipsy({gravity: $.fn.tipsy.autoNS,fallback: " <div style='padding: 5px;text-align: justify'>Feature properties are the large sliding images on the home page at the top. These cycle through regularly for prominent position and to get noticed. This will provide your property a very prominent and noticeable position. It may take some time to see your property depending on the number of registered feature properties.</div>",html: true });
			$('#homepage_tooltip').tipsy({gravity: $.fn.tipsy.autoNS,fallback: "<div style='padding: 5px;text-align: justify' >the Home page selection provides your property a position on the home page, and this will provide your property a good profile. If there are more properties than fit on 1 page, yours will come along keep refreshing the page to see your property posted on the home page.</div>",html:true });
		});
    </script>
{/literal}
<div class="step-8-info">
    <div class="step-name">
        <h2>{localize translate="Confirm & Pay"}</h2>
    </div>
    <div class="step-detail col2-set">
        <div class="col-1">
            <p style="text-align: justify;padding-right: 10px;">
                {localize translate="Please review and confirm the details of your property"}.
            </p>
            <p style="text-align: justify;padding-right: 10px;">
                Once you are happy and sure you have entered all details correctly, please progress to payment to finalise the posting of your property.
            </p>
            <p style="text-align: justify;padding-right: 10px;">
                To pay using Paypal, you can pay via a Paypal account, if you have one, but if not, don't worry, you can pay directly via the Paypal system, with a credit card, without using a Paypal account.
            </p>

        </div>
        <div class="col-2 bg-f7f7f7">
            <div class="areg-item">
                <div class="item">
                    <div class="title">
                        <span class="f-left">{$review.info.title}</span>
                        <span class="f-right">{$review.info.price}</span>
                        <div class="clearthis">
                        </div>
                    </div>
                    <div class="f-left info">
                        <div class="desc" style="margin-bottom: 15px">
                           {$review.info.full_address} {$review.info.description}
                        </div>
                        <div class="tbl-info">
                        	<form name="frmProperty" id="frmProperty" method="post" action="{$form_action}">
                            <ul class="f-left col1">
                                <li>
                                    <span class="span-l-step7">{localize translate="Property kind"}</span>
                                    <span class="span-r-step7">{php} echo PEO_getKindName($this->_tpl_vars['review']['info']['kind']);{/php}</span>
                                    <div class="clearthis clearthis-ie7"></div>
                                </li>
                                <li>
                                    <span class="span-l-step7">{localize translate="Land size"}</span>
                                    <span class="span-r-step7">{$review.info.land_size}</span>
                                    <div class="clearthis clearthis-ie7"></div>
                                </li>
                                <li>
                                    <span>
                                    {if $review.info.parking == 1}
                                        {assign var="car_port" value = $review.info.carport_value }
                                        {if $car_port == ''}{assign var="car_port" value="none"}{/if}
                                        <div style="float: left;">
                                            {localize translate="Car Parking"}{if $review.info.carport_value > 1}s{/if}: {$car_port}
                                        </div>
                                        <div style="float: right;">
                                            {localize translate="Carspace"}{if $review.info.carspace_value > 1}s{/if}: {$review.info.carspace_value}
                                        </div>
                                    {else}
                                        <strike>{localize translate="Car Parking: None"}</strike>
                                    {/if}
                                    </span>
                                    <div class="clearthis clearthis-ie7"></div>
                                </li>
                                {*<li id="focus_tooltip_step7" class="focus-tooltip-step7" title="">
                                    <span class="span-l-step7 span-s-step7">
                                    	<label id="focus_tip" for="set_focus" style="vertical-align: middle;">
                                        	{assign var = checked value = ''}
                                            {if $review.info.focus == 1}
                                            	{assign var = checked value = 'checked'}
                                            {/if}
                                            <input style="vertical-align: middle;" id="set_focus" type="checkbox" title="text text" value="{$review.info.focus}" {$checked} name="set_focus" />
                                            <span>Feature</span>
                                            <span id="set_focus_loading"></span>
                                        </label>                                
                                    </span>
                                    <span class="span-l-step7 span-ss-step7">
                                        <lable style="font-weight: bold; color: #CC8C04; vertical-align: middle;">
                                             ({$focus_price})
                                        </lable>
                                    </span>
                                    <span class="span-r-step7">
                                        <img id="focus_tooltip" style="vertical-align: middle;" src="/modules/general/templates/images/img_question.png"  />
                                    </span>
                                    <div class="clearthis clearthis-ie7"></div>
                                </li>*}
                            </ul>
                            <ul class="f-left col2">
                                <li>
                                    <span>
                                    {if $review.info.kind == 1}
                                        <strike>{localize translate="Bedrooms"}</strike>
                                    {else}
                                        {$review.info.bedroom_value} {localize translate="Bedroom"}{if $review.info.bedroom_value > 1}s{/if}
                                    {/if}
                                    </span>
                                    <div class="clearthis clearthis-ie7"></div>
                                </li>
                                <li>
                                    {*<span class="title-star">Livability Rating</span>
                                    <span class="span-star"> {$review.info.livability_rating_mark}</span>*}
                                    <span>
                                    {if $review.info.kind == 1}
                                        <strike>{localize translate="Bathrooms"}</strike>
                                    {else}
                                        {$review.info.bathroom_value} {localize translate="Bathroom"}{if $review.info.bathroom_value > 1}s{/if}
                                    {/if}
                                    </span>
                                    <div class="clearthis clearthis-ie7"></div>
                                </li>
                                <li style="height: 13px" {if $review.info.auction_sale_code == 'ebiddar'}class="ul-disable"{/if}>
                                    {*<span class="title-star" >iBB Sustainability</span>
                                    <span class="span-star">{$review.info.green_rating_mark}</span>
                                    <div class="clearthis clearthis-ie7"></div>*}
                                </li>
                                {*<li id="homepage_" class="focus-tooltip-step7" title="">
                                    <span class="span-l-step7 span-s-step7">
                                    	<label for="set_home" style=" vertical-align: middle;">
                                        	{assign var = checked value = ''}
                                            {if $review.info.set_jump == 1}
                                            	{assign var = checked value = 'checked'}
                                            {/if}
                                            <input style="vertical-align: middle;" id="set_home" type="checkbox" value="{$review.info.set_jump}" {$checked} name="set_home"/>
                                            <span>Home page</span>
                                            <span id="set_home_loading"></span>
                                        </label>                              
                                    </span>
                                    <span class="span-l-step7 span-ss-step7">
                                        <lable style="font-weight: bold; color: #CC8C04; vertical-align: middle;">
                                             ({$home_price})
                                        </lable>
                                    </span>
                                    <span class="span-r-step7">
                                        <img id="homepage_tooltip" style="vertical-align: middle;" src="/modules/general/templates/images/img_question.png"  />
                                    </span>
                                    <div class="clearthis clearthis-ie7"></div>
                                </li>*}
                            </ul>
                            </form>
                            <div class="clearthis"></div>
                        </div>
                    </div>
                    <div class="f-right img" style="margin-left: 10px">
                        <div>
                            <img src="{$review.photo}" alt="img" style="width:180px;height:130px;"/>
                        </div>
                    </div>
                    <div class="clearthis"></div>
                </div>
            </div>
            <div class="clearthis"></div>
            <!--BEGIN FORM-->

            <div id="panel_payment" class="panel-payment-step7" >
                <button id="step-eight-btn" class="btn-black step-eight-btn-red step-eight-btn3" onclick="(document.location.href='/?module=property&action=register&step=5')"><span><span>Back</span></span></button>
                <button class="btn-black step-eight-btn-red3" onclick="jQuery('#frmProperty').submit();">
                    <span><span>{localize translate="Confirm & Checkout"}</span></span>
                </button>
            </div>
            <!--END FORM-->

        </div>
        <div class="clearthis"></div>
    </div>
</div>

