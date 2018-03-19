<li {if $i1==1} class="first" {/if}>
    <div class="item">
        <div class="f-left info" >
            <div class="title">
                <span class="f-left">{$property.info.title}</span>
                <span class="f-right">{$property.info.price}</span>
                <div class="clearthis"></div>
            </div>
        
            <div class="sr-new-info">
                <div style="margin-top:-3px;">
                    <p>
                        <span style=""> Company Register: {$partner.info.firstname} </span>
                        <span style="float:right"> Date Register : {$partner.info.creation_time|date_format:"%d %B %Y"} </span>
                    </p>
                </div>
                <div style="margin-top:3px">
                    <p>
                       Views : {$partner.info.views} 
                       Click : {$partner.info.clicks} 
                    </p>
                </div>
            </div>
            <div class="desc" style="min-height:80px;">
                <p class="address-bold"> {$partner.info.postal_address} </p>
                <p style="margin-top:10px;"> {$partner.info.description} </p>
            </div>
        
        
            <div class="tbl-info" style="margin-top:0px;">
                <ul class="f-left col1">
                   <li>
                        <span> Debit Card</span> <span class="spxgreen2" style="float:right">
                            {if $partner.info.debit_card == 1}
                            	Yes
                            {else}
                            	No
                            {/if}
                        </span>
                    </li>
                </ul>
                <ul class="f-left col2">
                    <li>
                        <span>Contact References</span> <span class="spxgreen2" style="float:right">
                             {if $partner.info.contact_references == 1}
                                Yes
                            {else}
                                No
                            {/if}
                        </span>
                    </li>
                </ul>
                <div class="clearthis"></div>
            </div>

            <div class="clearthis"></div>
        </div>
        
        <div class="f-right" style="">
            <div class="img-partner">
                <img  src="store/uploads/banner/images/{$partner.info.banner_file}" class="watermark" 
                        alt="{$partner.info.banner_file}" />                                
            </div>
              
        </div>
            
        <div class="sr-new-action" style="position:relative;">
        </div>
        <div class="clearthis"></div>
    </div>
</li>


