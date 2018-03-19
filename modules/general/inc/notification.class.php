<?php
class Notification extends Model{
	public function __construct(){
		parent::__construct();
		$this->table = 'notification';
		$this->id = 'notification_id';
		$this->fields = array('notification_id' => 0,
							'property_id' => 0,
							'temp_id' => 0,
							'notify_value' => 0);
	}
}

if (!isset($notification_cls) || !($notification_cls instanceof Notification)) {
	$notification_cls = new Notification();
}

?>