{if isset($arr2)}
    <li class="img-banner-g" id="dnu-img-bans">  
    	<div class="banner-child" align="center">
            <a href="{php}echo shortUrl(array('module' => 'general', 'action' => 'counter-banner', 'id' => $this->_tpl_vars['arr2']['banner_id']));{/php}" target="_blank">
                <img src="{$MEDIAURL}/store/uploads/banner/images/{$arr2.file}" style="max-width:616px; max-height:200px "/>
            </a>  
        </div>              
    </li>      
{/if}

         
         
         