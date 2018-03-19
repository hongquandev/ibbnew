{literal}
<style type="text/css" media="all" >

/*.auctions-box .auctions-list .auction-item  {
	background: url('modules/general/templates/images/bg-search.jpg') no-repeat scroll 0 0 transparent;
	height: 295px;
	padding: 5px;
	/*position: relative;*/
	/*width: 191px;
	margin-bottom:20px;*/
}

.sr-new-info {
    margin-left: 0;
    margin-top: 12px;
    right: 0;
}

.auctions-box .auctions-list ul li.lis li {
    display: inline-block;
    margin: 0px 1px;
}
.auctions-box .auctions-list ul li.lis{display: inline-block;;margin-right:8px;}
.tbl-info .col1 li {
 	/*background-color: #D9D9D9 *; */
    margin: 1px 0;
    padding: 4px 5px;
}
.tbl-info .col1 {
    list-style: none outside none;
    margin-right: 1px;
    width: 190px;
}

.tbl-info .col2 {
    list-style: none outside none;
	margin-right: 1px;
    width: 190px;
}
.sr-new-action {
    bottom: 0;
    margin-top: 57px;
    right: 0;
	position:inherit;
}

/*.f-left, .left {
    float: none !important;
}*/
/*.tbl-info {
    margin-top: 56px;
    position: relative !important;
    right: 0;
}
*/
.auctions-box .auctions-list .auction-item .auc-img {
    margin: 3px auto !important;
    text-align: center;
}
#st1 {
	margin-bottom:4px;
}
#st2 {

}
/*
.btn-wht {
	border: medium none;
}
.btn-wht {
	border-bottom-style:none;
	border-bottom-width:medium;
	border-color:initial;
	border-left-style:none;
	border-left-width:medium;
	border-right-style:none;
	border-right-width:medium;
	border-top-style:none;
	border-top-width:medium;
	height:24px !important;
	padding-top:3px;
}*/
.mau {
background: url("modules/general/templates/images/list_selected_search.png") no-repeat scroll 0 0 transparent;
width:17px;
height:14px;
border:none;

}
.btn-wht-auc-grid{
    margin-top:0px !important;
    margin-left:0px !important;
}
.auctions-box .bar-title .bar-filter {
    width:160px !important;
}


</style>

{/literal}
{literal}
<script language="javascript">
	function ActionChange(id)
	{				
		var d = document.getElementById('cv').value;
		//alert(d);

		document.getElementById('frmSearch').action = '?module=property&action=search&state_code='+d;
		return document.frmSearch.submit();
	}
	
	function ActionChange()
	{
        document.getElementById('frmSearch').action = '?module=property&action=search';
		return document.frmSearch.submit();
	}
	function ActionAdvanceSearch()
	{				

        document.getElementById('frmSearch').action = '?module=property&action=search-auction';
		return document.frmSearch.submit();
	}
    function OrderSearch(combo,action)
    {
        //alert(combo.value);
        document.getElementById('order_by').value = combo.value;
        document.getElementById('frmSearch').action = '?module=property&action='+action+'&mode=grid';
        return document.getElementById('frmSearch').submit();
    }
    function OrderChangeStateCode(combo)
    {
        //alert(combo.value);
        document.getElementById('order_by').value = combo.value;
        var d = document.getElementById('cv').value;
        document.getElementById('frmSearch').action = '?module=property&action=search&state_code='+d+'&mode=grid';
        return document.getElementById('frmSearch').submit();
    }
</script>  
	
{/literal}
<div class="auctions-box">
    <div class="bar-title">
        <h2>SEARCH RESULTS</h2>
        <div class="bar-filter">
            	{if isset($state_code)}
                <div class="input-box-search-grid">
                        <select name="search[order_by]" onchange="OrderChangeStateCode(this)";>
                                {html_options options=$search_data.order_by selected =$form_data.order_by}
                         </select>
                </div>
                <input type="hidden" name="cv" id="cv" value="{$sate_code}" />
                	<div class="view-search-grid" id="fixhd1">
                          <span> View as : </span>
                            <div style="float:left;margin-right:5px;">
                                 <a href="javascript:void(0)" onclick="return ActionChange(); " style="color:#666666">
                                        <img src="'../../modules/general/templates/images/list_up.png" style="margin-left:5px;"/>    
                                 </a>
                                 <a href="/?module=property&action=search&state_code={$state_code}&mode=grid" style="color:#666666">
                                      <img src="'../../modules/general/templates/images/grid_selected.png" style="margin-left:5px;" />    
                                 </a>
                             
                                
                            </div>
                     </div>       
                	{elseif $action == 'search-auction'}
                        <div class="input-box-search-grid">
                            <select name="search[order_by]" onchange="OrderSearch(this,'search-auction')";>
                                 {html_options options=$search_data.order_by selected =$form_data.order_by}
                            </select>
                        </div>
                    	<div class="view-search-grid" id="fixhd1">
                            <span> View as : </span>
                                <div style="float:left;margin-right:5px;">
                                     <a href="/?module=property&action=search-auction" style="color:#666666">
                                             <img src="'../../modules/general/templates/images/list_up.png" style="margin-left:5px;"/>      
                                     </a>
                                     <a href="javascript:void(0)" onclick="return ActionAdvanceSearch();" style="color:#666666">
                                           <img src="'../../modules/general/templates/images/grid_selected.png" style="margin-left:5px;" />     
                                     </a>
                                      
                                </div>
                        </div>
                    {elseif $action == 'search-sale'}
                        <div class="input-box-search-grid">
                            <select name="search[order_by]" onchange="OrderSearch(this,'search-sale')";>
                               {html_options options=$search_data.order_by selected =$form_data.order_by}
                            </select>
                        </div>
                    	<div class="view-search-grid" id="fixhd1">
                            <span> View as : </span>
                                <div style="float:left;margin-right:5px;">
                                     <a href="/?module=property&action=search-sale" style="color:#666666">
                                             <img src="'../../modules/general/templates/images/list_up.png" style="margin-left:5px;"/>   
                                     </a>
                                    <a href="/?module=property&action=search-sale&mode=grid" style="color:#666666">
                                          <img src="'../../modules/general/templates/images/grid_selected.png" style="margin-left:5px;" />  
                                     </a>
                                </div>
                          </div>
                    {else}
                         <div class="input-box-search-grid">
                            <select name="search[order_by]" onchange="OrderSearch(this,'search')";>
                                {html_options options=$search_data.order_by selected =$form_data.order_by}
                            </select>
                        </div>
                    	<div class="view-search-grid" id="fixhd1">
                            <span> View as : </span>
                            <div style="float:left;margin-right:5px;">
                                 <a href="javascript:void(0)" onclick="return ActionChange();" style="color:#666666">
                                        <img src="'../../modules/general/templates/images/list_up.png" style="margin-left:5px;"/>   
                                 </a>
                                 <a href="/?module=property&action=search&mode=grid" style="color:#666666">
                                     <img src="'../../modules/general/templates/images/grid_selected.png" style="margin-left:5px;" />   
                                 </a> 
                            </div>
                        </div>
                  
                {/if}
              
                <span style="color:#CCCCCC" id="fixhd2">{$review_pagging}</span>
        </div>
            <div class="clearthis"></div>
    </div>
    
    <div class="auctions-list">
        <ul>
            {if isset($results) and is_array($results) and count($results)>0}
                 	{assign var = i1 value = 0}
                    	<!-- Duc Coding -->
        	 		{assign var = isearch value = 0}
                    {assign var = jsearch value = 0}
                    {assign var = pid value = $pid}		
                	{foreach from = $results key = k item = property}
                     <!-- Assign And Count -->
                    {assign var = isearch value = $isearch+1}                        				 
                    {assign var = i1 value = $i1+1}            		
                        <li class="lis">
						
                            <div class="auction-item">
                                   <div class="title">

                                        	{if $property.info.auction_sale == 9}
                                            <span class="f-left" style="padding-left:5px;padding-top:3px; color:#980000">AUCTION: {$property.info.end_time|date_format:"%d %B %Y"}</span>
                                            {/if}
                                            {if $property.info.auction_sale == 10}
                                            <span class="f-left" style="padding-left:5px;padding-top:3px; color:#980000"> SALE: {$property.info.suburb}</span>
                                            {/if}
                                          <!-- <span style="float:left; margin-left:5px;">  ID : {$property.info.property_id} </span> -->



                                       <div class="clearthis"></div>

                                       <div style="padding-left:5px;float:left;">
                                             <span>ID : {$property.info.property_id}</span>
                                       </div>
                                       <div class="detail-icons" style="float:right;padding-right:8px;">
                                                <span class="bed icons">{$property.info.bedroom_value}</span>
                                                <span class="bath icons">{$property.info.bathroom_value}</span>
                                                <span class="car icons">{$property.info.carport_value}</span>
                                  	   </div>

  									  
                                    </div>
                                    <div class="clearthis"></div>
                                    <div class="auc-img">
                                      {if isset($property.photos) and is_array($property.photos) and count($property.photos)>0}
                                        <script>
                                        var IS_{$property.info.property_id} = new ImageShow('container_simg_{$property.info.property_id}',{$property.photos_count});
                                        </script>
                                    
                                        <div id="container_simg_{$property.info.property_id}">

                                            {assign var = i value = 1}                     
                                            {foreach from = $property.photos key = k item = row}
                                                {assign var = is_show value = ';display:none;'}
                                                {if $i==1}
                                                    {assign var = is_show value = ''}
                                                {/if}
                                                <img id="img_{$i}" src="{$row.file_name}" alt="img"  style="width:180px;height:115px{$is_show}"/>
                                                {assign var = i value = $i+1} 
                                            {/foreach}
                                        </div>

                                      <!--  <div class="toolbar-img">
                                          
                                            <span class="img-num">1/{$property.photos_count}</span>
                                          
                                            <span class="icons img-prev" onclick="IS_{$property.info.property_id}.prev()"></span>
                                            <span class="icons img-next" onclick="IS_{$property.info.property_id}.next();"></span>
                                        </div> -->

                                    {else}
                                        <div>
                                            <img src="modules/property/templates/images/search-img.jpg" alt="img" style="width:180px;height:115px"/>
                                            <div class="toolbar-img">
                                            {*
                                            <span class="img-num"></span>
                                            <span class="icons img-prev"></span>
                                            <span class="icons img-next"></span>
                                            *}
                                            </div>
                                        </div>
                                    {/if}
                                
                                    </div>

                            <div class="desc desc-auction" style="padding: 5px 5px 5px 10px; min-height: 20px; ">
                                    {$property.info.full_address} <!-- {$property.info.description} -->
                            </div>

                            <div align="center" style="position:absolute; top:218px;width:200px;">
                                   <span style="font-size:14px; color:#980000 !important ">{$property.info.price}</span>
                            </div>
                                
                            <div class="tbl-info" id="fixstrates" style="position: absolute;bottom:40px;right:10px;">
                                        <ul id="st1" class="fixstrates1">
                                            <li>
                                                <span style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-left:5px; margin-right: 28px; margin-top:1px;"> Livability Rating </span>
                                                 <span style=""> {$property.info.livability_rating_mark}</span>
                                            </li>
                                        </ul>
                                        <ul id="st2" class="fixstrates2">
                                            <li>
                                                <span style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-left:5px; margin-right: 6px; margin-top:1px;">Sustainability Rating </span>
                                                <span style="">{$property.info.green_rating_mark}</span>
                                            </li>
                                        </ul>
                                   <!-- <div class="clearthis">
                                    </div> -->
                                  		 <p style="z-index:9999;float:right; font-size:10px; margin-top:15px; color: #980000;" id="fixstopen" >
                                          Open for Inspection: {$property.o4i}
                                          <!--{$row.o4i}-->                                			
                                   		 </p>
                           
						    </div>
							
                            <div class="f-right btn-bid-wht-grid btn-search-grid" style="position: absolute;bottom:10px;width:196px;">
                                	                                    
                                    <button class="btn-wht btn-wht-auc-grid" style="float:left !important;padding-left:3px;width:117px;" onclick="pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id={$property.info.property_id}')">
                                         <span style="font-size:12px;"><span style="font-size:12px; margin-top:-5px;">Add to Watchlist </span></span>
                                    </button>
                                    {*
                                    {if $property.info.auction_sale == 9 and $property.info.dt == $property.info.start_time or $property.info.dt > $property.info.start_time}
                                        <button class="btn-view f-right btn-view-search-list" style="margin-top:7px;" onclick="document.location='{$property.info.link}'">
                                        </button>
                                    {/if}      
                                    {if $property.info.auction_sale == 9 and $property.info.dt != $property.info.start_time}
                                       <button class="btn-view f-right btn-view-search-list" style="margin-top:7px;" onclick="document.location='{$property.info.link2}'">
                                       </button>
                                    {/if}
                                    *}
                                    <button style="float: right;margin-right:3px;" class="btn-view btn-view-sale" onclick="document.location='{$property.info.link}'"></button>
                            </div>
                         
                     </div>
                      
                 </li>
                  
			
                         	{assign var = p value = $p}   
                                 
                                  {assign var = len value = $len}
                                  {assign var = total_row value = $total_row}
                                  {assign var = c  value = $len*$p }     
                                  {assign var = x value = $len_arr}                         
                               	  {if isset($check) and  $bool==true}  
                  
                                       {if $isearch % 6 == 0}
                                       <li>
                                      		{if $c == $len}
                                            	
                                         	   {assign var = arr2 value = $arr[$jsearch]}
                                          	 
                                          	   {assign var = jsearch value = $jsearch+1}  

                                                 {if $x==1}
                                                 
                                                      {assign var = xsearch value = $pid-1}
                                                      {assign var = jsearch value = $jsearch+1}                   
                                              		  {assign var = arr2 value = $arr[$xsearch]} 
                                              	    
                                                      {assign var = pid value = $pid+1}                      
                                                 	       		                                                	
                                     			{/if}  
                                                
                                                {if $p==1} 
                                                	  {if $len_arr>0}                                             		
                                                          {assign var = xsearch value = $pid%$len_arr}  
                                                          {assign var = jsearch value = $jsearch+1}                   
                                                          {assign var = arr2 value = $arr[$xsearch]} 
                                                          {include file = "`$ROOTPATH`/modules/banner/templates/adbanner.tpl"}		 
                                                          {assign var = pid value = $pid+1}   
                                                      {/if}            
                                                {/if}   
                                                   
                                  			{/if}
                                            
                         			
                                         
                                        {if $c > $len}
                                        
                                                  {if $len_arr>0}                                    
                                                      {assign var = xsearch value = $pid%$len_arr}                                        		
                                                      {assign var = jsearch value = $jsearch+1}                   
                                                      {assign var = arr2 value = $arr[$xsearch]} 
                                                      {include file = "`$ROOTPATH`/modules/banner/templates/adbanner.tpl"}		 
                                                      {assign var = pid value = $pid+1}   
                                                  {/if}                                                                 
                                          {/if}  
                                           
                                       {/if}  
                                                                         
                                  {else $bool==false}
                                  </li>
                                  	
                           {/if}
                           	

                	{/foreach}
               {else}
               		There is no data.
               {/if}
                 
            </ul>
     
	</div>
    <div class="clearthis"></div>
        {$pag_str}    
 </div>

