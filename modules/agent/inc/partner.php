<?php
include_once 'partner.class.php';
// Call Constructor init();
if (!isset($partner_cls) || !($partner_cls instanceof PartnerRegister)) {
	$partner_cls = new PartnerRegister();
}
if (!isset($partner_region_cls) || !($partner_region_cls instanceof Partner_region)) {
	$partner_region_cls = new Partner_region();
}
if (!isset($partner_ref_cls) || !($partner_ref_cls instanceof Partner_reference)) {
	$partner_ref_cls = new Partner_reference();
}
?>