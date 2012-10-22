<?php
class user_controller {
	public function login() {
		if(isset($_POST['user_email']) && isset($_POST['user_password'])) {
			// TODO: Implement local logins */
			return array('message' => "Invalid username / password");
		} else {
			/* Just show login form */
			return array();
		}
	}
	
	/**
	 * Log in using google account
	 */
	public function google() {
		require_once(dirname(__FILE__) . "/../../vendor/lightopenid/openid.php");
		$config = core::getConfig('core');
		
		try {
			$openid = new LightOpenID($config['host']);
			if(!$openid -> mode) {
				/* New login: Use google openID, request name and email */
				$openid->identity = 'https://www.google.com/accounts/o8/id';
				$openid->required = array('namePerson/first', 'namePerson/last', 'contact/email');
				/* Redirect to google site */
				core::redirect($openid->authUrl());
				return;
		    } elseif($openid->mode == 'cancel') {
		    	/* Cancelled */
		        core::redirect(core::constructURL("user", "login", array(''), "html"));
		        return;
		    } else {
		    	if($openid -> validate()) {
		    		echo "Login successful";
		    		print_r($openid);
		    		die();
					return;
		    	} else {
		    		core::redirect(core::constructURL("user", "login", array(''), "html"));
		    		return;
		    	}
		   }
		} catch(ErrorException $e) {
		    return array('error' => '500', 'message' => $e -> getMessage());
		}
	}
}