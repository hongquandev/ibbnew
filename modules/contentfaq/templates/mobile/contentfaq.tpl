<link rel="stylesheet" type="text/css" href="modules/general/templates/style/faq_style.css" />
<script src="modules/contentfaq/templates/js/drop_list.js" type="text/javascript"></script>
<div class="container-l">
	<div class="container-r">
		<div class="container">
			<div class="main">
                    <div class=" cms">
                        <h3 >FAQ</h3>
						<div class="common-questions">
                            {if $action == 'faq'}
                                {include file = 'contentfaq.listfaq.tpl'}
                            {/if}
                        </div>
                    </div> 
                    <div class="clearthis"></div>
			</div>
		</div>
	</div>
</div>
   <script>
                         {literal}
         jQuery(document).ready(function(){  
               jQuery('.container-l').css('min-height', jQuery(window).height()-80);  
       });    
           
          
            {/literal} 
    </script>