<?php

class Message extends Model
{
    /**
     */
    public function
    __construct()
    {
        parent::__construct();
        $this->table = 'message';
        $this->id = 'message_id';
        $this->fields = array('message_id' => 0,
            'title' => '',
            'content' => '',
            'user_content' => '',
            'email_from' => '',
            'agent_id_from' => 0,
            'email_to' => '',
            'agent_id_to' => 0,
            'send_date' => '0000-00-00 00:00:00',
            'abort' => 0,
            'draft' => 0,
            'read' => 0,
            'active_sold' => 0,
            'entity_id' => 0,
            'offer_price' => 0,
            'buynow_price' => 0
        );
    }

}

?>