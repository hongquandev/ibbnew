<?php
$property_id = isset($_GET['property_id'])?intval($_GET['property_id']):0;
include_once ROOTPATH.'/modules/agent/inc/agent.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent_creditcard.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent_history.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent_lawyer.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent_contact.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent_option.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent.logo.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent.payment.class.php';
include_once ROOTPATH.'/modules/agent/inc/message.php';
include_once ROOTPATH.'/modules/agent/inc/company.php';
include_once ROOTPATH.'/modules/agent/inc/agent_site.class.php';

include_once ROOTPATH.'/modules/general/inc/sendmail.php';
include_once ROOTPATH.'/modules/general/inc/card_type.class.php';
include_once ROOTPATH.'/modules/general/inc/bids.php';

$_photo = PM_getPhoto($property_id, true);

die(json_encode($_photo['photo']));
?>