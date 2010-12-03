<?php

abstract class PayPal_Core{
	
	public static $environment = 'sandbox';
	public static $live = true;
	
	public static function Payments($live = NULL){
		
		if($live == NULL){
			$live = PayPal::$live;
		}
		
		return new PayPal_Adaptive('Payments', $live);
		
	}
	
	public static function Accounts($live = NULL){
		
		if($live == NULL){
			$live = PayPal::$live;
		}
		
		return new PayPal_Adaptive('Accounts', $live);
		
	}
	
	public static function Auth($live = NULL){
		
		if($live == NULL){
			$live = PayPal::$live;
		}
		
		return new PayPal_Auth($live);
		
	}
	
	public static function get_auth_url($return_url = NULL, $cancel_url = NULL, $logout_url = NULL){
		
		$auth = PayPal::Auth()->SetAuthFlowParam($return_url, $cancel_url, $logout_url);
		
		if($auth->success){
			
			$response = $auth->response;
			
			if(isset($response['TOKEN'])){
								
				$query = array(
					'cmd' => '_account-authenticate-login',
					'token' => $response['TOKEN'], 
				);
				
				$paypal_url = $auth->config['webscr_url'].'?'.http_build_query($query);
				
				return $paypal_url;
				
			}
			
		}
		
	}
	
	public static function get_auth_details($token){
		
		$get = PayPal::Auth()->GetAuthDetails($token);
		
		if($get->success){
			
			$response = $get->response;
			
			$return['paypal_id'] = $response['PAYERID'];
			$return['first_name'] = $response['FIRSTNAME'];
			$return['last_name'] = $response['LASTNAME'];
			$return['name'] = $response['FIRSTNAME'].' '.$response['LASTNAME'];
			$return['email'] = $response['EMAIL'];
			
			return $return;
			
		}
	}
	
	public static function do_auth_logout($token){
		
		$config = Kohana::config('paypal.'.PayPal::$environment);
		
		$query = array(
			'cmd' => '_account-authenticate-logout',
			'token' => $token, 
		);
		
		$url = $config['webscr_url'].'?'.http_build_query($query);
		
		$ch = curl_init();
				
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 2);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSLVERSION, 3);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
				
		$return = curl_exec($ch);
		
	}
}