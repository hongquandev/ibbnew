<?php
session_start();
include '../../configs/config.inc.php';
include_once ROOTPATH.'/includes/functions.php';
include_once ROOTPATH.'/includes/model.class.php';
include_once ROOTPATH.'/admin/functions.php';
//include_once ROOTPATH.'/includes/checkingform.class.php';
include_once ROOTPATH.'/modules/newsletter/inc/newsletter.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
include_once ROOTPATH.'/includes/smarty/Smarty.class.php';
$smarty = new Smarty;
if(detectBrowserMobile()){ 
    $smarty->compile_dir = ROOTPATH.'/m.templates_c/';
}else{
    $smarty->compile_dir = ROOTPATH.'/templates_c/';
}
//ini_set('display_errors', 1);
$action = getParam('action');
$token = getParam('token');
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
switch ($action) {
    case 'loadCustomize':
        die(json_encode(__loadCustom()));
    break;
    case 'list':
		if ($perm_ar['view'] == 0) {
			die(json_encode($perm_msg_ar['view']));
		}
		__newsletterListAction();
    break;
    case 'delete-letter':
		if ($perm_ar['delete'] == 0) {
			die(json_encode($perm_msg_ar['delete']));
		}
        $ids = getParam('ID');
		die(json_encode(__newsletterDeleteletterAction($ids)));
    break;
    case 'edit-letter':
		if ($perm_ar['edit'] == 0) {
			die(json_encode($perm_msg_ar['edit']));
		}
		__newsletterEditletterAction();
    break;
    case 'unsubscribe-letter':
        if ($perm_ar['edit'] == 0) {
			die(json_encode($perm_msg_ar['edit']));
		}
        $agent_id = (int)preg_replace('#[^0-9]#','',isset($_REQUEST['ID']) ? $_REQUEST['ID'] : 0);
		die(json_encode(__newsletterUnsubAction($agent_id)));
    break;
    case 'multidelete-letter':
        if ($perm_ar['delete'] == 0) {
			die(json_encode($perm_msg_ar['delete']));
		}
		__newsletterMultiDeleteAction();
    break;
}

/*---------*/

/**
@ function : __newsletterListAction
**/

function __newsletterListAction() {
	global $newsletter_cls, $agent_cls;
	$start = getParam('start', 0);
	$limit = getParam('limit', 0);
	$sort_by = getParam('sort', 'ID');
	$dir = getParam('dir', 'ASC');
	$search_query = getParam('query');

    $search_where = '';
	if (strlen($search_query)> 0){
	  $search_where = " WHERE (ID = '".$search_query."'
							   OR EmailAddress LIKE '%".$search_query."%'
							   OR Source LIKE '%".$search_query."%')";
	}
	
	$rows = $newsletter_cls->getRows('SELECT * FROM '.$newsletter_cls->getTable().$search_where
//								   ' ORDER BY '.$sortby.' '.$dir.
								   /*' LIMIT '.$start.','.$limit*/,true);
	$totalLetter = $newsletter_cls->getFoundRows();

    $i = 1;
    $retArray = array();
	if (is_array($rows) and count($rows)>0){
	  foreach ($rows as $row){
		  $row['Delete'] = '<a onclick ="outAction(\'delete\','.$row['ID'].')"><img src="/admin/resources/images/default/dd/delete.png"/></a>';
		  $row['Edit'] = '<a href="javascript:void(0);" onclick="$(\'#ID\').val(\''.$row['ID'].'\');$(\'#EmailAddress\').val(\''.$row['EmailAddress'].'\');Common.warningObject(\'#EmailAddress\',true);return !showPopup(\'nameFieldPopup\', event);"><img src="/admin/resources/images/default/dd/table_edit.png"/></a>';
		  $row['ID'] = $i;
          $row['real_id'] = 'lt_'.$row['ID'];
          $i++;
          $retArray[] = $row;
	  }
	}

    //get Information from Agent table
    $search_where = ' WHERE subscribe = 1';
	if (strlen($search_query)> 0){
	  $search_where .= " AND (agent_id = '".$search_query."'
							 OR email_address LIKE '%".$search_query."%')";
	}
    $rows = $agent_cls->getRows('SELECT * FROM '.$agent_cls->getTable().$search_where
  //                              ' ORDER BY '.$sortby.' '.$dir.
								/*' LIMIT '.$start.','.($limit - $totalLetter)*/,true);
    $totalAgent = $agent_cls->getFoundRows();
	if (is_array($rows) and count($rows)>0){
	  foreach ($rows as $row){
          /*$row['EmailAddress'] = $row['email_address'];
          $row['Source'] = 'Member';
		  $row['Delete'] = '<a onclick ="outAction(\'unsub-agent\','.$row['ID'].')"><img src="/admin/resources/images/default/dd/delete.png"/></a>';
		  //$row['Edit'] = '<a href="javascript:void(0);" onclick="$(\'#ID\').val(\''.$row['ID'].'\');$(\'#EmailAddress\').val(\''.$row['email_address'].'\');Common.warningObject(\'#EmailAddress\',true);return !showPopup(\'nameFieldPopup\', event);"><img src="/admin/resources/images/default/dd/table_edit.png"/></a>';
		  $row['ID'] = $i;*/
          $retArray[] = array('ID'=>$i,
                              'EmailAddress'=>$row['email_address'],
                              'Source'=>'Member',
                              'Delete'=>'<a onclick ="outAction(\'unsubscribe\','.$row['agent_id'].')"><img src="/admin/resources/images/default/dd/delete.png"/></a>',
                              'real_id'=>'ag_'.$row['agent_id']
                             );
          $i++;
	  }
	}

    //sort Array
    $retArrays = array();
            for ($j = $start; $j<($start+$limit); $j++){
                if ($retArray[$j] == null) break;
                $retArrays[] = $retArray[$j];

            }
    //print_r($retArrays);die();
    //$retArrays = multiSort($retArrays,$dir,$sort_by);

	$arrJS = array("totalCount" => $totalLetter + $totalAgent, "topics" => $retArrays);
	die(json_encode($arrJS));
	
}

/**
@ function : __newsletterDeleteletterAction
**/

function __newsletterDeleteletterAction($ids) {
    global $newsletter_cls;

	if (strlen($ids) > 0){
		$newsletter_cls->delete('ID IN ('.$ids.')');
	}
    return 'Deleted successful!';
}

/**
@ function : __newsletterEditletterAction
**/

function __newsletterEditletterAction() {
	global $newsletter_cls;
	$id = getParam('ID');
	$email = getParam('EmailAddress');
	$error = false;
	if (!isset($check)) {
		$check = new CheckingForm();
	}
	if ($email == '' || !$check->checkEmail($email)) {
		$error = true;
	}
	if (!$error){
		$newsletter_cls->update(array('EmailAddress'=>$email),
								'ID = '.$id);
	}
	die(json_encode($error));
}

function __loadCustom(){
     global $region_cls;
     $country = getPost('country');
     $form_data = getParam('params');
     //$form_data['country'] = $country;
     if (!((int)$form_data['country'] > 0)) {
	        $form_data['country'] = COUNTRY_DEFAULT;
	 }
     include_once ROOTPATH.'/modules/general/inc/regions.php';
     include_once ROOTPATH.'/includes/smarty/Smarty.class.php';
     require_once ROOTPATH.'/includes/functions.php';
     $smarty = new Smarty;
     if(detectBrowserMobile()){ 
            $smarty->compile_dir = ROOTPATH.'/m.templates_c/';
        }else{
            $smarty->compile_dir = ROOTPATH.'/templates_c/';
        }

     $data = array();
     $options_country = R_getOptions();

     $options_state = R_getOptions($form_data['country'] > 0 ? $form_data['country'] : -1 );
     $smarty->assign('option_state',$options_state);
     $smarty->assign('option_country',$options_country);
     $smarty->assign('form_data',$form_data);
     $smarty->assign('options_users',AgentType_getOptions_(false));
     $data['data'] = $smarty->fetch(ROOTPATH.'/modules/newsletter/templates/newsletter.popup.customize.tpl');
     //$data['data'] = $smarty->fetch(ROOTPATH.'/modules/property/templates/property.make-an-offer.popup.tpl');
    return $data;
}

/*function multiSort($array, $dir,$column) {
    return usort($array,function($a, $b) use($dir,$column) {
          if ((float)$a[$column] && (float)$b[$column]){
                if ($a[$column] == $b[$column]) $cmp = 0;
                else $cmp = $a[$column] > $b[$column]?1:-1;
          }else{
                $cmp = strcmp($a[$column], $b[$column]);
          }
            if ($dir == "ASC") return $cmp;
          return $cmp == 0?$cmp:-$cmp;
    });
    return $array;
}*/

function __newsletterUnsubAction($agent_id){
	global $agent_cls, $systemlog_cls;
    $agent_cls->update(array('subscribe'=>0),'agent_id='.$agent_id);
    $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									  'Action' => 'UPDATE',
									  'Detail' => 'UNSUBSCRIBED:'. $agent_id,
									  'UserID' => $_SESSION['Admin']['EmailAddress'],
									  'IPAddress' =>$_SERVER['REMOTE_ADDR']));
	return('This information has been updated!');
}

function __newsletterMultiDeleteAction(){
    $IDs = getParam('ID');
    $IDs_array = explode(',',$IDs);
    if (count($IDs_array) >= 1){
        foreach ($IDs_array as $item){
            $_item = explode('_',$item);
            if ($_item[0] == 'lt'){
                __newsletterDeleteletterAction($_item[1]);
            }
            if ($_item[0] == 'ag'){
                __newsletterUnsubAction($_item[1]);
            }
        }
    }
    die(json_encode('Deleted successful !'));
}

?>
