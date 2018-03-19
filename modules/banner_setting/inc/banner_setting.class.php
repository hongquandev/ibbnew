<?php
class BannerSetting extends Model{

	public function __construct() {
		parent::__construct();
		$this->table = 'banner_setting';
		$this->id = 'setting_id';
		$this->fields = array('setting_id' => 0,
						'title' => '',
						'keyword' => '',
						'setting_value' => 0
						);

	}
	
}

?>