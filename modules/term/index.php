<?php
require_once(ROOTPATH . "/includes/mpdf/mpdf.php");
include_once ROOTPATH . '/modules/configuration/inc/config.class.php';
include_once ROOTPATH . '/modules/term/inc/bid_term.class.php';
include_once ROOTPATH . '/modules/notification/notification.php';
include_once ROOTPATH . '/modules/notification/notification_app.class.php';
include_once ROOTPATH . '/modules/property/inc/property.php';
include_once ROOTPATH . '/utils/ajax-upload/server/php.php';
ini_set('display_errors', 0);
if (!isset($config_cls) || !($config_cls instanceof Config)) {
    $config_cls = new Config();
}
if (!isset($bid_term_cls) || !($bid_term_cls instanceof Bids_term)) {
    $bid_term_cls = new Bids_term();
}
$property_id = getParam('pid', 0);
$action = getParam('action');
$smarty->assign('action', $action);
$message = $_SESSION['rental_form_message'];
$smarty->assign('message', $message);
unset($_SESSION['rental_form_message']);
switch ($action) {
    case 'view':
        ini_set('display_errors', 1);
        $url_property = PE_getUrl($property_id);
        $smarty->assign('property_link', $url_property);
        $smarty->assign('form_action', ROOTURL . '/?module=term&action=view&pid=' . $property_id);
        $smarty->assign('link_application_form', ROOTURL . '/?module=term&action=view-application&pid=' . $property_id);

        if (isset($_SESSION['agent']) && is_array($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
            $row = $bid_term_cls->getRow('bidder_id = ' . $_SESSION['agent']['id'] . '');
            if (is_array($row) and count($row) > 0) {
                $data = unserialize($row['data_user_detail']);
                $file_arr = array();
                $files_application_supporting = unserialize($row['files_application_supporting']);
                if(is_array($files_application_supporting) && count($files_application_supporting) >0){
                    foreach($files_application_supporting as $key => $file){
                        $file_arr[$key] = getPath($file);
                    }
                }
                $smarty->assign('data', $data);
                $smarty->assign('file', $file_arr);
            }
        }

        if (isSubmit() && $property_id != 0) {
            if (isset($_SESSION['agent']) && is_array($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {

                /*print_r($_POST);
                print_r($_FILES);
                die();*/
                //SAVE FILE
                ini_set('max_input_time', 300);
                ini_set('max_execution_time', 300);
                $path = ROOTPATH.'/store/uploads/D' . $_SESSION['agent']['id'];
                $url_path = '/store/uploads/D' . $_SESSION['agent']['id'];
                createFolder($path, 1);
                //BEGIN SETTING FOR UPLOADER
                // list of valid extensions, ex. array()
                $allowedExtensions = array('pdf', 'png', 'jpg',"jpeg", "bmp");
                // max file size in bytes
                $sizeLimit = 10 * 1024 * 1024 * 1024;
                $isCheckSetting = false;
                $files_application_supporting = $result = array();
                $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, $isCheckSetting);
                if(is_array($_FILES) && count($_FILES) >0){
                    foreach($_FILES as $key => $file){
                        $uploader->addFileToUpload($file);
                        $result[$key] = $uploader->handleUpload($path.'/');
                        if($result[$key]['success']){
                            $files_application_supporting[$key] = $url_path.'/'.$result[$key]['filename'];
                        }
                    }
                }
                $data = $_POST;
                if($bid_term_cls->addDataUserDetail($_SESSION['agent']['id'],$data,$files_application_supporting)){
                    $message = 'Save Successful.';
                    $smarty->assign('message', $message);
                };
                if (getPost('is_save_application', 0) == 1) { // SAVE/EDIT
                    //redirect($url_property);
                } else { // SUBMIT
                    sendMailToAgent($property_id,$_SESSION['agent']['id']);
                    $bid_term_cls->updateStatusForm($_SESSION['agent']['id']);
                }
            } else {
                $message = 'Please login to continue!';
                $smarty->assign('message', $message);
            }

        }
        break;
    case 'view-application':
        $transact_agent_id = $_SESSION['registerToTransact_agent_id'];
        $smarty->assign('form_action', ROOTURL . '/?module=term&action=view-application&pid=' . $property_id);
        $smarty->assign('later_link',  ROOTURL . '/?module=agent&action=register-application&transact_step=3');
        if ($transact_agent_id > 0) {
            $row = $bid_term_cls->getRow('bidder_id = ' . $_SESSION['agent']['id'] . '');
            if (is_array($row) and count($row) > 0) {
                $data = unserialize($row['data_application']);
                $smarty->assign('data', $data);
            }
        }
        if (isSubmit() && $property_id != 0) {
            if ($transact_agent_id > 0) {
                $file_application = saveApplicationPdf($property_id, getPost('field'));
                $save = $bid_term_cls->addApplicationForm($transact_agent_id, $file_application, getPost('field'),1);
                if ($save) {
                    $_SESSION['rental_form_message'] = 'The rental application form has been saved successful.';
                }
            }
            if (getPost('is_save_application', 0) == 1) {
                redirect(ROOTURL . '/?module=agent&action=register-application&transact_step=4');
            } else {
                redirect(ROOTURL . '/?module=agent&action=register-application&transact_step=4');
            }
        }
        break;
    default:
        break;
}

function saveApplicationPdf($property_id, $data = array())
{
    global $smarty;

    $directory = '/store/uploads/D' . $_SESSION['agent']['id'];
    createFolder(ROOTPATH . $directory, 1);
    $filename = 'Rental_Application_Form_' . $property_id . '_' . $_SESSION['agent']['id'] . rand(10, 99). '.pdf';
    $mpdf = new mPDF('utf-8', 'A4',
        8,       // font size - default 0
        'arial',    // default font family
        5,    // margin_left
        5,    // margin right
        10,     // margin top
        10,    // margin bottom
        15,     // margin header
        15     // margin footer
    );
    $smarty->assign('data', $data);
    $html = $smarty->fetch(ROOTPATH . '/modules/term/templates/term.raywhite.tpl');
    $stylesheet = file_get_contents(ROOTPATH . '/modules/general/templates/style/style.css');
    $raywhite_style = file_get_contents(ROOTPATH . '/modules/term/templates/style/raywhite.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->WriteHTML($raywhite_style, 1);
    $pdf_style = file_get_contents(ROOTPATH . '/modules/term/templates/style/pdf.css');
    $mpdf->WriteHTML($pdf_style, 1);
    $mpdf->WriteHTML($html);
    $mpdf->Output(ROOTPATH . $directory . '/' . $filename, 'F');
    return $directory . '/' . $filename;

}

function sendMailToAgent($property_id = 0, $bidder_id = 0)
{
    global $agent_cls, $config_cls, $bid_term_cls, $smarty;

    $agentInfo = A_getAgentManageInfo($property_id);
    /*And email as per something like the below, with links to the documents…*/
    $subject = 'You have received an application for property ID '.$property_id.' - '.PE_getAddressProperty($property_id);
    $to = $agentInfo['agent_email'];
    $bidder = $agent_cls->getCRow(array('agent_id','firstname', 'lastname', 'email_address'), 'agent_id = ' . $bidder_id);
    $row = $bid_term_cls->getRow('bidder_id = ' . $_SESSION['agent']['id'] . '');
    if (is_array($row) and count($row) > 0) {
        $files = unserialize($row['files_application_supporting']);
        $smarty->assign('files',$files);
        $smarty->assign('term',$row);
    }
    $smarty->assign('bidder',$bidder);
    $content = $smarty->fetch(ROOTPATH . '/modules/term/templates/rental_application.email.template.tpl');
    sendEmail_func('', $to, $content, $subject);

    return true;



    $msg = $config_cls->getKey('email_agent_register_bid_with_form_msg');
    $link = ROOTURL . '/?module=property&action=view-auction-detail&id=' . $property_id;
    $link = '<a href="' . $link . '">' . $link . '</a> ';
    $subject = $config_cls->getKey('email_agent_register_bid_with_form_subject');
    $msg = str_replace(array('[agent_name]', '[ID]', '[link]', '[rooturl]', '[bidder_name]', '[bidder_email]'),
    array($agentInfo['full_name'], $property_id, $link, ROOTURL, $agent['firstname'] . ' ' . $agent['lastname'], $agent['email_address']), $msg);

    $result = sendEmail_attach($config_cls->getKey('general_contact_email'), $agentInfo['agent_email'], $msg, $subject);
    if ($result == 'send') {
        //@unlink($path.$filename);
        /* SEND MSG TO MANAGER */
        $new['from_email'] = $config_cls->getKey('general_contact_email');
        $new['to_email'] = $agentInfo['agent_email'];
        $new['content'] = 'Dear [agent_name],
                           [bidder_name] (email: [bidder_email]) has just registered to bid your property [ID] at [link].
                           Please check mail or you can download file <a href="' . ROOTURL . $path . $filename . '" style="font-weight: bold">HERE</a>!';
        $new['content'] = str_replace(array('[agent_name]', '[ID]', '[link]', '[rooturl]', '[bidder_name]', '[bidder_email]'),
            array($agentInfo['full_name'], $property_id, $link, ROOTURL, $agent['firstname'] . ' ' . $agent['lastname'], $agent['email_address']), $new['content']);
        $new['subject'] = 'bidRhino : Rental Application Form register bid for property #' . $property_id . '!';
        $new['from_id'] = '';
        $new['to_id'] = $agentInfo['agent_id'];
        sendMess($new);

        //push notification to agent who is owner that property
        //push($agentInfo['agent_id'], array('type_msg' => 'register-to-bid', 'to_agent_id' => $agentInfo['agent_id'], 'property_id' => $property_id, 'subject' => $new['subject']));
        //redirect(ROOTURL . '/?module=property&action=view-auction-detail&id=' . $property_id);
    } else {
        $message = $result;
        $smarty->assign('message', $message);
    }
}

function sendMess($array)
{
    global $message_cls;
    $nd = '<h2 style="font-size: 16px; color: #2f2f2f;"> Message Information </h2>
                    <div style="margin-top:8px;">Sender: ' . $array['from_email'] . '  </div>
                    <div style="margin-top:8px;">Subject: ' . stripslashes($array['subject']) . ' </div>
                    <div style="margin-top:8px">Content: ' . stripslashes($array['content']) . ' </div> ';

    sendEmail_func($array['from_email'], $array['to_email'], $nd, $array['subject']);

    include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
    if (!isset($log_cls) or !($log_cls instanceof Email_log)) {
        $log_cls = new Email_log();
    }
    $log_cls->createLog('send_message');


    $data = array('agent_id_from' => $array['from_id'],
        'email_from' => $array['from_email'],
        'agent_id_to' => $array['to_id'],
        'email_to' => $array['to_email'],
        'title' => addslashes($array['subject']),
        'content' => addslashes($array['content']),
        'send_date' => date('Y-m-d H:i:s'));
    $message_cls->insert($data);
}

function getPath($link, $type = "filename")
{
    if (strlen($link)) {
        $arr = explode('/', $link);
        if ($type == 'filename') {
            return end($arr);
        } else {
            unset($arr[count($arr) - 1]);
            return implode('/', $arr);
        }
    }
    return '';
}

?>