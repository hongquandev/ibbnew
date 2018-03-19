<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script>
<script type="text/javascript" src="js/ux-all.js"></script>
{*<script type="text/javascript" charset="utf-8" src="http://cdn.sencha.io/ext-4.0.7-gpl/ext-all.js"></script>*}
<script type="text/javascript" src="js/SuperBoxSelect.js"></script>
<script type="text/javascript" src="js/FileUploadField.js"></script>
<script type="text/javascript" src="js/colorpicker.js"></script>
<script type="text/javascript" src="js/colorpickerfield.js"></script>
<link rel="stylesheet" type="text/css" href="resources/css/fileuploadfield.css" />
<link rel="stylesheet" type="text/css" href="resources/css/superboxselect.css" />
<link rel="stylesheet" type="text/css" href="resources/css/data-view.css" />
<link rel="stylesheet" type="text/css" href="resources/css/colorpicker.css" />
<script type="text/javascript" src="../modules/theblock/templates/js/paging.en.js"></script>


<table align="center" border="0" cellspacing="1" cellpadding="3">
        <tr>
            <td><div id="topic-grid"></div></td>
        </tr>
</table>

<div style="width:100%">
    <script type="text/javascript">
        var session = new Object();
        session.action_link = '../modules/theblock/action.admin.php?[1]&token={$token}';
		session.url_link = '?[1]&token={$token}';
		session.add_link = '?module=theblock&action=add&token={$token}';
		session.action_type = 'background';
		session.token = '{$token}';
    </script>
</div>