<html>
<head>
	<title>Media Management</title>
    <link rel="stylesheet" type="text/css" href="/modules/general/templates/style/admin.css" />
    <link rel="stylesheet" type="text/css" href="/modules/general/templates/style/anylink.css" /></head>
    <link rel="stylesheet" type="text/css" href="resources/css/ext-all.css" />
    <link rel="stylesheet" type="text/css" href="/modules/general/templates/style/jquery-ui.css" />
    
    <script type="text/javascript" src="js/wow.js"></script>
    <script type="text/javascript" src="js/anylink.js"></script>
    <script type="text/javascript" src="js/utility.js"></script>
    <script type="text/javascript" src="js/popup.js"></script>
    <script type="text/javascript" src="ajax/js/Ajax.js"></script>
    <script type="text/javascript" src="ajax/js/Post.js"></script>
    <script type="text/javascript" src="/modules/general/templates/js/helper.js"></script>
    <script type="text/javascript" src="/modules/general/templates/js/common.js" ></script>
    <script type="text/javascript" src="/modules/general/templates/js/admin.js"></script>
    <script type="text/javascript" src="/modules/general/templates/js/jquery.min.js"></script>
    <script type="text/javascript" src="/modules/general/templates/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/modules/general/templates/js/validate.js"></script>
    
    
    <link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css" />
    <link href="/modules/property/templates/style/ajax-upload.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
    
    <link href="/modules/media/templates/style/media.css" rel="stylesheet" type="text/css"/>
    <script src="/modules/media/templates/js/media.js"></script>
    <script src="/modules/media/templates/js/upload.js"></script>
</head>
<body>
<table width="100%" class="media_container">
    <tr style="height:20px">
        <td class="media_title"><h2>Media Management</h2></td>
    </tr>
    <tr>
        <td valign="top" >
            <div style="width:100%;height:30px;" class="media_tool">
                <div id="btn_photo" style="float:left"></div>
                <ul id="lst_media" style="float:left;margin-left:10px" class="qq-upload-list" style="height:30px"></ul>
                <script type="text/javascript">
                    var photo = new Media();
                    photo.uploader('btn_photo','lst_media','/modules/media/action.php?action=upload-media&target=media_list');
                </script>
                <div style="float:right">
                	<input type="button" name="btn_insert" id="btn_insert" value="Insert" onclick="insertButton()"/>
                    <input type="hidden" name="media_id" id="media_id" value="0"/>
                </div>
            </div>
            <div style="width:100%;" id="media_list" class="media_list">
            </div>	
        </td>
    </tr>
</table>
</body>
</html>
{literal}
<script type="text/javascript">
var mm = new MediaManagement();
mm.getList('/modules/media/action.php?action=list-media');

function imgSelect(obj) {
	jQuery('#item_'+jQuery('#media_id').val()).removeClass('media_item_select');
	
	var id = jQuery(obj).attr('id').replace('img_','');
	jQuery('#media_id').val(id);
	jQuery('#item_'+id).addClass('media_item_select');
}

function insertButton() {
	//alert(opener.document.getElementById('textareas').value);
	//alert(jQuery('#img_'+jQuery('#media_id').val()).attr('src'));
	var str = "<img src='"+jQuery('#img_'+jQuery('#media_id').val()).attr('src')+"'/>";
	//opener.document.getElementById('textareas').value+=str;
	//
	//alert(parent.document.tinyMCE);
	//opener.document.getElementById('textareas').innerHTML = 'dd';
	//tinyMCE.setContent(document.getElementById('htmlSource').value);
	opener.self.tinyMCE.setContent(opener.self.tinyMCE.getContent()+str);
	/*
	
	var myField = opener.self.tinyMCE.get("SMSBody");
	   
		//IE support
	   if (opener.document.selection) {
	   
			 myField.focus();
			 sel = opener.document.selection.createRange();
			 sel.text = 'aa';
		}
	
	else if (document.getSelection) {
		   
			 opener.self.tinyMCE.activeEditor.selection.setContent('aa');
			 myField.focus();
		}
	*/
}
</script>
{/literal}
