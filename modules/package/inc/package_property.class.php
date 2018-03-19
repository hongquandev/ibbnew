<?php
include_once ROOTPATH.'/includes/model.class.php';
class Package_property extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'package_property';
		$this->id = 'package_id';
		$this->fields = array('package_id' => 0,
							  'name' => '',
							  'is_active' => 1,
                              'order' => 0,
                              'color' => '');
	}
}
?>