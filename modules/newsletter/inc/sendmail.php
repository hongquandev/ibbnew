<?php
    include_once ROOTPATH.'/modules/newsletter/inc/newsletter.php';
    include_once ROOTPATH.'/modules/agent/inc/agent.php';

    global $agent_cls;

     if (@$_SERVER['REQUEST_METHOD'] == 'POST') {//FOR POST
       if (isset($_POST))
             foreach ($_POST as $key => $val) {
                 $form_data[$key] = $_POST[$key];
                 //$msg .= $form_data[$key];
             }
           $error = false;
           if (!$error){
             if ($form_data['title'] == '' || $form_data['content'] == ''){
                 $error = true;
                 $msg = 'Please enter all information.';
             }
           }
           if (!$error){
               $wh_str = '';
               $sub = array();
               $mail_arr = explode('_',$form_data['mail_to']);
               switch ($mail_arr[1]){
                   /*case 'Vendors':
                   case 'Buyers':
                   case 'Partners':
                       $name = strtolower($form_data['mail_to']);
                       $wh_str = ' AND (SELECT title FROM '.$agent_cls->getTable('agent_type')." WHERE a.type_id = agent_type_id) = '".substr($name,0,strlen($name)-1)."'";
                       break;
                   case 'Customize':
                       $wh_ar = array();
                       if ($form_data['vendors'] == 'true'){$wh_ar[] = ' (SELECT title FROM '.$agent_cls->getTable('agent_type')." WHERE a.type_id = agent_type_id) = 'vendor'";}
                       if ($form_data['partners'] == 'true'){$wh_ar[] = ' (SELECT title FROM '.$agent_cls->getTable('agent_type')." WHERE a.type_id = agent_type_id) = 'partner'";}
                       if ($form_data['buyers'] == 'true'){$wh_ar[] = ' (SELECT title FROM '.$agent_cls->getTable('agent_type')." WHERE a.type_id = agent_type_id) = 'buyer'";}
                       if (count($wh_ar) > 0){
                            $wh_str = ' AND ';
                            $wh_str .= implode(' OR ',$wh_ar);
                       }

                       $wh_str .= ($form_data['suburb'] != '')?" AND UCASE(a.suburb) = '".strtoupper($form_data['suburb'])."'":'';
                       if ($form_data['country'] == 1){
                           $wh_str .= ($form_data['state'] > 0)?' AND a.state = '.$form_data['state']:'';
                       }else{
                            $wh_str .= ($form_data['other_state'] != '')?' AND a.other_state LIKE \'%'.trim($form_data['other_state']).'%\'':'';
                       }

                       $wh_str .= ($form_data['country'] > 0)?' AND a.country = '.$form_data['country']:'';
                       break;
                   default:
                      //$sub = $newsletter_cls->getRows();
                      //print_r($newsletter_cls->sql);
                       break;*/
                   case -1:
                            $wh_str .= $form_data['user'] != ''?' AND a.type_id IN ('.$form_data['user'].')':'';
                            $wh_str .= $form_data['suburb'] != ''?" AND UCASE(a.suburb) = '".strtoupper($form_data['suburb'])."'":'';
                            if ($form_data['country'] == 1){
                               $wh_str .= ($form_data['state'] > 0)?' AND a.state = '.$form_data['state']:'';
                            }else{
                               $wh_str .= ($form_data['other_state'] != '')?' AND a.other_state LIKE \'%'.trim($form_data['other_state']).'%\'':'';
                            }
                            $wh_str .= ($form_data['country'] > 0)?' AND a.country = '.$form_data['country']:'';
                       break;
                   case 0;
                            $sub = $newsletter_cls->getRows();
                       break;
                   default:
                       $wh_str .= ' AND a.type_id = '.$mail_arr[1];
                       break;
               }
               $wh_str .= ' AND a.subscribe = 1';
            
               $rows = $agent_cls->getRows('SELECT a.email_address FROM '.$agent_cls->getTable().' AS a
                                            WHERE 1 AND a.is_active = 1 '.$wh_str,true);
               if (is_array($rows) && count($rows)>0){
                   foreach ($rows as $row){
                    sendMail_newsletter($row,'email_address',$form_data['title'],$form_data['content'],$msg);
                   }
               }

               if (is_array($sub) && count($sub)>0){
                   foreach ($sub as $_sub){
                    sendMail_newsletter($_sub,'EmailAddress',$form_data['title'],$form_data['content'],$msg);
                   }
               }
               $msg = 'Email had been sent.';

           }
           unset($form_data);
           $session_cls->setMessage($msg);
           redirect(ROOTURL.'/admin/index.php?module=newsletter&action=emailtemplate&token='.$token);
     }
    $smarty->assign('form_data',$form_data);
    $smarty->assign('option_mail',MailOption());    
	 
?>