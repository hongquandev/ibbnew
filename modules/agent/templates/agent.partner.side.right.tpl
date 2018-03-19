<div class="refine-search-box">
<div class="title">
    <h3>MY ACCOUNT</h3>
</div>
<div class="form">
    <ul class="myaccount-nav">
        <li>
            <a href="/?module=agent&action=view-dashboard">Control Centre</a>
        </li>
        <li>
            <a href="/?module=agent&action=edit-account">Change My Password</a>
        </li>
        <li>
            <a href="/?module=agent&action=edit-personal">My Company Details </a>
        </li>
          <li>
            <a href="/?module=agent&action=edit-company">My Company Information </a>
        </li>
         <!-- <li>
        <li>
            <a href="?module=agent&action=edit-lawyer">My Lawyers Information</a>
        </li>
            <a href="?module=agent&action=edit-contact">My Property Contact Details</a>
        </li> -->
          <li>
            <a href="javascript:void(0)" onclick="check.regPro('?module=banner&action=add-advertising','banner')">Register Banner Advertising </a>
        </li> 
       {* <li>
            <a href="/?module=agent&action=view-creditcard">My Credit Card Details</a>
        </li>*}
        <li>
            <a href="/?module=agent&action=view-message">My Messages <span class="new-messages">({if isset($rights.num_unread)}{$rights.num_unread}{else}0 {/if} New messages)</span></a>
        </li>
        
       
        {*if $authentic.type == 'vendor'*}
        <li>
            <a href="/?module=agent&action=view-report">My Reports </a>
        </li>
        {*/if*}
    </ul>
</div>
<div class="bg-bottom">
</div>
</div>
  	

