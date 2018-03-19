<?php
if (!isset($config_cls) || !($config_cls instanceof Config)) {
    $config_cls = new Config();
}
/*Include Facebook*/
include_once ROOTPATH . '/modules/facebook-twitter/inc/fb.facebook.class.php';
if (!isset($fb_cls) || !($fb_cls instanceof Facebook)) {
    $fb = array('appId' => $config_cls->getKey('facebook_application_api_id'),
        'secret' => $config_cls->getKey('facebook_application_secret'));
    $fb_cls = new Facebook($fb);
}
$fb_info = array('uid' => $config_cls->getKey('facebook_fanpage_id'),
    'token' => $config_cls->getKey('facebook_fanpage_token'));

/*Include Twitter*/
include_once ROOTPATH . '/modules/facebook-twitter/inc/twitter.class.php';
define("CONSUMER_KEY", "yourconsumerkey");
define("CONSUMER_SECRET","yourconsumerscretkey");
define("OAUTH_TOKEN", "oauthtoken");
define("OAUTH_SECRET", "oauthsecret");
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
$content = $connection->get('account/verify_credentials');
$connection->post('statuses/update', array('status' => 'twit with http://designspicy.com - say hello'));
/*Include Instagram*/

/*BEGIN POST PROPERTY*/
function postPropertyToSocial($content_ar){
    global $fb_cls, $fb_info;
    try {
        $fb_cls->postFull($content_ar, $fb_info);

    } catch (Exception $er) {
        echo $er;
    }
}

