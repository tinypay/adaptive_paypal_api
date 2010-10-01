<?php

class PayPal_Auth{
	
	public $success;
	public $response = array();
	protected $api_type;
	protected $live;
	protected $environment;
	public $config;
	
	public function __construct($live = true){
		
		$this->live = $live;
		$this->environment = $live ? 'live' : 'sandbox';
		$this->config = Kohana::config('paypal.'.$this->environment);		
	}
	
	public function SetAuthFlowParam($return_url = NULL, $cancel_url = NULL, $logout_url = NULL){
		
		$return_url = ($return_url == NULL) ? $this->config['auth_return_url'] : $return_url;
		$cancel_url = ($cancel_url == NULL) ? $this->config['auth_cancel_url'] : $cancel_url;
		$logout_url = ($logout_url == NULL) ? $this->config['auth_logout_url'] : $logout_url;
		
		$post = array(
			'USER' => $this->config['security_userid'],
			'PWD' => $this->config['security_password'],
			'SIGNATURE' => $this->config['security_signature'],
			'VERSION' => $this->config['authentication_version'],
			'RETURNURL' => $return_url.'return',
			'CANCELURL' => $return_url.'cancel',
			'LOGOUTURL' => $return_url.'logout',
			'SERVICENAME1' => 'Name',
			'SERVICEDEFREQ1' => 'Required',
			'SERVICENAME2' => 'Email',
			'SERVICEDEFREQ2' => 'Required',	
			'METHOD' => 'SetAuthFlowParam',
		);
		
		$response = $this->send_request($post);
		
		if(!empty($response) AND isset($response['TOKEN'])){
		
			$this->success = true;
			
			return $this;
			
		}else{
			
			$this->success = false;
			
			return $this;
		}
		
	}
		
	public function GetAuthDetails($token){
		
		$post = array(
			'USER' => $this->config['security_userid'],
			'PWD' => $this->config['security_password'],
			'SIGNATURE' => $this->config['security_signature'],
			'VERSION' => $this->config['authentication_version'],
			'TOKEN' => $token,
			'METHOD' => 'GetAuthDetails',
		);
		
		$response = $this->send_request($post);
			
		if(isset($response['ACK']) AND $response['ACK'] === 'Success' 
			AND isset($response['FIRSTNAME']) AND isset($response['LASTNAME']) 
			AND isset($response['EMAIL'])
			AND isset($response['PAYERID'])
		){
					
			$this->success = true;
			return $this;
			
		}else{
			
			$this->success = false;
			return $this;
		}
		
	}
	
	protected function send_request($post){
		
		$ch = curl_init();
						
		$url = $this->config['authentication_url'];
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSLVERSION, 3);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		
		$curl_info = curl_getinfo($ch);
		
		$return = curl_exec($ch);
		
		$this->response = array();
		parse_str($return, $this->response);
				
		if(is_array($this->response)){		
				
			if(isset($this->response['ACK']) AND $this->response['ACK'] == 'Success'){
			
				return $this->response;
			}
			
		}
		
	}
	
}