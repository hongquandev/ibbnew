<?php
class Medias extends Model{
	/**
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'medias';
		$this->id = 'media_id';
		$this->fields = array('media_id'=>0,
							'file_name'=>'',
							'datas'=>'',
							'type'=>'',
							'active'=>1);
	}
}
?>