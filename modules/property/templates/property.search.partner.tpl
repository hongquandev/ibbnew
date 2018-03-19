<script src="/modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"> </script>
<div class="content-box">
    <div class="bar-title">
        <h2>LOCAL SERVICES SEARCH</h2>
    </div>
    <div class="content-details">
        <div class="col2-set mb-20px">
            <div class="col">
                <div>
                    <ul id="form-list-search-partner" class="form-list" style="position: relative;">
                        {literal}
                        <script type="text/javascript">
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
                            search_overlay._getValue = function (data) {
                                var info = jQuery.parseJSON(data);
                                jQuery(search_overlay._text_obj_1).val(info[0]);
                                $('#uniform-state span').html($(search_overlay._text_obj_1 + " option:selected").text());
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
                        
                        document.onclick = function () {
                            search_overlay.closeOverlay();
                        };
                        
                        function ActionChange(action,mode){
                            var model = (mode)?'&mode=grid':'';
                            document.getElementById('frmAdvanceSearch').action = action+model;
                            return document.getElementById('frmAdvanceSearch').submit();
                        }
                        function OrderSearch(val, frm) {
                            jQuery('#orderby').val($(val).val());
                            return document.getElementById('frmAdvanceSearch').submit();
                        }
                        </script>
                        {/literal}
                        <form name="frmAdvanceSearch" id="frmAdvanceSearch" method="post" enctype="multipart/form-data" action="{$form_action}" >
                            <li class="fields">
                                <div class="field">
                                    <label class="label-search"><strong>Company or Bussiness Register</strong></label>
                                    <div class="input-box">
                                        <input type="text" name="search[firstname]" id="firstname" value="{$form_data.firstname}" class="input-text" />
                                    </div>
                                </div>
                                <div class="field" style="float:right">
                                    <label class="label-search"><strong>Region</strong></label>
                                    <div class="input-box">
                                        <input type="text" name="search[region]" id="region" value="{$form_data.region}" class="input-text" />
                                    </div>
                                </div>
                            </li>
                            <input type="hidden" id="is_submit" name="is_submit" value="0"/>
                            <input type="hidden" id="orderby" name="search[order_by]"/>
                        </form>
                    </ul>
                </div>
                
				<div class="clearthis"></div>
                <div class="buttons-set">
                    <input type="button" value="" class="btn-search" onclick="search_overlay.submit()"/>
                </div>  
                <!--              
                <div class="buttons-set">
                    <button class="btn-red f-right btn-red-search" onclick="search_overlay.submit()">
                        <span><span>Search</span></span>
                    </button>
                    <div class="clearthis"></div>
                </div>
                -->
            </div>
        </div>

            {if isset($mode) and $mode == 'grid'}
                {include file = "searchpartner.viewmode.grid.tpl"}
            {else}
                {include file = "searchpartner.viewmode.list.tpl"}
            {/if}

    </div>
</div>
