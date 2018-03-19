<div class="advertisement-box">
    <ul class="adv-list" style="text-align: center;">
         {foreach from=$rowbanner item=rowbanner}
             {if !($rowbanner.banner_id == 72)}
                <li>
                   <a href="{php}echo shortUrl(array('module' => 'general', 'action' => 'counter-banner', 'id' => $this->_tpl_vars['rowbanner']['banner_id']));{/php}" target="_blank">
                        <img src="{$MEDIAURL}/store/uploads/banner/images/{$rowbanner.file}" style="max-width:280px;" alt="" />
                   </a>
                </li>
            {else}
                 <li>
                      <a href="/?module=property&action=view-tv-show" target="_self">
                         <img src="{$MEDIAURL}/store/uploads/banner/images/{$rowbanner.file}" style="max-width:280px;" alt="" />
                      </a>
                 </li>
            {/if}
         {/foreach} 
    </ul>
</div>
