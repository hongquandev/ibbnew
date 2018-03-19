<script src="modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"></script>
{literal}

<script type="text/javascript">
    var search_overlay = new Search();
    search_overlay._frm = '#frmAgent';
    search_overlay._text_search = '#personal_suburb';
    search_overlay._text_obj_1 = '#personal_state';
    search_overlay._text_obj_2 = '#personal_postcode';
    search_overlay._overlay_container = '#search_overlay';
    search_overlay._url_suff = '&' + 'type=suburb';

    search_overlay._success = function (data) {
        var info = jQuery.parseJSON(data);
        var content_str = "";
        var id = 0;
        if (info.length > 0) {
            search_overlay._total = info.length;
            search_overlay._current = -1;
            for (i = 0; i < info.length; i++) {
                var id = 'sitem_' + i;
                content_str += "<li onclick='search_overlay.setValue(this)' id=" + id + ">" + info[i] + "</li>";
                search_overlay._item.push(id);
            }
        }


        search_overlay._getValue = function (data) {
            var info = jQuery.parseJSON(data);
            jQuery(search_overlay._text_obj_1).val(info[0]);
            $('#uniform-personal_state span').html($(search_overlay._text_obj_1 + " option:selected").text());
        };


        if (content_str.length > 0) {
            jQuery(search_overlay._overlay_container).html(content_str);
            jQuery(search_overlay._overlay_container).show();
            jQuery(search_overlay._overlay_container).width(jQuery(search_overlay._text_search).width());
        } else {
            jQuery(search_overlay._overlay_container).hide();
        }
		jQuery(search_overlay._text_search).removeClass('search_loading');
    };

    document.onclick = function () {
        search_overlay.closeOverlay()
    };
    function moveKey(e) {
        if (window.event) {
            e = window.event;
        }
        switch (e.keyCode) {
            case 40:
                if (search_overlay._current < search_overlay._total) {
                    search_overlay._current = search_overlay._current + 1;
                }
                break;
            case 38:
                if (search_overlay._current > 0) {
                    search_overlay._current--;
                }
                break;
            case 13:
                search_overlay.setValue(search_overlay._name_id + search_overlay._current);
                break;
        }
    }

</script>
<script type="text/javascript" src="modules/agent/templates/js/partner.js"></script>
<script type="text/javascript" src="modules/agent/templates/js/checkimage.js"></script>
<script type="text/javascript">
    var partner = new Partner();
</script>
{/literal}
{if $authentic.type == 'partner'}
<div class="bar-title">
    <h2>MY EXTRA COMPANY DETAILS</h2>
</div>

<div class="ma-info mb-20px">

    <div class="col2-set mb-20px">
        <div class="col">
            {if isset($message) and strlen($message)>0}
                <div class="message-box message-box-ie">
                    {$message}
                </div>
            {/if}
                <ul class="tabs">
                     <li><a href="javascript:void(0)" rel="my-account" class="defaulttab">My Account</a></li>
                     <li><a href="javascript:void(0)" rel="regions">Location of Business</a></li>
                     <li><a href="javascript:void(0)" rel="partners">Partner References</a></li>
                </ul>
                <div id="my-account" class="tab-content">
                    <ul class="form-list form-company">
                        <form name="frmAgent" id="frmAgent" method="post" action="?module=agent&action=edit-company" enctype="multipart/form-data">
                            <li class="wide">
                                 <label><strong>Email <span id="notify_email_address">*</span></strong></label>
                                 <div class="input-box">
                                        <input type="text" name="field[email_address]" id="email_address" value="{$form_data.email_address}"
                                               class="input-text validate-require validate-email"
                                               onkeyup="Common.existEmail('/modules/{$module}/action.php?action=exist_email&agent_id={$form_data.agent_id}',this)"
                                               autocomplete="off"/>
                                 </div>
                            </li>

                            <li class="fields">
                                <div class="field">
                                    <label>
                                        <strong>Security question <span id="notify_security_question">*</span></strong>
                                    </label>

                                    <div class="input-box input-select">
                                        <select name="field[security_question]" id="security_question"
                                                class="input-select validate-number-gtzero">
                                            {html_options options = $options_question selected = $form_data.security_question}
                                        </select>
                                    </div>
                                </div>
                                <div class="field">
                                    <label id="notify_security_answer">
                                        <strong>Security Answer <span>*</span></strong>
                                    </label>

                                    <div class="input-box">
                                        <input type="text" name="field[security_answer]" id="security_answer" value="{$form_data.security_answer}"
                                               class="input-text validate-require"/>
                                    </div>
                                </div>
                                <div class="clearthis">
                                </div>
                            </li>


                            {*<li class="control">
                                <label>
                                    <input type="checkbox" name="contact_references" id="cr1" {if $row.contact_references == 1}checked="checked"{/if}/>
                                    <strong>Contact references </strong>
                                </label>

                                <label style="margin-left:15px;">
                                    <input type="checkbox" name="debit_card" id="cr2" {if $row.debit_card == 1}checked="checked"{/if}/>
                                    <strong>Debit card </strong>
                                </label>
                            </li>*}


                        </form>
                    </ul>

                    <div id="buttons-set-company" class="buttons-set buttons-set-a">
                        <button class="btn-red f-right btn-red-a" onclick="agent.submit('#frmAgent')">
                            <span><span>Save</span></span>
                        </button>
                        <div class="clearthis">
                        </div>
                    </div>
                </div>
            <div id="regions" class="tab-content">
               <form id="frmRegion" onsubmit="return false;" name="frmRegion">
                <ul id="form-company2" class="form-list form-company">
                    <li class="fields">
                        <div class="field2 field">
                            <label>
                                <strong>Suburb</strong>
                            </label>

                            <div class="input-box">
                                <input type="text" id="personal_suburb" name="suburb"
                                       class="input-text"
                                       onclick="search_overlay.getData(this)"
                                       onkeyup="search_overlay.moveByKey(event)" autocomplete="off"/>
                                <ul>
                                    <div id="search_overlay" class="search_overlay"
                                         style="display:none; position: absolute;"></div>
                                </ul>
                            </div>
                        </div>

                        <div class="field">
                                <label>
                                    <strong>Postcode</strong>
                                </label>

                                <div class="input-box">
                                    <input type="text" id="personal_postcode" name="postcode"
                                           class="input-text validate-number"
                                           autocomplete="off"/>
                                </div>
                        </div>
                    </li>
                    <li class="fields">
                        <div class="field2 field">
                            <label>
                                <strong id="notify_personal_state">State</strong>
                            </label>

                            <div class="input-box input-select">
                                <div id="inactive_personal_state">
                                    <select id="personal_state" name="state"
                                            class="input-select" >
                                    {html_options options = $options_state}
                                    </select>
                                </div>
                            <input type="text" id="personal_other_state" class="input-text" name="other_state"/>
                            </div>
                        </div>

                                <div class="field">
                                    <label>
                                        <strong>Country</strong>
                                    </label>

                                    <div class="input-box input-select">
                                        <select id="personal_country" class="input-select" name="country">
                                            {html_options options = $options_country selected = $country_default}
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="ID">
                                <div class="clearthis">
                                </div>
                            </li>

                </ul>
                </form>
                <div id="buttons-set-company2" class="buttons-set buttons-set-a">
                    <button class="btn-red f-right btn-red-a" onclick="agent.addRegion('#frmRegion','addRegion')">
                        <span><span>Add</span></span>
                    </button>
                    <div class="clearthis">
                    </div>
                </div>
                 <!-- Show Information My regions-->
                <div class="popup_container_eadd">
                    <div class="contact-wrapper">
                        <div class="title">
                            <h2 style="float:left">My Regions</h2>
                        </div>

                        <div class="content" style="width: 98%;">
                            <div id="region" class="myaccount ma-messages mb-20px">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="partners" class="tab-content">
                <form id="frmPartner" onsubmit="return false;">
                <ul id="form-company3" class="form-list">
                    <li class="fields">
                        <div class="field">
                            <label>
                                <strong>Company</strong>
                            </label>

                            <div class="input-box">
                                <input type="text" id="company" name="company_name"
                                       class="input-text validate-require"/>
                            </div>
                        </div>

                        <div class="field">
                            <label>
                                <strong>Address</strong>
                            </label>

                            <div class="input-box">
                                <input type="text" id="address" name="address"
                                       class="input-text"/>
                            </div>
                        </div>
                    </li>

                    <li class="fields">
                        <div class="field">
                            <label>
                                <strong>Telephone</strong>
                            </label>

                            <div class="input-box">
                                <input type="text"  id="telephone" name="telephone"
                                       class="input-text {*validate-number*}"/>
                            </div>
                        </div>

                        <div class="field">
                            <label>
                                <strong>Email</strong>
                            </label>

                            <div class="input-box">
                                <input type="text"  id="email" name="email_address"
                                       class="input-text validate-email"/>
                            </div>
                        </div>
                        <input type="hidden" name="ref_id">
                    </li>
                </ul>
                </form>
                <div id="buttons-set-company3" class="buttons-set buttons-set-a">
                            <button class="btn-red f-right btn-red-a" onclick="agent.addRegion('#frmPartner','addPartner')">
                                <span><span>Add</span></span>
                            </button>

                            <label class="f-right" style="margin-right:20px;margin-top: 5px;">
                                    <input style="vertical-align: middle;" type="checkbox" name="contact_references" id="contact_references" onclick="changeNotification(this,'#contact_references');"/>
                                    <strong>Contact references </strong>
                            </label>
                            <div class="loading" id="loading_1" style="float:right"></div>

                            <div class="clearthis">
                            </div>
                        </div>
                <!-- Show Information My partner-->
                <div class="popup_container_eadd">
                    <div class="contact-wrapper">
                        <div class="title">
                            <h2 style="float:left">My Partner References</h2>
                        </div>

                        <div class="content" style="width: 98%;">
                            <div id="reference" class="myaccount ma-messages mb-20px">

                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
     var country_default = '{$country_default}';
     {literal}
     $(document).ready(function() {
                $('.tabs a').click(function(){
                       switch_tabs($(this));
                });
                switch_tabs($('.defaulttab'));
                onLoad('personal');
                agent.prepareList('prepareRegion','#region');
                agent.prepareList('preparePartner','#reference');
                $('#personal_country').bind('change',function(){
                    onLoad('personal');
                });
                $('#personal_country').trigger('change');
                agent.loadRef();
     });

     function switch_tabs(obj) {
         var id = obj.attr("rel");
         $('.tab-content').hide();
         $('.tabs a').removeClass("selected");
         $('#' + id).show();
         obj.addClass("selected");
         $('.message-box').hide();
     }
     function changeNotification(obj,id_div) {
         jQuery('#loading_1').show();
         var value = jQuery(obj).attr('checked') ? 1 : 0;
         var dataString = '?' + jQuery(obj).attr('name') + '=' + value;
         jQuery.ajax({
             type: "GET",
             url: '/modules/agent/json/agent.notification.json.php' + dataString,
             datatype: "json",
             cache: false,
             success: function(msg) {
                 var obj = jQuery.parseJSON(msg);
                 jQuery('#loading_1').hide();
             }
         });
     }
     {/literal}
</script>
{else}
    {include file="agent.auction.company.tpl"}
{/if}