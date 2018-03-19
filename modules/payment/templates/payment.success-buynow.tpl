<div class="">
    <div class="">
        <div class="">
            <div class="main" style="width: 915px;">
                <div class="col-main" style="float: left; width: 620px;">
                    <div class="step-8-info">
                        <div class="step-name">
                            {if $type == 'registration'}
                                 <h2>Your registration has completed !</h2>
                            {else}
                                <h2>Your payment is successful !</h2>
                            {/if}
                        </div>
                        <div class="step-detail col2-set">
                            <div class="col-1">
                                <p style="">
                                    Thanks for buy this property.</br>
                                    if you have any issues or concerns please contact us at <a href="mailto:{$contact_email}" style="font-size: 14px;font-weight: bold;">{$contact_email}</a>.
                                </p>
                                <br/>
                                <p>
                                </p>
                            </div>
                            <div class="col-2 bg-f7f7f7">
                                <div class="step-name">
                                    <h2 style=" padding-left: 10px; padding-top: 10px; ">Property Information</h2>
                                </div>
                                <div class="areg-item">
                                    <div class="item">
                                        <div class="title">
                                            <span class="f-left">{$review.info.title}</span>
                                            <span class="f-right">{$review.info.buynow_price}</span>
                                            <div class="clearthis">
                                            </div>
                                        </div>
                                        <div class="f-left info" style="height: auto;">
                                            <div class="desc" style="margin-bottom: 15px">
                                               {$review.info.full_address} {$review.info.description}
                                            </div>
                                            <div class="tbl-info">
                                                <ul class="f-left col1">
                                                    <li>
                                                        <span class="span-ll-step7">Property kind</span>
                                                        <span class="span-rr-step7">{php} echo PEO_getKindName($this->_tpl_vars['review']['info']['kind']);{/php}</span>
                                                        <div class="clearthis clearthis-ie7"></div>
                                                    </li>
                                                    <li>
                                                    {*<span class="title-star">Livability Rating</span><span  class="span-star"> {$review.info.livability_rating_mark}</span>*}
                                                        <span class="span-ll-step7">Land size</span>
                                                        <span class="span-rr-step7">{$review.info.land_size}</span>
                                                        <div class="clearthis clearthis-ie7"></div>
                                                    </li>
                                                    <li>
                                                        <span>
                                                            {if $review.info.parking == 1}
                                                                {assign var="car_port" value = $review.info.carport_value }
                                                                {if $car_port == ''}{assign var="car_port" value="none"}{/if}
                                                                <div style="float: left;">
                                                                    Car Parking{if $review.info.carport_value > 1}s{/if}
                                                                    : {$car_port}
                                                                </div>
                                                                <div style="float: right;">
                                                                    Carspace{if $review.info.carspace_value > 1}s{/if}
                                                                    : {$review.info.carspace_value}
                                                                </div>
                                                                {else}
                                                                <strike>Car Parking: None</strike>
                                                            {/if}
                                                            <div class="clearthis clearthis-ie7"></div>
                                                        </span>
                                                    </li>
                                                    {*<li id="focus_tooltip" class="focus-tooltip-step7" title="">
                                                        <span class="tooltip-step7-ie7">
                                                            <label id="focus_tip" for="set_focus">
                                                                {assign var = checked value = ''}
                                                                {if $review.info.focus == 1}
                                                                    {assign var = checked value = 'checked'}
                                                                {/if}
                                                                    <input id="set_focus" type="checkbox" title="text text" value="{$review.info.focus}" {$checked} name="set_focus" disabled="disabled"/>
                                                                <span>Set Focus</span> <span id="set_focus_loading"></span>
                                                            </label>
                                                        </span>
                                                        <div class="clearthis clearthis-ie7"></div>
                                                    </li>*}
                                                </ul>
                                                <ul id="ul-payment-success" class="f-left col2">

                                                    <li>
                                                        <span>
                                                        {if $review.info.kind == 1}
                                                            <strike>Bedrooms</strike>
                                                            {else}
                                                            {$review.info.bedroom_value} Bedroom{if $review.info.bedroom_value > 1}s{/if}
                                                        {/if}
                                                        </span>
                                                        <div class="clearthis clearthis-ie7"></div>
                                                    </li>
                                                    <li>
                                                        <span>
                                                        {if $review.info.kind == 1}
                                                            <strike>Bathrooms</strike>
                                                            {else}
                                                            {$review.info.bathroom_value} Bathroom{if $review.info.bathroom_value > 1}s{/if}
                                                        {/if}
                                                        </span>
                                                        <div class="clearthis clearthis-ie7"></div>
                                                    </li>

                                                    <li class="payment-success {if in_array($review.info.auction_sale_code,array('ebiddar','bid2stay'))}ul-disable{/if}">
                                                        <span class="title-star" >iBB Sustainability</span><span  class="span-star">{$review.info.green_rating_mark}</span>
                                                        <div class="clearthis clearthis-ie7"></div>
                                                    </li>
                                                    {*<li id="homepage_tooltip" class="focus-tooltip-step7" title="">
                                                        <span class="tooltip-step7-ie7">
                                                            <label for="set_home">
                                                                {assign var = checked value = ''}
                                                                {if $review.info.set_jump == 1}
                                                                    {assign var = checked value = 'checked'}
                                                                {/if}
                                                                    <input id="set_home" type="checkbox" value="{$review.info.set_jump}" {$checked} name="set_home" disabled="disabled"/>
                                                                <span>Set Home page</span> <span id="set_home_loading"></span>
                                                            </label>
                                                        </span>

                                                        <div class="clearthis clearthis-ie7"></div>
                                                    </li>*}
                                                </ul>
                                                <div class="clearthis">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="f-right img">
                                            <div>
                                                <img src="{$review.photo}" alt="img" style="width:180px;height:130px;"/>
                                            </div>
                                        </div>
                                        <div class="clearthis">
                                        </div>
                                    </div>
                                    <div class="buttons-set">
                                        <!-- <button class="btn-red step-eight-btn-red">
                                            <span><span>Confirm & Checkout</span></span>
                                        </button> -->
                                    </div>

                                </div>

                                <div>
                                    <ul style="margin-left: 50px; height: 100px;">
                                        <li  style="font-size: larger; margin-bottom: 5px;" ><a href="/?module=agent&action=view-dashboard">Go to dashboard.</a></li>
                                        <li style="font-size: larger; margin-bottom: 5px;"><a href="/?module=package">Add a new property.</a></li>
                                        <li  style="font-size: larger; margin-bottom: 5px;"><a href="/?module=property&action=view-auction-detail&id={$item_number}">Go to property detail.</a></li>
                                    </ul>
                                    {*{$meta_refresh}*}
                                </div>

                            </div>

                            <div class="clearthis"></div>
                        </div>
                    </div>
                </div>

                <div class="col-right">
                      {include file = "`$ROOTPATH`/modules/general/templates/side.right.tpl"}
                </div>
                
                <div class="clearthis"></div>
            </div>
        </div>
    </div>
</div>
