<div class="ma-info mb-20px">
    <div class="col2-set mb-20px">
        <div class="col">
            <div class="col-main myaccount">
                <h2>Your Package Current</h2>
                <table class="tbl-package" cellpadding="0" cellspacing="0" style="width:100%">
                   {foreach from=$package_current key=k item=value}
                   <tr>
                       <td class="main-col">{$k}</td>
                       <td>{$value}</td>
                   </tr>
                   {/foreach}
                </table>

               {if $authentic.parent_id == 0}
                    <div class="popup_container_eadd normal-width">
                            <div class="title">
                                <h2 style="float:left">Payment </h2>
                            </div>

                            <div class="content normal-width">
                                <form name="frmPayment" id="frmPayment" method="post" action="{$form_action}">
                                    <div class="message-box message-box-v-ie" id="message" style="display:none"></div>
                                    <ul class="form-list">
                                        {$package_tpl}
                                        <li class="wide">
                                            <label><strong>Payment for<span>*</span></strong></label>
                                            <div class="input-box">
                                                {foreach from=$package_time key=k item=time}
                                                    <input type="radio" name="time[]" value="{$k}" {if $k==1}checked{/if}><label class="rlabel">{$time}</label>
                                                {/foreach}
                                            </div>
                                        </li>
                                    </ul>
                                </form>

                                <div class="buttons-set">
                                    <button type="button" id="submit" class="btn-red step-eight-btn-red3">
                                        <span><span>Confirm & Checkout</span></span>
                                    </button>
                                </div>
                            </div>
                    </div>
                {/if}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    {literal}
        jQuery(document).ready(function(){
            $('#submit').bind('click',function(){
                var i = 0;
                $.each($('input','#frmPayment'),function(){
                        if ($(this).is(':checked')){
                            i++;
                        }
                });
                if (i < 2){
                    $('#message','#frmPayment').show().html('Please select package!');
                }else{
                    $('#message','#frmPayment').hide();
                    jQuery('#frmPayment').submit();
                }
            })
        });
    {/literal}
</script>
