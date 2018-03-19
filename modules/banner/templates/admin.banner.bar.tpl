<ul>
	<li class="title">Banner information</li>
    {if $action == 'addpage'}
		<li class="select">Add new banner</li> 
    {elseif $action == 'edit'}   
    	<li class="select">Update banner</li>
    {/if} 
    <li onclick="document.location='?module=banner&token={$token}'">Manager banners</li>  
</ul>
