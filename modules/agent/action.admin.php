<?php
//session_start();
ini_set('display_errors', 0);
include '../../configs/config.inc.php';
include ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include_once ROOTPATH.'/admin/functions.php';
include_once 'lang/agent.en.lang.php';
include_once ROOTPATH.'/includes/checkingform.class.php';
include_once ROOTPATH.'/modules/configuration/inc/configuration.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/agent/inc/partner.php';
include_once ROOTPATH.'/modules/general/inc/bids_first.class.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once ROOTPATH.'/includes/pagging.class.php';
include_once ROOTPATH.'/utils/ajax-upload/server/php.php';
include_once ROOTPATH.'/modules/payment/inc/payment_store.class.php';
include_once ROOTPATH.'/modules/agent/inc/company.php';

include_once ROOTPATH.'/modules/general/inc/ftp.php';
include_once ROOTPATH.'/modules/general/inc/media.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/general/inc/bids_first.class.php';
include_once ROOTPATH.'/utils/ajax-upload/server/php.php';
include_once ROOTPATH.'/modules/theblock/inc/background.php';

if (!$payment_store_cls || !($payment_store_cls instanceof Payment_store)) {
    $payment_store_cls = new Payment_store();
}
if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
    $pag_cls = new Paginate();
}
if (!isset($bids_first_cls) or !($bids_first_cls instanceof Bids_first)) {
    $bids_first_cls = new Bids_first();
}

if (!$_SESSION['Admin']) {
	die('logout');
}

restrict4AjaxBackend();

if (!isset($bids_first_cls) or !($bids_first_cls instanceof Bids_first)) {
	$bids_first_cls = new Bids_first();
}

if (!isset($check)) {
	$check = new CheckingForm();
}

$action = getParam('action');
$token = getParam('token');
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
if (eregi('-', $action)) {
	$action_ar = explode('-',$action);
	switch ($action_ar[1]) {
		case 'agent':

			include_once ROOTPATH.'/modules/general/inc/regions.php';
			include_once ROOTPATH.'/modules/agent/inc/admin.agent.php';
			include_once ROOTPATH.'/modules/property/inc/property.php';
			include_once ROOTPATH.'/modules/general/inc/bids.php';
			include_once ROOTPATH.'/modules/note/inc/note.php';
            include_once ROOTPATH.'/modules/facebook-twitter/inc/twitter_detail.class.php';
            include_once ROOTPATH.'/modules/facebook-twitter/inc/fb.fb_detail.class.php';

            include_once ROOTPATH.'/modules/configuration/inc/config.class.php';
			include_once ROOTPATH.'/modules/agent/inc/partner.php';
			include_once ROOTPATH.'/modules/banner/inc/banner.php';

            /*if (!isset($fb_cls) || !($fb_cls instanceof Facebook)) {
                $fb = array('appId' => $config_cls->getKey('facebook_application_api_id'),
                            'secret' => $config_cls->getKey('facebook_application_secret'));
                $fb_cls = new Facebook($fb);
            }
            if (!isset($tw_cls) || !($tw_cls instanceof Twitter)) {
                $tw_cls = new Twitter($config_cls->getKey('twitter_consumer_key'),$config_cls->getKey('twitter_consumer_secret'));
            }*/

			switch ($action_ar[0]) {
				case 'list':
					if ($perm_ar['view'] == 1) {
						__agentListAction();
					} else {
						die(json_encode($perm_msg_ar['view']));
					}
				break;
				case 'delete':
					if ($perm_ar['delete'] == 1) {
						__agentDeleteAction();
					} else {
						die(json_encode($perm_msg_ar['delete']));
					}
				break;
				case 'active':
					if ($perm_ar['edit'] == 1) {
						__agentActiveAction();
					} else {
						die(json_encode($perm_msg_ar['edit']));
					}
				break;
                case 'list_type':
                    $options[] = array('value'=>'','title'=>'All');
                    foreach (AgentType_getOptions_(false) as $key=>$row){
                        $options[] = array('value'=>$key,'title'=>$row);
                    }
                    $result = array('data'=>$options);
                    die(json_encode($result));
                    break;
			}
		break;
        case 'bidder':

            switch ($action_ar[0]){
                case 'list':
                    if ($perm_ar['view'] == 1) {
						__bidderListAction();
					} else {
						die(json_encode($perm_msg_ar['view']));
					}
                    break;
                case 'view':
                    $agent_id = (int)preg_replace('#[^0-9]#','',isset($_REQUEST['agent_id']) ? $_REQUEST['agent_id'] : 0);
                    die(__prepareAction($agent_id));
                    break;
                default:
                    break;
            }
        default:

            switch ($action) {
                case 'search-property':
                    if ($perm_ar['edit'] == 1) {
                        __searchPropertyAction();
                    } else {
                        die(json_encode($perm_msg_ar['edit']));
                    }
                    break;
                case 'add-property':
                    if ($perm_ar['edit'] == 1) {
                        __addPropertyAction();
                    } else {
                        die(json_encode($perm_msg_ar['edit']));
                    }
                    break;
                case 'upload-logo-block':
                     $agent_id = (int)getParam('id');
                     $df_width = 205;
                     //$df_height = 1000;
                     $path_pre = '/store/uploads/logo/';
                     $dir = ROOTPATH . $path_pre;
                     createFolder(ROOTPATH.'/store/uploads/logo',2);
                     $sizeLimit = 2 * 1024 * 1024;
                     $allowedExtensions = array('gif', 'jpg', 'jpeg', 'bmp', 'png');
                     $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, false);
                     $result = $uploader->handleUpload($dir);
                     if (isset($result['success'])) {
                         list($width, $height) = getimagesize($dir . $result['filename']);
                         if ($width  > $df_width /*&& $height > $df_height*/){
                             if ($width == $height) {
                                 $new_width = $new_height = $df_width;
                             } else/*if ($width > $height)*/ { //max:185px
                                 $new_width = $df_width;
                                 $new_height = $height * ($df_width / $width);
                             }/* else {
                                 $new_height = $df_height;
                                 $new_width = $height * ($df_height / $height);
                             }*/
                             resizeImage($dir . $result['filename'], $new_width, $new_height);
                         }
                         if (isset($_SESSION['block'][$agent_id]['logo']) && strlen($_SESSION['block'][$agent_id]['logo']) > 0){
                             @unlink($_SESSION['block'][$agent_id]['logo']);
                         }
                         $_SESSION['block'][$agent_id]['logo'] = $path_pre.$result['filename'];
                         $result['nextAction'] = array();
                         $result['nextAction']['method'] = 'showLogo';
                         $result['nextAction']['args'] = array(
                             'image' => ROOTURLS . $path_pre . $result['filename'],
                             'file_name' => $result['filename'],
                             'ext' => strtolower(end(explode(".", $result['filename']))),
                             'admin'=>1,
                             'height'=>$new_height,
                             'container'=>'logo'
                         );
                     } else if (!isset($result['error'])) {
                         $result['error'] = 'Error';
                     }
                     die(_response($result));
                     break;
                case 'upload-banner-agent':
                     $default_width = 420;
                     $result = uploadLogo($default_width);
                     $agent_id = (int)restrictArgs(getParam('id',0));
                     if (isset($result['nextAction'])){
                         if (isset($_SESSION['auction'][$agent_id]['logo']) && strlen($_SESSION['auction'][$agent_id]['logo']) > 0) {
                             @unlink($_SESSION['auction'][$agent_id]['logo']);
                         }
                         $_SESSION['auction'][$agent_id]['logo'] = $result['nextAction']['args']['file_name'];
                     }
                     die(json_encode($result));
                     break;
                case 'upload-logo':
                    __uploadLogo();
                    break;
                case 'prepare-region':
                    $p = (int)restrictArgs(getQuery('p', 1));
                    $p = $p <= 0 ? 1 : $p;
                    $len = getParam('len', 20);
                    $agent_id = (int)restrictArgs(getParam('agent_id',0));
                    $str = '<table width="100%" class="grid-table" cellspacing="1">
                            <tr class="title">
                                <td width="60px" align="center" style="font-weight:bold;color:#fff;">#</td>
                                <td align="center" style="font-weight:bold;color:#fff;">Region</td>
                                <td align="center" style="font-weight:bold;color:#fff;width:60px;">Edit</td>
                                <td align="center" style="font-weight:bold;color:#fff;width:60px;">Delete</td>
                            </tr>';
                    $page = '';
                    $rows = $partner_region_cls->getRows('SELECT SQL_CALC_FOUND_ROWS *,
                                                    (SELECT reg1.name
                                                     FROM ' . $region_cls->getTable() . ' AS reg1
                                                     WHERE reg1.region_id = p.state
                                                     ) AS state_name,

                                                     (SELECT reg1.name
                                                     FROM ' . $region_cls->getTable() . ' AS reg1
                                                     WHERE reg1.region_id = p.country
                                                     ) AS country_name

                                                  FROM ' . $partner_region_cls->getTable() . ' AS p
                                                  WHERE p.agent_id = ' . $agent_id . '
                                                  ORDER BY p.ID DESC
                                                  LIMIT ' . (($p - 1) * $len) . ',' . $len, true);
                    $total = $partner_region_cls->getFoundRows();
                    $pag_cls->setTotal($total)
                            ->setPerPage($len)
                            ->setCurPage($p)
                            ->setLenPage(10)
                            ->setUrl('')
                            ->setParam('prepare-region')
                            ->setParam('#region')
                            ->setLayout('ajax')
                            ->setFnc('agent.prepareList');
                    if (is_array($rows) and count($rows) > 0) {
                        $i = ($p-1)*$len;
                        foreach ($rows as $k=>$row) {
                            $i++;
                            $row['region'] = implode(' ', array($row['suburb'], $row['state_name'], $row['other_state'], $row['postcode'], $row['country_name']));

                            $str .= '<tr class="item'.($row['ID']%2 == 0?1:2).'" id="row_'.$row['ID'].'">
                                        <td align="center">'.$i.'</td>
                                        <td>
                                            '.$row['region'].'
                                        </td>
                                        <td align="center">
                                            <a href="javascript:void(0)" onclick="agent.editRegion(' . $row['ID'] . ',\'row\')">Edit</a>
                                        </td>
                                        <td align="center">
                                            <a href="javascript:void(0)" onclick="agent.deleteRegion(' . $row['ID'] . ',\'row\')">Delete</a>
                                        </td>
                                    </tr>';

                        }
                    }
                    $page = '<div class="clearthis"></div>' . $pag_cls->layout();
                    $str .= '</tbody></table>' . $page;
                    die($str);
                    break;
                case 'prepare-partner':
                    $agent_id = (int)restrictArgs(getParam('agent_id',0));
                    $p = (int)restrictArgs(getQuery('p', 1));
                    $p = $p <= 0 ? 1 : $p;
                    $len = getParam('len', 20);
                    $str = '<table width="100%" class="grid-table" cellspacing="1">
                                <tr class="title">
                                    <td width="60px" align="center" style="font-weight:bold;color:#fff;">#</td>
                                    <td align="center" style="font-weight:bold;color:#fff;">Company</td>
                                    <td align="center" style="font-weight:bold;color:#fff;">Address</td>
                                    <td align="center" style="font-weight:bold;color:#fff;">Telephone</td>
                                    <td align="center" style="font-weight:bold;color:#fff;width:60px;">Edit</td>
                                    <td align="center" style="font-weight:bold;color:#fff;width:60px;">Delete</td>
                                </tr>';
                    $page = '';
                    $rows = $partner_ref_cls->getRows('SELECT SQL_CALC_FOUND_ROWS *
                                                  FROM ' . $partner_ref_cls->getTable() . '
                                                  WHERE agent_id = ' . $agent_id . '
                                                  ORDER BY ref_id DESC
                                                  LIMIT ' . (($p - 1) * $len) . ',' . $len, true);
                    $total = $partner_ref_cls->getFoundRows();
                    $pag_cls->setTotal($total)
                            ->setPerPage($len)
                            ->setCurPage($p)
                            ->setLenPage(10)
                            ->setUrl('')
                            ->setParam('prepare-partner')
                            ->setParam('#reference')
                            ->setLayout('ajax')
                            ->setFnc('agent.prepareList');
                    if (is_array($rows) and count($rows) > 0) {
                        $i = ($p-1)*$len;
                        foreach ($rows as $k=>$row) {
                            $i++;
                            $str .=  '<tr class="item'.($k%2 == 0?1:2).'" id="par_' . $row['ref_id'] . '">
                                        <td align="center">'.$i.'</td>
                                        <td>
                                            <b>'.$row['company_name'].'</b>
                                            <br />
                                            <i><a href="mailto:'.$row['email_address'].'">'.$row['email_address'].'</a></i>
                                        </td>
                                        <td>'.$row['address'].'</td>
                                        <td>'.$row['telephone'].'</td>
                                        <td align="center">
                                            <a href="javascript:void(0)" onclick="agent.editRegion(' . $row['ref_id'] . ',\'par\')">Edit</a>
                                        </td>
                                        <td align="center">
                                            <a href="javascript:void(0)" onclick="agent.deleteRegion(' . $row['ref_id'] . ',\'par\')">Delete</a>
                                        </td>
                                    </tr>';

                        }
                    }
                    $page = '<div class="clearthis"></div>' . $pag_cls->layout();
                    $str .= '</tbody></table>' . $page;
                    die($str);
                    break;
                case 'add-region':
                    $param = getPost('params');
                    if ($param['country'] == 1) {
                        $param['other_state'] = '';
                    } else {
                        $param['state'] = '';
                    }
                    $id = (int)restrictArgs($param['ID']);
                    unset($param['ID']);
                    if ($id == 0) {
                        $partner_region_cls->insert($param);
                    } else {
                        $partner_region_cls->update($param, ' ID = ' . $id);
                    }
                    if ($partner_region_cls->hasError()) {
                        die(json_encode(array('msg' => 'Process fail ! Try again.')));
                    } else {
                        die(json_encode(array('success' => 1)));
                    }
                    break;
                case 'add-partner':
                    $param = getPost('params');
                    $id = (int)restrictArgs($param['ref_id']);
                    unset($param['ref_id']);
                    if ($id == 0) {
                        $partner_ref_cls->insert($param);
                    } else {
                        $partner_ref_cls->update($param, ' ref_id = ' . $id);
                    }
                    if ($partner_ref_cls->hasError()) {
                        die(json_encode(array('msg' => 'Process fail ! Try again.')));
                    } else {
                        die(json_encode(array('success' => 1)));
                    }
                    break;
                case 'delete-region':
                    $id = (int)restrictArgs(getParam('id'));
                    $row = $partner_region_cls->getRow("ID = '{$id}'");
                    if (is_array($row) and count($row) > 0) {
                        $partner_region_cls->delete("ID = '{$id}'");
                        die(json_encode(array('success' => 1)));
                    }
                    die(json_encode(array('msg' => 'You have not permission to delete it!')));
                    break;
                case 'edit-region':
                    $id = (int)restrictArgs(getParam('id'));
                    $row = $partner_region_cls->getRow("ID = '{$id}'");
                    if (is_array($row) and count($row) > 0) {
                        die(json_encode($row));
                    }
                    die(json_encode(array('msg' => 'You have not permission to edit it!')));
                    break;
                case 'delete-partner':
                    $id = (int)restrictArgs(getParam('id'));
                    $row = $partner_ref_cls->getRow("ref_id = '{$id}'");
                    if (is_array($row) and count($row) > 0) {
                        $partner_ref_cls->delete("ref_id = '{$id}'");
                        die(json_encode(array('success' => 1)));
                    }
                    die(json_encode(array('msg' => 'You have not permission to delete it!')));
                    break;
                case 'edit-partner':
                    $id = (int)restrictArgs(getParam('id'));
                    $row = $partner_ref_cls->getRow("ref_id = '{$id}'");
                    if (is_array($row) and count($row) > 0) {
                        die(json_encode($row));
                    }
                    die(json_encode(array('msg' => 'You have not permission to edit it!')));
                    break;
                case 'get-parent':
                    $type_id = (int)restrictArgs(getParam('type',0));
                    $options = A_getParentOption($type_id,array(0=>'None'));
                    die(json_encode($options));
                    break;
                case 'check-user':

                    $key = $agent_cls->escape(getParam('key',''));
                    $site_id = restrictArgs(getParam('site',0));
                    $site_id = $site_id > 0?$site_id:0;
                    $result = Agent_checkValidSite($key,$site_id,$message);
                    if ($result){
                        die(json_encode(array('avai'=>1)));
                    }else{
                        die(json_encode(array('unavai'=>1,'msg'=>$message)));
                    }
                    break;
                case 'upload-background-left':
                case 'upload-background-right':
                case 'upload-background-top':

                    $action_ar = explode('-',$action);

                    $target = getParam('target');
                    $sizeLimit = 5 * 1024 * 1024;
                    $allowedExtensions = array('gif', 'jpg', 'jpeg', 'bmp', 'png');

                    $path = ROOTPATH . '/store/uploads/background';
                    $path_relative = '/store/uploads/background';
                    createFolder($path, 2);
                    createFolder($path . '/thumbs', 1);

                    $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, false);
                    $result = $uploader->handleUpload($path . '/img/');

                    if (isset($result['success'])) {
                            switch ($action_ar[2]){
                                case 'left':
                                case 'right':
                                    resizeImgByPercent($path.'/img/'.$result['filename'],
                                                       $path.'/thumbs/'.$result['filename'],
                                                       136,0
                                    );

                                    $ftp_path = ftp_getPath($path);
                                    ftp_mediaUpload($path.'/img/', $result['filename']);
                                    $ftp_cls->copyFile($path.'/thumbs/'.$result['filename'], $ftp_path.'/thumbs');
                                    break;
                                case 'top':
                                    list($width,$height) = getimagesize($path.'/img/'.$result['filename']);
                                    if ($width > 376){
                                            resizeImgByPercent($path.'/img/'.$result['filename'],
                                                           $path.'/img/'.$result['filename'],
                                                           376,0
                                            );
                                            list($width,$height) = getimagesize($path.'/'.$result['filename']);
                                    }
                                    if ($height > 79){
                                            resizeImgByPercent($path.'/img/'.$result['filename'],
                                                           $path.'/'.$result['filename'],
                                                           0,79
                                        );
                                    }
                                    ftp_mediaUpload($path.'/img/',$result['filename']);
                                    break;
                            }
                            $_SESSION['Admin']['bg'][$action_ar[2]] = $result['filename'];

                            $result['nextAction'] = array();
                            $result['nextAction']['method'] = $action_ar[2] == 'top'?'viewLogo':'viewBackground';
                            $result['nextAction']['args'] = array('target' => $target,
                                                                  'image' => $action_ar[2] == 'top'?MEDIAURL . $path_relative . '/img/'.$result['filename']:MEDIAURL . $path_relative . '/thumbs/' . $result['filename'],
                                                                  'type'=>'background-'.$action_ar[2],
                                                                  'agent_id'=>getParam('agent_id',0),
                                                                  'admin'=>1
                            );
                            die(_response($result));
                    }else{
                            die(_response($result));
                    }
                    break;
                case 'delete-background-top':
                case 'delete-background-left':
                case 'delete-background-right':
                    $action_ar = explode('-',$action);
                    $agent_id = getParam('id',0);
                    $row = $background_cls->getCRow(array('background_id','link'),"type = '{$action_ar[2]}' AND agent_id = ".$agent_id);
                    if (is_array($row) and count($row) > 0){
                        $background_cls->delete('background_id = '.$row['background_id']);
                        if (is_file(ROOTPATH.'/store/uploads/background/img/'.$row['link'])){
                            @unlink(ROOTPATH.'/store/uploads/background/img/'.$row['link']);
                        }
                        if (is_file(ROOTPATH.'/store/uploads/background/thumbs/'.$row['link'])){
                            @unlink(ROOTPATH.'/store/uploads/background/thumbs/'.$row['link']);
                        }
                    }
                    unset($_SESSION['Admin']['bg']);
                    die(json_encode(array('success'=>1)));
                    break;
            }
            break;
	}
}

/*-------------*/
function __agentListAction() {
	global $agent_cls, $region_cls, $token, $company_cls;
	$start = (int)( $_REQUEST['start'] == 0 ? 0 : $_REQUEST['start'] );
	$limit = (int)($_REQUEST['limit'] == 0 ? 20 : $_REQUEST['limit'] );
	$sort_by = $_REQUEST['sort'] == '' ? 'pro.property_id' : $_REQUEST['sort'] ;
	$dir = $_REQUEST['dir'] == '' ? 'ASC' : $_REQUEST['dir'] ;

	$sort_by = $agent_cls->escape($sort_by);
	$dir = $agent_cls->escape($dir);

	/*$search_query = $agent_cls->escape(isset($_REQUEST['search_query']) ? $_REQUEST['search_query']:'');*/
	$search_query = getParam('query');
    $search_query = utf8_encode($search_query);
	$search_where = '';
	if (strlen($search_query) > 0) {
		$search_where = "WHERE (agt.street LIKE '%".$search_query."%'
								OR agt.firstname LIKE '%".$search_query."%'
								OR agt.lastname LIKE '%".$search_query."%'
								OR CONCAT(agt.firstname,' ',agt.lastname) LIKE '%".$search_query."%'
								OR agt.agent_id = '".$search_query."'
								OR agt.postcode = '".$search_query."'
								OR agt.suburb LIKE '%".$search_query."%'
								OR (SELECT reg1.name FROM ".$region_cls->getTable()." AS reg1 WHERE reg1.region_id = agt.state) LIKE '%".$search_query."%'
								OR (SELECT reg2.name FROM ".$region_cls->getTable()." AS reg2 WHERE reg2.region_id = agt.country) LIKE '%".$search_query."%'
								OR agt.email_address LIKE '%".$search_query."%'
								OR agt.mobilephone LIKE '%".$search_query."%'
								OR agt.telephone LIKE '%".$search_query."%'
								OR c.suburb LIKE '%".$search_query."%'
								OR (SELECT reg1.name FROM ".$region_cls->getTable()." AS reg1 WHERE reg1.region_id = c.state) LIKE '%".$search_query."%'
								OR (SELECT reg2.name FROM ".$region_cls->getTable()." AS reg2 WHERE reg2.region_id = c.country) LIKE '%".$search_query."%'
								OR c.telephone LIKE '%".$search_query."%')";

	}
    $filter = getParam('type','');
    if ($filter != ''){
         $_filter = $search_where == ''? ' WHERE agt.type_id ='.$filter:' AND agt.type_id ='.$filter;
    }

	$rows = $agent_cls->getRows('SELECT SQL_CALC_FOUND_ROWS
										agt.agent_id,
										agt.type_id,
										agt.firstname,
										agt.lastname,
										agt.street,
										agt.suburb,
										agt.postcode,
										agt.telephone,
										agt.mobilephone,
										agt.email_address,
										agt.is_active,
										agt.country,
										agt.other_state,
										agt_typ.title AS type,
										agt_typ.name AS type_name,
										agt.parent_id,
										agt.general_contact_partner,
										agt.website_partner,
										agt.creation_time,
										agt.instance,
										c.address,
										c.suburb AS c_suburb,
										c.other_state AS c_other_state,
										c.telephone AS c_telephone,
										c.postcode AS c_postcode,

										(SELECT CONCAT(a.firstname," ",a.lastname) FROM '.$agent_cls->getTable().' AS a
										 WHERE a.agent_id = agt.parent_id) AS parent_name,

										(SELECT reg1.code
										FROM '.$region_cls->getTable().' AS reg1
										WHERE reg1.region_id = agt.state
										) AS state_name,

										(SELECT reg2.name
										FROM '.$region_cls->getTable().' AS reg2
										WHERE reg2.region_id = agt.country
										) AS country_name,

										(SELECT reg1.code
										FROM '.$region_cls->getTable().' AS reg1
										WHERE reg1.region_id = c.state
										) AS c_state_name,

										(SELECT reg2.name
										FROM '.$region_cls->getTable().' AS reg2
										WHERE reg2.region_id = c.country
										) AS c_country_name

								FROM '.$agent_cls->getTable().' AS agt
								INNER JOIN '.$agent_cls->getTable('agent_type').' AS agt_typ ON agt.type_id = agt_typ.agent_type_id
								LEFT JOIN '.$company_cls->getTable().' AS c ON agt.agent_id = c.agent_id
								'.$search_where.@$_filter.'
								ORDER BY '.$sort_by.' '.$dir.'
								LIMIT '.$start.','.$limit,true);

	$total = $agent_cls->getFoundRows();

	$topics = array();

	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {

		    $row['full_name'] = $row['firstname'].' '.$row['lastname'];

			/*if ($row['country'] == 1) {
				$row['address'] = $row['street'].', '.$row['suburb'].', '.$row['postcode'].', '.$row['state_name'].', '.$row['country_name'];
			} else {
				$row['address'] = $row['street'].', '.$row['suburb'].', '.$row['postcode'].', '.$row['other_state'].', '.$row['country_name'];
			}*/

			$row['address'] = !in_array($row['type'],array('agent','theblock'))?
                              $row['street'].', '.implode(' ',array($row['suburb'],$row['state_name'],$row['other_state'],$row['postcode'],$row['country_name']))
                              :$row['address'].', '.implode(' ',array($row['c_suburb'],$row['c_state_name'],$row['c_other_state'],$row['c_postcode'],$row['c_country_name']));
            $row['telephone'] = !in_array($row['type'],array('agent','theblock'))?$row['telephone']:$row['c_telephone'];
            $edit_link = '?module=agent&action=edit&agent_id='.$row['agent_id'].'&token='.$token;
			$row['edit_link'] = '<a href="'.$edit_link.'"><img src="/admin/resources/images/default/dd/table_edit.png"/></a>';

			$delete_link = '../modules/agent/action.admin.php?action=delete-agent&agent_id='.$row['agent_id'].'&token='.$token;

            if (!in_array($row['type'],array('agent','theblock'))){
                $row['delete_link'] = '<a onclick ="outAction(\'delete\','.$row['agent_id'].')"><img src="/admin/resources/images/default/dd/delete.png"/></a>';
            }

			$row['type'] = ucfirst($row['type']);
            /*activated_by*/
            $row['activated_by'] = 'User';
			$topics[] = $row;
		}
	}

	$result = array('totalCount' => $total,'topics' => $topics);
	die(json_encode($result));
}

function __agentDeleteAction() {
	global $agent_cls, $message_cls, $watchlist_cls, $bid_cls, $note_cls, $agent_creditcard_cls, $agent_history_cls,
           $company_cls,$agent_payment_cls,$agent_logo_cls,
	       $agent_lawyer_cls, $agent_contact_cls, $property_cls, $twitter_detail_cls, $fb_detail_cls, $agent_cls, $partner_cls, $systemlog_cls, $banner_cls;
	/*$agent_id = (int)preg_replace('#[^0-9]#','',isset($_REQUEST['agent_id']) ? $_REQUEST['agent_id'] : 0);
	if ($agent_id > 0) {
		$message_cls->delete('agent_id_from = '.$agent_id);
		$message_cls->update(array('read' => 1, 'draft' => 1),'agent_id_to = '.$agent_id);

		$watchlist_cls->delete('agent_id = '.$agent_id);
		$bid_cls->delete('agent_id = '.$agent_id);

		$note_cls->delete('entity_id_from = '.$agent_id." AND `type` = 'customer2property'");
		$note_cls->delete('entity_id_to = '.$agent_id." AND `type` = 'admin2customer'");

		$agent_creditcard_cls->delete('agent_id = '.$agent_id);
		$agent_history_cls->delete('agent_id = '.$agent_id);
		$agent_lawyer_cls->delete('agent_id = '.$agent_id);
		$agent_contact_cls->delete('agent_id = '.$agent_id);
		$agent_cls->delete('agent_id = '.$agent_id);

			// Write Logs
		mysql_query("INSERT INTO `systemlogs` SET  `Updated`='".date("Y-m-d H:i:s")."', `Action`='DELETE',  `Detail`='DELETE AGENT ID: $agent_id ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '".$_SERVER['REMOTE_ADDR']."'");



		deleteFolder(ROOTPATH.'/stores/uploads/'.$agent_id);
		@rmdir(ROOTPATH.'/store/uploads/'.$agent_id);
		$message = 'Deleted #'.$agent_id;
	}
	die($message);*/
		$message = '';
		$agent_ids = getParam('agent_id');
		$message = $agent_ids;
		if (strlen($agent_ids) > 0) {
			$agent_id_ar = explode(',',$agent_ids);
			if (count($agent_id_ar) > 0) {
				foreach ($agent_id_ar as $agent_id) {
					$row = $agent_cls->getRow('agent_id = '.$agent_id);
					if (is_array($row) && count($row) > 0) {
						//del full information
						Property_deleteFullAgent($agent_id);
                        $message_cls->delete('agent_id_from = '.$agent_id);
						$message_cls->update(array('read' => 1, 'draft' => 1),'agent_id_to = '.$agent_id);

						$watchlist_cls->delete('agent_id = '.$agent_id);
						$bid_cls->delete('agent_id = '.$agent_id);

						$note_cls->delete('entity_id_from = '.$agent_id." AND `type` = 'customer2property'");
						$note_cls->delete('entity_id_to = '.$agent_id." AND `type` = 'admin2customer'");

						$agent_creditcard_cls->delete('agent_id = '.$agent_id);
						$agent_history_cls->delete('agent_id = '.$agent_id);
						$agent_lawyer_cls->delete('agent_id = '.$agent_id);
						$agent_contact_cls->delete('agent_id = '.$agent_id);
                        $twitter_detail_cls->delete("agent_id = '".$row['provider_id']."'");
						$fb_detail_cls->delete("agent_id = '".$row['agent_id']."'");

                        $logo = $agent_logo_cls->getCRow(array('logo'),'agent_id = '.$agent_id);
                        if (is_array($logo) and count($logo) > 0){
                            @unlink(ROOTPATH.$logo['logo']);
                            $agent_logo_cls->delete('agent_id = '.$agent_id);
                        }

                        $row = $company_cls->getCRow(array('agent_id','logo'),'agent_id = '.$agent_id);
                        if (is_array($row) and count($row) > 0){
                            @unlink(ROOTPATH.$row['logo']);
                            $company_cls->delete('agent_id = '.$agent_id);
                            $agent_payment_cls->delete('agent_id = '.$agent_id);
                        }


						//$property_cls->delete('agent_id = '.$agent_id);
						$agent_cls->delete('agent_id = '.$agent_id);

						//$partner_cls->getRow('agent_id = '.$agent_id);
						$rowdeleteBan = $partner_cls->getRow('agent_id = '.$agent_id);
						if (count($rowdeleteBan) > 0) {

							@unlink(ROOTPATH.'/store/uploads/banner/images/partner/'.$rowdeleteBan['partner_logo']);
							@unlink(ROOTPATH.'/store/uploads/banner/images/partner/thumbs/'.$rowdeleteBan['partner_logo']);
							$partner_cls->delete('agent_id ='.$agent_id);
						}

						// If Agent is Partner And Account is Remove, Will Remove Banner Agent is Register
						$rowBannerDrm = $banner_cls->getRow('agent_id = '.$agent_id);
						if (count($rowBannerDrm) > 0){

							@unlink(ROOTPATH.'/store/uploads/banner/images/'.$rowBannerDrm['banner_file']);
							@unlink(ROOTPATH.'/store/uploads/banner/images/thumbs/'.$rowBannerDrm['banner_file']);
							@unlink(ROOTPATH.'/store/uploads/banner/images/thumbs/dashboard/'.$rowBannerDrm['banner_file']);
							@unlink(ROOTPATH.'/store/uploads/banner/images/thumbs/dashboard/mybanner/'.$rowBannerDrm['banner_file']);

							$banner_cls->delete('agent_id ='.$agent_id);

						}

						$message = 'Deleted successful !';

						// Write Logs
						$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
													 'Action' => 'DELETE',
													 'Detail' => "DELETE AGENT ID :". $agent_id,
													 'UserID' => $_SESSION['Admin']['EmailAddress'],
													 'IPAddress' =>$_SERVER['REMOTE_ADDR']));
					}
				}
			}
		}
		die(json_encode($message));
}

function __agentActiveAction() {
	global $agent_cls, $systemlog_cls;
	$agent_id = (int)preg_replace('#[^0-9]#','',isset($_REQUEST['agent_id']) ? $_REQUEST['agent_id'] : 0);
	$status = A_getStatus($agent_id);
	if ($status != ''){
		$status = 1-(int)$status;
		$status_label = $status == 0?'DISABLE':'ENABLE';
		$result = array('success'=>1,'status'=>$status_label);
		$agent_cls->update(array('is_active'=>$status),'agent_id='.$agent_id);
		$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									  'Action' => 'UPDATE',
									  'Detail' => $status_label." AGENT ID :". $agent_id,
									  'UserID' => $_SESSION['Admin']['EmailAddress'],
									  'IPAddress' =>$_SERVER['REMOTE_ADDR']));
	} else {
		$status_label = 'This information has been updated';
		$result = array('error'=>1,'status'=>$status_label);
	}

	die(json_encode('This information has been updated!'));
}

function __bidderListAction(){
    global $agent_cls, $bids_first_cls, $token,$property_cls;
    include_once ROOTPATH.'/modules/property/inc/property.php';
	$start = (int)( $_REQUEST['start'] == 0 ? 0 : $_REQUEST['start'] );
	$limit = (int)($_REQUEST['limit'] == 0 ? 20 : $_REQUEST['limit'] );
	$sort_by = $_REQUEST['sort'] == '' ? 'a.agent_id' : $_REQUEST['sort'] ;
	$dir = $_REQUEST['dir'] == '' ? 'ASC' : $_REQUEST['dir'] ;
    $query = restrictArgs(getParam('query',''),'[^0-9A-Za-z\-\_]');
    if($query == '')
    {
        $query = '1';
    }
    else{
        $query = " (a.agent_id = '{$query}'
                   OR a.agent_id IN (SELECT agt.agent_id FROM ".$agent_cls->getTable()." AS agt WHERE agt.firstname LIKE '%".$query."%' OR agt.lastname LIKE '%".$query."%'
							                       OR CONCAT(agt.firstname,' ',agt.lastname) LIKE '%".$query."%')
		           OR a.email_address LIKE '%{$query}%'
		           OR (SELECT agt.name
								     FROM {$agent_cls->getTable('agent_type')} AS agt
								     WHERE agt.agent_type_id = a.type_id
									 ) LIKE '%{$query}%' )
        ";
    }

    $auction_sale_ar = PEO_getAuctionSale();
    $rows = $agent_cls->getRows('SELECT a.*,
                                    (SELECT agt.name
								     FROM '.$agent_cls->getTable('agent_type').' AS agt
								     WHERE agt.agent_type_id = a.type_id
									 ) AS type_name,

                                 GROUP_CONCAT(property_id) As property_id FROM agent AS a
                                 INNER JOIN '.$bids_first_cls->getTable().' AS b ON a.agent_id = b.agent_id
                                 WHERE b.pay_bid_first_status > 0
                                 AND b.property_id IN (

                                 (SELECT pro.property_id
                                  FROM ' . $property_cls->getTable() . ' AS pro
                                  WHERE pro.active = 1
                                      AND  pro.agent_active = 1
                                      AND  pro.confirm_sold = 0
                                      AND  pro.stop_bid = 0
                                      AND  pro.pay_status = ' . Property::CAN_SHOW . '

                                      AND  pro.end_time > pro.start_time
                                      AND ((pro.end_time > \''.date('Y-m-d H:i:s').'\'
								           AND pro.start_time <= \''.date('Y-m-d H:i:s').'\')
								           OR pro.start_time > \''.date('Y-m-d H:i:s').'\')))
								  AND '.$query.'
                                 GROUP BY a.agent_id
                                 ORDER BY '.$sort_by.' '.$dir.'
								 LIMIT '.$start.','.$limit,true);
//AND  pro.auction_sale ='.$auction_sale_ar['auction'].'
    $total = $agent_cls->getFoundRows();
    if (is_array($rows) and count($rows)> 0){
        foreach ($rows as $row){
            $row['full_name'] = $row['firstname'].' '.$row['lastname'];
            $edit_link = '?module=agent&action=edit-bidder&agent_id='.$row['agent_id'].'&token='.$token;
			$row['edit_link'] = '<a href="'.$edit_link.'"><img src="/admin/resources/images/default/dd/table_edit.png"/></a>';
            $topics[] = $row;
        }
    }

	$result = array('totalCount' => $total,'topics' => $topics);
	die(json_encode($result));
}

function __searchPropertyAction(){
    global $pag_cls,$property_cls,$bids_first_cls;

    $p = (int)restrictArgs(getQuery('p', 1));
    $p = $p <= 0 ? 1 : $p;
    $len = 10;
    $auction_sale_ar = PEO_getAuctionSale();
    $val = getParam('property_id');
    $agent_id = getParam('agent_id');
    $agent_type = AgentType_getTypeAgent($agent_id);
    $str = $agent_type != 'theblock'?' AND property_id NOT IN (SELECT property_id FROM '.$property_cls->getTable().' WHERE agent_id = '.$agent_id.' )':'';
                                     /*' AND IF(pro.agent_manager = '.$agent_id;*/
    $rows = $property_cls->getRows('active = 1
                                         AND agent_active = 1
                                         AND confirm_sold = 0
                                         AND stop_bid = 0
                                         AND pay_status = ' . Property::CAN_SHOW . "

                                         AND end_time > start_time
                                         AND ((end_time > '".date('Y-m-d H:i:s')."'
								              AND start_time <= '".date('Y-m-d H:i:s')."')
								              OR start_time > '".date('Y-m-d H:i:s')."') AND property_id LIKE '{$val}%'
								         AND property_id NOT IN (SELECT b.property_id FROM ".$bids_first_cls->getTable()." AS b
								                                 WHERE b.agent_id = '{$agent_id}' AND b.pay_bid_first_status > 0)
								         {$str}
								         ORDER BY property_id
								         LIMIT ".(($p-1)*$len).",".$len);
	//AND auction_sale =' . $auction_sale_ar['auction']."

    //PAGING
    $total_row = $property_cls->getFoundRows();
    $pag_cls->setTotal($total_row)
            ->setPerPage($len)
            ->setCurPage($p)
            ->setLenPage(10)
            ->setUrl('')
            ->setLayout('ajax')
            ->setFnc('showProperty');

    /*$bids = array();
    $bid_first = $bids_first_cls->getRows('agent_id = '.$agent_id.' ANd pay_bid_first_status > 0');
    if (is_array($bid_first) and count($bid_first) > 0){
        foreach ($bid_first as $row){
            $bids[] = $row['property_id'];
        }
    }*/

    $html = '<tr id="result">
                <td></td>
                <td colspan="3">';

    if(is_array($rows) and count($rows) > 0){
        $html .= '<div style="width:650px;"><table class="grid-table" cellspacing="1" style="width:100%">';
        $i = 0;
        foreach ($rows as $row){
            //if (!in_array($row['property_id'],$bids)){
                $html .= '<tr class="item'.(($i++ % 2 == 0)?1:2).'">
                         <td width="10%">#'.$row['property_id'].'</td>
                         <td width="80%">'.safecontent($row['description'],300).'...</td>
                         <td align="center"><a class="add-property" href="javascript:void(0)" onclick="addProperty('.$row['property_id'].','.$agent_id.')">Add</a></td>
                      </tr>';
            //}
        }
        $html .= '</table><div class="clearthis"></div>'.$pag_cls->layout().'</div>';
    }else{
        $html .= 'No property match your key or this property registered to bid.';
    }
    $html .= '</td></tr>';
    die($html);

}
function __addPropertyAction(){
    include_once ROOTPATH.'/modules/property/inc/property.class.php';
    include_once ROOTPATH.'/modules/property/inc/property.php';

    if (!isset($property_cls) or !($property_cls instanceof Property)) {
            $property_cls = new Property();
    }
    global $bids_first_cls,$payment_store_cls;
    $property_id = (int)preg_replace('#[^0-9]#','',isset($_REQUEST['property_id']) ? $_REQUEST['property_id'] : 0);
    $agent_id = (int)preg_replace('#[^0-9]#','',isset($_REQUEST['agent_id']) ? $_REQUEST['agent_id'] : 0);

    $row = $bids_first_cls->getRow('property_id = '.$property_id.' AND agent_id = '.$agent_id);
    if (is_array($row) and count($row)> 0){
         $bids_first_cls->update(array('pay_bid_first_status'=> 2,
                                       'bid_first_time'=>date('Y-m-d H:i:s')),
                                       'property_id = '.$property_id.' AND agent_id = '.$agent_id);

    }else{
         $bids_first_cls->insert(array('property_id'=>$property_id,
                                  'agent_id'=>$agent_id,
                                  'pay_bid_first_status'=> 2,
                                  'bid_first_time'=>date('Y-m-d H:i:s')));

    }
    // QUAN : Update into Payment store
    $payment_row =  $payment_store_cls->getRow('property_id = '.$property_id.' AND agent_id = '.$agent_id.' AND bid = 1');

    if(count($payment_row) > 0 and is_array($payment_row)){
        $payment_store_cls->update(array('is_paid' => 2),'property_id = '.$property_id.' AND agent_id = '.$agent_id);
    }else{
        $payment_store_cls->insert(array('is_paid' => 2,
                                            'property_id' => $property_id,
                                            'agent_id' => $agent_id,
                                            'bid' => 1,
                                            'creation_time' => date('Y-m-d H:i:s')));
    }
    if (!$bids_first_cls->hasError()){
        $_row = $property_cls->getRow('SELECT set_count,no_more_bid
                                      FROM '.$property_cls->getTable().'
                                      WHERE property_id = '.$property_id,true);
        if ($_row['no_more_bid'] == 1){
            $set_count = $_row['set_count'] == 'No More Online Bids'?'Auction Live':$_row['set_count'];
            $property_cls->update(array('no_more_bid'=>0/*,
                                        'set_count'=>$set_count*/),'property_id = '.$property_id);
        }
        include_once ROOTPATH.'/modules/general/inc/bids_first.class.php';
        if (!isset($bids_first_cls) or !($bids_first_cls instanceof Bids_first)) {
            $bids_first_cls = new Bids_first();
        }
        $html = __prepareAction($agent_id);
        die($html);
    }
    die('error');
}

function __prepareAction($agent_id){
    global $pag_cls,$bids_first_cls;
    $token = getParam('token');
    include_once ROOTPATH.'/modules/property/inc/property.class.php';
    include_once ROOTPATH.'/modules/property/inc/property.php';
    if (!isset($property_cls) or !($property_cls instanceof Property)) {
            $property_cls = new Property();
    }
    $auction_sale_ar = PEO_getAuctionSale();
    $p = (int)preg_replace('#[^0-9]#','',isset($_REQUEST['p']) ? $_REQUEST['p'] : 1);
    $p = $p <= 0 ? 1 : $p;
    $len = 7;

    $html = '<table width="100%" class="grid-table" cellspacing="1" id="grid-table">
                        <tr class="title">
                            <td width="60px" align="center" style="font-weight:bold;color:#fff;">#</td>
                            <td align="center" style="font-weight:bold;color:#fff;">Description</td>
                            <td align="center" style="font-weight:bold;color:#fff;width:100px;">Remove</td>
                        </tr>';
    $rows = $property_cls->getRows('SELECT SQL_CALC_FOUND_ROWS pro.*,

                                   (SELECT CONCAT(a.firstname," ",a.lastname) FROM ' . $property_cls->getTable('agent') .
                                   ' AS a WHERE a.agent_id = pro.agent_id
                                   ) AS agent_name,

                                   (SELECT b.pay_bid_first_status FROM ' . $bids_first_cls->getTable() .
                                   ' AS b WHERE b.agent_id = ' . $agent_id . ' AND pro.property_id = b.property_id AND b.pay_bid_first_status > 0
                                   LIMIT 0,1) AS pay_bid_first_status

                                   FROM ' . $property_cls->getTable() . ' AS pro

                                   WHERE
                                         pro.active = 1
                                         AND  pro.agent_active = 1
                                         AND  pro.confirm_sold = 0
                                         AND  pro.stop_bid = 0
                                         AND  pro.pay_status = ' . Property::CAN_SHOW . "
                                         AND  pro.end_time > pro.start_time
                                         AND ((pro.end_time > '" . date('Y-m-d H:i:s') . "'
								              AND pro.start_time <= '" . date('Y-m-d H:i:s') . "')
								              OR pro.start_time > '" . date('Y-m-d H:i:s') . "')
								         AND pro.property_id IN (SELECT property_id FROM " . $bids_first_cls->getTable() . " AS b
								                                 WHERE b.agent_id = {$agent_id} AND b.pay_bid_first_status > 0)
								   GROUP BY pro.property_id
								   ORDER BY pro.property_id DESC
								   LIMIT " . ($p - 1) * $len . ',' . $len
        , true);
    //AND  pro.auction_sale =' . $auction_sale_ar['auction'] . "
    $pag_cls->setTotal($property_cls->getFoundRows())
            ->setPerPage($len)
            ->setCurPage($p)
            ->setLenPage(10)
            ->setUrl('')
            ->setLayout('ajax')
            ->setFnc('showList');
    if (is_array($rows) and count($rows) > 0) {
        $i = 0;
        foreach ($rows as $_row) {
            $_row['description'] = safecontent($_row['description'], 300) . '...';
            $_row['delete_link'] = ROOTURL . '/admin/?module=agent&action=delete-bidder&agent_id=' . $agent_id . '&property_id=' . $_row['property_id'] . '&token=' . $token;
            $html .= '<tr class="item'.($i++ % 2 == 0?1:2).'">
                    <td align="center">' . $_row['property_id'] . '</td>
                    <td>
                        <div style="margin: 4px">
                            <b>Vendor:</b> ' . $_row['agent_name'] . '
                            <br />
                            <b>Description: </b>
                            <br />
                            ' . $_row['description'] . '
                        </div>
                    </td>
                    <td width="70px" align="center">'.($_row['pay_bid_first_status'] == 2
                        ? '<a href="javascript:void(0)" onclick ="deleteItem2(\'' . $_row['delete_link'] . '\')" style="color:#0000FF">Remove</a>' : '').'
                    </td>
                </tr>';
        }
    }
    $html .= '</table>' . $pag_cls->layout();
    return $html;
}

function __uploadLogo(){
    $agent_id = (int)restrictArgs(getParam('id',0));
    $path_pre = ROOTPATH . '/store/uploads/banner/images/partner/';
    $sizeLimit = 2 * 1024 * 1024;
    $allowedExtensions = array('gif', 'jpg', 'jpeg', 'bmp', 'png');
    $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, false);
    $result = $uploader->handleUpload($path_pre);

    if (isset($result['success'])) {
        list($width, $height) = getimagesize($path_pre . $result['filename']);
        if ($width > 185 && $height > 154) {
            if ($width == $height) {
                $new_width = $new_height = 154;
            } elseif ($width > $height) { //max:185px
                $new_width = 185;
                $new_height = $height * (185 / $width);
            } else {
                $new_height = 154;
                $new_width = $height * (154 / $height);
            }
            resizeImage($path_pre . $result['filename'], $new_width, $new_height);
        }
//        $row = $partner_cls->getRow('agent_id = ' . $_SESSION['agent']['id']);
//        if (is_array($row) and count($row) > 0) {
//            @unlink($row['partner_logo']);
//        }
//        $partner_cls->update(array('partner_logo' => $result['filename']), 'agent_id = ' . $_SESSION['agent']['id']);
        if (isset($_SESSION['partner'][$agent_id]['logo']) && strlen($_SESSION['partner'][$agent_id]['logo']) > 0) {
            @unlink($_SESSION['partner'][$agent_id]['logo']);
        }
        $_SESSION['partner'][$agent_id]['logo'] = $result['filename'];
        $result['nextAction'] = array();
        $result['nextAction']['method'] = 'showLogo';
        $result['nextAction']['args'] = array(
            'image' => ROOTURLS . '/store/uploads/banner/images/partner/' . $result['filename'],
            'file_name' => $result['filename'],
            'ext' => strtolower(end(explode(".", $result['filename']))),
            'container'=>'partner_logo',
            'admin'=>1
        );
    } else if (!isset($result['error'])) {
        $result['error'] = 'Error';
    }
    die(_response($result));
}

function uploadLogo($default_width){
    $path_pre = '/store/uploads/logo/';
    $dir = ROOTPATH . $path_pre;
    createFolder(ROOTPATH . '/store/uploads/logo', 2);
    $sizeLimit = 2 * 1024 * 1024;
    $allowedExtensions = array('gif', 'jpg', 'jpeg', 'bmp', 'png');
    $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, false);
    $result = $uploader->handleUpload($dir);
    if (isset($result['success'])) {
        list($width, $height) = getimagesize($dir . $result['filename']);
        if ($width > $default_width) {
            if ($width == $height) {
                $new_width = $new_height = $default_width;
            } else {
                $new_width = $default_width;
                $new_height = $height * ($default_width / $width);
            }
            resizeImage($dir . $result['filename'], $new_width, $new_height);
        }

		ftp_mediaUpload($path_pre, $result['filename']);

        $result['nextAction'] = array();
        $result['nextAction']['method'] = 'showLogo';
        $result['nextAction']['args'] = array(
            'image' => MEDIAURL . $path_pre . $result['filename'],
            'file_name' => $path_pre . $result['filename'],
            'ext' => strtolower(end(explode(".", $result['filename']))),
            'admin'=>1
        );
    } else if (!isset($result['error'])) {
        $result['error'] = 'Error';
    }
    return $result;
}
?>