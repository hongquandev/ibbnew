<div class="advertisement-box">
    <ul class="adv-list">
    {if isset($countview)}
        {foreach from=$rowbanner item=rowbanner}
            <li>
                <a href="{php}
                if ($this->_tpl_vars['rowbanner']['banner_id'] != 72) :
                	echo shortUrl(array('module' => 'general', 'action' => 'counter-banner', 'id' => $this->_tpl_vars['rowbanner']['banner_id']));
                else :
                	echo $this->_tpl_vars['ROOTURL'].'/?module=property&action=view-tv-show';
                endif;
                {/php}" target="_blank">
                    <img src="store/uploads/banner/images/{$rowbanner.file}" width="140px" alt="" />
                </a>
            </li>
        {/foreach} 
    {/if}
    </ul>
</div>

