<?php
class Property_media extends Model{
	/**
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'property_media';
		$this->id = 'property_media_id';
		$this->fields = array('property_media_id' => 0,
						'property_id' => 0,
						'media_id' => 0,
						'default' => 0);
	}
	
	/**
	@ function : getCountPhoto
	@ argument : property_id
	@ output : int
	**/
	
	public function getCountPhoto($property_id = 0) {
		$row = $this->getRow('SELECT COUNT(*) AS num 
							  FROM '.$this->getTable().' AS pm,'.$this->getTable('medias').' AS m 
							  WHERE pm.media_id = m.media_id AND pm.property_id = '.$property_id.' AND m.type = \'photo\'',true);
		if (is_array($row) && count($row) > 0) {
			return $row['num'];
		}
		
		return 0;					  
	}
	
	/**
	@ function : getCountPhoto
	@ argument : property_id
	@ output : int
	**/
	
	public function getCountVideo($property_id = 0) {
		$row = $this->getRow('SELECT COUNT(*) AS num 
							  FROM '.$this->getTable().' AS pm,'.$this->getTable('medias').' AS m 
							  WHERE pm.media_id = m.media_id AND pm.property_id = '.$property_id.' AND m.type = \'video\'',true);
		if (is_array($row) && count($row) > 0) {
			return $row['num'];
		}
		
		return 0;					  
	}
	
	/**
	@ function : getCountYT
	@ argument : property_id
	@ output : int
	**/
	
	public function getCountYT($property_id = 0) {
		$row = $this->getRow('SELECT COUNT(*) AS num 
							  FROM '.$this->getTable().' AS pm,'.$this->getTable('medias').' AS m 
							  WHERE pm.media_id = m.media_id AND pm.property_id = '.$property_id.' AND m.type = \'video-youtube\'',true);
		if (is_array($row) && count($row) > 0) {
			return $row['num'];
		}
		
		return 0;					  
	}
	
}
?>