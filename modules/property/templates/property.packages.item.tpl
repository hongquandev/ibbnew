{if isset($package_data) and is_array($package_data) and count($package_data) > 0}
	{foreach from = $package_data key = k item = row}
    	<li>
            <label for = "package_{$row.package_id}">
            	{assign var = chked value = ''}
                {if $package_id == $row.package_id}
                	{assign var = chked value = 'checked'}
                {/if}
                <input type = "radio" name = "package[]" id = "package_{$row.package_id}" value = "{$row.package_id}" {$chked} onClick="package.click(this)"/>
                <span style = "margin-left:10px;">{$row.title} - {$row.price}.</span>
            </label>
        </li>
    {/foreach}
{/if}