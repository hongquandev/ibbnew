<?php
class Banner extends Model{

	public function __construct() {
		parent::__construct();
		$this->table = 'banners';
		$this->id = 'banner_id';
		$this->fields = array('banner_id' => 0,
						'banner_name' => '',
						'banner_file' => '',
						'url' => '',
						'type' => '0',
						'position' => 1000,
						'page_id' => '',
						'clicks' => 0,
						'views' => 0,
						'agent_id' => 0,
						'date_from' => '0000-00-00',
						'date_to' => '0000-00-00',
						'creation_time' => '0000-00-00 00:00:00',
						'update_time' => '0000-00-00 00:00:00',
						'status' => '1',
						'agent_status' => '1',
						'suburb' => '',
						'postcode' => '',
						'state' => '0',
						'country'=> 0,
						'display' => '0',
						'description' => '',
						'pay_status' => 0,
						'notification_email' => 0,
						'pay_notification_email' => 0,
						'check_all_page' => 0
						);
	}
	
}
?>