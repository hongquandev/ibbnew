<link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css" />
<link href="/modules/property/templates/style/ajax-upload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
<script type="text/javascript" src="/modules/property/templates/js/upload.js"></script>
<script type="text/javascript" src="/modules/property/templates/js/upload-common.js"></script>
<script src="/modules/property/templates/js/main.js" type= "text/javascript">  </script> 
<table width="100%" cellspacing="5" class="media">
	<tr>
    	<td>
			{if isset($document_rows) and is_array($document_rows) and count($document_rows)>0}
                {foreach from = $document_rows key = k item = row}
                    {assign var = script value = true}
                        {assign var = style value = ''}
                        {assign var = readonly value = ''}
                        {if $check == true and !in_array($row.document_id,$document_id_ar)}
                        	{assign var = script value = false}
                        	{assign var = style value = 'opacity: 0.5;filter: alpha(opacity = 50);'}
                            {assign var = readonly value = 'readonly="readonly"'}
                        {/if}
                    <li class="wide" style="{$style}" {$readonly}>
                        <label>
                            <strong>{$row.title}</strong>
                            <strong>
                                <a href="#" class="tooltip" style="color:#990000;font-weight:bold; margin-left:20px;text-decoration:none;" title="{$row.help}">
                                    <p style="margin-left:245px; margin-top:-16px;">
                                        <img src="../modules/general/templates/images/img_question.png" style="border:none; vertical-align:sub"/>
                                    </p>
                                </a>
                            </strong>
                        </label>
                     	<!--<a href="#" class="tooltip" style="color:#990000;font-weight:bold; margin-left:20px; text-decoration:none;" title="{$row.help}"> ? </a>-->
                            
                        <div class="input-box file-upload">
                            <div id="btn_{$row.document_id}" style="float:left"></div>
                            
                            <ul id="lst_{$row.document_id}" style="float:left;margin-left:10px" class="qq-upload-list">
                            
                            {if isset($property_document_rows[$row.document_id]) and count($property_document_rows[$row.document_id])>0 and $script}
                                <li class="qq-upload-success">
                                    <span class="qq-upload-file">{$property_document_rows[$row.document_id].file_name}</span>
                                    <a class="qq-upload-del" style="display: inline-block;color: #980000" href="javascript:void(0)" onclick="pro.downDoc('/modules/property/action.php?action=down-doc&property_id={$property_document_rows[$row.document_id].property_id}&document_id={$row.document_id}')">Download</a>
                                    <span class="split">|</span>
                                    <a class="qq-upload-del" style="display: inline-block;color: #980000" href="javascript:void(0)" onclick="deleteAction('/modules/property/action.admin.php?action=delete-doc&property_id={$property_id}&document_id={$row.document_id}&token={$token}','lst_{$row.document_id}','1')">Delete</a>
                                </li>                                    
                            {else}
                                {'No file chosen'}
                            {/if}
                            
                            </ul>
                            
                            <br clear="all"/>
                        </div>
                        {if $script}
                            <script type="text/javascript">
                                var doc_{$row.document_id} = new Doc();
                                doc_{$row.document_id}.uploader('btn_{$row.document_id}','lst_{$row.document_id}','/modules/property/action.admin.php?action=upload-doc&property_id={$property_id}&document_id={$row.document_id}&token={$token}');
                            </script>
                        {/if}
                    </li>
                {/foreach}
            {/if}        
        </td>
    </tr>
     <tr>
     	<td align="right">
        	<hr/>
        	<input type="button" class="button" value="Next" onclick="pro.submit(true)/*pro.goto('{$form_action}')*/"/>
        </td>
     </tr>
    
</table>