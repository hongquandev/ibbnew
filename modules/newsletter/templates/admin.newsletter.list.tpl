<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script>
<script type="text/javascript" src="../modules/newsletter/js/paging.js"></script>
<script type="text/javascript" src="js/Ext.ux.plugin.PagingToolbarResizer.js"></script>
<script type="text/javascript" src="js/Ext.ux.grid.Search.js"></script>
<script type="text/javascript" src="../modules/general/templates/js/validate.js"></script>
<script type="text/javascript" src="../modules/general/templates/js/common.js"></script>
 {literal}
<script type="text/javascript">
        function on_submit(){
           var valid = new Validation('#frmLetter');
           if (valid.isValid()){
                hideCurrentPopup();
                var url = session.action_link.replace('[1]','action=edit-letter');
                     showWaitBox();
                     $.post(url,{ID:$('#ID').val(),EmailAddress:$('#EmailAddress').val()},function(data){
                          hideWaitBox();
			              store.reload();
                });
           }
        }
       {/literal}
    var session = new Object();
    session.action_link = '../modules/newsletter/action.admin.php?[1]&token={$token}';
	session.grid_title = 'Subscribers List';
    session.action_type = 'letter';
</script>

<table width="778" align="center" border="0" cellspacing="1" cellpadding="3">
	{if $message}
    <tr>
        <td><div id="msgID" class="message-box">{$message}</div></td>
    </tr>
    {/if}
    <tr>
        <td>
            <div id="vu-grid"></div>
            <div onClick="event.cancelBubble = true;" class="popupSmall" id="nameFieldPopup" style="display:none;">
                <form id="frmLetter" onsubmit="return false;">
                    <input type="hidden" id="ID" value="" />
                    <table width="350px" border="0" cellspacing="1" cellpadding="3">
                        <tr>
                            <td style=" padding:15px;">Email</td> 
                            <td ><input class="validate-require validate-email" id="EmailAddress" style="width:320px" /></td>
                        </tr> 
                        <tr>
                            <td> </td>
                            <td>
                                <button class="button" onclick="on_submit()">Submit</button>
                                <button class="button" onclick="hideCurrentPopup()">Close</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </td>
    </tr>
</table>