<?php
include_once ROOTPATH.'/modules/general/inc/regions.class.php';
include_once ROOTPATH.'/modules/general/inc/card_type.class.php';
include_once ROOTPATH.'/modules/general/inc/bids.php';
include_once ROOTPATH.'/modules/comment/inc/comment.php';
include_once ROOTPATH.'/modules/note/inc/note.php';
include_once ROOTPATH.'/modules/banner/inc/banner.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/package/inc/package.php';
include_once ROOTPATH.'/modules/configuration/inc/configuration.php';
include_once ROOTPATH.'/modules/menu/inc/menu.php';
include 'partner.php';
include_once 'company.php';

if (!isset($region_cls) or !($region_cls instanceof Region)) {
	$region_cls = new Regions();
}

if (!isset($card_type_cls) or !($card_type_cls instanceof Card_type)) {
	$card_type_cls = new Card_type();
}

if (!isset($banner_cls) or !($banner_cls instanceof Banner)) {
	$banner_cls = new Banner();
}

if (!isset($partner_cls) or !($partner_cls instanceof PartnerRegister)) {
	$partner_cls = new PartnerRegister();
}

if (!isset($package_cls) || !($package_cls instanceof Package)) {
	$package_cls = new Package();
}

__getAgentAccount();
__getAgentBanner();
__getAgentBanner();
__getAgentAccountPartner();
__getAgentPersonal();
__getAgentContact();
__getAgentLawyer();
__getAgentCompany();


//BEGIN MESSAGE
$message_data = array('num_inbox' => M_numInbox(), 'num_unread' => M_numUnread(), 'num_outbox' => M_numOutbox());
$smarty->assign('db_message_data',formUnescapes($message_data));

__viewProperty('view-dashboard');
$smarty->assign('page','view-dashboard');
__getNotification();

//BEGIN FACEBOOK/TWITTER
include_once ROOTPATH.'/modules/facebook-twitter/inc/fb.fb_detail.class.php';
include_once ROOTPATH.'/modules/facebook-twitter/inc/twitter_detail.class.php';
include_once ROOTPATH.'/modules/configuration/inc/config.class.php';

$db_facebook_data = FD_getListFace($_SESSION['agent']['id']);
$db_twitter_data = TD_getTwitterAcc($_SESSION['agent']['id']);
$tw = array('url' => ROOTURL.'?module=agent&action=tw-info');

$smarty->assign(array('db_facebook_data'=>$db_facebook_data,
                      'db_twitter_data'=>$db_twitter_data));

//SHOW MESS REG
if (isset($_SESSION['register_page'])) {
	$register = $_SESSION['register_page'];
	unset($_SESSION['register_page']);
	$smarty->assign('register',$register);
}

$browserMobile = detectBrowserMobile();
if ($browserMobile) {
	// LIST
	include_once ''.$module.'.property.mobile.php';
}
/**
@ function : __getAgentAccount
**/

function __getAgentAccount() {
	global $agent_cls, $smarty;
	$row = $agent_cls->getCRow(array('agent_id','email_address','firstname','lastname'),'agent_id = '.$_SESSION['agent']['id']);
	$db_account_data = array();
	if (is_array($row) and count($row) > 0) {
		$db_account_data = $row;
	}
	$smarty->assign('db_account_data',formUnescapes($db_account_data));
}

/**
@ function : __getAgentBanner
**/

function __getAgentBanner() {
	global $banner_cls, $region_cls, $smarty, $config_cls;
	$sql2 = 'SELECT a.* , c.* ,
					sum(b.click) as click 
			 FROM '.$banner_cls->getTable().' AS a 
			 LEFT JOIN '.$banner_cls->getTable('banner_log').' AS b ON a.banner_id = b.banner_id
			 LEFT JOIN '.$region_cls->getTable().' as c
				ON a.state = c.region_id 
			 WHERE agent_id = '.$_SESSION['agent']['id'].' GROUP BY a.banner_id ORDER BY a.banner_id DESC LIMIT 0,5';
	
	$rowbanner = $banner_cls->getRows($sql2, true);
	
	//echo $banner_cls->sql;
	
	$db_banner_data = array();
	$type_ar = array(0 => 'Any')  + PEO_getOptions('property_type') + PEO_getOptions('property_type_commercial');
	foreach ($rowbanner as $row2) {
			
		$dt  =  new DateTime($row2['creation_time']);
		$dt2 =  new DateTime($row2['date_from']);
		$dt3 =  new DateTime($row2['date_to']);
		$row2['creation_time']= $dt->format($config_cls->getKey('general_date_format'));
		$row2['date_from'] = $dt2->format($config_cls->getKey('general_date_format'));
		$row2['date_to'] = $dt3->format($config_cls->getKey('general_date_format'));
		$row2['type'] = $type_ar[$row2['type']];
		if (strlen($row2['description']) > 100) {
			$row2['description'] = safecontent($row2['description'], 100) . '...';
		}
		
		$page_ar = Menu_getTitleArById(explode(',', $row2['page_id']));
		$row2['page_list'] = is_array($page_ar) && count($page_ar) > 0 ? $page_ar : array(0 => 'None');
		$db_banner_data[] = $row2;	
	}
	
	$smarty->assign('db_banner_data', $db_banner_data);	
}

/**
@ function : __getAgentAccountPartner
**/

function __getAgentAccountPartner() {
	global $partner_cls, $region_cls, $smarty;
	$rowpartner = $partner_cls->getRow('SELECT al.agent_id,
											   al.partner_logo,
											   al.description,
											   al.postal_suburb,
											   al.postal_address,
											   al.postal_postcode,
											   al.postal_other_state,
	
												(SELECT r1.name
												FROM '.$region_cls->getTable('regions').' AS r1
												WHERE r1.region_id = al.postal_state) AS state_name,
	
												(SELECT r2.name
												FROM '.$region_cls->getTable('regions').' AS r2
												WHERE r2.region_id = al.postal_country) AS country_name
										FROM '.$partner_cls->getTable().' AS al
										WHERE al.agent_id = '.$_SESSION['agent']['id'],true);
	$db_partner_data = array();
	if (is_array($rowpartner) and count($rowpartner) > 0) {
        $rowpartner['postal_address'] = strip_tags($rowpartner['postal_address']);
		$rowpartner['full_postal_address'] = implode(' ',array($rowpartner['postal_suburb'],$rowpartner['state_name'],$rowpartner['postal_other_state'],$rowpartner['postal_postcode'],$rowpartner['country_name']));
		$rowpartner['description'] = strlen($rowpartner['description']) > 200?strip_tags(safecontent($rowpartner['description'], 200),"<br>").'...':strip_tags($rowpartner['description'],"<br>");
		$db_partner_data = $rowpartner;
	}
	$smarty->assign('db_partner_data',formUnescapes($db_partner_data));
}

/**
@ function : __getAgentPersonal
**/

function __getAgentPersonal() {
	global $agent_cls, $region_cls, $company_cls, $smarty;
	$db_personal_data = array();
	$row = $agent_cls->getRow('SELECT a.*,
									  c.address,
									  c.suburb AS c_suburb,
									  c.postcode AS c_postcode,
									  c.other_state AS c_other_state,
									  c.telephone AS c_telephone,
									  c.email_address AS c_email,
									  c.description,
	
									(SELECT r1.name 
									FROM '.$region_cls->getTable().' AS r1 
									WHERE r1.region_id = a.state) AS state_name,
									
									(SELECT r2.name 
									FROM '.$region_cls->getTable().' AS r2 
									WHERE r2.region_id = a.country) AS country_name,
	
									(SELECT r2.code
									FROM '.$region_cls->getTable().' AS r2
									WHERE r2.region_id = c.state) AS state_code,
	
									(SELECT r2.name
									FROM '.$region_cls->getTable().' AS r2
									WHERE r2.region_id = c.country) AS company_country_name
							FROM '.$agent_cls->getTable().' AS a
							LEFT JOIN '.$company_cls->getTable().' AS c
							ON a.agent_id = c.agent_id
							WHERE a.agent_id = '.$_SESSION['agent']['id'],true);
					
	if (is_array($row) and count($row)>0) {
		$row['full_address'] = implode(' ',array($row['suburb'],$row['state_name'],$row['other_state'], $row['postcode'], $row['country_name']));
		$row['company_full_address'] = implode(' ',array($row['c_suburb'],$row['state_name'],$row['c_other_state'], $row['c_postcode'], $row['company_country_name']));
		$row['description'] = strlen($row['description']) > 200?strip_tags(safecontent($row['description'], 200),"<br>").'...':strip_tags($row['description'],"<br>");
		$db_personal_data = $row;
	}
	$smarty->assign('db_personal_data',formUnescapes($db_personal_data));
}

/**
@ function : __getAgentContact
**/

function __getAgentContact() {
	global $agent_lawyer_cls, $agent_contact_cls, $region_cls, $smarty;
	$db_contact_data = array();
	$row = $agent_lawyer_cls->getRow('SELECT al.*,
											(SELECT r1.name 
											FROM '.$region_cls->getTable('regions').' AS r1 
											WHERE r1.region_id = al.state) AS state_name,
											
											(SELECT r2.name 
											FROM '.$region_cls->getTable('regions').' AS r2 
											WHERE r2.region_id = al.country) AS country_name
									FROM '.$agent_contact_cls->getTable().' AS al 
									WHERE al.agent_id = '.$_SESSION['agent']['id'],true);
	if (is_array($row) and count($row)>0) {
		$db_contact_data = $row;
	}
	$smarty->assign('db_contact_data',formUnescapes($db_contact_data));
}

/**
@ function : __getAgentLawyer
**/

function __getAgentLawyer() {
	global $agent_lawyer_cls, $region_cls, $smarty;
	$db_lawyer_data = array();
	$row = $agent_lawyer_cls->getRow('SELECT al.*,
											(SELECT r1.name 
											FROM '.$region_cls->getTable('regions').' AS r1 
											WHERE r1.region_id = al.state) AS state_name,
											
											(SELECT r2.name 
											FROM '.$region_cls->getTable('regions').' AS r2 
											WHERE r2.region_id = al.country) AS country_name
									FROM '.$agent_lawyer_cls->getTable().' AS al 
									WHERE al.agent_id = '.$_SESSION['agent']['id'],true);
	if (is_array($row) and count($row)>0) {
		$db_lawyer_data = $row;
	}
	$smarty->assign('db_lawyer_data',formUnescapes($db_lawyer_data));
}

/**
@ function : __getAgentCompany
**/

function __getAgentCompany() {
	global $company_cls, $region_cls, $smarty, $package_cls, $agent_payment_cls, $config_cls;
	if (in_array($_SESSION['agent']['type'],array('agent','theblock'))){
		$parent_id = $_SESSION['agent']['parent_id'] > 0 ? $_SESSION['agent']['parent_id'] : $_SESSION['agent']['id'];
		$row = $company_cls->getRow('SELECT c.*,
											(SELECT r1.name
											FROM ' . $region_cls->getTable('regions') . ' AS r1
											WHERE r1.region_id = c.state) AS state_name,
	
											(SELECT r2.name
											FROM ' . $region_cls->getTable('regions') . ' AS r2
											WHERE r2.region_id = c.country) AS country_name
									FROM ' . $company_cls->getTable() . ' AS c
									WHERE c.agent_id = ' . $parent_id, true);
		if (is_array($row) and count($row) > 0) {
			$row['full_address'] = implode(' ', array($row['suburb'], $row['state_name'], $row['other_state'], $row['postcode'], $row['country_name']));
			$row['description'] = strlen($row['description']) > 200?strip_tags(safecontent($row['description'], 200),"<br>").'...':strip_tags($row['description'],"<br>");
			$company_data = $row;
		}
		$smarty->assign('company_data', formUnescapes($company_data));
	
		$agent_id = $_SESSION['agent']['parent_id'] == 0?$_SESSION['agent']['id']:$_SESSION['agent']['parent_id'];
		$package = $package_cls->getRow('SELECT p.title,
											(SELECT ap.date_to
											 FROM '.$agent_payment_cls->getTable().' AS ap
											 WHERE ap.agent_id = '.$agent_id."
											 AND ap.date_from <= '".date('Y-m-d H:i:s')."' AND ap.date_to >= '".date('Y-m-d H:i:s')."'
											 ) AS expire
									 FROM ".$package_cls->getTable().' AS p
									 WHERE p.package_id = (SELECT ap.package_id
														   FROM '.$agent_payment_cls->getTable().' AS ap
														   WHERE ap.agent_id = '.$agent_id."
														   AND ap.date_from <= '".date('Y-m-d H:i:s')."' AND ap.date_to >= '".date('Y-m-d H:i:s')."'
														   )"
									,true);
		if (is_array($package) and count($package) > 0){
			foreach ($package as $item){
				$dt = new DateTime($package['expire']);
				$package['expire'] = $dt->format($config_cls->getKey('general_date_format'));
			}
			$smarty->assign('package_data',$package);
		}
	}
	//END
}

/**
@ function : __getNotification
**/

function __getNotification() {
	global $agent_cls, $smarty;
	$db_notification_data = array();
	$row = $agent_cls->getRow('agent_id = '.$_SESSION['agent']['id']);
	if (is_array($row) and count($row) > 0) {
		$db_notification_data = $row;
	}
	$smarty->assign('db_notification_data', $db_notification_data);
}
?>