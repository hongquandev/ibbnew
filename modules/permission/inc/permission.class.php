<?php
//include_once ROOTPATH.'/includes/model.class.php';
class Permission extends Model{
	/**
	Construct
	*/
	public function __construct() {
		parent::__construct();
		$this->table = 'permissions';
		$this->id = 'permission_id';
		$this->fields = array('permission_id' => 0,
						'tab_id' => 0,
						'role_id' => 0,
						'add' => 0,
						'view' => 0,
						'edit' => 0,
						'delete' => 0);
	}
	
}
?>