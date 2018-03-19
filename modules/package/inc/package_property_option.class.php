<?php
include_once ROOTPATH.'/includes/model.class.php';
class Package_property_option extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'package_property_option';
		$this->id = 'option_id';
		$this->fields = array('option_id'   => 0,
							  'group_id'    => 0,
                              'name'        => '',
                              'code'        => '',
                              'is_required' => 0,
                              'type'        => '',
							  'is_active'   => 1,
                              'is_system'   => 0,
                              'order'       => 0,
                              'price'       => 0,
                              'show_in_frontend' => 1,
                              'has_unit'    => 0,
                              'description'    => '',
                              'unit'        => 1);
	}
}
?>