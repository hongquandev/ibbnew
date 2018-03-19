<?php

class Development extends Model
{
    /**
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = 'development';
        $this->id = 'development_id';
        $this->fields = array('development_id' => 0,
            'first_name' => '',
            'last_name' => '',
            'email_address' => '',
            'postcode' => '',
            'interested' => '',
            'interested_project' => '',
            'describes' => '');
    }
}

if (!isset($development_cls) || !($development_cls instanceof Development)) {
    $development_cls = new Development();
}
?>