<script type="text/javascript" src="modules/general/templates/js/confirm.js"></script>
<script type="text/javascript" src="modules/general/templates/js/jquery.simplemodal.js"></script>
<link href="modules/general/templates/style/bidconfirm.css" type="text/css" rel="stylesheet"/>

<div class="popup_container" id="popup_container" style="width:356px;height: 122px;" style="display:none;">
	<div id="contact-wrapper">
		<div class="title">
        	<h2 id="txtt"> That page at Inspect Bid Buy says: <span id="btnclosex"><a href="#"> x </a> </span> </h2> 
        </div>
		<div class="clearthis" style="clear:both;"> </div>
<div class="content content-po" id="msg">Are you sure you want to continue Bid ? </div>
   <!-- <button class="btn-red btn-red-mess-po" onclick="closeMess()" >
        <span><span>Yes</span></span>
    </button>
    
    <button class="btn-red btn-red-mess-po" onclick="closeMess()" >
        <span><span>No</span></span>
    </button> -->
    
    <div class='buttons'>
				<div class='no simplemodal-close'>No</div>
                <a href="javascript:void(0)" onclick="bid_{$row.property_id}.click()"> <div class='yes'> Yes  </div> </a>
			</div>
            
	</div>
</div>


