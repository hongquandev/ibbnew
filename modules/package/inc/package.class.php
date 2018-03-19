<?php
class Package extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'package';
		$this->id = 'package_id';
		$this->fields = array('package_id' => 0,
							  'title' => '',
							  'price' => 0.00,
							  'description' => '',
							  'photo_num' => 'all',
							  'video_num' => 'all',
							  'video_capacity' => 'all',
							  'document_ids' => 'all',
							  'can_comment' => 0,
							  'can_blog' => 0,
							  'property_type' => 0,
							  'active' => 0,
							  'order' => 0,
                              'package_type'=>'',
                              'account_num'=>'',
                              'for_agent'=>0,
                              'can_show'=>1);
	}

	/**
	@ function : isExist
	@ argument : package_id
	@ output : bool
	**/

	public function isExist($package_id = 0) {
		$row = $this->getRow('package_id = '.$package_id);
		if (is_array($row) && count($row) > 0) {
			return true;
		}
		return false;
	}


}
?>