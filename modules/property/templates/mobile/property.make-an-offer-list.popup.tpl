{literal}
<style>
.maogb_box2{
	position:absolute;
	z-index:10px;
	background-color:#FFFFFF;
	border:1px solid #FFECEC;
	padding:0px 4px 2px 10px;
}
.maogb_box2 form{
	margin:0px;
	padding:0px;
}
</style>
{/literal}
<script type="text/javascript">
    jQuery('#bid-price-acc-{$property_id}').html('{$pro_price}');
</script>
{if is_array($rows) and count($rows) > 0}
	{foreach from = $rows key = k item = row}
        <div style="margin:1px;background-color:#FFFBFB;border:1px solid #FFECEC;width:434px;">
            <div style="margin:10px">
                <!--<p style="text-decoration:underline">MSG ID : {$row.message_id}</p>-->
                {$row.content}
                <br/>
                <p style="font-size:10px;color:#006FDD">
                    From : <a href="mailto:{$row.email_from}">{$row.email_from}</a><br/>
                    Created At : {$row.at}
                </p>
                <p>
                </p>
                    <div class="maogb_box2" id = "maogb_minibox_{$row.message_id}" style="display:none">
                        <form style="display:inline">
                            <label for="money_{$row.message_id}">
                                <input type = "text" readonly="readonly" name="money[]" id="money_{$row.message_id}" value="{$row.offer_price}" style="width:150px;height:20px;display: none"/>
                                Offer price: <input type = "text" readonly="readonly" name="money[]" id="show_money_{$row.message_id}" value="{$row.price}" style="width:150px;height:20px"/>
                            </label>
                        </form>
                            {if $row.type == "forth_auction" AND $row.reserve > $row.offer_price}
                                <button class="btn-red btn-makeanoffer" onClick="acceptOfferPopup('{$row.message_id}','{$row.entity_id}','{$row.agent_id_from}','#money_{$row.message_id}')">
                                    <span><span>Submit</span></span>
                                 </button>
                            {else}
                                 <button class="btn-red btn-makeanoffer" onClick="MAOGridBox.submit('{$row.message_id}','{$row.entity_id}','{$row.agent_id_from}','#money_{$row.message_id}')">
                                    <span><span>Submit</span></span>
                                 </button>
                            {/if}
                             <button class="btn-red btn-makeanoffer" onClick="MAOGridBox.cancel('{$row.message_id}','{$row.entity_id}')">
                                <span><span>Cancel</span></span>
                             </button>
                    </div>

                     <button class="btn-red btn-makeanoffer" onClick="MAOGridBox.accept('{$row.message_id}','{$row.entity_id}','{$row.agent_id_from}','#money_{$row.message_id}')">
                        <span><span>Accept</span></span>
                     </button>
                     <button class="btn-red btn-makeanoffer" onClick="MAOGridBox.refuse('{$row.message_id}','{$row.entity_id}')">
                        <span><span>Refuse</span></span>
                     </button>
                     <span id="maogb_loading_{$row.message_id}" style="position:absolute;display:none;margin-top:5px">
                        <img src="/modules/general/templates/images/loading.gif" style="height:30px;" alt="" />
                     </span>
                <p></p>
            </div>
        </div>
    {/foreach}
{else}
    {if $check_sold}
        <script type="text/javascript">
            jQuery('#reset_options_{$property_id}').hide();
        </script>
    {/if}
    <script type="text/javascript">
        closeMAOGB();
        jQuery('#offer-message-{$property_id}').hide();
    </script>
{/if}
<script type="text/javascript">
</script>
{literal}
    <script type="text/javascript">
        function closeOfferPopup(){
            offerPopup.hide();
        }
        function acceptOfferPopup(message_id,entity_id,agent_id_from,money_id){
            MAOGB_popup.hide();
            offerPopup.init({id:'offerPopup',className:'popup_overlay'});
            offerPopup.updateContainer('<div class="popup_container" style="width:295px;height: 150px;"><div id="contact-wrapper">\
                             <div class="title"><h2 id="txtt"> This page says:<span id="btnclosex" onclick="closeOfferPopup()">x</span></h2> </div>\
                             <div class="clearthis" style="clear:both;"></div>\
                             <div align="center" style="margin-bottom: 20px; margin-top: 20px;" class="content content-po" id="msg"> This offer price is less than your reserve price.<br>Please confirm if you really want to sell your property with this offer price</div>\
                             <div align="center" class="button" style="margin: 5px 25px 0px 30px;"><button class="btn-red" style="margin-right: 25px;" onclick="MAOGridBox.submit('+message_id+','+entity_id+','+agent_id_from+',\''+money_id+'\')"><span><span>OK</span></span></button>\
                             <button style="width:84px;*width:74px;" class="btn-red" onclick="MAOGridBox.refuse('+message_id+','+entity_id+')"><span><span>CANCEL</span></span></button></div>\
                              </div></div></div>');

            offerPopup.show().toCenter();
        }
    </script>
{/literal}