<?php
include_once ROOTPATH.'/includes/model.class.php';
class Package_select_option extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'package_select_option';
		$this->id = 'entity_id';
		$this->fields = array('entity_id'   => 0,
							  'option_id'   => 0,
                              'label'       => '',
                              'order'       => 0,
                              'is_default'  => 0);
	}
}
?>