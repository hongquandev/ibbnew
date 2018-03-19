<?php
class EmailAlert extends Model{
	/**
	construct
	*/
	public function __construct(){
		parent::__construct();
		
		$this->table = 'email_alert';
		
		$this->id = 'email_id';
		
		$this->fields = array('email_id' => 0,
							'name_email' => '',
							'auction_sale' => 0,
							'schedule' => 0,
                            'allows' => 1,
							'content' => '',
							'auction_sale' => 0,
							'property_type' => 0,
							'property_kind' => 0,
							'minprice' => 0.00,
							'maxprice' => 0.00,
							'description' => '',
							'address' => '',
							'suburb' => '',
							'state' => 0,
							'postcode' => '',
							'country' => 0,
							'price' => 0.00,					
							'price_range' => 0,
							'bedroom' => 0,
							'bathroom' => 0,
                            'parking' => 0,
							'land_size_min' => 0,
                            'land_size_max' => 0,
                            'unit' =>0,
							'car_space' => 0,
							'car_port' => 0,		
							'open_for_inspection' => 0,
							'open_time' => 0,
							'auction_blog' => 0,
							'contact_by_bidder' => 0,
							'has_auction_term' => 0,
							'agent_id' => 0,
							'active' => 0,	
							'end_time' => '0000-00-00 00:00:00',
							'last_cron' => '0000-00-00 00:00:00',
                            'property_number' => '',
                            'abort' => 0
							);
	}
}
