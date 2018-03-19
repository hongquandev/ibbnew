<?php
include_once ROOTPATH.'/modules/general/inc/propose_increment.class.php';
if (!isset($propose_increment_cls) || !($propose_increment_cls instanceof Propose_increment)) {
	$propose_increment_cls = new Propose_increment();
}
$data['property_id']=getParam('property_id');
$data['from_id']=getParam('from_id');
$data['amount']=getParam('amount');
if (!isset($data['property_id']) || !isset($data['from_id'])) return '';
	$row = $propose_increment_cls->getCRow(array('property_id'), 'property_id = '.$data['property_id'].' AND from_id = '.$data['from_id']);
	if (isset($row['property_id'])) {
		$propose_increment_cls->update(array('type_approved' => 0, 'amount' => $data['amount']), 'property_id = '.$data['property_id'].' AND from_id = '.$data['from_id']);
	} else {
		$propose_increment_cls->insert($data);	
	}

	die(json_encode(array('error'=>'','msg'=>'okay')));
