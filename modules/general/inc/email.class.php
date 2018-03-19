<?php

class Email extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->id = array('email_id');
        $this->table = 'email';
        $this->fields = array(
            'email_id' => 0,
            'from' => '',
            'from_name' => '',
            'subject' => '',
            'body' => '',
            'to' => '',
            'cc' => '',
            'bcc' => '',
            'file_att' => '',
            'info' => '',
            'scan' => 0,
            'sent' => 0,
            'create_date' => '0000-00-00 00:00:00',
            'scan_date' => '0000-00-00 00:00:00',
        );
    }
}

if (!isset($email_cls) || !($email_cls instanceof Email)) {
    $email_cls = new Email();
}
?>