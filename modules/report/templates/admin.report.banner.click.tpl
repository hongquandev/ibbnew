<script type="text/javascript">
var report = new Report('');
</script>
<div>
	<div style="float:left"><h1>{$title}</h1></div>
    <div style="float:right">
        <select name="year" id="year" class="input-select" style="width:100%" onchange="report.redirect('{$link_view}&year='+this.value)">
            {html_options options = $year_options selected = $year}
        </select>
    </div>
    <br clear="all"/>
</div>
{if is_array($month_ar) and count($month_ar) > 0}
	<table class="report_grid" width="100%" style="margin-top:10px">
    	<tr>
        	<td>Month</td>
        {foreach from = $month_ar key = i item = month}
        	<td>{$month}/{$year}</td>
        {/foreach}
    	</tr>
        
    	<tr>
        	<td>Click</td>
        {foreach from = $data_ar key = i item = data}
        	<td>{$data}</td>
        {/foreach}
    	</tr>
    </table>    
{/if}
