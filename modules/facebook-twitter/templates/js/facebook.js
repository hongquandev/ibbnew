var Facebook = function(action,logout_url,fb_id){
    this.action = action;
    this.logout_url = logout_url;
    this.fb_id = fb_id;
}
Facebook.prototype = {
    addAccount: function(){
      FB.getLoginStatus(function(response) {
          if (response.status === 'connected' || response.status === 'not_authorized') {
                 FB.logout(function(response) {
                     // user is now logged out
                 });
          }
      });
      FB.login(function(response) {
             if (response.authResponse) {
                 alert('log in');
                 /*var url = '/modules/agent/action.php?action=add_another_fb';
                 $.post(url,{},function(data){
                        *//*var result = jQuery.parseJSON(data);
                        if (result.success){
                            $('#fb_noacc').html(result.html);
                        }else{
                            showMess('Error when process. Please try again !');
                        }*//*
                        if (data != ''){
                             $('#fb_noacc').html(data);
                        }
                         },'html');*/
             } else {
                 //user cancelled login or did not grant authorization
             }
       }, {scope:'email,user_birthday,status_update,offline_access'});
    }
}
