<div class="container-l">
	<div class="container-r">
		<div class="container">
        
         {if isset($cms_row) and is_array($cms_row) and count($cms_row)>0}
			<div class="main">
           
                    <div class="cms">
                        {if is_array($cms_row) and count($cms_row)>0}
                        	 <h3>FAQ</h3>
                            {foreach from = $cms_row key = k item = data}
                             <p style="margin-bottom:3px;"> <a href="#{$data.title}" name="{$data.title}"> <strong> Q : {$data.title} </strong> </a> </p> 
                                 
                            {/foreach}   
                            
                            {foreach from = $cms_row key = k2 item = data2}
                            
                            <div>
                            	<p style="padding-top:20px;"> <a name="{$data2.title}" id="{$data2.title}" > <strong> Q : {$data2.title}</strong> </a> </p>
                                <p style="padding-top:5px; padding-bottom:5px;"> {$data2.content} </p>
                                <p style="margin-left:400px; margin-top:10px;"> <a href="#"> Top page </a> </p>
                            </div>
                            {/foreach}
                            
                       {/if}         
                     </div> 
              {/if}   
                <div class="clearthis"> </div>
                    
			</div>
		</div>
	</div>
</div>