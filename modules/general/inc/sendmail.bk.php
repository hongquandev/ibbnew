<?php
# Include the Autoloader (see "Libraries" for install instructions)
require ROOTPATH .'/vendor/autoload.php';
use Mailgun\Mailgun;

function sendEmail2($from, $to, $message, $subject = SITE_TITLE)
{
    sendEmail_func($from, $to, $message, $subject);
}

function sendEmailOnly($from, $to, $message, $subject, $ban = '')
{
    sendEmail_func($from, $to, $message, $subject, $ban);
}

// Function Send Mail via a Web mail SMTP ()
function sendEmail_phpmailer($from, $to, $message, $subject, $ban = '')
{
    sendEmail_func($from, $to, $message, $subject, $ban);
}

/**
 * @ function: sendMail
 */

function sendEmail($from, $to, $message, $subject, $ban = '')
{
    sendEmail_func($from, $to, $message, $subject, $ban);
}

function sendEmail_func($from = "", $to = "", $message = "", $subject = "", $ban = '', $from_name = '', $has_content = false, $type = '', $file_att = array())
{
    //return 'send';
    global $config_cls, $email_log_system;
    require_once ROOTPATH . '/includes/PHPMailerAutoload.php';
    include_once ROOTPATH . '/modules/general/inc/email_log_system.class.php';
    if(strlen($message) > 0 && strlen($subject) > 0){}else{return false;}
    ob_start();
    $mail = new PHPMailer;
    $isSMTP_sending = (boolean)$config_cls->getKey('general_smtp_enable');
    if ($isSMTP_sending) {
        $mail->isSMTP();  // Set mailer to use SMTP
        $mail->Host = $config_cls->getKey('general_mail_host_smtp');
        $mail->SMTPAuth = true;
        //$mail->Port = 587;
        $mail->Username = $config_cls->getKey('general_mail_username_smtp');
        $mail->Password = $config_cls->getKey('general_mail_password_smtp');
        $mail->SMTPSecure = 'tls';   // Enable encryption, 'ssl'
    } else {
        $mail->isMail();
    }
    $from = ($from == "" ? $config_cls->getKey('general_contact_email') : $from);
    $from_name = ($from_name == "" ? $config_cls->getKey('general_contact_name') : $from_name);
    $mail->From = $from;
    $mail->FromName = $from_name;

    if (is_array($to) && count($to) > 0) {
        $to = array_unique($to);
        StaticsReport('email_total', count($to));
        foreach ($to as $_to) {
            $mail->addBCC($_to);
            Email_log($_to, $subject);
        }
    } else {
        StaticsReport('email_total', 1);
        $mail->addAddress($to);
    }
    // LOG EMAIL SYSTEM
    $data_email_log = array('from'=> $mail->From,'from_name' => $mail->FromName,'message' => $message,'to' => $to,'subject' => $subject);
    $email_log_system_id = $email_log_system->addLogEmail($data_email_log);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = emailTemplates($message,$to);
    if (is_array($file_att) && count($file_att) > 0) {
        if (!empty($file_att['path'])) $mail->AddAttachment($file_att['path'], $file_att['filename']);
        if (!empty($file_att['string'])) $mail->AddStringAttachment($file_att['string'], $file_att['filename']);
    }
    $mail->AltBody = 'This email is sent from Bidrhino site';
    if(strlen(trim($mail->Subject)) <= 0) return false;
    if(strlen(trim($mail->Body)) <= 0)  return false;
    /**/
    # Instantiate the client.
    $mgClient = new Mailgun('key-47ac07b7e66cc356bd8e51814b42a65d');
    $domain = "mg.bidrhino.com";
    $to_ar = (array)$to;
    if(count($to_ar) == 0){
        return false;
    }
    $to_ar_to = $to_ar[0];$to_ar_bbcs = implode(',',array_splice($to_ar,1,1));
    # Make the call to the client.
    /*$data_api = array(
        'from'    => $mail->FromName.' <'.$mail->From.'>',
        'to'      => $to_ar_to,
        'subject' => $mail->Subject,
        'text'    => 'Your mail do not support HTML',
        'html'    => $mail->Body
    );
    if(strlen(trim($to_ar_bbcs)) > 0){
        $data_api['bcc'] = $to_ar_bbcs;
    }
    $result_api = $mgClient->sendMessage($domain, $data_api );
    if($result_api->http_response_code == 200){
        $result = 'send';
        $email_log_system->update(array('status' => 1),'id='.$email_log_system_id);
    }else{
        $result = $result_api;
    }*/
    if (!$mail->send()) {
        $result = $mail->ErrorInfo;
    } else {
        $result = 'send';
        $email_log_system->update(array('status' => 1),'id='.$email_log_system_id);
    }
    ob_clean();
    return $result;
}

function sendEmail_attach($from = "", $to = "", $message = "", $subject = "", $ban = '', $file_att = array())
{
    return sendEmail_func($from, $to, $message, $subject, $ban, '', false, '', $file_att);
}

function Email_log($to, $subject)
{
    // Static Email
    $Folder_log = ROOTPATH . '/store/email_log';
    $log = $Folder_log . '/log.txt';
    if (!file_exists($Folder_log)) {
        mkdir($Folder_log, 0777);
    }
    if (!file_exists($log)) {
        $date_ = date('Y-m-d');
        $handle = @fopen($log, 'w+');
        if ($handle !== false) {
            fwrite($handle, $date_);
            fwrite($handle, "\n");
            $num = 1;
            fwrite($handle, $num);
            fclose($handle);
        }
    } else {
        $handle = @fopen($log, 'r+');
        if ($handle !== false) {
            $date_ = fgets($handle);
            //print_r('date='.$date_);
            $num = fgets($handle);
            $num = isset($num) ? $num : 0;
            //print_r('num='.$num);
            //die();
            $num = $num + 1;

            fseek($handle, 0);
            fwrite($handle, date('Y-m-d'));
            fwrite($handle, "\n");
            fwrite($handle, $num);
            fclose($handle);
        }

    }

    if (date('Y-m-d') > $date_) {
        $handle = @fopen($log, 'w+');
        if ($handle !== false) {
            $date_ = date('Y-m-d');
            fwrite($handle, $date_);
            fwrite($handle, "\n");
            $num = 1;
            fwrite($handle, $num);
            fclose($handle);
        }
    }
    // BEgin Set Log
    $file = $Folder_log . '/Log_email_' . date('Y-m-d') . '.txt';
    $f = @fopen($file, 'a+');
    if ($f == false) {
    } else {
        fwrite($f, "--------------\n");
        fwrite($f, "Email ID = $num \n");
        fwrite($f, "Subject = $subject \n");
        fwrite($f, "To = $to \n");
        fwrite($f, "Time sent =" . date('Y-m-d H:i:s') . "\n");
        fclose($f);
    }
}

/* List event:
system_service_purchased
system_property_posted
system_property_posted_to_live
system_property_changed
system_property_registered_bid
system_property_approved_bid
system_property_72hours_before_live
system_property_extended_due_to_bid_final_5_minutes
system_property_sold_or_leased
system_property_passed_in
system_property_closed_or_disabled
user_post_property_service
service_provider_user_post_property_service
service_provider_user_review_property_listing
service_provider_user_bidder_assessment
service_provider_user_select_buyer_co-ordination
service_provider_user_selected_settlement_services
service_provider_user_selected_photography_service
service_provider_user_selected_video_service
service_provider_user_selected_copywriting_service
service_provider_user_selected_floorplan_service
service_provider_user_selected_designer_service
service_provider_user_selected_full_valuation_service
service_provider_user_selected_desktop_valuation_service
service_provider_user_selected_report_service
service_provider_user_selected_suburb_report_service
service_provider_user_selected_building_inspection_service
service_provider_user_selected_marketing_plan_1_domain_service
service_provider_user_selected_marketing_plan_2_rea_service
service_provider_user_selected_marketing_plan_3_all_service
service_provider_user_selected_marketing_plan_4_rental_domain_services
service_provider_user_selected_marketing_plan_5_rental_REA_service
service_provider_user_selected_marketing_plan_6_rental_REA_service
service_provider_user_selected_HelloRE_Option_2_Open_service
service_provider_user_selected_HelloRE_Option_3_service
service_provider_user_selected_HelloRE_Option_4_service
service_provider_user_selected_an_AVR
user_select_any_purchase
user_vendor_approved_and_posted_to_live
user_bidder_register_to_bid
user_bidder_register_to_bid_bidder
user_bidder_approved_vendor_agent_to_bid
user_added_to_a_watchlist
user_added_to_a_watchlist_user
user_property_changed
user_property_changed_bidder
user_property_changed_user_in_watch_list
user_4_days_before_auction_starts
user_24_hours_before_auction_starts
user_24_hours_before_auction_starts_bidder
user_24_hours_before_auction_starts_bidder_user_in_watchlist
user_auction_start
user_auction_start_user_in_watchlist
user_auction_start_registered_bidder
user_bid_placed_in_an_auction
user_bid_placed_in_an_auction_registered_bidders
user_bid_placed_in_an_auction_user_in_watchlist
user_bid_placed_in_an_auction_previous_highest_bidder
user_2_hours_before_auction_end
user_2_hours_before_auction_end_all_register_bidders
user_2_hours_before_auction_end_user_in_watchlist
user_extended_due_to_bid_in_final_5_minutes
user_extended_due_to_bid_in_final_5_minutes_all_registered_bidders
user_sold_or_leased
user_sold_or_leased_buyer
user_sold_or_leased_buyer_all_registered_bidders
user_sold_or_leased_buyer_user_in_watchlist
user_passed_in
user_passed_in_all_registered_bidders
user_passed_in_user_watchlist
 *
 * $params['subject']
 * $params['email_content']
 * $params['sms_content']
 * $params['property_id']
 * $params['to']
 * $params['hasBan'],$params['hasFromName'],$params['hasContent']
 * $params['sms_to']
 *
 *  */
function sendNotificationByEventKey($event_key = '', $params = array(), $variables = array())
{
    global $config_cls, $log_cls,$property_cls;
    if (!empty($event_key)) {
        //Process SUBJECT, CONTENT, SMS CONTENT
        $subject = $params['subject'];
        if (empty($subject)) {
            $subject = $config_cls->getKey('email_' . $event_key . '_subject');
        }
        $email_content = $params['email_content'];
        if (empty($email_content)) {
            $email_content = $config_cls->getKey('email_' . $event_key . '_content');
        }
        $sms_content = $params['sms_content'];
        if (empty($sms_content)) {
            $sms_content = $config_cls->getKey('email_' . $event_key . '_sms_content');
        }
        // Process Template vars
        if (isset($params['property_id']) && $params['property_id'] > 0) {
            $property_id = $params['property_id'];
            include_once ROOTPATH . '/modules/property/inc/property.class.php';
            if (!isset($property_cls) || !($property_cls instanceof Property)) {
                $property_cls = new Property();
            }
            $address = $property_cls->getAddress($property_id);
            $detail_link = $property_cls->getDetailLink($property_id);
            $subject = str_replace(array('[ID]', '[address]', '[detail_link]', '[ROOTURL]'), array($property_id, $address, $detail_link,ROOTURL), $subject);
            $email_content = str_replace(array('[ID]', '[address]', '[detail_link]', '[ROOTURL]'), array($property_id, $address, $detail_link, ROOTURL), $email_content);
            $sms_content = str_replace(array('[ID]', '[address]', '[detail_link]', '[ROOTURL]'), array($property_id, $address, $detail_link,ROOTURL), $sms_content);
        }
        /*// Replace variables Params */
        if (is_array($variables) && count($variables) > 0) {
            foreach ($variables as $key => $value) {
                $subject = str_replace($key, $value, $subject);
                $email_content = str_replace($key, $value, $email_content);
                $sms_content = str_replace($key, $value, $sms_content);
            }
        }
        // Process send email
        $emails_to = $params['to'];
        $emails_from = $params['from'];
        if (strpos($event_key, 'system_') !== false) {
            $emails_to = $config_cls->getKey('general_contact1_name');
            $emails_from = $config_cls->getKey('general_contact2_name');
        } elseif (strpos($event_key, 'service_provider_') !== false) {
            $emails_to = $config_cls->getKey('general_service_provider_email');
            $emails_from = $config_cls->getKey('general_contact2_name');
        } else {
            if(empty($emails_from)){$emails_from = $config_cls->getKey('general_contact_email');}
        }
        $message = $email_content;
        if(empty($params['send_mymessage']) || $params['send_mymessage']){
            $result['mymessage'] = sendToMyMessageBox($emails_from, $emails_to, $message, $subject);
        }
        $result['email'] = sendEmail_func($emails_from, $emails_to, $message, $subject, $params['hasBan'], $params['hasFromName'], $params['hasContent']);
        $result['sms'] = sendSMS_func($sms_content,$params['sms_to'],$emails_to);
        // LOG EMAIL
        include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
        if (!isset($log_cls) || !($log_cls instanceof Email_log)) {
            $log_cls = new Email_log();
        }
        $log_cls->createLog($event_key);
        return $result;
    }
    return array();
}
function sendSMS_func($sms_content,$sms_to,$emails_to){
    global $config_cls;
    // Process send SMS
    if(empty($sms_to)){
        include_once ROOTPATH . '/modules/agent/inc/agent.class.php';
        if (!isset($agent_cls) || !($agent_cls instanceof Agent)) {
            $agent_cls = new Agent();
        }
        $emails_to_ar = (array)$emails_to;$sms_to = array();
        foreach($emails_to_ar as $email_to){
            if(in_array($email_to,array($config_cls->getKey('general_contact1_name'),$config_cls->getKey('general_contact2_name'),
                $config_cls->getKey('general_contact_email'),$config_cls->getKey('general_service_provider_email')))){
                continue;
            }
            $sms_to[] = $agent_cls->getSMSNumber($email_to);
        }
    }
    if (!empty($sms_content) > 0) {
        include_once ROOTPATH . '/modules/general/inc/SMS.php';
        $sms_to_ar = (array) $sms_to;
        foreach($sms_to_ar as $_sms_to){
            if(strlen($_sms_to) > 0){
                return sendSMS($sms_content, $_sms_to);
            }
        }
    }
    return false;
}

function sendToMyMessageBox($emails_from, $emails_to, $message, $subject)
{
    global $config_cls,$agent_cls,$message_cls;
    include_once ROOTPATH . '/modules/agent/inc/agent.class.php';
    if (!isset($agent_cls) || !($agent_cls instanceof Agent)) {
        $agent_cls = new Agent();
    }
    include_once ROOTPATH . '/modules/agent/inc/message.class.php';
    if (!isset($message_cls) || !($message_cls instanceof Message)) {
        $message_cls = new Message();
    }
    $emails_to_ar = (array)$emails_to;
    foreach($emails_to_ar as $email_to){
        if(in_array($emails_to,array($config_cls->getKey('general_contact1_name'),$config_cls->getKey('general_contact2_name'),
            $config_cls->getKey('general_contact_email'),$config_cls->getKey('general_service_provider_email')))){
            continue;
        }
        $agent_to_row = $agent_cls->getCRow(array('agent_id'),'email_address=\''.$email_to.'\'');
        if($agent_to_row['agent_id'] > 0){
            $data = array(
                'email_from' => $emails_from ,
                'agent_id_to' => $agent_to_row['agent_id'],
                'email_to' => $email_to,
                'title' => $subject,
                'content' => $message_cls->escape($message),
                'send_date' => date('Y-m-d H:i:s')
            );
            $message_cls->insert($data);
            if(!$message_cls->hasError()){
                return true;
            }
        }
    }
    return false;
}
