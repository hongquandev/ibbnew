<?php
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
include_once ROOTPATH.'/modules/facebook-twitter/inc/fb.facebook.class.php';
include_once ROOTPATH.'/modules/configuration/inc/configuration.php';

//prepare update
	$form_data = $press_article_cls->getFields();
	$form_data[$press_article_cls->id] = getParam('id',0);
    $row = $press_article_cls->getRow('press_id ='.$form_data[$press_article_cls->id]);
    if (is_array($row) and count($row) > 0){
        $form_data = $row;
    }
    if ($form_data['show_date'] == '0000-00-00 00:00:00' || $form_data['show_date'] == ''){
            $form_data['show_date'] = date('Y-m-d H:i:s');
    }

	if($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (isset($_POST['fields'])) {
		    if (is_array($_POST['fields']) and count($_POST['fields']) > 0) {
                foreach ($form_data as $key => $val) {
                    if (isset($_POST['fields'][$key])) {
                        $data[$key] = $press_article_cls->escape($_POST['fields'][$key]);
                    }else{
                      unset($data[$key]);
                    }
                }
            }
            $data['active'] = isset($_POST['fields']['active'])?1:0;
            $data['publish_facebook'] = isset($_POST['fields']['publish_facebook'])?1:0;
            $data['publish_twitter'] = isset($_POST['fields']['publish_twitter'])?1:0;
			$data['content'] = scanContent($data['content']);

            //tag
            $data['tag'] = explode(',',$data['tag']);
            array_walk($data['tag'],'trim_arr');
            $data['tag'] = implode(',',$data['tag']);

            if ($form_data[$press_article_cls->id] > 0){//update
                $data['modified_date'] = date('Y-m-d H:i:s');
			    $press_article_cls->update($data,'press_id ='.$form_data[$press_article_cls->id]);
                $message = $session_cls->setMessage('Edited successful');
                $status_label = 'UPDATE';
            }else{
                $data['creation_date'] = date('Y-m-d H:i:s');
			    $press_article_cls->insert($data);
                $message = $session_cls->setMessage('Added successful');
                $status_label = 'INSERT';
                $form_data[$press_article_cls->id] = $press_article_cls->insertId();
            }
            $seo_url = Press_SEO($form_data[$press_article_cls->id]);

            //post facebook
            $current = new DateTime(date('Y-m-d H:i:s'));
            $show_date = new DateTime($data['show_date']);
            if ($form_data['publish_facebook'] == 0 && $data['publish_facebook'] == 1 && $current > $show_date && $form_data['scan'] == 0){
                if (!isset($fb_cls) || !($fb_cls instanceof Facebook)) {
                    $fb = array('appId' => $config_cls->getKey('facebook_application_api_id'),
                                'secret' => $config_cls->getKey('facebook_application_secret'));
                    $fb_cls = new Facebook($fb);
                }


                //POST ENTRY TO FACEBOOK, TWITTER
                $fb_info = array('uid'=>$config_cls->getKey('facebook_fanpage_id'),
                                 'token'=>$config_cls->getKey('facebook_fanpage_token'));

                $url = ROOTURL.'/press/'.$seo_url.'.html';
                $image = Press_getImageFromHTML($data['content']);
                $photo = $image != null?$image[0]:ROOTURL.'/modules/general/templates/images/ibb-logo.png';

                $content = array('message' => '',
                                'name' => formUnescape($data['title']),
                                'caption' => ROOTURL,
                                'link' => $url,
                                'description' => strip_tags(formUnescape($data['content'])),
                                'picture' =>$photo);

                $fb_cls->postFull($content,$fb_info);
                $press_article_cls->update(array('scan'=>1),'press_id = '.$form_data[$press_article_cls->id]);
            }
            //end

			$smarty->assign('message', $message);
	    }
        $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									  'Action' => $status_label,
									  'Detail' => $status_label." PRESS POST:". $data['title'],
									  'UserID' => $_SESSION['Admin']['EmailAddress'],
									  'IPAddress' =>$_SERVER['REMOTE_ADDR']));
        if ($_POST['track'] == 1) {
            redirect(ROOTURL . '/admin/?module=press&action=add-article&token=' . $token);
        } else {
            redirect(ROOTURL . '/admin/?module=press&action=edit-article&id=' . $form_data[$press_article_cls->id] . '&token=' . $token);
        }
    }

$smarty->assign(array('options_category'=>Press_getCategory(array(0=>'Select...')),
                      'form_data'=>formUnescapes($form_data)));
function trim_arr(&$val){
    $val = trim($val);
}
?>