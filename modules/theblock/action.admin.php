<?php
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include ROOTPATH.'/admin/functions.php';
include 'inc/background.php';
include_once ROOTPATH.'/modules/cms/inc/cms.php';
include_once ROOTPATH.'/modules/menu/inc/menu.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';

include_once ROOTPATH.'/modules/general/inc/ftp.php';
include_once ROOTPATH.'/modules/general/inc/media.php';


//restrict4AjaxBackend();
$action = getParam('action');
$token = getParam('token');

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
$dir = ROOTPATH.'/store/uploads/background/';
switch ($action){
    case 'list-background':
    case 'list-background-agent':
		if ($perm_ar['view'] == 0) {
			die(json_encode($perm_msg_ar['view']));
		}
        $action_ar = explode('-',$action);
		__backgroundListAction($action_ar[2]);
	break;
    case 'get-background':
        if ($perm_ar['edit'] == 1) {
			__getBackground();
	    } else {
			die(json_encode($perm_msg_ar['edit']));
	    }
        break;
    case 'get-page':
        __getCMSOptions();
    break;
    case 'upload-background':
        if ($perm_ar['add'] == 1) {
			__uploadBackground();
	    } else {
			die(json_encode($perm_msg_ar['edit']));
	    }
    break;
    case 'active-background':
        if ($perm_ar['edit'] == 1) {
			__activeBackground();
	    } else {
			die(json_encode($perm_msg_ar['edit']));
	    }
    break;
    case 'delete-background':
    case 'multidelete-background':
        if ($perm_ar['delete'] == 1) {
		    __deleteBackground();
		} else {
		    die(json_encode($perm_msg_ar['delete']));
        }
    break;
    case 'get-property':
        __getPropertyOptions();
    break;
	
	case 'list-banner':
		__bannerListAction();
	break;
	
    case 'upload-banner':
        if ($perm_ar['add'] == 1) {
			__bannerUploadAction();
	    } else {
			die(json_encode($perm_msg_ar['edit']));
	    }
    break;
	
    case 'delete-banner': case 'multidelete-banner':
        if ($perm_ar['delete'] == 1) {
		    __bannerDeleteAction();
		} else {
		    die(json_encode($perm_msg_ar['delete']));
        }
    break;
    case 'active-banner':
        if ($perm_ar['edit'] == 1) {
			__bannerActiveAction();
	    } else {
			die(json_encode($perm_msg_ar['edit']));
	    }
    break;
    case 'get-company':
        $rows = $company_cls->getRows('SELECT distinct c.agent_id,c.company_name
                                       FROM '.$company_cls->getTable().' AS c
                                       LEFT JOIN '.$agent_site_cls->getTable().' AS s
                                       ON c.agent_id = s.agent_id
                                       LEFT JOIN '.$agent_cls->getTable().' AS a
                                       ON a.agent_id = c.agent_id
                                       WHERE company_name != \'\'
                                       AND type_id = '.AgentType_getIdByKey('agent'),true);
        if (is_array($rows) and count($rows)> 0){
            die(json_encode($rows));
        }
        break;
	
}

/**
@ function : __backgroundListAction
**/

function __backgroundListAction($action = ''){
    global $background_cls,$dir;
	$start = getParam('start', 0);
	$limit = getParam('limit', 25);
	$sort_by = getParam('sort', 'b.background_id');


	$rows = $background_cls->getRows('SELECT SQL_CALC_FOUND_ROWS b.*
								  FROM '.$background_cls->getTable().' AS b
								  WHERE '.($action == 'agent'?'agent_id != 0':'agent_id = 0').'
								  ORDER BY '.$sort_by.' DESC
								  LIMIT '.$start.','.$limit,true);
	$totalCount = $background_cls->getFoundRows();
	$retArray = array();


	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
            $row['active_value'] = $row['active'];
            $row['active'] = $row['active'] == 1?'<span>Active</span>':'<span class="grid_warn">InActive</span>';
            $row['thumb_url'] = ($row['type'] == 'top')?MEDIAURL.'/store/uploads/background/'.$row['link']
                                :MEDIAURL.'/store/uploads/background/thumbs/'.$row['link'];
            switch ($row['type']){
                case 'top':
                    $row['type_name'] = 'Logo';
                    break;
                case 'left':
                    $row['type_name'] = 'Left Background';
                    break;
                case 'right':
                    $row['type_name'] = 'Right Background';
                    break;
                default:
                    break;
            }
			$retArray[] = $row;
		}
	}

	$arrJS = array("totalCount" => $totalCount, "topics" => $retArray);
	die(json_encode($arrJS));
}

/**
@ function : __getCMSOptions
**/

function __getCMSOptions(){
    global $cms_cls,$menu_cls;
	
	$rs = Menu_getMenuOptions();	
	$data = array();
	$data[] = array('title' => 'HOME', 'page_id' => 0);
	if (is_array($rs) && count($rs) > 0) {
		foreach ($rs as $k => $v) {
			$data[] = array('title' => $v, 'page_id' => $k);
		}
	}
    $result = array('success' => true, 'rows' => $data);
    die(json_encode($result));
}

/**
@ function : __getPropertyOptions
**/

function  __getPropertyOptions(){
    global $property_cls,$agent_cls;
    $data = array();
    $rows = $property_cls->getRows('SELECT pro.property_id, pro.owner, a.type_id
                                    FROM '.$property_cls->getTable().' AS pro
                                    LEFT JOIN '.$agent_cls->getTable().' AS a
                                    ON a.agent_id = pro.agent_id
                                    WHERE (SELECT agt.title
                                           FROM '.$agent_cls->getTable('agent_type').' AS agt
                                           WHERE agt.agent_type_id = a.type_id) = \'theblock\'
                                           AND pro.confirm_sold = 0
                                           AND pro.agent_active = 1
                                           AND pro.stop_bid = 0
                                           AND pro.pay_status = '.Property::CAN_SHOW.'
                                           AND pro.active = 1
                                    ORDER BY pro.owner'
                                    ,true);
    if (is_array($rows) and count($rows)> 0){
        foreach ($rows as $row){
            $row['title'] = '#'.$row['property_id'].' - '.$row['owner'].'\'s property.';
            $data[] = $row;
        }
    }
    die(json_encode(array('topics'=>$data)));
}

/**
@ function : __uploadBackground
**/

function __uploadBackground(){
    global $background_cls,$dir;
    //upload Image
     $id = getParam('id',0);
     $theblock_id = $_GET['block'];
     $allowedType = array('image/jpeg', 'image/jpg','image/png', 'image/gif', 'image/x-png');
     createFolder($dir.'thumbs',2);
     createFolder($dir.'img',2);
     $error = false;
     $file_name = '';
     if ($_FILES['img']['name'] == ''){
         if ($id == 0){
            $error = true;
            $msg = 'No image !';
         }
     }elseif (in_array($_FILES['img']['type'], $allowedType)) {
         if ($_FILES['img']['size'] <= 500000) {
                $file_name = date('YmdHis').'_'.formatFilename($_FILES['img']['name']);
                //$file_name = $_FILES['img']['name'];
                if (move_uploaded_file($_FILES['img']['tmp_name'],$dir.'img/'.$file_name)){
                }else{
                    $error = true;
                    $msg = 'Error upload !';
                }
         } else {$error = true;$msg = 'File is large !';}
     }else{
         $error = true;
         $msg = 'File type is invalid !';
     }
     if (!$error){
          if ($file_name != ''){
               // create thumbnail
               createThumb($file_name,$dir.'img/',$dir.'thumbs/',$_FILES['img']['type']);
			   //createThumbs($file_name,$dir.'img/',$dir.'thumbs/',200,200);
			   if (isset($_GET['type']) && $_GET['type'] == 'top'){
                   list($width, $height) = getimagesize($dir.'img/'.$file_name);
                   if ($width > 376) {
                       resizeImgByPercent($dir.'img/'.$file_name,
                                          $dir.'img/'.$file_name,
                                          376, 0
                       );
                       list($width, $height) = getimagesize($dir.'img/'.$file_name);
                   }
                   if ($height > 79) {
                       resizeImgByPercent($dir.'img/'.$file_name,
                                          $dir.'img/'.$file_name,
                                          0, 79
                       );
                   }
               }
			   ftp_mediaUpload($dir.'img/', $file_name);
			   ftp_mediaUpload($dir.'thumbs/', $file_name);
          }
          $cms = $_GET['cms'];
          $color = getParam('background_color');
          $color = strpos($color,'#') === false?'#'.$color:$color;
          $data = array('cms_page'=>$cms,
                        'background_color'=>$color,
                        'fixed'=>isset($_POST['fixed']['fixed'])?1:0,
                        'repeat'=>isset($_POST['repeat']['fixed'])?1:0,
                        'active'=>isset($_POST['active']['fixed'])?1:0,
                        'theblock_id'=>$theblock_id,
                        'agent_id'=>isset($_GET['agent_id'])?$_GET['agent_id']:0,
                        'type'=>isset($_GET['type'])?$_GET['type']:'');
          if ($file_name != '')  $data['link']= $file_name;
          if ($id == 0){//insert
             $data['upload_time'] = date('Y-m-d H:i:s');
             $background_cls->insert($data);

          }else{//update
             $background_cls->update($data,"background_id ='".$id."'");
          }
          echo '{"success":true}';
          exit();
     }
     echo '{"success":true,"error":1,"msg":\''.$msg.'\'}';
}

/**
@ function : __activeBackground
**/

function __activeBackground(){
    global $background_cls, $systemlog_cls;
	$background_id = (int)preg_replace('#[^0-9]#','',isset($_REQUEST['background_id']) ? $_REQUEST['background_id'] : 0);
	$status = TB_getBackgroundStatus($background_id);
	if ($status != ''){
		$status = 1-(int)$status;
		$status_label = $status == 0?'ACTIVE':'INACTIVE';
		$background_cls->update(array('active'=>$status),'background_id='.$background_id);
		$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									  'Action' => 'UPDATE',
									  'Detail' => $status_label." BACKGROUND ID :". $background_id,
									  'UserID' => $_SESSION['Admin']['EmailAddress'],
									  'IPAddress' =>$_SERVER['REMOTE_ADDR']));
        die(json_encode('This information has been updated!'));
	} else {
		die(json_encode('Process fail! Please try again.'));
	}

}

/**
@ function : __deleteBackground
**/

function __deleteBackground(){
    global $background_cls,$systemlog_cls;

	$background_ids = getParam('background_id');
	if (strlen($background_ids) > 0) {
	    $rows = $background_cls->getRows("background_id IN ({$background_ids})");
        if (is_array($rows) and count($rows)> 0){
            foreach ($rows as $row){
                @unlink(ROOTPATH.'/store/uploads/background/img/'.$row['link']);
                @unlink(ROOTPATH.'/store/uploads/background/thumbs/'.$row['link']);
				
				ftp_mediaDelete('/store/uploads/background/img/', $row['link']);
				ftp_mediaDelete('/store/uploads/background/thumbs/', $row['link']);
            }
        }
        $background_cls->delete("background_id IN ({$background_ids})");
        $systemlog_cls->insert(array('Updated' => date("Y-m-d H:i:s"),
									 'Action' => 'DELETE',
									 'Detail' => "DELETE BACKGROUND ID :". $background_ids,
                                     'UserID' => $_SESSION['Admin']['EmailAddress'],
									 'IPAddress' =>$_SERVER['REMOTE_ADDR']));
        die(json_encode('Deleted successful !'));
    }
    die(json_encode('No item choose !'));
}

/**
@ function : __bannerListAction
**/

function __bannerListAction(){
    global $theblock_banner_cls,$dir;
	$start = getParam('start', 0);
	$limit = getParam('limit', 25);
	$sort_by = getParam('sort', 'b.theblock_banner_id');


	$rows = $theblock_banner_cls->getRows('SELECT SQL_CALC_FOUND_ROWS b.*
								  FROM '.$theblock_banner_cls->getTable().' AS b
								  ORDER BY '.$sort_by.' DESC
								  LIMIT '.$start.','.$limit,true);
	$totalCount = $theblock_banner_cls->getFoundRows();
	$retArray = array();

	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
            $row['active_value'] = $row['active'];
            $row['active'] = $row['active'] == 1?'<span>Active</span>':'<span class="grid_warn">InActive</span>';
            $row['thumb_url_header'] = MEDIAURL.'/store/uploads/background/thumbs/'.$row['link_header'];
			$row['thumb_url_footer'] = MEDIAURL.'/store/uploads/background/thumbs/'.$row['link_footer'];
			$retArray[] = $row;
		}
	}

	$arrJS = array("totalCount" => $totalCount, "topics" => $retArray);
	die(json_encode($arrJS));
}


/**
@ function : __bannerUploadAction
**/

function __bannerUploadAction(){
	global $theblock_banner_cls, $dir;
	//upload Image
	$id = getParam('id', 0);
	$theblock_id = getParam('block');
	
	createFolder($dir.'thumbs', 2);
	createFolder($dir.'img', 2);
	try {
		$data = array('cms_page' => $_GET['cms'],
				'active' => isset($_POST['active']['fixed']) ? 1 : 0,
				'theblock_id' => $theblock_id);
				
		if ($id == 0) {
			if (strlen(@$_FILES['link_header']['name']) == 0) {
				throw new Exception('Banner header is invalid1.');
			}
			
			if (strlen(@$_FILES['link_footer']['name']) == 0) {
				throw new Exception('Banner footer is invalid.');
			}
		}
		
		$rs = Bg_uploadMedia('link_header');
		if ($rs['error']) {
			throw new Exception('Banner header '.$rs['msg']);
		}
		
		if (strlen($rs['file_name']) > 0) {
			$data['link_header'] = $rs['file_name'];
		}
		
		$rs = Bg_uploadMedia('link_footer');
		if ($rs['error']) {
			throw new Exception('Banner footer '.$rs['msg']);
		}
		
		if (strlen($rs['file_name']) > 0 ) {
			$data['link_footer'] = $rs['file_name'];
		}
				
		if ($id == 0){//insert
			$data['upload_time'] = date('Y-m-d H:i:s');
			$theblock_banner_cls->insert($data);
		} else {//update
			$row = $theblock_banner_cls->getCRow(array('link_header', 'link_footer'), 'theblock_banner_id = '.$id);
			if (isset($data['link_header']) && strlen($row['link_header']) > 0) {
                @unlink(ROOTPATH.'/store/uploads/background/img/'.$row['link_header']);
                @unlink(ROOTPATH.'/store/uploads/background/thumbs/'.$row['link_header']);
			}
			
			ftp_meidaDelete('/store/uploads/background/img/', $row['link_header']);
			ftp_meidaDelete('/store/uploads/background/thumbs/', $row['link_header']);
			
			if (isset($data['link_footer']) && strlen($row['link_footer']) > 0) {
                @unlink(ROOTPATH.'/store/uploads/background/img/'.$row['link_footer']);
                @unlink(ROOTPATH.'/store/uploads/background/thumbs/'.$row['link_footer']);
			}

			ftp_meidaDelete('/store/uploads/background/img/', $row['link_footer']);
			ftp_meidaDelete('/store/uploads/background/thumbs/', $row['link_footer']);
			
			$theblock_banner_cls->update($data, 'theblock_banner_id ='.$id);
		}
		echo '{"success":true}';
	} catch (Exception $e) {
		echo '{"success":true,"error":1,"msg":\''.$e->getMessage().'\'}';
	}
	exit();
}

/**
@ function : __bannerDeleteAction
**/

function __bannerDeleteAction(){
    global $theblock_banner_cls, $systemlog_cls;

	$ids = getParam('theblock_banner_id');
	if (strlen($ids) > 0) {
	    $rows = $theblock_banner_cls->getRows("theblock_banner_id IN ({$ids})");
        if (is_array($rows) and count($rows)> 0){
            foreach ($rows as $row){
                @unlink(ROOTPATH.'/store/uploads/background/img/'.$row['link_header']);
                @unlink(ROOTPATH.'/store/uploads/background/thumbs/'.$row['link_header']);
				
                @unlink(ROOTPATH.'/store/uploads/background/img/'.$row['link_footer']);
                @unlink(ROOTPATH.'/store/uploads/background/thumbs/'.$row['link_footer']);
            }
        }
		
        $theblock_banner_cls->delete("theblock_banner_id IN ({$ids})");
        $systemlog_cls->insert(array('Updated' => date("Y-m-d H:i:s"),
									 'Action' => 'DELETE',
									 'Detail' => "DELETE THE BLOCK\'S BANNER ID :". $ids,
                                     'UserID' => $_SESSION['Admin']['EmailAddress'],
									 'IPAddress' => $_SERVER['REMOTE_ADDR']));
        die(json_encode('Deleted successful !'));
    }
    die(json_encode('No item choose !'));
}

/**
@ function : __bannerActiveAction
**/

function __bannerActiveAction(){
    global $theblock_banner_cls, $systemlog_cls;
	$id = (int)getParam('theblock_banner_id', 0);
	$theblock_banner_cls->update(array('active' => array('fnc' => 'abs(1 - active)')), 'theblock_banner_id = '.$id);
	$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
								  'Action' => 'UPDATE',
								  'Detail' => "(IN)ACTIVE THE BLOCK BANNER ID :". $id,
								  'UserID' => $_SESSION['Admin']['EmailAddress'],
								  'IPAddress' => $_SERVER['REMOTE_ADDR']));
	die(json_encode('This information has been updated!'));
}

function __getBackground(){
    global $background_cls;
    $background_id = restrictArgs(getParam('id',0));
    if ($background_id > 0){
        $row = $background_cls->getRow('background_id = '.$background_id);
        if (is_array($row) and count($row)> 0){
            $row['thumb_url'] = ($row['type'] == 'top')?MEDIAURL.'/store/uploads/background/'.$row['link']
                                :MEDIAURL.'/store/uploads/background/thumbs/'.$row['link'];
            $row['success'] = 1;
            die(json_encode($row));
        }
    }
    die(json_encode(array('error'=>1)));
}

?>

