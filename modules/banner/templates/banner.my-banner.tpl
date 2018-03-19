<div class="content-box content-box-myacc">
    <div class="bar-title">
        <h2>MY BANNERS DETAILS</h2>
        <div class="bar-filter" style="width: auto;">
            <span class="pagging-search-list" style="margin-top: 40px">{$review_pagging}</span>
        </div>
        <div class="clearthis"></div>
    </div>
    <div class="content-details">
        <div class="toolbar">
            <div class="tn">
                <button class="btn-red btn-red-my-banner" onclick="check.regPro('?module=banner&action=edit-advertising','banner')">
                     <span><span>Register New Banner</span></span>
                </button>
            </div>
        </div>
        <div class="search-results">
            <ul class="search-list">
 				
                 {if isset($results) and is_array($results) and count($results) > 0}
               
				 	{foreach from = $results key = k item = banner}

                    	{if $banner.info.display == 1}
                        
                        <li {if $i1==1} class="first" {/if} style="height: 290px;">
                            <div class="item" id="ibbsdheight2" style="border-bottom: medium none ! important;">
                                <div class="div-cms-landing-top div-cms-landing-top2" style="margin-left: -6px;"></div><div class="clearthis"></div>
                                <div class="div-cms-landing"  style="margin-left: -10px;*margin-top: -1px;">
                                    <div class="div-cms-landing-child div-partner-all">
                                        <div id="search-partner" class="f-left info" >
                                            <div class="sub-banner-title">
                                                <span class="span-a"> {$banner.info.banner_name}  </span>
                                                <span class="span-b"> {$banner.info.creation_time} </span>
                                            </div>

                                            <div class="clearthis"></div>
                                            <div class="sub-partner-all-b">
                                                <div style="float: left;color:#980000;"><span> Date From</span>: {$banner.info.date_from} </div>
                                                <div style="float: right;color:#980000;"><span style="margin-left:10px"> Date To</span>:  {$banner.info.date_to}</div>
                                            </div>
                                            <div class="clearthis"></div>
                                            <div class="sub-partner-all-b">
                                                <div style="float: left;color:#980000;"><span>ID</span>: {$banner.info.banner_id}</div><div style="float: right;color:#980000;"><span>Display</span>: Right</div>
                                            </div>
                                            <div class="clearthis"></div>
                                            <div class="sub-partner-all-b">
                                                <div style="float: left;"><span>Url</span>: <a href="{$banner.info.url}" target="_blank">{$banner.info.url} </a> </div>
                                            </div>
                                            <div class="clearthis"></div>
                                            <!-- desc-mycc-ie7-->
                                            <div class="sub-partner-all-b">
                                                <span style="font-weight:bold;font-size: 11px"> {$banner.info.full_address} </span>

                                                    <div style="float:left">
                                                        <span> Type</span>: {$banner.info.type}
                                                        <span style="margin-left:5px;"> Click</span>:  {$banner.info.click}
                                                        <span style="margin-left:5px;"> Views</span>: {$banner.info.views}
                                                     </div>
                                            </div>
                                            <div class="clearthis"></div>
                                            <div class="sub-partner-all-b">
                                                <span style="float:left;">
                                                        {$banner.info.suburb} {$banner.info.name} {$banner.info.postcode}
                                                </span>
                                            </div>
                                            {* Begin Highlight no payment and fix layout*}
                                            {assign var=fix_photo value="0px"}

                                            {* End Highlight no payment and fix layout*}

                                                <div class="tbl-info" style="margin-top:0px;float: right;">

                                                    <div class="clearthis"></div>
                                                </div>

                                            <div class="clearthis">
                                            </div>

                                            <div class="botton sub-partner-all-b" style="min-height:90px;*min-height:75px;">
                                                <p>
                                                    <span style="float:left">Page:</span> 
                                                    <span style="width:264px;margin-left:5px;float:left">
                                                        <select>{html_options options = $banner.info.page_list}</select>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="clearthis"></div>
                                            <div class="tbl-info-partner tbl-info-banner-bottom" id="tbl-info-banner-font">
                                                <ul class="f-left col1">
                                                    <li>
                                                        <span class="f-left-partner">Status :</span>
                                                        <a href="?module=banner&action=agent-active&id={$banner.info.banner_id}">
                                                              {if $banner.info.agent_status == 1}
                                                                    <span class="banner-a f-right">Enabled</span>
                                                                {else}
                                                                    <span class="banner-a f-right">Disabled</span>
                                                              {/if}
                                                        </a>
                                                    </li>
                                                </ul>
                                                <ul class="f-left col2">
                                                    <li>
                                                        {if $banner.info.check_all_page == 1 && $banner.info.pay_status != 2}
                                                         <a href="javascript:void(0)" onclick="return showMess('Please contact admin complete payment !')" style="color:#990000; text-decoration:none"> <span class="banner-a f-left-partner">Edit</span></a>
                                                            {else}
                                                          <a href="?module=banner&action=edit-advertising&id={$banner.info.banner_id}" style="color:#990000; text-decoration:none"> <span class="banner-a f-left-partner">Edit</span></a>
                                                        {/if}

                                                        <!--
                                                        <a href="javascript:void(0)" onclick="return ConfirmDelete({$banner.info.banner_id});" style="color:#990000; text-decoration:none" > Delete </a>                   					-->

                                                        <a href="javascript:void(0)" onclick="return show_confirm('/?module=banner&action=my-banner&banner_id={$banner.info.banner_id}','Do you really want to delete this banner ?');" style="color:#990000; text-decoration:none" ><span class="banner-a f-right">Delete</span></a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                        <div id="f-search-partner-ie7" class="f-right f-right-search-partner f-right-partner-all" style="margin-top:{$fix_photo}">
                                            <div class="img-partner" id="img-partner-ie7" align="center">
                                                <div class="chi-img-partner-ie7">
                                                    <a href="{$banner.info.url}" target="_blank">
                                                        <img src="{$MEDIAURL}/store/uploads/banner/images/{$banner.info.banner_file}" style="max-width:185px; max-height:154px; width:auto; height:auto;" />
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="div-cms-landing-bottom div-cms-landing-top" style="margin-left: -6px;"></div>
                                <div class="clearthis"></div>
                            </div>
                        </li>
                        {else} <!-- Banner Display = Center -->

                        <li {if $i1==1} class="first" {/if} style="height: 332px;*height: 363px;">
                            <div class="item" style="border-bottom: medium none ! important;">
                                <div class="div-cms-landing-top div-cms-landing-top2" style="margin-left: -6px;"></div><div class="clearthis"></div>
                                    <div class="div-cms-landing"  style="margin-left: -10px;*margin-top: -1px;">
                                         <div id="div-partner-all-div" class="div-cms-landing-child div-partner-all">
                                            <div class="f-left info" style="width:599px;padding-left: 4px;">
                                                <div class="sub-banner-title">
                                                    <span class="span-a"> {$banner.info.banner_name}  </span>
                                                    <span class="span-b"> {$banner.info.creation_time} </span>
                                                </div>

                                                <div class="clearthis"></div>
                                                <div class="sub-partner-all-b">
                                                    <div style="float: left;color:#980000;"><span> Date From</span>: {$banner.info.date_from}</div>
                                                    <div style="float: right;color:#980000;"><span style="margin-left:10px"> Date To</span>:  {$banner.info.date_to}</div>
                                                </div>
                                                <div class="clearthis"></div>
                                                <div class="sub-partner-all-b">
                                                       <div style="float: left;color:#980000;"><span>ID</span>: {$banner.info.banner_id}</div>
                                                       <div style="float: right;color:#980000;"><span>Display</span>:  Center</div>
                                                </div>
                                                <div class="clearthis"></div>
                                                <div class="sub-partner-all-b">
                                                    <div style="float: left;clear: both;"> <span>Url</span>: <a href="{$banner.info.url}" target="_blank">{$banner.info.url} </a> </div>
                                                </div>
                                                <div class="clearthis"></div>
                                                <div class="sub-partner-all-b">
                                                    <span style="font-weight:bold;font-size: 11px"> {$banner.info.full_address} </span>
                                                    <div style="float:left">
                                                        <span> Type </span>: {$banner.info.type}
                                                        <span style="margin-left:5px;"> Click </span>:  {$banner.info.click}
                                                        <span style="margin-left:5px;"> Views   </span>: {$banner.info.views}
                                                    </div>
                                                </div>
                                                <div class="clearthis"> </div>
                                               
                                                <div class="desc-sub-name">
                                                   <span style="float:left;">
                                                            <!--{$banner.info.suburb} {$banner.info.name} {$banner.info.postcode} -->
                                                            {$banner.info.suburb} {$banner.info.name} {$banner.info.postcode}
                                                   </span>
                                                </div>
                                               
                                                <div class="clearthis"> </div>
                                                <div class="f-right-banner-all sub-partner-all-b f-right-banner-all-ie7">
                                                    <div class="img-banner-div" align="center" id="img-banner-ie7">
                                                        <div class="img-banner-div-div chi-img-banner-ie7" style="vertical-align: middle;" >
                                                            <a style="vertical-align: middle;" href="{$banner.info.url}" target="_blank">{*max-width:604px; max-height: 120px*}
                                                                <img src="{$MEDIAURL}/store/uploads/banner/images/{$banner.info.banner_file}" style="max-width:590px; max-height: 108px;" />
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearthis"> </div>
                                                <div class="tbl-info" style="margin-top:0px;float: right;">
                                                    <div class="clearthis"></div>
                                                </div>
                                                <div class="clearthis"> </div>
                                                <div class="botton sub-partner-all-b">
                                                     <p>
                                                        <strong style="float:left">Page: </strong>
                                                        <span style="width:264px;margin-left:5px;float:left">
                                                        <select>{html_options options = $banner.info.page_list}</select>
                                                        </span>
                                                     </p>
                                                </div>
                                                <div class="clearthis"></div>
                                                <div class="tbl-info-banner-bottom-a sub-partner-all-b">
                                                    <ul class="f-left col1">
                                                        <li>
                                                            <span class="banner-left"> Status:</span>
                                                            <a href="?module=banner&action=agent-active&id={$banner.info.banner_id}">
                                                                          {if $banner.info.agent_status == 1}
                                                                                <span class="banner-a banner-right">Enabled</span>
                                                                            {else}
                                                                                <span class="banner-a banner-right">Disabled</span>
                                                                          {/if}
                                                            </a>
                                                        </li>
                                                    </ul>

                                                    <ul class="f-left col2">
                                                        <li>
                                                            {if $banner.info.check_all_page == 1 && $banner.info.pay_status != 2}
                                                                <a href="javascript:void(0)" onclick="return showMess('Please contact admin complete payment !')" style="color:#990000; text-decoration:none"><span class="banner-a banner-left">Edit</span> </a>
                                                                    {else}
                                                                <a href="?module=banner&action=edit-advertising&id={$banner.info.banner_id}"
                                                                style="color:#990000; text-decoration:none"><span class="banner-a banner-left">Edit</span></a>
                                                            {/if}
                                                              <a href="javascript:void(0)" onclick="return show_confirm('/?module=banner&action=my-banner&banner_id={$banner.info.banner_id}','Do you really want to delete this banner ?');" style="color:#990000; text-decoration:none" ><span class="banner-a banner-right">Delete</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                         </div>
                                    </div>
                                <div class="div-cms-landing-bottom div-cms-landing-top" style="margin-left: -6px;"></div>
                                <div class="clearthis"></div>
                            </div>
                        </li>
                            
                     {/if}  <!-- End Banner Display = Left -->
                     
                	{/foreach}
               {else}
               		There is no data.
               {/if}
             
            </ul>
        </div>
        
       
        
        {$pag_str}
    </div>
</div>
