<?php
class Comments extends Model{
	public function __construct(){
		parent::__construct();
		$this->table = 'comments';
		$this->id = 'comment_id';
		$this->fields = array('comment_id' => 0,
								'name' => '',
								'email' => '',
								'title' => '',
								'content' => '',
								'created_date' => '0000-00-00 00:00:00',
								'type' => '',
								'property_id' => 0,
								'active' => 1);
	}
}

?>