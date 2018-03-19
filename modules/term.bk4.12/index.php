<?php
require_once(ROOTPATH."/includes/mpdf/mpdf.php");
include_once ROOTPATH.'/modules/configuration/inc/config.class.php';

if (!isset($config_cls) || !($config_cls instanceof Config)) {
        $config_cls = new Config();
}

$action = getParam('action');
switch ($action){
    case 'view':
        $property_id = getParam('pid',0);
        $url = ROOTURL.'/?module=property&action=view-auction-detail&id='.(int)$property_id;
        $smarty->assign('later_link',$url);
        $smarty->assign('form_action',ROOTURL.'/?module=term&action=view&pid='.$property_id);
        if (isSubmit() && $property_id != 0){
            if (isset($_SESSION['agent']) && is_array($_SESSION['agent']) and $_SESSION['agent']['id'] > 0){
                $data = getPost('field');
                $filename = 'Registration_Bid_Form_'.$property_id.'_'.$_SESSION['agent']['id'].'.pdf';
                $path = ROOTPATH.'/store/uploads/';
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
                $smarty->assign('data',$data);
                $html =  $smarty->fetch(ROOTPATH.'/modules/term/templates/term.raywhite.tpl');
                $stylesheet = file_get_contents(ROOTPATH.'/modules/general/templates/style/style.css');
                $raywhite_style = file_get_contents(ROOTPATH.'/modules/term/templates/style/raywhite.css');
                $mpdf->WriteHTML($stylesheet,1);
                $mpdf->WriteHTML($raywhite_style,1);
                $pdf_style = file_get_contents(ROOTPATH.'/modules/term/templates/style/pdf.css');
                $mpdf->WriteHTML($pdf_style,1);
                $mpdf->WriteHTML($html);

                $mpdf->Output($path.$filename,'F');

                //send Mail
                //IBB-1572: Email the agent (listed property owner/manager) when users register to bid on their property
                $agentInfo = A_getAgentManageInfo($property_id);

                //bidder_info
                $agent = $agent_cls->getCRow(array('firstname','lastname','email_address'),'agent_id = '.$_SESSION['agent']['id']);
                $msg = $config_cls->getKey('email_agent_register_bid_with_form_msg');
                $link = ROOTURL . '/?module=property&action=view-auction-detail&id=' . $property_id;
                $link = '<a href="' . $link . '">' . $link . '</a> ';
                $subject = $config_cls->getKey('email_agent_register_bid_with_form_subject');
                $msg = str_replace(array('[agent_name]', '[ID]', '[link]', '[rooturl]','[bidder_name]','[bidder_email]'),
                                   array($agentInfo['full_name'], $property_id, $link, ROOTURL,$agent['firstname'].' '.$agent['lastname'],$agent['email_address']), $msg);
                $file = array('path'=>$path.$filename,
                              'filename'=>$filename);
                $result = sendEmail_attach($config_cls->getKey('general_contact_email'), $agentInfo['agent_email'], $msg, $subject, '',$file);
                if ($result == 'send'){
                    //@unlink($path.$filename);

                    /* SEND MSG TO MANAGER */
                    $new['from_email'] = $config_cls->getKey('general_contact_email');
                    $new['to_email'] = $agentInfo['agent_email'];
                    $new['content'] = 'Dear [agent_name],
                                       [bidder_name] (email: [bidder_email]) has just registered to bid your property [ID] at [link].
                                       Please check mail!';
                    $new['content'] = str_replace(array('[agent_name]', '[ID]', '[link]', '[rooturl]','[bidder_name]','[bidder_email]'),
                                                  array($agentInfo['full_name'], $property_id, $link, ROOTURL,$agent['firstname'].' '.$agent['lastname'],$agent['email_address']), $new['content']);
                    $new['subject'] = 'New register bid for property #'.$property_id.'!';
                    $new['from_id'] = '';
                    $new['to_id'] = $agentInfo['agent_id'];
                    sendMess($new);
                    redirect(ROOTURL . '/?module=property&action=view-auction-detail&id=' . $property_id);
                }else{
                    $message = $result;
                    $smarty->assign('message',$message);
                }
            }else{
                $message = 'Please login to continue!';
                $smarty->assign('message',$message);
            }
        }
        break;
    case 'save':
        $smarty->assign('form_action',ROOTURL.'/?module=term&action=view');
        require_once(ROOTPATH."/includes/mpdf/mpdf.php");
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
        //$html = '<p style="display: inline-table;">abcsdads</p><p style="display: inline-table;">aaaa</p><p style="display: inline-table;">bbbbbbbbbbbbbbbbb</p>';
        $html =  $smarty->fetch(ROOTPATH.'/modules/term/templates/term.raywhite.tpl');
        $stylesheet = file_get_contents(ROOTPATH.'/modules/general/templates/style/style.css');
        $raywhite_style = file_get_contents(ROOTPATH.'/modules/term/templates/style/raywhite.css');
        $pdf_style = file_get_contents(ROOTPATH.'/modules/term/templates/style/pdf.css');
        $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML($raywhite_style,1);
        $mpdf->WriteHTML($pdf_style,1);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        //echo '<button type="button" onclick="document.location=\''.ROOTURL.'/store/uploads/raywhite.pdf'.'\'">Download</button>';
        exit();
    default:
        break;
}

function sendMess($array) {
    global $message_cls;
    $nd = '<h2 style="font-size: 16px; color: #2f2f2f;"> Message Information </h2>
                    <div style="margin-top:8px;">Sender : ' . $array['from_email'] . '  </div>
                    <div style="margin-top:8px;">Subject : ' . stripslashes($array['subject']) . ' </div>
                    <div style="margin-top:8px">Content : ' . stripslashes($array['content']) . ' </div> ';

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
?>