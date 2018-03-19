{literal}
<style type="text/css">
.col22-set .col-22 {
    float: right;
    margin-top: 50px;
    width: 48.55%;
}

</style>
<link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css"/>
<link href="/modules/property/templates/style/ajax-upload.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
<script type="text/javascript" src="/modules/property/templates/js/upload.js"></script>

<script language="javascript" src="modules/general/templates/js/helper.js" > </script>
<script type="text/javascript">
	function howMany(page_id){
		var page_select = document.getElementById(page_id);
		if (form_select.hasManySelect(page_id)) {
			if (page_select.options[0].selected == true) {
				form_select.unSelectAll(page_id);
				page_select.options[0].selected = true;
				showMess("You can't choose the two cases");
			}
		}
	}
	
	var banner = new BANNER('#frmCreate');
    var search_overlay = new Search();
	search_overlay._frm = '#frmAgent';
	search_overlay._text_search = '#suburb';
	search_overlay._text_obj_1 = '#state';
	search_overlay._text_obj_2 = '#postcode';
	search_overlay._overlay_container = '#search_overlay';
	search_overlay._url_suff = '&'+'type=suburb';

	search_overlay._success = function(data) {
		var info = jQuery.parseJSON(data);
		var content_str = "";
		var id = 0;
		if (info.length > 0) {
			search_overlay._total = info.length;
			for (i = 0; i < info.length; i++) {
				var id = 'sitem_' + i;
				content_str +="<li onclick='search_overlay.setValue(this)' id="+id+">"+info[i]+"</li>";
				search_overlay._item.push(id);
			}
		};

		search_overlay._getValue = function(data){
			var info = jQuery.parseJSON(data);
			jQuery(search_overlay._text_obj_1).val(info[0]);
			$('#uniform-state span').html($(search_overlay._text_obj_1+" option:selected").text());
		};

		if (content_str.length > 0) {
			jQuery(search_overlay._overlay_container).html(content_str);
			jQuery(search_overlay._overlay_container).show();
			jQuery(search_overlay._overlay_container).width(jQuery(search_overlay._text_search).width());
		} else {
			jQuery(search_overlay._overlay_container).hide();
		}
		jQuery(search_overlay._text_search).removeClass('search_loading');
	};
    document.onclick = function() {search_overlay.closeOverlay()};
</script>
{/literal}
<script language="javascript" src="modules/banner/templates/js/check_state.js" > </script>
<script language="javascript" src="modules/banner/templates/js/check-display-edit{if $row.pay_status == 2}-pay{/if}.js"> </script>
<script src="/modules/banner/templates/js/common.js"></script>
<div class="content-box">
    <div class="bar-title"><h2>{if $id > 0}UPDATE BANNER ADVERTISING{else}ADD NEW BANNER ADVERTISING{/if}</h2></div>
    <div class="step-1-info step-1-uba-partner">
        <div class="step-detail col2-set">
            <div class="col-1"></div>
    
            <div class="col-2 bg-f7f7f7" style="padding:10px">
                {if isset($message) and strlen($message) > 0}<div style="position: relative;" class="message-box message-box-add">{$message}</div>{/if}
                {if isset($messresend) and strlen($messresend) > 0}<div style="position: relative;" class="message-box message-box-add">{$messresend}</div>{/if}
                <div class="clearthis"></div>
                <form name="frmCreate" id="frmCreate" method="post" action="{$form_action}&id={$row.banner_id}" enctype="multipart/form-data" onsubmit="return checkUrlBFront();">
                    <div class="col22-set">
                        <div class="col-edit-banner" style="{*calender:position: relative;*}">
                            <ul class="form-list">
                                <li class="wide">
                                    <label><strong id="notify_address">Banner Name<span>*</span></strong></label>
                                    <div class="input-box">
                                        <input type="text" style="width:100%;" name="banner_name" id="banner_name" class="input-text validate-require" value="{$row.banner_name}"/>
                                    </div>
                                </li>
                                
                                <li class="wide" id="banner_container" {if $row.banner_file == ''}style="display:none"{/if}>
                                    <label><strong id="notify_address">Banner File</strong></label>
                                    <div style="margin-top:5px;">
                                         <img src="{$MEDIAURL}/store/uploads/banner/images/{$row.banner_file}" style="max-width:600px"/> 
                                        <input type="hidden" name="banner_file" id="banner_file" value="{$row.banner_file}"/>   
                                        <div class="clearthis"></div>
                                    </div>
                                </li>
                                
                                
                                <li class="wide" id="upload-logo">
                                    <label><strong>Upload Banner</strong></label>
                                    <div class="input-box">
                                        <div class="input-box file-upload">
                                            <div id="btn_photo" style="float:left"></div>
                                            <ul id="lst_photo" style="float:left;margin-left:10px" class="qq-upload-list">
                                                No file chosen
                                            </ul>
                                            <br clear="all"/>
                                            <script type="text/javascript">
                                                var photo = new Media();
                                                photo.uploader('btn_photo', 'logo', '/modules/banner/action.php?action=upload');
                                            </script>
                                        </div>
                                        <i>   
                                            You must upload  with one of the following extensions: jpg, jpeg, gif, png<br/>
                                            The best dimension for right banner is: 280 x 280 pixel and for center banner is: 616 x 110 pixel. !<br/> 
                                            But in case you don't have the banner fits the size, we limit it up to 280 pixel in width and 500pixel in height<br/>
                                            for right banner. And 616 pixel in width and 200 pixel in height for center banner.<br/> 
                                         </i>
                                    </div>
                                </li>
                                
                                
                                <li class="wide">
                                    <label><strong id="notify_address">Url<span>*</span></strong></label>
                                    <div class="input-box">
                                        <input type="text" style="width:100%;" name="url" id="url" class="input-text validate-require" value="{$row.url}"/>
                                        <i>Ex : http://www.google.com</i>
                                    </div>
                                </li>
                    
                                <li class="fields">
                                    <div class="field field-banner" style="margin-top:11px;width:45%;float:left" >
                                        <label><strong id="notify_type">Property Type</strong></label>
                                        <div class="input-box">
                                            <select style="width:97%" name="type" {if $id > 0 && $row.pay_status == 2}disabled="disabled"{/if}>
                                                {html_options options = $property_types selected = $row.type}   
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="field" style="margin-top:11px;width:45%;float:right">
                                        <label><strong id="notify_bedroom">Page</strong></label>
                                        <div class="clearthis"></div>
                                        <select class="input-select" name="page_id[]" id="page_id" style="width:97%;height:200px;padding:5px;" multiple="multiple" {if $id > 0 && $row.pay_status == 2}{/if}>
											{html_options options = $options_page selected = $row.page_id}
                                        </select>
                                        {if $row.pay_status == 2}
                                        <script>
										from_multiselect.setup('page_id');
										</script>
                                        {/if}
                                    </div>
                                    <div class="clearthis"></div>
                                </li>    
                    
                                <li class="fields">
                                    <div class="field field-banner">
                                        <label><strong id="notify_bedroom">Display Area</strong></label>
                                        <div class="input-box">
                                            <select id="display" name="display" style="width:97%" {if $id > 0 && $row.pay_status == 2}disabled="disabled"{/if} onchange="banner_area.change('/modules/menu/action.php?action=get-menu', this, '#page_id')">
                                                {html_options options = $options_display selected = $row.display}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="clearthis"></div>
                                </li>               
                                                      
                                <li class="fields">
                                   <div class="field field-banner" style="width:45%;float:left">
                                        <label><strong id="notify_country">Suburb</strong></label>
                                        <div class="input-box">
                                            <input type="text" name="suburb" id="suburb" class="input-text validate-require disable-auto-complete" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)" value="{$row.suburb}" {if $row.pay_status == 2}disabled="disabled"{/if}/>
                                            <ul><div id="search_overlay" class="search_overlay" style="display:none; position: absolute;"></div></ul>
                                        </div>
                                   </div>
                                   
                                   <div class="field field-e-ie" style="width:45%;float:right">
                                        <label><strong id="notify_state">State</strong></label>
                                        <div class="input-box">
                                            <select name="state" id="state"  class="input-select"  {if $row.pay_status != 2}onchange="onReloadState(this.form)"{else}disabled="disabled"{/if}>
                                                  {html_options options = $options_state selected = $row.state}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="clearthis"></div>
                                </li>
                                
                                <li class="fields">
                                   <div class="field field-banner" style="width:45%;float:left">
                                        <label><strong id="notify_country">Postcode</strong></label>
                                        <div class="input-box">
                                            <input type="text" name="postcode" id="postcode" class="input-text validate-postcode" value="{$row.postcode}" {if $row.pay_status == 2}disabled="disabled"{/if}/>
                                        </div>
                                   </div>
                                   <div class="field field-e-ie" style="width:45%;float:right">
                                        <label><strong id="notify_country">Country</strong></label>
                                        <div class="input-box">
                                            <select name="country" id="country" class="input-select validate-number-gtzero" disabled="disabled">
                                                {html_options options = $countries selected = $row.country}
                                            </select>
                                            <input type="hidden" name="country" value="{$row.country}"/>
                                        </div>
                                    </div>
                                    <div class="clearthis"></div>
                                </li>
                                
                                <li class="fields">
                                    <div class="field field-e-ie field-banner" style="width:45%;float:left">
                                        <label><strong id="notify_country">Date From</strong></label>
                                        <div class="input-box">
                                            <input id="date_from" name="date_from" type="text" class="input-text validate-require" value="{$row.date_from}" {if $row.pay_status == 2}disabled="disabled"{/if}/>
                                        </div>
                                    </div>
                                
                                    <div class="field" style="width:45%;float:right">
                                        <label><strong id="notify_country">Date To</strong></label>
                                        <div class="input-box">
                                            <input id="date_to" name="date_to" type="text" class="input-text validate-require" value="{$row.date_to}" {if $row.pay_status == 2}disabled="disabled"{/if}/>
                                        </div>
                                    </div>
                                    <div class="clearthis"></div>
                                </li>
                               
                                <li>
                                    <input type="checkbox" name="notification_email" id="notification_email" value="1" {if $row.notification_email == 1}checked="checked"{/if} /> Notification Email
                                </li>
                                
                                <li>
                                    <div class="field" style="margin-top:20px;">
                                        <label><strong>Notes</strong></label>
                                        <div class="input-box" style="width:600px;">
                                            <textarea name="description" id="description" class="input-select" rows="10"  style="width:99%" {if $id > 0 && $row.pay_status == 2}disabled="disabled"{/if}>{$row.description}</textarea>
                                        </div>
                                    </div>  
                                    <div class="clearthis"></div>
                                </li>
                            </ul>
                        </div>
                        <div class="clearthis"></div>
                    </div>
                    <input type="hidden" name="track" id="track" value="0"/>
                </form>
                 
                <div class="buttons-set">
                    <div class="dbt2">
                    	<!--
                        <button class="btn-red" name="rgalert" id="rgalert" onclick="{if $row.pay_status == 2}editPaySubmit(){else}bannerSubmit(){/if}">
                            <span><span> Update Banner &nbsp;&nbsp; </span></span>
                        </button> 
                        -->
                        <button class="btn-blue" name="rgalert" id="rgalert" onclick="{if $row.pay_status == 2}editPaySubmit(){else}bannerSubmit(){/if}">
                            <span><span> Update Banner &nbsp;&nbsp; </span></span>
                        </button> 
                        
                    </div>
                </div>
            </div>
            <div class="clearthis"></div>
        </div>
    </div>
</div>

{literal}
<style type="text/css">
.popup_container {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #8A0000;
    position: relative !important;
    z-index: 101;
}
.btn-red {
	border-bottom-style:none;
	border-color:initial;
	border-left-style:none;
	border-right-style:none;
	border-top-style:none;
	border-width:initial;
	cursor:pointer;
	height:26px !important;
}
</style>

<script type="text/javascript">
	onReloadState(document.getElementById("frmCreate"));
	onReloadDisplay(document.getElementById("frmCreate"));
</script>
{/literal}
