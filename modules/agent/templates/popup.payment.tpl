{literal}
<style type="text/css">
    /*table.tpackage{
        behavior: url(PIE.htc);
        font-family: "Trebuchet MS", sans-serif;
        font-size: 12px;
        font-weight: bold;
        line-height: 1em;
        font-style: normal;
        border-collapse:separate;
    }
    table.tpackage .price{
        font-size: 30px;
        font-weight: bold;
        line-height: 33px;
        color: black
    }
    .tpackage thead th,.tpackage tbody th{
        padding:10px;
        color:#fff;
        -webkit-border-top-left-radius:5px;
        -webkit-border-top-right-radius:5px;
        -moz-border-radius:5px 5px 0px 0px;
        border-top-left-radius:5px;
        border-top-right-radius:5px;
        *//*text-shadow:1px 1px 1px #3EC0DF;
        border:1px solid #3EC0DF;
        border-bottom:3px solid #3EC0DF;
        background-color:#3EC0DF;*//*
        *//*----------------*//*
        *//*text-shadow: 1px 1px 1px #AA2F0A;
        border: 1px solid #D3340C;
        border-bottom: 3px solid #AA2F0A;
        background-color: #D3340C;
        background: -moz-linear-gradient(top, #ed370e 1%, #d83f0d 48%, #d3340c 50%, #d3340c 100%); *//**//* FF3.6+ *//**//*
        background: -webkit-gradient(linear, left top, left bottom, color-stop(1%,#ed370e), color-stop(48%,#d83f0d), color-stop(50%,#d3340c), color-stop(100%,#d3340c)); *//**//* Chrome,Safari4+ *//**//*
        background: -webkit-linear-gradient(top, #ed370e 1%,#d83f0d 48%,#d3340c 50%,#d3340c 100%); *//**//* Chrome10+,Safari5.1+ *//**//*
        background: -o-linear-gradient(top, #ed370e 1%,#d83f0d 48%,#d3340c 50%,#d3340c 100%); *//**//* Opera 11.10+ *//**//*
        background: -ms-linear-gradient(top, #ed370e 1%,#d83f0d 48%,#d3340c 50%,#d3340c 100%); *//**//* IE10+ *//*
        text-shadow: 1px 1px 1px #D07300;
        border: 1px solid #D07300;
        border-bottom: 3px solid #D07300;
        background: #ffa330; *//* Old browsers *//*
        background: -moz-linear-gradient(top, #ffa330 0%, #ffa330 31%, #ff940e 55%, #f4890e 100%); *//* FF3.6+ *//*
        *//*background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffa330), color-stop(31%,#ffa330), color-stop(55%,#ff940e), color-stop(100%,#f4890e)); *//**//* Chrome,Safari4+ *//*
        background: -webkit-linear-gradient(top, #ffa330 0%,#ffa330 31%,#ff940e 55%,#f4890e 100%); *//* Chrome10+,Safari5.1+ *//*
        *//*background: -o-linear-gradient(top, #ffa330 0%,#ffa330 31%,#ff940e 55%,#f4890e 100%); *//**//* Opera 11.10+ *//**//*
        background: -ms-linear-gradient(top, #ffa330 0%,#ffa330 31%,#ff940e 55%,#f4890e 100%); *//**//* IE10+ *//*
        *//*background:-webkit-gradient(
            linear,
            left bottom,
            left top,
            color-stop(0.87, #3492C8)
            color-stop(0.51, #35ABDA),
            color-stop(0.02, #3EC0DF),
            );
        background: -moz-linear-gradient(
            center bottom,
            #3492C8 87%
            #35ABDA 51%,
            #3EC0DF 2%,
            );*//*
    }
    *//*.tpackage thead th,.tpackage tbody th{
        padding:10px;
        color:#fff;
        text-shadow:1px 1px 1px #568F23;
        border:1px solid #93CE37;
        border-bottom:3px solid #9ED929;
        background-color:#9DD929;
        background:-webkit-gradient(
            linear,
            left bottom,
            left top,
            color-stop(0.02, rgb(123,192,67)),
            color-stop(0.51, rgb(139,198,66)),
            color-stop(0.87, rgb(158,217,41))
            );
        background: -moz-linear-gradient(
            center bottom,
            rgb(123,192,67) 2%,
            rgb(139,198,66) 51%,
            rgb(158,217,41) 87%
            );
        -webkit-border-top-left-radius:5px;
        -webkit-border-top-right-radius:5px;
        -moz-border-radius:5px 5px 0px 0px;
        border-top-left-radius:5px;
        border-top-right-radius:5px;
    }*//*
    .tpackage thead th:empty,.tpackage thead th.empty{
        background:transparent;
        background-color: white;
        border:none;
    }
    .tpackage tbody td{
        padding:10px;
        text-align:center;
        background-color:#F6F6F6;
        -moz-border-radius:2px;
        -webkit-border-radius:2px;
        border-radius:2px;
        color:#666;
        text-shadow:1px 1px 1px #fff;
    }
    span.msg{
        display:inline-block;
        font-family: "Trebuchet MS", sans-serif;
        font-size: 12px;
        margin-bottom:10px;
    }
    .content-po .buttons-set{
        padding: 0;
    }
    .content-po .buttons-set span.msg{
        margin-bottom: 0;
    }*/
</style>
{/literal}
<div style="display:block;{if $authentic.parent_id == 0}*max-width: 863px;{else}*width:426px;{/if}">
<div class="title">
    <h2 id="nh_txt">bidRhino say:<span id="btnclosex" class="btnclosex-popup-newsletter" onclick="remind_payment.closePopup()">x</span></h2>
</div>

<div class="content normal-width {if $authentic.parent_id != 0}content-po{/if}" style="padding:15px;zoom:1;width:auto">
    <form name="frmPayment" id="frmPayment" method="post" action="{$form_action}">
    {if $authentic.parent_id == 0}
                     <span class="msg">Your account has expired. Please payment to continue.</span>
                     <div class="message-box message-box-v-ie" id="message" style="display:none"></div>
                    {$package_tpl}
                    {*<ul class="form-list">
                        <li class="wide">
                            <label><strong>Payment for<span>*</span></strong></label>
                            <div class="input-box">
                                {foreach from=$package_time key=k item=time}
                                    <input type="radio" name="time[]" value="{$k}" {if $k==1}checked{/if}><label
                                        class="rlabel">{$time}</label>
                                {/foreach}
                            </div>
                        </li>
                    </ul>*}
                    <table class="tpackage" style="width:100%;*width:820px;padding-top:15px">
                        <tr>
                            <th colspan="3"><span style="font-size:20px">Payment for</span></th>
                        </tr>
                        <tr>
                            {foreach from=$package_time key=k item=time}
                            <td>
                                <input type="radio" name="time[]" value="{$k}" {if $k==1}checked{/if}><label
                                        class="rlabel">{$time}</label>
                            </td>
                            {/foreach}
                        </tr>    
                    </table>
                
                <div class="buttons-set">
                    <div class="input-box">
                        <input type="checkbox" name="rlater" id="rlater" value="0">
                        <span class="msg" style="margin-bottom:0">Remind me later.</span>
                    </div>
                    <button type="button" class="btn-red step-eight-btn-red3" onclick="remind_payment.closePopup()">
                        <span><span>Close</span></span>
                    </button>
                    <button type="button" class="btn-red step-eight-btn-red3" onclick="remind_payment.payment()">
                        <span><span>Confirm & Checkout</span></span>
                    </button>
                </div>
                <div class="clearthis"></div>

    {else}
        <div class="content content-po" id="msg" style="display:block;width:387px;margin-left: 0px;margin-top: 0px;">
            <img src="/modules/property/templates/images/alert.png"/>
            <span>Your account has expired. Please contact your main account to payment to continue.</span>
        </div>
        <div class="buttons-set">
            <div class="input-box">
                <input type="checkbox" name="rlater" id="rlater" value="0">
                <span class="msg">Remind me later.</span>
            </div>
            <button type="button" class="btn-red step-eight-btn-red3" onclick="remind_payment.closePopup()">
                <span><span>Close</span></span>
            </button>
        </div>
        <div class="clearthis"></div>
    {/if}
    </form>
</div>
</div>