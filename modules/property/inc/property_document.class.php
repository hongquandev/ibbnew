<?php
class Property_document extends Model{
	/**
	construct
	*/
	public function __construct(){
		parent::__construct();
		
		$this->table = 'property_document';
		$this->documents_table = 'documents';
			
		$this->id = 'property_document_id';
		
		$this->fields = array('property_document_id' => 0,
							'property_id' => 0,
							'document_id' => 0,
							'file_name' => '',
							'link_name' => '',
							'active' => 1);
	}
	
	/**
	get data that has document information
	*/
	public function getRowsWithDocument(){
		$this->sql = 'SELECT FROM '.$this->getTable().' AS a ';
		$rows = $this->db->GetAssoc($this->sql);
		return $rows;
	}
	
	/**
	get date that input data is document information
	*/
	public function getRowsByDocument(){
	}
	
	/**
	Get property document rows that was index by document_id
	*/
	public function getRowsByDocumentIndex($property_id=0){
		$property_documents = array();
		$rows = $this->getRows('a.property_id='.$property_id);
		if(is_array($rows) and count($rows)>0){
			foreach($rows as $row){
				$property_documents[$row['document_id']] = $row;
			}
		}
		return $property_documents;
	}
	
	/**
	@ function : getCountDoc
	@ argument : property_id
	@ output : int
	**/
	public function getCountDoc($property_id = 0) {
		global $package_cls, $property_cls;
        $row = PA_getPackageOfID($property_id);
		
        $wh_str = '';
        if (is_array($row) && count($row)> 0 && strlen(@$row['document_ids']) > 0){
            if ($row['document_ids'] != 'all'){
                $wh_str = ' AND document_id IN ('.$row['document_ids'].')';
            }
        }
		$row = $this->getRow('SELECT count(*) AS num FROM '.$this->getTable().' WHERE property_id = '.$property_id.$wh_str,true);
		if (is_array($row) && count($row) > 0) {
			return $row['num'];
		}
		return 0;
	}
	
}
?>