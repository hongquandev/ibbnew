{literal}
        <script type="text/javascript">
            replaceCufon('lightbox-cufon');
        </script>
{/literal}
{*<h2 class="lightbox-cufon lightbox-vm-h2">iBB Ratings</h2>*}
{*<div class="lightbox-vm-col1">
	<div>
        <h3>Livability Rating</h3>
        <span>{$info.livability_mark}</span>
    </div>
    <div class="clearthis"></div>
    <ul>
        {if isset($info.livability) && count($info.livability) > 0}
            {foreach from = $info.livability key = k item = row}	
                  <li>{$row.title}: {$row.value}</li> 
            {/foreach}
        {/if}
    </ul>
</div>*}
<div class="lightbox-vm-col2">
	<div>
        <h3>iBB Sustainability</h3>
        <span>{$info.green_mark}</span>
     </div>
     <div class="clearthis"></div>
     <ul>
        {if isset($info.green) && count($info.green) > 0}
            {foreach from = $info.green key = k item = row}              
                  <li>{$row.title}: {$row.value}</li>        
            {/foreach}
        {/if}
	</ul>
</div>
<div class="clearthis"></div>
