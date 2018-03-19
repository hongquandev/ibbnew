<?php
class Options extends Model{
	/**
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'options';
		$this->id = 'option_id';
		$this->fields = array('option_id'=>0,
							'title'=>'',
							'code'=>'',
							'order'=>0,
							'active'=>1);
	}
}
?>