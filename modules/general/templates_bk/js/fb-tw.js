(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  //js.src = ROOTURL+"/modules/general/templates/js/all.js#xfbml=1& appId="+fb_id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1& appId="+fb_id;
  //js.src = "//connect.facebook.net/en_US/all.js";
  fjs.parentNode.insertBefore(js, fjs);
 }(document, 'script', 'facebook-jssdk'));
  window.fbAsyncInit = function() {
    FB.init({appId: fb_id,cookie: true,xfbml: true,oauth: true});
};

$('.fb').click(function() {FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            document.location = fb_url;
        } else if (response.status === 'not_authorized') {
            FB.login(function(response) {
                if (response.authResponse) {
                    document.location = fb_url;
                } else {
                }
            }, {scope:'email,user_birthday,status_update,offline_access'});
        } else {
            FB.login(function(response) {
                if (response.authResponse) {
                    document.location = fb_url;
                } else {
                }
            }, {scope:'email,user_birthday, status_update,offline_access'});
        }
    });
});
function loginFB() {FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            document.location = fb_url;
        } else if (response.status === 'not_authorized') {
            FB.login(function(response) {
                if (response.authResponse) {
                    document.location = fb_url;
                } else {
                }
            }, {scope:'email,user_birthday,status_update,offline_access'});
        } else {
            FB.login(function(response) {
                if (response.authResponse) {
                    document.location = fb_url;
                } else {
                }
            }, {scope:'email,user_birthday, status_update,offline_access'});
        }
    });
};
(function(jQuery) {
    jQuery.oauthpopup = function(options) {
        options.windowName = options.windowName || 'ConnectWithOAuth'; // should not include space for IE
        options.windowOptions = options.windowOptions || 'location=0,status=0,width=800,height=400';
        /*options.callback = options.callback || function() {
            window.location.reload();
        };*/
        var that = this;

        that._oauthWindow = window.open(options.path, options.windowName, options.windowOptions);
        that._oauthInterval = window.setInterval(function() {
            if (that._oauthWindow.closed) {
                window.clearInterval(that._oauthInterval);
                options.callback();
            }
        }, 1000);  
    };
})(jQuery);
$('.tw').click(function() {
    $.oauthpopup({
        path: tw_url,
        callback: function() {
            window.location.reload();
        }
    });
});
 