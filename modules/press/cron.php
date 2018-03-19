<?php

    include_once ROOTPATH.'/modules/press/inc/press.php';
    include_once ROOTPATH.'/modules/facebook-twitter/inc/fb.facebook.class.php';
    include_once ROOTPATH.'/modules/facebook-twitter/inc/twitter.class.php';

    if (!isset($fb_cls) || !($fb_cls instanceof Facebook)) {
        $fb = array('appId' => $config_cls->getKey('facebook_application_api_id'),
                    'secret' => $config_cls->getKey('facebook_application_secret'));
        $fb_cls = new Facebook($fb);
    }

    //POST ENTRY TO FACEBOOK, TWITTER
    $fb_info = array('uid'=>$config_cls->getKey('facebook_fanpage_id'),
                      'token'=>$config_cls->getKey('facebook_fanpage_token'));

    $rows = $press_article_cls->getRows('SELECT pa.press_id,
                                                pa.seo_url,
                                                pa.title,
                                                pa.content,
                                                pa.publish_facebook,
                                                pa.publish_twitter
                                         FROM '.$press_article_cls->getTable()." AS pa
                                         WHERE pa.active = 1
                                               AND pa.show_date <= '".date('Y-m-d H:i:s')."'
                                               AND pa.scan = 0
                                               ",true);
    // AND pa.show_date BETWEEN ('".date('Y-m-d H:i:s')."' + INTERVAL 3 MINUTE AND '".date('Y-m-d H:i:s')."' - INTERVAL 3 MINUTE)

    if (is_array($rows) and count($rows) > 0){
       foreach ($rows as $row){
           $url = ROOTURL.'/press/'.$row['seo_url'].'.html';
           $row['image'] = Press_getImageFromHTML($row['content']);
           $photo = $row['image'] != null?$row['image'][0]:ROOTURL.'/modules/general/templates/images/ibb-logo.png';

           if ($row['publish_facebook'] == 1){
               $content = array('message' => '',
                                'name' => $row['title'],
                                'caption' => ROOTURL,
                                'link' => $url,
                                'description' => strip_tags($row['content']),
                                'picture' =>$photo);

               $fb_cls->postFull($content,$fb_info);
               $press_article_cls->update(array('scan'=>1),'press_id = '.$row['press_id']);
           }
       }
    }
?>