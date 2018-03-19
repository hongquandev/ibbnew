<?php
include_once ROOTPATH.'/modules/comment/inc/comment.php';

$property_id = (int)restrictArgs(getParam('property_id',0));
$comment_id = (int)restrictArgs(getParam('comment_id',0));


$data = array();

switch ($action_ar[0]) {
	case 'view':
		if ($comment_id > 0 && $property_id > 0) {//DETAIL
			$row = $comment_cls->getRow('comment_id = '.$comment_id.' AND property_id = '.$property_id);
			if (is_array($row) && count($row) > 0) {
				$dt = new DateTime($row['created_date']);
				$row['created_date'] = $dt->format($config_cls->getKey('general_date_format'));
				
				$link_ar = array('module' => 'agent',
								'action' => 'view-comment',
								'property_id' => $property_id);
								
				$row['link_back'] = ROOTURL.'/?'.http_build_query($link_ar);
				
				$link_ar['action'] = 'edit-comment';
				$link_ar['comment_id'] = $comment_id;
				$row['link_status'] = ROOTURL.'/?'.http_build_query($link_ar);
                $link_ar['action'] = 'delete-comment';
                $row['link_status_delete'] = ROOTURL.'/?'.http_build_query($link_ar);

				$row['label_status'] = 'Approved';
                 $row['label_status']= 'Approve';
				if ($row['active'] == 1) {
					$row['label_status'] = 'Pending';

				}
				
				$smarty->assign('comment_row',$row);	
			}
		} else if ($property_id > 0) {//LIST
			$data = AgentComment_view($property_id);
			$smarty->assign('comment_rows',$data);
		}
	break;
	case 'edit':
		if ($comment_id > 0 && $property_id > 0) {
			$comment_cls->update(array('active' => array('fnc' => 'abs(`active` - 1)')),'comment_id = '.$comment_id);	
				
			// Write Logs					
						mysql_query("INSERT INTO `systemlogs` SET  `Updated`='".date("Y-m-d H:i:s")."', `Action`='UPDATE',  `Detail`='UPDATE AGENT COMMENT ID: $comment_id ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '".$_SERVER['REMOTE_ADDR']."'");	
							
			$message = 'Information has been updated.';
			$session_cls->setMessage($message);
			redirect(ROOTURL.'/?module=agent&action=view-comment&property_id='.$property_id);
		}
	break;

	case 'delete':
            $comment_ids = getPost('chk',array());
		  //$comment_id = (int)restrictArgs(getParam('comment_id',0));
               //print_r($comment_ids);
        if(is_array($comment_ids)&& count($comment_ids)>0){//Delete comment on Grid
        foreach($comment_ids as $id){
			    $comment_cls->delete('property_id = '.$property_id." AND comment_id =".$id);
			    $message = 'Information has been deleted.';
			    $session_cls->setMessage($message);
			    redirect(ROOTURL.'/?module=agent&action=view-comment&property_id='.$property_id);

        }
        }else {

            $comment_id = (int)restrictArgs(getParam('comment_id',0));
            //$session_cls->setMessage(print_r($comment_id));

            if($comment_id>0 && $property_id>0){//Delete comment on View comment
                $comment_cls->delete('property_id = '.$property_id." AND comment_id =".$comment_id);
			    //$message = 'Information comment has been deleted.';
			    //$session_cls->setMessage($message);
			    redirect(ROOTURL.'/?module=agent&action=view-comment&property_id='.$property_id);
            }
            else {
			//jQuery('#is_submit',this.form).val(0);
			//alert('Please select.');
            }
		}
	break;
    case 'del':

		  $comment_id = (int)restrictArgs(getParam('comment_id',0));
               //print_r($comment_ids);
            if ($comment_id > 0 && $property_id > 0) {
			    $comment_cls->delete('property_id = '.$property_id." AND comment_id =".$id);
			    $message = 'Information has been deleted.';
			    $session_cls->setMessage($message);
			    redirect(ROOTURL.'/?module=agent&action=view-comment&property_id='.$property_id);

        }else {
			jQuery('#is_submit',this.form).val(0);
			alert('Please select.');
		}
	break;

    /*
     * del: function () {
		var _check = false;
		jQuery('[name^=chk]').each(function () {
			if (jQuery(this).attr('checked') == true) {
				_check = true;
			}
		});

		if (_check == true) {
			if (confirm('Do you really want to delete ?')) {
				jQuery('#is_submit',this.form).val(1);
				jQuery(this.form).submit();
			}
		} else {
			jQuery('#is_submit',this.form).val(0);
			alert('Please select least one mail.');
		}
	},
     */

}

function AgentComment_view($property_id = 0) {
	global $config_cls, $comment_cls;
	$data = array();
	$rows = $comment_cls->getRows('property_id = '.$property_id);
	if (is_array($rows) && count($rows) > 0) {
		foreach ($rows as $row) {
			$dt = new DateTime($row['created_date']);
			$row['created_date'] = $dt->format($config_cls->getKey('general_date_format'));

			$label_status = 'Pending';
			if ($row['active'] == 1) {
				$label_status = 'Approved';
			}

			$link_ar = array('module' => 'agent',
							'action' => 'edit-comment',
							'property_id' => $property_id,
							'comment_id' => $row['comment_id'] );

			$row['link_status'] = '<a href="/?'.http_build_query($link_ar).'">'.$label_status.'</>';

			$link_ar['action'] = 'view-comment';
			$row['link_detail'] = ROOTURL.'/?'.http_build_query($link_ar);

            $link_ar['action'] = 'delete-comment';
			$row['link_delete'] = ROOTURL.'/?'.http_build_query($link_ar);

			$data[] = $row;
		}
	}
	return $data;
}

$form_action = ROOTURL.'/?module=agent&action=delete-comment&property_id='.$property_id;
$smarty->assign('comment_id',$comment_id);
?>