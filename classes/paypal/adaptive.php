<?php

class PayPal_Adaptive{
	
	public $success;
	public $response = array();
	protected $api_type;
	protected $live;
	protected $environment;
	public $config;
	
	public function __construct($api_type, $live = true){
		
		$this->api_type = $api_type;
		$this->live = $live;
		$this->environment = $live ? 'live' : 'sandbox';
		$this->config = Kohana::config('paypal');
	}
	
	public function __call($method, $args){
		
		$ch = curl_init();

		$headers = array(
			'X-PAYPAL-SECURITY-USERID: '.$this->config['security_userid'],
			'X-PAYPAL-REQUEST-DATA-FORMAT: NV',
			'X-PAYPAL-RESPONSE-DATA-FORMAT: NV',
			'X-PAYPAL-SECURITY-PASSWORD: '.$this->config['security_password'] ,
			'X-PAYPAL-SECURITY-SIGNATURE: '.$this->config['security_signature'],
			'X-PAYPAL-APPLICATION-ID: '.$this->config['application_id'],
			'CLIENT_AUTH: ',
			'Expect:',
		);
		
		if(isset($args[0]) AND is_array($args[0])){
			
			$post = $args[0];
			$post['requestEnvelope.errorLanguage'] = $this->config['error_lang'];
			$post['requestEnvelope.detailLevel'] = 'ReturnAll';
			curl_setopt($ch, CURLOPT_POST, true);
			if($this->api_type == 'nvp') {
				$post['VERSION'] = urlencode('84.0');
				$post['PWD'] = $this->config['security_password'];
				$post['USER'] = $this->config['security_userid'];
				$post['SIGNATURE'] = $this->config['security_signature'];
			}
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		}
						
		$url = $this->config['adaptive_url'].'/'.$this->api_type.'/'.$method;
		if($this->api_type == 'nvp') {
			$url = 'https://api-3t.sandbox.paypal.com/nvp';
		}
		
		// curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSLVERSION, 3);
		
		$curl_info = curl_getinfo($ch);
		$return = curl_exec($ch);
		
		$this->response = array();
		parse_str($return, $this->response);
				
		if(is_array($this->response)){		
				
			if(isset($this->response['responseEnvelope_ack']) AND $this->response['responseEnvelope_ack'] == 'Success'){
			
				$this->success = true;
				return $this;
		
			}else{
			
				$this->success = false;
				return $this;
			}
			
		}else{
			
			$this->success = false;
			return $this;
		}
		
		
	}

	
	
}