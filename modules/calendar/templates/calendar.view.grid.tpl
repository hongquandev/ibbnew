{if is_array($calendar_rows) and count($calendar_rows) > 0}	
	{if $mode == 'list' && ($action != 'home_auction-property' && $action != 'home_forthcoming-property' && $action != 'home_sale-property')}			
        {foreach from = $calendar_rows key = i item = row}
            <tr>
                <td align="center">{$i+1}</td>
                <td style="width:40%;">{$row.begin_date}<span style="margin-left: 10px;">{$row.begin_time}</span></td>
                <td style="width:40%;">{$row.end_date}<span style="margin-left: 10px;">{$row.end_time}</span></td>
                <td style="text-align:center">
                    <a href="{$ROOTURL}?module=calendar&action=export-calendar&calendar_id={$row.calendar_id}" target="_blank">Export</a>
                </td>
            </tr>
         {/foreach}   
    {else}
        	{foreach from = $calendar_rows key = i item = row}
            <tr>
                <td align="center">{$i+1}</td>
                <td style="width:40%;">{$row.begin_date}<br /><span>{$row.begin_time}</span></td>
                <td style="width:40%;">{$row.end_date}<br /><span>{$row.end_time}</span></td>
                <td style="text-align:center">
                    <a href="{$ROOTURL}?module=calendar&action=export-calendar&calendar_id={$row.calendar_id}" target="_blank">Export</a>
                </td>
            </tr>
         {/foreach}   
    {/if}    
{/if}