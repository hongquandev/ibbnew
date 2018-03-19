{if $action == 'list-article'}
    <script type="text/javascript" src="../modules/press/templates/js/article.paging.js"></script>
    <script type="text/javascript">
        session.action_type = 'article';
    </script>
{else}
    <script type="text/javascript" src="../modules/press/templates/js/cat.paging.js"></script>
    <script type="text/javascript">
        session.action_type = 'cat';
    </script>
{/if}
{if $Admin.Level == 1}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
        <tr>
            <td><div id="topic-grid"></div></td>
        </tr>
    </table>
	<div id="blankDiv" style="position: absolute; left: 0pt; top: 0pt; visibility: hidden;"></div>
{else}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td >You do not have permission to view this module.</td>
      </tr>
    </table>
{/if}