<?php
include_once ROOTPATH.'/modules/facebook-twitter/inc/twitter.class.php';
include_once ROOTPATH.'/modules/configuration/inc/config.class.php';

global $config_cls;
$tw_cls = new Twitter($config_cls->getKey('twitter_consumer_key'),
                      $config_cls->getKey('twitter_consumer_secret'));
$mobile = $_GET['isMobile'];

if (isset($_GET['oauth_token'])){
    if ($_GET['oauth_token'] !== $_SESSION['oauth_token']) {
        session_unset();
        die("<script language='javascript1.2'>alert('The oauth token you started with doesn\\'t match the one you\\'ve been redirected with. do you have multiple tabs open?');window.close();</script>");
    }

    if (!isset($_GET['oauth_verifier'])) {
        session_unset();
        die("<script language='javascript1.2'>alert('The oauth verifier is missing so we cannot continue. Did you deny the application access?');window.close();</script>");
    }

    $tw_cls->setToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
    $access_token = $tw_cls->getAccessToken($_REQUEST['oauth_verifier']);

    /* Remove no longer needed request tokens */
    unset($_SESSION['oauth_token']);
    unset($_SESSION['oauth_token_secret']);

    /* If HTTP response is 200 continue otherwise send to connect page to retry */
    if (200 == $tw_cls->http_code) {
        $tw_cls->setToken($access_token['oauth_token'], $access_token['oauth_token_secret']);
        $user = $tw_cls->get('account/verify_credentials');
        $token = array('token' => $access_token['oauth_token'],
                       'token_sec' => $access_token['oauth_token_secret']);
        $tw_cls->getUser($user, $token);
    } else {
        die("<script language='javascript1.2'>alert('Have problem when authorize your account. Please try again!');window.close();</script>");
    }

}else{
    /* Get temporary credentials. */
    /*if(detectBrowserMobile() || $mobile){
        define('OAUTH_CALLBACK', ROOTURL.'/?module=agent&action=tw-info');
    }else{
        define('OAUTH_CALLBACK', ROOTURL);
    }*/
    define('OAUTH_CALLBACK', ROOTURL.'/?module=agent&action=tw-info');
    $request_token = $tw_cls->getRequestToken(OAUTH_CALLBACK);
    $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
    $url = $tw_cls->getAuthorizeURL($request_token);
    header('Location: ' . $url);
}

?>
