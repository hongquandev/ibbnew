<script type="text/javascript" src="../modules/package/templates/js/paging.en.js"></script>
{if $Admin.Level == 1}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
    	{if $message}
        <tr>
            <td><div id="msgID" class="message-box">{$message}</div></td>
        </tr>
        {/if}
        <tr>
            <td><div id="topic-grid"></div></td>
        </tr>
    </table>
	<div id="blankDiv" style="position: absolute; left: 0pt; top: 0pt; visibility: hidden;"></div>

    <script type="text/javascript">
		var session = new Object();
		session.action_link = '../modules/package/action.admin.php?[1]&token={$token}';
		session.url_link = '?[1]&token={$token}';
		session.add_link = '?module=package&action=edit-property_new&token={$token}';
		session.action_type = 'package';
		session.token = '{$token}';
		session.grid_title = 'Package List';
    </script>
{else}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td><div class="message-box">You do not have permission to view this module.</div></td>
      </tr>
    </table>
{/if}
