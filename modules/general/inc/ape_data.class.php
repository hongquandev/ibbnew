<?php
class Ape_data extends Model{
	public function __construct(){
		parent::__construct();
		$this->id = '';
		$this->table = 'ape_data';
		$this->fields = array('key' => '',
							  'data' => '');
	}
	
}
?>