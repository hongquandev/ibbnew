<?php
include_once ROOTPATH.'/includes/model.class.php';
class Package_property_group extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'package_property_group';
		$this->id = 'group_id';
		$this->fields = array('group_id' => 0,
							  'name' => '',
                              'order' => 0,
							  'is_active' => 1,
                              'is_system' => 0,
                              'is_extra_group' => 0
        );
	}
}
?>