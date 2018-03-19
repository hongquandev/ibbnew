<script type="text/javascript">
    var fb_id = '{$fb.id}';
    var fb_url = '{$fb.url}';
    {literal}
     function logIn(){
         if (!FB){
             window.fbAsyncInit = function() {
                FB.init({appId: fb_id ,cookie: true,xfbml: true,oauth: true});
             };
         }
         FB.getLoginStatus(function(response) {
              if (response.status === 'connected' || response.status === 'not_authorized') {
                    FB.logout(function(response) {
                    });
              }
         });
         FB.login(function(response) {
                 if (response.authResponse) {
                     document.location = fb_url;
                 } else {
                 }
         }, {scope:'email,user_birthday,status_update,offline_access'});
     }
     function deleteFace(){
         var url = '/modules/agent/action.php?action=delete_fb';
         $.post(url,{},function(data){
                    var result = jQuery.parseJSON(data);
                    if (result.success){
                       $('#fb_detail').html('No account facebook connected. <a class="fb-1" href="javascript:void(0)" onclick="logIn()" style="color:#990000">Add account.</a>');
                    }else{
                        showMess('Error when process. Please try again !');
                    }
                 },'html');
     }
     {/literal}
</script>
{if isset($db_facebook_data) and is_array($db_facebook_data) and count($db_facebook_data) > 0}
   <div id="fb_detail">You connected account: <span style="color:#990000">{$db_facebook_data.email_address}</span>
       <a href="javascript:void(0)" onclick="deleteFace()">(Delete)</a></div>
{else}
    <div>No account facebook connected. <a class="fb-1" href="javascript:void(0)" onclick="logIn()" style="color:#990000">Add account.</a></div>
{/if}
