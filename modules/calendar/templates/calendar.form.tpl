<!--for admin, don't remove -->
{* <script type="text/javascript" src="../modules/general/templates/js/cufon/cufon-yui.js"></script>
 <script type="text/javascript" src="../modules/general/templates/js/cufon/Neutra_Text_500-Neutra_Text_700.font.js"></script>
 <script type="text/javascript" src="../modules/general/templates/js/cufon/gos-api.js"></script>
 <script type="text/javascript" src="../modules/general/templates/js/gos_api.js"></script>*}
{literal}
<script  type="text/javascript">

                         calbegin = new Calendar({
                            inputField : 'begin',
                            trigger    : 'begin',
                            onSelect   : function() { this.hide() },
                            showTime   : true,
                            dateFormat : "%Y-%m-%d %H:%M:%S"
                         });

                         calend = new Calendar ({
                            inputField : 'end',
                            trigger    : 'end',
                            onSelect   : function() { this.hide() },
                            showTime   : true,
                            dateFormat : "%Y-%m-%d %H:%M:%S"
                         });
                         function validDate(){
                            if ($('#begin').val() > $('#end').val()){
                                Common.warningObject('#begin');
                                Common.warningObject('#end');
                                return false;
                            }
                            return true;
                        }
                        note_time.flushCallback();
                        note_time.addCallbackFnc(function(){return validDate();});
                        Cufon.replace('#calendar_cufon');
 {/literal}
</script>
<div id="note_time_container_form" class="" style="width:300px;/*display:none*/">
    <div id="contact-wrapper" class="myaccount"  style="padding-bottom:0px">
         <div class="title">
             <h2>
                Popup Calendar
                <span class="h2-ie7 btn-x" onclick="closeNoteTimeForm()">Close X</span>
             </h2> 
         </div>
         <div class="content" style="width:94%">
            <form name="frmNoteTime" id="frmNoteTime">
                <input type="hidden" name="property_id" id="property_id" value="{$property_id}"/>
                <input type="hidden" name="calendar_id" id="calendar_id" value=""/>
                <div class="input-box" style="height: 40px;">
                    <div style="float:left;width:135px">
                        <label><strong>Date from:</strong></label>
                        <br/>
                        <input type="text" name="begin" id="begin" value="" style="width:90%" class="input-text validate-datetime">
                    </div>
                    <div style="float:right;width:135px">
	                    <label><strong>Date to:</strong></label>
                        <br/>
                        <input type="text" name="end" id="end" value="" style="width:90%" class="input-text validate-datetime"/>
                    </div>
                </div>
            </form>
             <div>
                 <div class="notification" style="margin-top: 5px;margin-bottom: 5px;margin-left: 5px;">
                    <label>
                        {assign var='ch' value=''}
                        {if $notify.inspect_time == 1}
                            {assign var='ch' value='checked'}
                        {/if}
                        <input type="checkbox" onclick="Notify_InspectTime(this,'#loading1');" id="notify_inspect_time" name="notify_inspect_time" value="1" {$ch}/>
                        Notification
                    </label>
                 </div>
                 <div class="clearthis"></div>
                 <!--
                 <button class="btn-red btn-calendar3" name="submit" onClick="note_time.send('#frmNoteTime','/modules/calendar/action.php?action=save-calendar',note_time_data)">
                    <span><span>Submit</span></span>
                 </button>
                 -->
                 <button class="btn-blue" name="submit" onClick="note_time.send('#frmNoteTime','/modules/calendar/action.php?action=save-calendar',note_time_data)">
                    <span><span>Submit</span></span>
                 </button>
                 
                 <div id="loading1" style="display:inline;">
                    <img src="/modules/general/templates/images/loading.gif" style="height:30px;" alt=""/>
                 </div>
                 
            </div>
        </div>

        <div class="ma-messages">
			<table class="tbl-messages" cellpadding="0" cellspacing="0">
                <colgroup>
                    <col width="10px"/><col width="110px"/><col width="110px"/><col width="80px"/>
                </colgroup>
                <thead>
                    <tr>
                        <td>No</td>
                        <td>From</td>
                        <td>To</td>
                        <td>Tool</td>
                    </tr>
                </thead>
                <tbody id="grid_note_time">
                </tbody>
            </table>        
        </div>
    </div>

</div>
<script  type="text/javascript">
 {literal}

 {/literal}
</script>
   <!--for Frontend-->
{literal}
<script type="text/javascript">
    function Notify_InspectTime(obj,loading) {
        jQuery(loading).show();openNoteTimeForm
        var value = jQuery(obj).attr('checked') ? 1: 0;
       /* var dataString = '&'+jQuery(obj).attr('name')+'='+value +'&property_id='+ jQuery('#property_id').val();
        jQuery.ajax({
            type: "POST",
            url: 'modules/calendar/action.php?action=notify-time',
            datatype: "json",
            cache: false,
            success: function(msg) {
                var obj = jQuery.parseJSON(msg);
                jQuery(loading).hide();
               *//* if (id_div != ''){
                    $(id_div).show();
                }*//*
            }
        });*/
        data_ = new Object();
        data_.notify_inspect_time = value;
        data_.property_id = jQuery('#property_id').val();
        jQuery.post('/modules/calendar/action.php?action=notify-time',data_,OninspectTime,'html');
    }
    function OninspectTime(data)
    {
        var obj = jQuery.parseJSON(data);
        jQuery('#loading1').hide();

    }
</script>
{/literal}


