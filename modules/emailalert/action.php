<?php
include_once '../../configs/config.inc.php';
include_once ROOTPATH.'/includes/functions.php';
include_once ROOTPATH.'/includes/model.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/includes/pagging.class.php';
include_once 'inc/emailalert.php';

$action = getParam('action');
if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
	$pag_cls = new Paginate();
}

include_once ROOTPATH.'/modules/general/inc/user_online.php';

if (!isset($user_online_cls) || !($user_online_cls instanceof UserOnline)) {
    $user_online_cls = new UserOnline();
}
$user_online_cls->checkOnline();

switch ($action){
        case 'getEmail':
            //global $email_cls;
            $email_id = getPost('email_id');
            $form = getPost('frm');
            $type = getPost('type');
            $row = $email_cls->getRow(' email_id = '. $email_id);
            if (is_array($row) and count($row)>0){
                $result['success'] = 'Success';
                $result['data'] = $row;
                $result['type'] = $type;
            }else{
                $result['error'] = 'Error';
            }
            $result['form'] = $form;
            die(_response($result));
            break;
        case 'change-status':
            $id = (int)getParam('email_id');
            $row = $email_cls->getRow('email_id = '.$id);
            if (count($row)>0){
               $status = 1 - (int)$row['allows'];

               $email_cls->update(array('allows'=>$status),'email_id = '.$id);
               $result = array('success' => 'success','id' => $id);
               $result['data'] = 'Active';
               if ($status == 0){
                    $result['data'] = 'InActive';
               }
            } else{
                $result['error'] = 'error';
            }

            die(_response($result));
            break;
        case 'resend':
            $message = 'resend successful!';
            $id = getParam('email_id');
            $agent_id = getParam('agent_id');
            $status = EA_getStatus($id);
            if ($status != null and $status != 0){
                $row = $email_cls->getRow('email_id = '.$id);
                if (is_array($row) and count($row) > 0){
                     if (EA_reSearch($row,$message,$agent_id,0,'resend')){
                         $email_cls->update(array('content'=>addslashes($row['content'])),'email_id = '. $id);
                     }
                }
            } else{
                 $message = 'If you want to use the function to resend email alerts, pleaes set the status to active.';
            }

           die(_response($message));
           break;
        case 'view-email':
            $agent_id = (int)restrictArgs(getQuery('agent_id',0));
			$p = (int)restrictArgs(getQuery('p',1));
			$p = $p <= 0 ? 1 : $p;
			$len = getParam('len',12);
			$str = '<table cellspacing="0" cellpadding="0" class="tbl-messages">
                        <colgroup>
                           <col width="320px"/> <col width="170px"/> <col width="240px"/> <col width="110px"/><col width="80px"/> <col width="70px"/><col width="70px"/>
                           <col width="70px"/>
                        </colgroup>
                        <thead>
                            <tr>
                                <td>Name Email Alert </td>
                                <td style="text-align:center">Type</td>
                                <td style="text-align:center">Date Register</td>
                                <td style="text-align:center">Status</td>
                                <td style="text-align:center;">Edit</td>
                                <td style="text-align:center;">Search</td>
                                <td style="text-align:center;">Tool</td>
                                <td style="text-align:center">Delete</td>
                            </tr>
                        </thead>
                        <tbody>';
            $page = '';
			$rows = $email_cls->getRows('SELECT SQL_CALC_FOUND_ROWS e.*,
	                                    (SELECT reg1.name FROM '.$region_cls->getTable().' AS reg1 WHERE reg1.region_id = e.state) AS state_name,
	                                    (SELECT reg2.name FROM '.$region_cls->getTable().' AS reg2 WHERE reg2.region_id = e.country) AS country_name,
	                                    (SELECT pro_opt1.title
				                         FROM '.$property_entity_option_cls->getTable().' AS pro_opt1
				                         WHERE pro_opt1.property_entity_option_id = e.property_type) AS property_name
	                                     FROM '.$email_cls->getTable().' as e
	                                     WHERE e.agent_id = '.$agent_id.'
	                                     ORDER BY e.email_id DESC
										 LIMIT '.(($p-1)*$len).','.$len,true);
            $total = $email_cls->getFoundRows();
            $pag_cls->setTotal($total)
                    ->setPerPage($len)
                    ->setCurPage($p)
                    ->setLenPage(10)
                    ->setUrl(getRootUrl().'/modules/emailalert/action.php?action=view-email&agent_id='.$agent_id.'&len='.$len)
                    ->setLayout('ajax')
                    ->setFnc('emailalert.view_email');
            //print_r($pag_cls->layout());
            $rows = formUnescapes($rows);
		    if ($email_cls->hasError()) {
			} else if (is_array($rows) and count($rows)>0) {
				foreach ($rows as $row) {
                    $row['full_address'] = $row['suburb'].' '.$row['postcode'].' '.$row['state_name'].' '.$row['country_name'];
                    $row['property_name'] = ($row['property_name'] == null)?'Any': $row['property_name'];
                    $row['status'] = ($row['allows'])?'Active':'InActive';
					$str .= '<tr>
                                <td style="padding-left:5px;">
                                    <strong>'.$row['name_email'].'</strong>
                                    <br/>
                                    <span style="font-size:10px;">'.$row['full_address'].'</span>
                                </td>
                                <td style="text-align:center;">'.$row['property_name'].'</td>
                                <td style="text-align:center;width: 16%;">'.$row['end_time'].'</td>
                                <td style="text-align:center;"><a href="javascript:void(0)" onclick="emailalert.changeStatus('.$row['email_id'].');"><span id="stt_'.$row['email_id'].'">'.$row['status'].'</span></a></td>
                                <td style="text-align:center;"><a href="?module=emailalert&action=edit-email&id='.$row['email_id'].'"> Edit </a></td>
                                <td style="text-align:center;"><a href="javascript:void(0)" onclick="emailalert.search('.$row['email_id'].',\'#frmProperty\');"> Search </a></td>
                                <td style="text-align:center;"><a href="javascript:void(0)" onclick="emailalert.resend('.$row['email_id'].','.$agent_id.');"> Resend </a></td>
                                <td style="text-align:center;"><a  href="javascript:void(0)" onclick="emailalert.del('.$row['email_id'].'); ">Delete </a>
                                </td>
                            </tr>';

				}
            }
            //print_r($page_cls->layout());
            $page = '<div class="clearthis"></div>'.$pag_cls->layout();
            $str .='</tbody></table>'.$page;
			die($str);
			break;

    }
?>