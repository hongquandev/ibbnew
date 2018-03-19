<?php
include_once ROOTPATH.'/includes/model.class.php';
class Package_basic extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'package_basic';
		$this->id = 'package_id';
		$this->fields = array('package_id' => 0,
							  'focus' => 0.00,
							  'home' => 0.00,
							  'bid' => 0.00,
							  'bid_block' => 0.00,
							  'make_an_offer' => 0.00,
							  'banner_notification_email' => 0.00);
	}
}
?>