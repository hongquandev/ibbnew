{*
<script src="/modules/calendar/templates/js/calendar.popup.js" type="text/javascript"></script>
*}
{if $action == "view-tv-show" }
    <div class="popup_container popup_container_tv_show" id="note_time_{$note_time_id}" style="display:none;">
        <div id="contact-wrapper" class="mycalen"  style="padding-bottom:0px;">
           {* <div class="title"><h2>INSPECTION DATE & TIMES <span onclick="hideNoteTimePopup('note_time_{$note_time_id}')">x</span></h2> </div>*}
           <div class="title"><h2>INSPECTION DATE & TIMES <span onclick="hideNoteTimePopup('note_time_{$note_time_id}')" class="btn-x" id="fridx" style="color:#ffffff">Close X</span></h2> </div>
            <div class="ma-messages" id="fridmess">
            <table class="tbl-messages" cellpadding="0" cellspacing="0">
                <colgroup>
                    <col width="10px"/><col width="120px"/><col width="120px"/><col width="60px"/>
                </colgroup>
                <thead>
                    <tr>
                        <td>No</td>
                        <td>From</td>
                        <td>To</td>
                        <td>Tool</td>
                    </tr>
                </thead>
                <tbody id="grid_note_time"></tbody>
                    {$calendar_items}
                </tbody>
            </table>
            </div>
        </div>
    </div>
{elseif in_array($action, array('view-auction-detail','view-sale-detail','view-forthcoming-detail','view-passedin-detail','view-detail'))}
    
    <div class="popup_container" id="note_time_{$note_time_id}" style="display:none;width: 200px;">
        <!--<div id="contact-wrapper" class="myaccount mycalen"  style="padding-bottom:0px;">-->
        <div id="contact-wrapper" class="mycalen"  style="padding-bottom:0px;">
           <div class="title"><h2 style="font-size: 12px;text-align:left">INSPECTION DATE & TIMES <span class="btn-x" onclick="hideNoteTimePopup('note_time_{$note_time_id}')"  id="fridx" style="color:#ffffff">Close X</span></h2> </div>
            <div class="ma-messages" id="fridmess">
            <table class="tbl-messages" cellpadding="0" cellspacing="0">
                <colgroup>
                    <col width="10px"/><col width="120px"/><col width="120px"/><col width="60px"/>
                </colgroup>
                <thead>
                    <tr>
                        <td>No</td>
                        <td>From</td>
                        <td>To</td>
                        <td>Tool</td>
                    </tr>
                </thead>
                <tbody id="grid_note_time"></tbody>
                    {$calendar_items}
                </tbody>
            </table>
            </div>
        </div>
    </div>
    {elseif true}
        <div class="note_time_popup_overlay2 popup_container popup_container2 popup_container_ie" id="note_time_{$note_time_id}" style="display:none;bottom: 5px;;position: absolute !important;">
            <!--<div id="contact-wrapper" class="myaccount mycalen"  style="padding-bottom:0px;">-->
            <div id="contact-wrapper" class="mycalen"  style="padding-bottom:0px;">
               {* <div class="title"><h2>INSPECTION DATE & TIMES <span onclick="hideNoteTimePopup('note_time_{$note_time_id}')">x</span></h2> </div>*}
               <div class="title"><h2>INSPECTION DATE & TIMES <span onclick="hideNoteTimePopup('note_time_{$note_time_id}')"  class="btn-x" id="fridx" style="color:#ffffff">Close X</span></h2> </div>
                <div class="ma-messages" id="fridmess">
                <table class="tbl-messages" cellpadding="0" cellspacing="0">
                    <colgroup>
                        <col width="10px"/><col width="120px"/><col width="120px"/><col width="60px"/>
                    </colgroup>
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>From</td>
                            <td>To</td>
                            <td>Tool</td>
                        </tr>
                    </thead>
                    <tbody id="grid_note_time"></tbody>
                        {$calendar_items}
                    </tbody>
                </table>
                </div>
            </div>
        </div>
{/if}
{literal}
<script type="text/javascript">
    jQuery(document).ready(function(){
        var document_width = jQuery(document).width();
        var width = jQuery.browser.mobile?(document_width - 30+'px'):'300px';
        jQuery('#note_time_{/literal}{$note_time_id}{literal}').css('width',width);
    });
</script>
{/literal}
