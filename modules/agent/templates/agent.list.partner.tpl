<div class="bar-title">
    <h2>LOCAL SERVICES</h2>
</div>
<div class="ma-info mb-20px">
    <div class="col2-set mb-20px">
        <div class="col">
			{if isset($data) and count($data) > 0}
            	{foreach from = $data key = k item = row}
                <p>{$row.firtname} {$row.lastname}</p>
                {/foreach}
                
                <div>{$pag_str}</div>
          	{else}
            	Empty data.
            {/if}
        </div>
        <div class="clearthis">
        </div>
    </div>
</div>