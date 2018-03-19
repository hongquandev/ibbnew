<?php
include_once ROOTPATH.'/includes/model.class.php';
class Package_property_group_option extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'package_property_group_option';
		$this->id = 'entity_id';
		$this->fields = array('entity_id' => 0,
                              'package_id' => 0,
							  'option_id' => 0,
							  'value' => '');
	}
}
?>