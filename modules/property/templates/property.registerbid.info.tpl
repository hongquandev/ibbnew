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

}
    </style>
{/literal}
{if isset($data_agent) and count($data_agent) > 0}
    <div class="content-bid winner-info-content" id="winner-info-{$property_id}" style="margin-bottom: 15px; padding-right: 40px; padding-left: 40px; background-color: rgb(247, 247, 247);height: auto" >
        <div style="">
            <div class="winner-info" style="">
                <strong>Name:</strong>
                <span class="value">{$data_agent.name} </span>
                <input type="hidden" id="winner-name" value="{$data_agent.name}">
            </div>
            <div class="winner-info" style="">
                <strong>Email:</strong>
                <span class="value">{$data_agent.email_address}</span>
                <input type="hidden" id="winner-email" value="{$data_agent.email_address}">
            </div>
            <div class="winner-info" style="">
                <!--<div style="font-weight: bold;float: left; width: 55px;">Address:</div>
                <div class="value" style="padding-left: 22px;">{$data_agent.address}</div>-->
                <strong>Address:</strong>
                <span>{$data_agent.address}</span>
            </div>

        </div>
        <div style="">
            {if $data_agent.type_id != 3}
                <div class="winner-info" style="">
                    <strong>Telephone:</strong>
                    <span>{$data_agent.telephone}</span>
                </div>
            {/if}
            {if $data_agent.type_id != 3}
                <div class="winner-info" style="">
                    <strong>MobilePhone:</strong>
                    <span>{$data_agent.mobilephone}</span>
                </div>
            {else}
                <div class="winner-info" style="">
                    <strong>Contact Phone Number:</strong>
                    <span>{$data_agent.telephone}</span>
                </div>
            {/if}
            {if $data_agent.type_id != 3}
                <div class="winner-info">
                    <strong>Drivers Register Number:</strong>
                    <span>{$data_agent.license_number}</span>
                </div>
            {else}
                <div class="winner-info">
                    <strong>ABN/ACN:</strong>
                    <span>{$data_agent.license_number}</span>
                </div>
            {/if}
        </div>
        <div class="clearthis"></div>
        <div class="" style="text-align: right;">
            {*<span id="winner-loading" style="position:absolute;display:none;margin-top:5px">
                    <img src="/modules/general/templates/images/loading.gif" style="height:30px;" alt="" />
                 </span>*}
            <button style="margin-right:0!important;width:70px;" class="btn-red btn-red-search" onclick="cleanRegisterAgent('#register-bid-agent')">
                <span><span>Close</span></span>
            </button>
        </div>

    </div>
{else}
    <div class="content-bid winner-info-content">
        <div class="message-winner" style="" >
            <b>
                There aren't Agent Information
            </b>
        </div>
    </div>
{/if}
<script type="text/javascript">
    Cufon.replace('h2');
</script>


{literal}
    <script type="text/javascript">
        function cleanRegisterAgent(id){
            jQuery(id).html('');
        }
    </script>
{/literal}