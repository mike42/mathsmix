<?php
class user_controller {
	public static function init() {
		core::loadClass("user_model");
	}
	
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
		    } elseif($openid -> mode == 'cancel') {
		    	/* Cancelled */
		        core::redirect(core::constructURL("user", "login", array(''), "html"));
		        return;
		    } else {
		    	if($openid -> validate()) {
		    		$attributes = $openid -> getAttributes();
		    		if(!isset($attributes['contact/email']) || !isset($attributes['namePerson/first']) || !isset($attributes['namePerson/last'])) {
		    			return array('error' => '500', 'message' => 'A required piece of information was not returned by the server.');
		    		}
		    		
		    		if(strpos($attributes['contact/email'], '@') === false) {
		    			return array('error' => '500', 'message' => 'Email address returned by authentication server was invalid.');
		    		}
		    		
		    		if($user = user_model::get_by_user_email($attributes['contact/email'])) {
						die("User exists");
		    		} else {
		    			$part = explode('@', $attributes['contact/email']);
		    			if($domain = domain_model::get_by_domain_host($part[1])) {
		    				$newUser = new user_model();
		    				$newUser -> user_firstname =  $attributes['namePerson/first'];
		    				$newUser -> user_surname = $attributes['namePerson/last'];
		    				$newUser -> user_email = $attributes['contact/email'];
		    				$newUser -> domain_id = $domain -> domain_id;
		    				$newUser -> user_role = $domain -> domain_defaultrole;
		    				$newUser -> user_id = $newUser -> insert();
		    				print_r($domain);
		    				die();
		    			} else {
		    				die("No such domain ".$part[1]);
		    			}
		    		}

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