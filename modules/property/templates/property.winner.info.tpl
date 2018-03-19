{literal}
    <style type="text/css">
        .winner-info-content {
            border: 1px solid #980000;
            padding: 20px;
        }
        .winner-info-content .winner-info
        {
            margin-bottom:  15px !important;
            font-size: 13px;
        }
        .winner-info-content .winner-info .value
        {
            display: inline;
            /*margin-left: 60px;*/
            font-weight: normal;
        }


        .winner-info-content .mess-content {

        }
        .winner-table tr{line-height:20px}

}
    </style>
{/literal}
{if isset($data_agent) and count($data_agent) > 0}
    <div class="winner-info-content" id="winner-info-{$property_id}" >
        {if $data_agent.title == 'partner'}
            <table class="winner-table">
                <tr>
                    <td width="23%"><strong>Company</strong></td>
                    <td>{$data_agent.name}</td>
                </tr>
                <tr>
                    <td width="23%"><strong>Webiste</strong></td>
                    <td>{$data_agent.webiste_partner}</td>
                </tr>
                <tr>
                    <td width="23%"><strong>Email</strong></td>
                    <td>{$data_agent.general_contact_partner}</td>
                </tr>
                <tr>
                    <td width="23%"><strong>Telephone</strong></td>
                    <td>{$data_agent.telephone}</td>
                </tr>
                <tr>
                    <td width="23%"><strong>Address</strong></td>
                    <td>{$data_agent.address}</td>
                </tr>
                <tr>
                    <td width="23%"><strong>Postal Address</strong></td>
                    <td>{$data_agent.postal_address}</td>
                </tr>
                <tr>
                    <td><strong>Message</strong></td>
                </tr>
                <tr>
                    <td colspan="2">
                       <textarea id="winner-content" name="content" class="" style="width:100%;height:100px;display: block;"></textarea>
                    </td>
                </tr>
            </table>
        {else}
            <div class="winner-info" style="">
            <b>Name:
                <div class="value">{$data_agent.name} </div>
            </b>
            {*<input type="hidden" id="winner-name" value="{$data_agent.name}">*}
        </div>
        <div class="winner-info" style="">
            <b>Email:
                <div class="value">{$data_agent.email_address}</div>
            </b>
            {*<input type="hidden" id="winner-email" value="{$data_agent.email_address}">*}
        </div>
        <div class="winner-info" style="">
            <b>Telephone:
               <div class="value">{$data_agent.telephone}</div>
            </b>
        </div>
        <div class="winner-info" style="">
            <b>MobilePhone:
                <div class="value">{$data_agent.mobilephone}</div>
            </b>
        </div>
        <div class="winner-info" style="">
            <b>Address:
                <div class="value">{$data_agent.address}</div>
            </b>
        </div>
        <div class="winner-info">
            <b>Drivers License Number:
                <div class="value">{$data_agent.license_number}</div>
            </b>
        </div>
        <div class="mess-content">
            <div>
                <b>Message: </b>
            </div>
            <textarea id="winner-content" name="content" class="" style="width:100%;height:100px;display: block;"></textarea>
        </div>
        {/if}
        <div class="winner-info" id="winner-mess-success" style="display: none;border: 1px solid #980000; ">
            <b> The your mail had been sent successful.
            </b>
        </div>

        <div class="winner-info" id="winner-mess-fail" style="display: none;border: 1px solid #980000;">
            <b>The your mail hadn't been sent successful.
            </b>
        </div>
        <div style="height: 15px"></div>
        <div class="" style="text-align: right;">
            <input type="hidden" id="winner-name" value="{$data_agent.name}">
            <input type="hidden" id="winner-email" value="{$data_agent.email_address}">
            <span id="winner-loading" style="position:absolute;display:none;margin-top:5px">
                    <img src="/modules/general/templates/images/loading.gif" style="height:30px;" alt="" />
                 </span>
            <button style="margin-right:0px !important;width:70px;" class="btn-wht btn-make-an-ofer " onclick="pro.sendMail('{$property_id}')">
                <span><span>Contact</span></span>
            </button>
        </div>


    </div>
{else}
    <div class="winner-info-content">
        <div class="message-winner" style="border: 1px dashed #980000;width: 400px;" >
            <b>
                There aren't Winner Information, Because This property had been sold by confirm sold function.
            </b>
        </div>
    </div>
{/if}
<script type="text/javascript">
    Cufon.replace('h2');
</script>


