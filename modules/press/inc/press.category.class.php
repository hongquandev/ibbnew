<?php
class Press_cat extends Model{
	/**
	Construct
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'press_category';

		$this->id = 'cat_id';

		$this->fields = array('cat_id' => 0,
							'title' => '',
							'key' => '',
							'position' => 0,
							'active' => 0
							);

	}
}