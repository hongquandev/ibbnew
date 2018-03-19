<?php
include_once ROOTPATH.'/includes/model.class.php';
class Package_banner extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'package_banner';
		$this->id = 'package_id';
		$this->fields = array('package_id' => 0,
							  'price' => 0.00,
							  'property_type_id' => 0,
							  'area' => 0,
							  'page_id' => 0,
							  'position' => 0,
							  'country_id' => 0,
							  'state_id' => 0,
							  'order' => 0,
							  'active' => 0);
	}
}
?>