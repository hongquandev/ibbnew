{literal}
    <link rel="stylesheet" type="text/css" href="modules/general/templates/style/faq_style.css" />
    <script src="modules/faq/js/drop_list.js" type="text/javascript"> </script>

{/literal}

<div class="container-l">
    <div class="container-r">
        <div class="container">
            <div class="main">          
                <div class="cms">

                    <h3>FAQ</h3>      
                    
                    <div class="sub-nav2">

                        <div class="subnav-center">
                            <div class="subnav-content" style="float:left; width:200px; margin-top:60px;" >
                                {$top_menu}
                            </div>
                        </div>    
                        <div id="content">
                            <h2>{$site_title_config} FAQ </h2>

                            <!-- <div style="float:left;" id="img1" >
                            {$top_menu2}
                    </div> -->

                        </div>
                    </div>      
<div  >
                        
                        {include file = "`$ROOTPATH`/modules/general/templates/mobile/quicksearch.tpl"} 
                            
                        <div class="advertisement-box">
                            <ul class="adv-list">
                                {foreach from=$rowbanner item=rowbanner}
                                    <li>            	 
                                        <a href="/?module=general& action=counter-banner& id={$rowbanner.banner_id}" target="_blank">
                                            <img src="store/uploads/banner/images/{$rowbanner.file}" width="280" alt="" />
                                        </a> 					  		 
                                    </li>
                                {/foreach}
                            </ul>
                        </div> 
                    </div>
                </div> 
                <div class="clearthis"> </div>

            </div>
        </div>
    </div>
</div>