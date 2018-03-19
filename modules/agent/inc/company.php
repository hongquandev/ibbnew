<?php
include_once 'agent.company.class.php';
if (!isset($company_cls) || !($company_cls instanceof Agent_Company)) {
	$company_cls = new Agent_Company();
}
?>