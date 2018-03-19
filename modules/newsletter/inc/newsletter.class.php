<?php
class Newsletter extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'newsletter';
		$this->id = 'ID';
		$this->fields = array('ID' => 0,
							'EmailAddress' => '',
							'Source' => '',
							'Updated' => '0000-00-00 00:00:00');

	}
}
?>
