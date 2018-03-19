<div class="bar-title">
    <h2>MY CREDIT CARD DETAILS</h2>
    <script type="text/javascript">
	var cc = new CreditCard('#frmCreditCard');
	cc.pre_checkbox = 'cc_id';
	</script>
</div>

<div class="ma-info mb-20px credit-card-account">

    <div class="col2-set mb-20px">
        <div class="col">
            {if isset($message) and strlen($message) > 0}
                <div class="message-box message-box-ie">{$message}</div>
            {/if}
        	
            <form id="frmCreditCard" class="frmcreditcard-all" ame="frmCreditCard" method="post" action = "{$form_action}" onsubmit="return cc.isSubmit()">
			{if $action_ar[0] == 'view'}
			<div class="ma-messages mb-20px">
            	
                <table class="tbl-messages" cellpadding="0" cellspacing="0">
                    <colgroup>
                        <col width="20px"/><col width="150px"/><col width="200px"/><col width="130px"/><col width="130px"/>
                    </colgroup>
                    <thead>
                        <tr>
                            <td>
                                <input type="checkbox" name="all_chk" id="all_chk" onclick="Common.checkAll(this,'cc_id')"/>
                            </td>
                            <td>
                                Card type
                            </td>
                            <td>
                                Card name
                            </td>
                            <td>
                                Card number
                            </td>
                            <td>
                            	Expiration date
                            </td>
                        </tr>
                    </thead>
                    <tbody></tbody>      
                {if isset($creditcard_data) and is_array($creditcard_data) and count($creditcard_data)>0}
                    {foreach from = $creditcard_data key = k item = v}
                        <tr>
                            <td><input type="checkbox" name="cc_id[{$v.agent_creditcard_id}]" id="cc_id_{$v.agent_creditcard_id}" value="{$v.agent_creditcard_id}"/></td>
                            <td onclick="cc.rowClick('{$v.agent_creditcard_id}')">{$v.card_typename}</td>
                            <td onclick="cc.rowClick('{$v.agent_creditcard_id}')">{$v.card_name}</td>
                            <td onclick="cc.rowClick('{$v.agent_creditcard_id}')">{$v.card_number}</td>
                            <td onclick="cc.rowClick('{$v.agent_creditcard_id}')">{$v.expiration_date}</td>
                        </tr>
                    {/foreach}
                {/if}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <a href="javascript:void(0)" onclick="cc.newCC('?module=agent&action=edit-creditcard')">New Credit Card</a>
                                |<a href="javascript:void(0)" onclick="cc.delCC('?module=agent&action=delete-creditcard')">Delete</a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>                        
                
            {else if $action_ar[0] == 'edit'}
                <ul class="form-list">
                    <li class="wide">
                        <label>
                            <strong id="notify_card_type">Card type <span>*</span></strong>
                        </label>
                        <div class="input-box" style="width:50%">
                            <select name="field[card_type]" id="card_type"  class="input-select validate-require">
                                {html_options options = $options_card_type selected = $form_data.card_type}
                            </select>
                        </div>
                    </li>
                    <li class="wide">
                        <label>
                            <strong id="notify_card_name">Name on card <span>*</span></strong>
                        </label>
                        <div class="input-box">
                            <input type="text" name = "field[card_name]" id = "card_name" value="{$form_data.card_name}" class="input-text validate-require" />
                        </div>
                    </li>
                    <li class="wide">
                        <label>
                            <strong id="notify_card_number">Credit card number <span>*</span></strong>
                        </label>
                        <div class="input-box">
                            <input type="text" name = "field[card_number]" id = "card_number" value="{$form_data.card_number}" class="input-text validate-require validate-digits" />
                        </div>
                    </li>
                    <li class="wide">
                        <label>
                            <strong id="notify_expiration_date">Expiration date <span>*</span></strong>
                        </label>
                        <div class="input-box">
                            <div style="width:30%;float:left">
                                <select name="field[expiration_month]" id="expiration_month"  class="input-select validate-require">
                                    {html_options options = $options_month selected = $form_data.expiration_month}
                                </select>
                            </div>
                            <div style="width:20%;float:left">    
                                <select name="field[expiration_year]" id="expiration_year"  class="input-select validate-require">
                                    {html_options options = $options_year selected = $form_data.expiration_year}
                                </select>
                            </div>
                            <br clear="all"/>
                        </div>
                    </li>
                </ul>
                <div class="buttons-set">
                	<script type="text/javascript">
					{literal}
					function expirationDate() {
						var month = jQuery('#expiration_month').val();
						var year = jQuery('#expiration_year').val();
						if ((month*year) == 0){
							jQuery('#notify_expiration_date').css({"color":"#ff0000"});
							return false;
						}
						jQuery('#notify_expiration_date').css({"color":""});
						return true;
					}
					cc.callback_func.push(function() {return expirationDate();});
					{/literal}
					</script>
                    <a href="?module=agent&action=view-creditcard">back</a>
                    <button class="btn-red btn-red-no-cre" onclick="cc.submit()">
                        <span><span>Save</span></span>
                    </button>
                </div>            
            {/if}
            	<input type="hidden" name="is_submit" id="is_submit" value="0"/>
             </form>
        </div>
        <div class="col-2">
        </div>
        <div class="clearthis">
        </div>
    </div>
</div>