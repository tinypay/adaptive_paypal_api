<?php

abstract class PayPal_Core{
	
	public static function Payments($live = true){
		
		return new PayPal_Adaptive('Payments', $live);
		
	}
	
	public static function Accounts($live = true){
		
		return new PayPal_Adaptive('Accounts', $live);
		
	}
	
	public static function Auth($live = true){
		
		return new PayPal_Auth($live);
		
	}
	
	public static function get_auth_url($return_url = NULL, $cancel_url = NULL, $logout_url = NULL){
		
		$auth = PayPal::Auth(false)->SetAuthFlowParam($return_url, $cancel_url, $logout_url);
		
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
		
		$get = PayPal::Auth(false)->GetAuthDetails($token);
		
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
}