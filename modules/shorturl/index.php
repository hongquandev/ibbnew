<?php
//ini_set('display_errors', 1);
include_once ROOTPATH . '/modules/shorturl/inc/short_url.class.php';
$short_url = getParam('url', '');
if (strlen($short_url) > 0) {
    $long_url = $shortUrl_cls->getLongUrl($short_url);
    if (strlen($long_url) > 0){
        redirect(ROOTURL.''.$long_url);
    }
}
//echo $shortUrl_cls->addShortUrl('?module=1');
redirect(ROOTURL);
