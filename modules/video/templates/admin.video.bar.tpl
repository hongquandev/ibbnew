<ul>
	<li class="title">Video information</li>
    {if $action == 'addpage'}
		<li class="select">Add new video</li> 
    {elseif $action == 'edit'}   
    	<li class="select">Update video</li>
    {/if} 
    <li onclick="document.location='{$url}'">List video page</li>  
</ul>
