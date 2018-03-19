<link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css" />
<link href="modules/{$module}/templates/style/ajax-upload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
<script type="text/javascript" src="modules/{$module}/templates/js/upload.js"></script>
<script src="modules/property/templates/js/main.js" type= "text/javascript"></script>
<script type="text/javascript" src="modules/{$module}/templates/js/upload-common.js"></script>

<script type="text/javascript">
    var count_doc = 20;
</script>
{literal}
    <script type="text/javascript">
        jQuery(function () {
            for (i = 0; i < count_doc; i++) {
                jQuery('#tooltip_' + i).tipsy({gravity: 'w', html: true});
                console.log(jQuery('#tooltip_' + i));
            }
        });
    </script>
    <style type="text/css">
        .auction-register .step-4-info .step-detail .form-list li.wide {
            padding-bottom: 41px !important;
        }
        .step-4-info .step-detail .form-list li.wide .input-box {
            width: 60% !important;;
        }
        .step-4-info .step-detail .form-list li.wide label
        {
            width: 35% !important;
        }
    </style>
{/literal}
      
<div class="step-2-info step-4-info">
    <div class="step-name">
        <h2>{localize translate="Legal documents"}</h2>
    </div>
    <div class="step-detail col2-set">
        <div class="col-1">
            <p style="text-align: justify">
                {localize translate="Please upload all the relevant legal documents for your property."}
            </p>
            <br/>
            <p style="text-align: justify">
                You may upload later if you don’t have them now, but please be aware, without the correct legal documents, section 32 and contract of sale, as a minimum, your property will not be allowed to go to auction.  To sell your property potential buyers must have an opportunity to view and read the legal documents and you must provide these prior to the sale or auction begining.
                For more specific answers on each field, please click on the ? icon next to each field to confirm what is required.
            </p>
        </div>
        <div class="col-2 bg-f7f7f7">
            {if strlen($message)>0}
                <div class="message-box all-step-message-box">{$message}</div>
            {/if}
            <ul class="form-list form-property">
                               
            	<form id="frmProperty" name="frmProperty" method="post" action="{$form_action}" enctype="multipart/form-data">
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
                                <strong>{localize translate=$row.title}</strong>
                                <br />
                                <span style="clear:both;">(Allow format: .pdf, .png, .jpg)</span>
                                {*<strong>
                                    <a href="#" id="tooltip_{$k}"
                                       style="color:#990000;font-weight:bold; margin-left:20px;text-decoration:none;"
                                       title="{$row.help}">
                                    </a>
                                </strong>*}
                            </label>
                            <div class="input-box file-upload">
                                <div id="btn_{$row.document_id}" style="float:left;height: 24px;"></div>
                                <br clear="all"/>
                                <div class="div-file-upload">
                                    <ul id="lst_{$row.document_id}" style="float:left;" class="qq-upload-list">
                                        {assign var = index value= "item_`$row.document_id`"}
                                        {if isset($property_document_rows[$row.document_id]) and count($property_document_rows[$row.document_id]) > 0 and $script and $doc_rows.$index.file_name}
                                            <li class="qq-upload-success">
                                                <span class="qq-upload-file">{$doc_rows.$index.file_name}</span>
                                                <a class="qq-upload-del" href="javascript:void(0)"
                                                   onclick="pro.downDoc('/modules/property/action.php?action=down-doc&property_id={$doc_rows.$index.property_id}&document_id={$row.document_id}')">Download</a>
                                                <span class="split">|</span>
                                                <a class="qq-upload-del" href="javascript:void(0)"
                                                   onclick="deleteAction('modules/property/action.php?action=delete-doc&document_id={$row.document_id}','lst_{$row.document_id}')">Delete</a>
                                            </li>
                                        {else}
                                            {'No file chosen'}
                                        {/if}
                                    </ul>
                                    <span style="float: right;height: 16px;margin-top: -17px;">
                                        <a href="javascript:void(0)" id="tooltip_{$k}"  title="<div style='text-align: justify;padding:0px 10px;0px;10px'>{$row.help}</div>">
                                            <img src="/modules/general/templates/images/img_question.png"
                                                 style="border:none; vertical-align:top;"/>
                                        </a>
                                    </span>
                                </div>
                                <br clear="all"/>
                                {*LINK TO DOCUMENTS*}
                                <div>
                                    <span><strong>Or Add a Link: &nbsp;</strong></span>
                                    <input style="width: 70%" type="text" value="{$property_document_rows[$row.document_id].link_name}" placeholder="http://link.com" name="doc_link_{$row.document_id}" />
                                </div>
                                <br clear="all"/>
                            </div>
                            {if $script}
                                <script type="text/javascript">
                                    var doc_{$row.document_id} = new Doc();
                                    doc_{$row.document_id}.uploader('btn_{$row.document_id}', 'lst_{$row.document_id}', 'modules/property/action.php?action=upload-doc&document_id={$row.document_id}');
                                </script>
                            {/if}
                        </li>
                    {/foreach}
                {/if}
                <input type="hidden" name="track" id="track" value="0"/>
                <input type="hidden" name="is_submit2" id="is_submit2" value="0"/>
                </form>
           		<script type="text/javascript">pro.is_submit = 'is_submit2';</script>
            </ul>
            
            <div class="buttons-set">
                <button class="btn-red step-eight-btn-red" onclick="(document.location.href='/?module=property&action=register&step=3')"><span><span>Back</span></span></button>
                <button class="btn-red" onclick="pro.submit('#frmProperty',true)">
                    <span><span>{localize translate="Save"}</span></span>
                </button>
                <button class="btn-red" onclick="pro.submit('#frmProperty')">
                    <span><span>{localize translate="Next"}</span></span>
                </button>
            </div>
        </div>
        <div class="clearthis">
        </div>
    </div>
</div>
