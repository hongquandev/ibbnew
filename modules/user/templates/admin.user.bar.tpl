<ul>
	<li class="title">User information</li>
    {if $action == 'myaccount'}
    <li class="select">My account</li>
    {else}
    <li class="select">User detail</li>   
    <li onclick="document.location='?module=user&token={$token}'">User list</li>  
    {/if}
</ul>