{literal}
    <style>
        .result-success{
            color: green;
        }
        .result-fail{
            color: red;
        }
    </style>
{/literal}
<script type="text/javascript" src="/modules/agent/templates/js/file.js"></script>
<div class="register-application-title" style="margin-top: 20px">
    <h1>REAXML Imports/Exports - Bidrhino.com.au</h1>
</div>
<div class="register-application-content">
    <form name="frmAgentTransact" id="frmAgentTransact" method="post" action="{$form_action_transact}" enctype="multipart/form-data">
        <input type="hidden" id="transact_agent_id" name="transact_agent_id" value="{$transact_agent_id}"/>
        <p style="font-size: 26px;font-weight: bold">Introduction</p>
        <p>This documentation contains important technical information for new and existing 3rd party data providers (interconnect providers) to REA.</p>
        <p>The REAXML system receives listing data from agents in the XML format and imports this data into the REA database.</p>
        <p>This data is then displayed as property listings on the website.</p>
        <p>This documentation should be read in conjunction with the REAXML propertyList.DTD, available at http://ask.realestate.com.au/reaxml/propertylistdtd/.</p>
        <p>The XML data structure is described by the DTD.</p>
        <div class="rental-row-file">
            <label>Upload Your XML:</label><br/>
            <div class="file-box">
                <span class="file"><input type="file" name="file_xml"/></span>
                <span class="file-name" style="width: 300px">{$files.file_xml}</span>
                <span class="file-action">{if $files.file_xml}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                <input class="file-delete" type="hidden" value="0" name="files_deleted[file_xml]"/>
            </div>
        </div>
        <div>
            <div style="font-weight: bold;">{$result}</div>
        </div>
        <br/><br/>
        <button type="button" class="btn-blue-transact" onclick="submitXml('#frmAgentTransact')">
            <span><span>Import REAXML</span></span>
        </button>
        <a href="{$ROOTURL}/api/property/xml/" target="_blank">
            <button style="margin-left: 20px" type="button" class="btn-blue-transact">
                <span><span>Generate REAXML</span></span>
            </button>
        </a>

        <p>To ensure you are kept up to date with changes to the REAXML specifications please register your contact details below. We will only use this information to send you details of upcoming validation, specification or process changes.</p>
    </form>
</div>
<script type="text/javascript">
    {literal}
    function submitXml(frm){
        var isSubmit = true;
        if(isSubmit){
            showLoadingPopup();
            jQuery(frm).submit();
        }
    }
    function exportXml(frm){

    }
    {/literal}
</script>
