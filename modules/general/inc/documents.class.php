<?php
class Documents extends Model{
	/**
	**/
	public function __construct(){
		parent::__construct();
		$this->table = 'documents';
		$this->id = 'document_id';
		$this->fields = array('document_id'=>0,
							'title'=>'',
							'max_size'=>0,
							'max_number'=>0,
							'active'=>1,
                            'require'=>0,
                            'is_term'=>0,
                            'key'=>'');
	}
}
?>