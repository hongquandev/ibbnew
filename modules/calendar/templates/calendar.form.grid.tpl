{if is_array($rows) and count($rows) > 0}
	{foreach from = $rows key = i item = row}
        <tr>
            <td style='text-align:center'>{$i+1}</td>
            <td>{$row.begin_date}<br/><span style='margin-left:20px'>{$row.begin_time}</span></td>
            <td>{$row.end_date}<br/><span style='margin-left:20px'>{$row.end_time}</span></td>
            <td style='text-align:center'>
                <a href='javascript:void(0)' onclick='editNoteTime("{$row.calendar_id}")'>edit</a> 
                - <a href='javascript:void(0)' onclick='deleteNoteTime("{$row.calendar_id}")'>delete</a>
            </td>
        </tr>
     {/foreach}   
{/if}
