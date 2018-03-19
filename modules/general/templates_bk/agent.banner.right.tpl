<div class="advertisement-box">
    <ul class="adv-list">
    	
             {foreach from=$rowbanner item=rowbanner}
                    <li>    
                          <a href="?module=general& action=counter-banner& id={$rowbanner.banner_id}" target="_blank">
                             <img src="{$MEDIAURL}/store/uploads/banner/images/{$rowbanner.file}" width="280" alt="" />
                           </a>
                    </li>
             {/foreach} 
         
    </ul>
</div>

