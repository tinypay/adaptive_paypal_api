<?php

class PayPal_Adaptive{
	
	protected $api_type;
	protected $live;
	protected $environment;
	protected $config;
	
	public function __construct($api_type, $live = true){
		
		$this->api_type = $api_type;
		$this->live = $live;
		$this->environment = $live ? 'live' : 'sandbox';
		$this->config = Kohana::config('paypal.'.$this->environment);
		
	}
	
	public function __call($name, $args){
		
		
		
	}

	
	
}