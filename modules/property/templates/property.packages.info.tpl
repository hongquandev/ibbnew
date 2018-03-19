{if isset($package_data) and is_array($package_data) and count($package_data) > 0}
    {if $admin}
        <td>
             <strong id="notify_package">Auction's packages <span class="require" >*</span></strong>
        </td>
        <td>
        {foreach from = $package_data key = k item = row}
            <label for = "package_id{$row.package_id}">
                {assign var = chked value = ''}
                {if $package_id == $row.package_id}
                    {assign var = chked value = 'checked'}
                {/if}
                <input style="float: left;" type = "radio" name = "package_id[]" id = "package_id{$row.package_id}" value = "{$row.package_id}" {$chked} onClick="clickPackage(this)"/>
                <span style = "margin-left:10px;width: 251px;float: right;">{$row.title} - {$row.price}.</span>
            </label>
            <div class="clearthis"></div>
        {/foreach}
        </td>
    {else}
         <label>
             <strong id="notify_package">Auction's packages <span >*</span></strong>
         </label>
         <div class="input-box">


        {if $package_id != 0 and $pay_status == 'complete'}
           {foreach from = $package_data key = k item = row }
               {assign var = chked value = ''}
                {if $package_id == $row.package_id}
                    {assign var = chked value = 'checked'}
                    <label for = "package_id{$row.package_id}">
                        <input type = "radio" name = "package_id[]" id = "package_id{$row.package_id}" value = "{$row.package_id}" {$chked} onClick="clickPackage(this)"/>
                        <span style = "margin-left:10px">{$row.title} - {$row.price}.</span>
                    </label>
                {/if}
            {/foreach}
        {else}
            {foreach from = $package_data key = k item = row }
                    {assign var = chked value = ''}
                    <label for = "package_id{$row.package_id}">
                        {if $package_id == $row.package_id}
                            {assign var = chked value = 'checked'}
                        {/if}
                        <input style="float: left;" type = "radio" name = "package_id[]" id = "package_id{$row.package_id}" value = "{$row.package_id}" {$chked} onClick="clickPackage(this)"/>
                        <span style = "margin-left:10px;width: 251px;float: right;">{$row.title} - {$row.price}.</span>
                    </label>
                    <div class="clearthis"></div>
            {/foreach}
        {/if}
        </div>
    {/if}
{/if}
