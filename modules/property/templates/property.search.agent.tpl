<script src="/modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"></script>
{literal}
<script type="text/javascript">
    jQuery(document).ready(function(){
        onLoadSearch();
    });

    var search_overlay = new Search();
    search_overlay._frm = '#frmAdvanceSearch';
    search_overlay._text_search = '#suburb';
    search_overlay._overlay_container = '#search_overlay';
    search_overlay._url_suff = '&type=suburb';

    search_overlay._success = function (data) {
        var info = jQuery.parseJSON(data);
        var content_str = "";
        var id = 0;
        if (info.length > 0) {
            search_overlay._total = info.length;
            for (i = 0; i < info.length; i++) {
                var id = 'sitem_' + i;
                content_str += "<li onclick='search_overlay.set2SearchText(this)' id='" + id + "'>" + info[i] + "</li>";
                search_overlay._item.push(id);
            }
        }

        if (content_str.length > 0) {
            jQuery(search_overlay._overlay_container).html(content_str);
            jQuery(search_overlay._overlay_container).show();
            jQuery(search_overlay._overlay_container).width(jQuery(search_overlay._text_search).width());
        } else {
            jQuery(search_overlay._overlay_container).hide();
        }
		jQuery(search_overlay._text_search).removeClass('search_loading');
    };
    document.onclick = function () {
        search_overlay.closeOverlay();
    };
</script>
{/literal}
<div class="content-box search-agent">
    <div class="bar-title">
        <h2>AGENT SEARCH</h2>
    </div>
    <div class="content-details">
        <div class="div-search-a div-search-partner">
            <form name="frmAdvanceSearch" id="frmAdvanceSearch" method="post" enctype="multipart/form-data" action="{$form_action}" >
                <ul id="form-list-search-partner" class="form-list" style="position: relative;">
                     <li class="fields">
                        <div class="field">
                            <label>Agent name</label>
                            <div class="input-box">
                                 <input type="text" name="search[agent_name]" id="agent_name" value="{$form_data.agent_name}" class="input-text disable-auto-complete"/>
                            </div>
                        </div>
                        <div class="field" style="float:right">
                            <label>Agency name</label>
                            <div class="input-box">
                                <input type="text" name="search[agency_name]" id="agency_name" value="{$form_data.agency_name}" class="input-text disable-auto-complete"/>
                            </div>
                        </div>
                        <div class="clearthis"></div>
                     </li>
                     <li class="fields">
                        <div class="field">
                            <label>Suburb</label>

                            <div class="input-box">
                                <input type="text" name="search[suburb]" id="suburb" value="{$form_data.suburb}" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)" class="input-text"/>
                                <ul>
                                    <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;"></div>
                                </ul>
                            </div>
                        </div>
                        <div class="field" style="float:right">
                            <label>Postcode</label>

                            <div class="input-box">
                                <input type="text" name="search[postcode]" id="postcode" value="{$form_data.postcode}" class="input-text"/>
                            </div>
                        </div>
                     </li>
                     <li class="fields">
                        <div class="field">
                            <label>State</label>

                            <div class="input-box">
                                <div id="inactive_state">
                                    <select name="search[state]" id="state" class="input-select">
                                        {html_options options = $subState selected = $form_data.state}
                                    </select>
                                </div>
                                <input type="text" id="other_state" name="search[other_state]" class="input-text" value="{$form_data.other_state}"/>
                            </div>
                        </div>


                        <div class="field" style="float:right">
                            <label>Country</label>
                            <div class="input-box input-select input-select-new">
                                <select name="search[country]" id="country" class="input-select" onchange="onLoadSearch()">
                                    {html_options options = $options_country selected = $form_data.country}
                                </select>
                            </div>
                        </div>
                        <div class="clearthis"></div>
                     </li>
                     <li class="fields">
                        <div class="field">
                            <label>List by</label>

                            <div class="input-box input-select input-select-new">
                                <select name="search[view]" id="view" class="input-select">
                                    <option value="agent" {if $form_data.view == 'agent'}selected{/if}>Agent</option>
                                    <option value="property" {if $form_data.view == 'property'}selected{/if}>Property</option>
                                </select>
                            </div>
                        </div> 
                        
                        <li class="fields">
                            <div class="buttons-set">
                                <input type="button" value="" class="btn-search" onclick="$('#frmAdvanceSearch').submit()"/>
                            </div>
                        </li>                                                                         	
                         
                        <div class="clearthis"></div>
                     </li>
                </ul>
            </form>
            <div class="clearthis"></div>
            <!--
            <div class="buttons-set">
                <button class="btn-red f-right btn-red-search" onclick="$('#frmAdvanceSearch').submit()">
                    <span><span>Search</span></span>
                </button>
                <div class="clearthis"></div>
            </div>
            -->
        </div>
    </div>
</div>


