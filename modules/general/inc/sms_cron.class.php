<?php

class SMSCRON extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->id = array('sms_id');
        $this->table = 'smscron';
        $this->fields = array(
            'sms_id' => 0,
            'content' => '',
            'to' => '',
            'info' => '',
            'scan' => 0,
            'sent' => 0,
            'create_date' => '0000-00-00 00:00:00',
            'scan_date' => '0000-00-00 00:00:00',
        );
    }
}

if (!isset($smscron_cls) || !($smscron_cls instanceof SMSCRON)) {
    $smscron_cls = new SMSCRON();
}
?>