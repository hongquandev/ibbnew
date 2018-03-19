<h4> MY BANNER ADVERTISING </h4>
<div class="search-results">
    <ul class="search-list">
        {if is_array($db_banner_data) and count($db_banner_data) > 0}
            {assign var = i1 value = 0}
            {foreach from = $db_banner_data key = k item = banner}
                {assign var = i1 value = $i1+1}
                {if $banner.display == 1}
                    <li {if $i1==1} class="first" {/if} style="height: 290px;">
                        <div class="item" id="ibbsdheight" style="border-bottom: medium none ! important;font-size: 12px;*width:620px;">
                            <div id="div-cms-landing-top-ie" class="div-cms-landing-top div-cms-landing-top2" style="margin-left: -8px;"></div>
                            <div class="clearthis"></div>
                            <div class="div-cms-landing"  style="margin-left: -12px;*margin-top: -1px;">
                                <div class="div-cms-landing-child div-partner-all">
                                    <div id="search-partner" class="f-left info" >
                                        <div class="sub-banner-title">
                                            <span class="span-a"> {$banner.banner_name}  </span>
                                            <span class="span-b"> {$banner.creation_time|date_format:"%d %B %Y"} </span>
                                        </div>
                                        <div class="clearthis"></div>
                                        <div class="sub-partner-all-b">
                                            <div style="float: left;color:#980000;"><span>Date From</span>: {$banner.date_from}</div>
                                            <div style="float: right;color:#980000;"><span style="margin-left:10px">Date To</span>: {$banner.date_to}</div>
                                        </div>
                                        <div class="clearthis"></div>
                                        <div class="sub-partner-all-b">
                                            <div style="float: left;color:#980000;"><span>ID</span>: {$banner.banner_id}</div>
                                            <div style="float: right;color:#980000;"><span>Display</span>: Right</div>
                                        </div>
                                        <div class="clearthis"></div>
                                        <div class="sub-partner-all-b">
                                            <div style="float: left;"><span>Url</span>:  <a href="{$banner.url}" target="_blank">{$banner.url} </a> </div>
                                        </div>
                                        <div class="clearthis"></div>
                                        <div class="sub-partner-all-b">
                                            <span style="font-weight:bold;font-size: 11px"> {$banner.full_address} </span>
                                            <div style="float:left">
                                                <span>Type</span>: {$banner.type}
                                                <span style="margin-left:5px;">Click</span>:  {$banner.click}
                                                <span style="margin-left:5px;">Views</span>: {$banner.views}
                                            </div>
                                        </div>
                                        <div class="clearthis"></div>
                                        <div class="sub-partner-all-b">
                                            <span style="float:left;">
                                                {$banner.suburb} {$banner.name} {$banner.postcode}
                                            </span>
                                        </div>
                                        {* Begin Highlight no payment and fix layout*}
                                        {assign var=fix_photo value="0px"}
                                        {* End Highlight no payment and fix layout*}
                                        <div class="tbl-info" style="margin-top:0px;float: right;">
                                            <div class="clearthis"></div>
                                        </div>
                                        <div class="clearthis"></div>
                                    
                                        <div class="botton sub-partner-all-b" style="min-height:90px;*min-height: 75px;">
                                            <p> 
                                                <span style="float:left">Page:</span> 
                                                <span style="width:264px;margin-left:5px;float:left">
                                                    <select>{html_options options = $banner.page_list}</select>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="tbl-info-partner tbl-info-banner-bottom" id="tbl-info-banner-font">
                                            <ul class="f-left col1">
                                                <li>
                                                    <span class="f-left-partner">Status :</span>
                                                    <a href="?module=agent&action=agent-active&id={$banner.banner_id}">
                                                        <span class="banner-a f-right">{if $banner.agent_status == 1}Enabled{else}Disabled{/if}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            
                                            <ul class="f-left col2">
                                                <li>
                                                    {if $banner.check_all_page == 1 && $banner.pay_status != 2}
                                                        <a href="javascript:void(0)" onclick="return showMess('Please contact admin complete payment !')" style="color:#990000; text-decoration:none"><span class="banner-a f-left-partner">Edit</span></a>
                                                    {else}
                                                        <a href="?module=banner&action=edit-advertising&id={$banner.banner_id}" style="color:#990000; text-decoration:none"><span class="banner-a f-left-partner">Edit</span></a>
                                                    {/if}
                                                    <a href="javascript:void(0)" onclick="return show_confirm('?module=agent&action=view-dashboard&agent-delete={$banner.banner_id}','Do you really want to delete this banner ?');" style="color:#990000; text-decoration:none" ><span class="banner-a f-right">Delete</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="f-search-partner-ie7" class="f-right f-right-search-partner f-right-partner-all">
                                        <div class="img-partner" id="img-partner-ie7" align="center">
                                            <div class="chi-img-partner-ie7">
                                                <a href="{$banner.url}" target="_blank">
                                                    <img src="{$MEDIAURL}/store/uploads/banner/images/{$banner.banner_file}" style="max-width:185px; max-height:154px; width:auto; height:auto;" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="div-cms-landing-bottom div-cms-landing-top" style="margin-left: -8px;"></div>
                            <div class="clearthis"></div>
                        </div>
                    </li>
                {else} <!-- Banner Display = Center -->
                    <li {if $i1==1} class="first" {/if} style="height: 325px;*height: 338px;">
                        <div class="item" style="border-bottom: medium none ! important; font-size: 12px;">
                            <div id="div-cms-landing-top-ie" class="div-cms-landing-top div-cms-landing-top2" style="margin-left: -8px;"></div>
                            <div class="clearthis"></div>
                            <div class="div-cms-landing"  style="margin-left: -12px;*margin-top: -1px;">
                                <div id="div-partner-all-div" class="div-cms-landing-child div-partner-all">
                                    <div class="f-left info" style="width:599px;padding-left: 4px;">
                                        <div class="sub-banner-title">
                                            <span class="span-a"> {$banner.banner_name}  </span>
                                            <span class="span-b"> {$banner.creation_time|date_format:"%d %B %Y"} </span>
                                        </div>
                                        <div class="clearthis"></div>
                                        <div class="sub-partner-all-b">
                                            <div style="float: left;color:#980000;font-size: 12px;"><span> Date From</span>: {$banner.date_from}</div>
                                            <div style="float: right;color:#980000;font-size: 12px;"><span style="margin-left:10px"> Date To</span>:  {$banner.date_to}</div>
                                        </div>
                                        <div class="clearthis"></div>
                                        <div class="sub-partner-all-b">
                                            <div style="float: left;color:#980000;"><span>ID</span>: {$banner.banner_id}</div>
                                            <div style="float: right;color:#980000;"><span>Display</span>:  Center</div>
                                        </div>
                                        <div class="clearthis"></div>
                                        <div class="sub-partner-all-b">
                                            <div style="float: left;clear: both;"> <span>Url</span>:  <a href="{$banner.url}" target="_blank">{$banner.url} </a> </div>
                                        </div>
                                        <div class="clearthis"></div>
                                        <div class="sub-partner-all-b">
                                            <span style="font-weight:bold;font-size: 11px"> {$banner.full_address} </span>
                                            <div style="float:left">
                                                <span> Type </span>: {$banner.type}
                                                <span style="margin-left:5px;"> Click </span>:  {$banner.click}
                                                <span style="margin-left:5px;"> Views </span>: {$banner.views}
                                            </div>
                                            <p style="float:right;">
                                            
                                            </p>
                                        </div>
                                        <div class="clearthis"> </div>
                                    
                                        <div class="desc-sub-name">
                                            <span style="float:left;">
                                                {$banner.suburb} {$banner.name} {$banner.postcode}
                                            </span>
                                        </div>
                                    
                                        <div class="clearthis"> </div>
                                        <div class="f-right-banner-all sub-partner-all-b f-right-banner-all-ie7">
                                            <div class="img-banner-div" align="center" id="img-banner-ie7">
                                                <div class="img-banner-div-div chi-img-banner-ie7">
                                                    <a href="{$banner.url}" target="_blank">
                                                        <img src="{$MEDIAURL}/store/uploads/banner/images/{$banner.banner_file}" style="max-width:590px; max-height: 108px;" />
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearthis"></div>
                                        <div class="tbl-info" style="margin-top:0px;float: right;">
                                            <div class="clearthis"></div>
                                        </div>
                                        <div class="clearthis"> </div>
                                        <div class="botton sub-partner-all-b">
                                            <p>
                                                <strong style="float:left">Page: </strong>
                                                <span style="width:264px;margin-left:5px;float:left">
                                                <select>{html_options options = $banner.page_list}</select>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="clearthis"></div>
                                        <div class="tbl-info-banner-bottom-a sub-partner-all-b">
                                            <ul class="f-left col1">
                                                <li>
                                                    <span class="banner-left"> Status:</span>
                                                    <a href="?module=agent&action=agent-active&id={$banner.banner_id}">
                                                        <span class="banner-a banner-right">{if $banner.agent_status == 1}Enabled{else}Disabled{/if}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        
                                            <ul class="f-left col2">
                                                <li>
                                                    {if $banner.check_all_page == 1 && $banner.pay_status != 2}
                                                        <a href="javascript:void(0)" onclick="return showMess('Please contact admin complete payment !')" style="color:#990000; text-decoration:none"><span class="banner-a banner-left">Edit</span></a>
                                                    {else}
                                                        <a href="?module=banner&action=edit-advertising&id={$banner.banner_id}" style="color:#990000; text-decoration:none"><span class="banner-a banner-left">Edit</span></a>
                                                    {/if}
                                                    <a href="javascript:void(0)" onclick="return show_confirm('?module=agent&action=view-dashboard&agent-delete={$banner.banner_id}','Do you really want to delete this banner ?');" style="color:#990000; text-decoration:none" ><span class="banner-a banner-right">Delete</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="div-cms-landing-bottom div-cms-landing-top" style="margin-left: -8px;"></div>
                            <div class="clearthis">  </div>
                        </div>
                    </li>
                {/if}  <!-- End Banner Display = Left -->
            {/foreach}
        {else}
            There is no data.
        {/if}
    </ul>
</div>