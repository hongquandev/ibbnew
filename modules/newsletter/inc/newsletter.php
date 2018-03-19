<?php
include_once 'newsletter.class.php';
include_once ROOTPATH.'/modules/general/inc/sendmail.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
if (!isset($newsletter_cls) || !($newsletter_cls instanceof Newsletter)) {
	$newsletter_cls = new Newsletter();
}

	function MailOption(){
        $option_ar = array('item_0' => 'Email All',
                          /* 'item_1'=>'Vendors',
                           'item_2'=>'Buyers',
                           'item_3'=>'Partners',
                           'item_4'=>'Customize'*/

        );
        foreach (AgentType_getOptions_(false) as $k=>$row){
            $option_ar['item_'.$k] = $row;
        }
        $option_ar['item_-1'] = 'Customize';
       /*foreach ($option_ar as $_option_ar){
            $selected = ($option == $_option_ar)?' selected':'';
            $onclick = ($_option_ar == 'Customize')?'onclick="showCustomize()"':'';
            $options_ar .= '<option value="'.$_option_ar. '"'.$selected.' '.$onclick.'>'.$_option_ar.'</option>';

        }*/
        //return $options_ar;
        return $option_ar;

    }

    function sendMail_newsletter($to,$field,$subject,$content,&$msg){
        include_once ROOTPATH.'/includes/class.phpmailer.php';
        include_once ROOTPATH.'/modules/general/inc/bids.php';
        global $config_cls,$log_cls;
        $nd = '<h5 style="font-weight: normal; font-size: 14px; color: #2f2f2f;">
                    </h5>
                    <h3 style="font-size: 14px;"> '.SITE_TITLE.' Newsleter </h3>

                        '.$content.'
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
			 ';
		$radd = $config_cls->getKey('general_contact_email');

        sendEmail_func($radd,$to[$field],$nd,$subject);
        include_once ROOTPATH.'/modules/general/inc/email_log.class.php';
        if (!isset($log_cls) || !($log_cls instanceof Email_log)) {
            $log_cls = new Email_log();
        }
        $log_cls->createLog('newsletter');
    }

?>
