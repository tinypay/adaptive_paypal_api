<?php

class PayPal{
	
	public static function Payments($live = true){
		
		return new PayPal_Adaptive('Payments', $live);
		
	}
	
	public static function Accounts($live = true){
		
		return new PayPal_Adaptive('Accounts', $live);
		
	}
	
	
}