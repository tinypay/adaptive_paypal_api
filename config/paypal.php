<?php

return array(
	
	'live' => array(
		
			'paypal_api_account' => 'paypal@example.com',
			'security_userid' => 'xxx_biz_api1.example.com',
			'security_password' => '1234567890',
			'security_signature' => 'ABCDEFGHIJKLMNOPQRST.ABCDEF-ABCDEFGHIJKLMNOPQRSTUVW.Hl-B',
			'application_id' => 'APP-3E522411WF908144L',
			'partner_name' => 'example.com',
			'ip_address' => '127.0.0.1',
			'ipn_url' => 'http://example.com/ipn',
			'error_lang' => 'en_US',
			'paypal_account' => 'paypal@example.com',
			'paypal_micro_account' => 'paypal-micro@paypal.com', // see http://goo.gl/Z4yF 
			'authentication_url' => 'https://api-3t.paypal.com/nvp',
			'authentication_version' => '64.0',
			'webscr_url' => 'https://www.paypal.com/cgi-bin/webscr',
			'adaptive_url' => 'https://svcs.paypal.com',
			'auth_return_url' => 'http://example.com/return',
			'auth_cancel_url' => 'http://example.com/cancel',
			'auth_logout_url' => 'http://example.com/logout',
	),
	
	
	'sandbox' => array(

			'paypal_api_account' => 'paypal@example.com',
			'security_userid' => 'xxx_biz_api1.example.com',
			'security_password' => '1234567890',
			'security_signature' => 'ABCDEFGHIJKLMNOPQRST.ABCDEF-ABCDEFGHIJKLMNOPQRSTUVW.Hl-B',
			'application_id' => 'APP-3E522411WF908144L',
			'partner_name' => 'example.com',
			'ip_address' => '127.0.0.1',
			'ipn_url' => 'http://example.com/ipn',
			'error_lang' => 'en_US',
			'paypal_account' => 'paypal@example.com',
			'paypal_micro_account' => 'paypal-micro@paypal.com', // see http://goo.gl/Z4yF 
			'authentication_url' => 'https://api-3t.sandbox.paypal.com/nvp',
			'authentication_version' => '64.0',
			'webscr_url' => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
			'adaptive_url' => 'https://svcs.sandbox.paypal.com',
			'auth_return_url' => 'http://example.com/return',
			'auth_cancel_url' => 'http://example.com/cancel',
			'auth_logout_url' => 'http://example.com/logout',
	),

);