
<script type="text/javascript" src="/modules/report/templates/js/report.js"></script>
{literal}
<script type="text/javascript">
	var report = new Report();
</script>
<script type="text/javascript">
/*function displayResult(obj)
{
  	jQuery(obj).attr('size',10);
	document.getElementById(id).size=4;
}*/
</script>
{/literal}
<link href="/modules/report/templates/style/style.css"  rel="stylesheet" type="text/css"/>

<div class="bar-title">
    <h2>MY REPORTS</h2>
    <div class="bar-filter" style="width:auto;">
    	<form name="frmReport" id="frmReport" method="post" action="{$form_action}" onsubmit="return report.isSubmit()">
             

              <div style="width:60px;float:right">
                 <select name='len' id='len' onchange="report.submit('#frmReport')" style="width:65px">
                        {html_options options = $len_ar selected = $len}
                 </select>
              </div>
                {*<span class="pagging-search-list" style="float:right">View more: </span>*}
                {if $agent.type != 'partner'}
                    <span style="width:100px;float:right;">
                        <select name="schedule" onChange="report.submit('#frmReport')" style="width:100px;">
                            {$option_year}
                        </select>
                    </span>
                {/if}
           <input type="hidden" name="is_submit" id="is_submit" value="0"/>
        </form>
    </div>
</div>

<div class="ma-info mb-20px">
    <div class="col2-set mb-20px">
        <div class="col">
            <div class="col-main myaccount">
                <span class="" style="float:right;padding-bottom:10px;">{$review_pagging}</span>
                <div class="clearthis"></div>
                <div class="ma-messages mb-20px my-report">
                    <table class="tbl-messages" cellpadding="0" cellspacing="0">

                        {if $agent.type == 'partner'}
                            <colgroup>
                                <col width="400px"/><col width="130px"/><col width="130px"/><col width="60px"/>
                            </colgroup>
                            <thead>
                                <tr>
                                    <td>Banner</td>
                                    <td align="center">Click</td>
                                    <td align="center">View</td>
                                    <td align="center">Report</td>
                                    <td align="center">Preview</td>
                                </tr>
                            </thead>
                            {if isset($banner_rows) and is_array($banner_rows) and count($banner_rows)>0}
                                <tbody></tbody>
                                    {foreach from = $banner_rows key = k item = row}
                                        <tr {if $k%2 == 1} class="read" {/if}>
                                            <td>
                                                <div id="banner_bound_{$row.banner_id}" style="width:400px;padding-left:10px;">
                                                <div id="banner_container_{$row.banner_id}" class="banner_container" style="display:none;">
                                                    <img onclick="report.closeImg('{$row.banner_id}')" id="banner_img_full_{$row.banner_id}"/>
                                                    </div>
                                                    {if $row.display == 2}
                                                    	
                                                      <img onclick="report.openImg('{$row.banner_id}')" id="banner_img_{$row.banner_id}" src="{$MEDIAURL}/store/uploads/banner/images/{$row.banner_file}" style="max-width:278px; min-height:70px;"/>
                                                    	{else}
                                                       
                                                      <img onclick="report.openImg('{$row.banner_id}')" id="banner_img_{$row.banner_id}" src="{$MEDIAURL}/store/uploads/banner/images/{$row.banner_file}" style="max-height: 200px; max-width: 280px; min-width: 280px;" />
                                                    {/if}
                                                  
                                                    
                                                </div>
                                            </td>
                                            <td align="center">{$row.clicks}</td>
                                            <td align="center">{$row.views}</td>
                                            <td align="center"><a href="{$row.url_detail}" target="_blank" >View</a></td>
                                            <td align="center"><a href="{$row.url}" target="_blank" >Link</a></td>
                                        </tr>
                                    {/foreach}
                                </tbody>
                            {/if}

                        {else}  {*property*}
                            <colgroup>
                                <col width="50px"/><col width="355px"/><col width="70px"/><col width="70px"/><col width="70px"/>
                            </colgroup>
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td align="center">Address</td>
                                    <td align="center">Bids</td>
                                    <td align="center">Views</td>
                                    <td align="center">Report</td>
                                </tr>
                            </thead>
                            {if isset($property_rows) and is_array($property_rows) and count($property_rows)>0}
                                <tbody></tbody>
                                    {foreach from = $property_rows key = k item = row}
                                        <tr {if $k%2 == 1} class="read" {/if}>
                                            <td style="padding-left:4px;">#{$row.property_id}</td>
                                            <td>{$row.title}</td>
                                            <td align="center"><a href="javascript:void(0)" onclick="showBidHistory('{$row.property_id}')">{$row.bids}</a></td>
                                            <td align="center"><a href="{$row.view_url}" target="_blank">{$row.views}</a></td>
                                            <td align="center"><a href="{$row.url}" target="_blank">View</a></td>
                                            {*<td><center><a href="javascript:void(0)" onclick="report.openWindow('{$row.url}',800,480)">View</a></center></td>*}
                                        </tr>
                                    {/foreach}
                                </tbody>
                            {/if}                                                     
                         {/if}	
                    </table>
                </div>                     
            </div>
        </div>
        <div class="clearthis"></div>
        {$pag_str}
    </div>
</div>
