<ul>
	<li class="title">Cms information</li>
    {if $action == 'addpage'}
		<li class="select">Add new cms</li> 
    {elseif $action == 'edit'}   
    	<li class="select">Update cms</li>
    {/if} 
    <li onclick="document.location='{$url}'">List cms page</li>  
</ul>
