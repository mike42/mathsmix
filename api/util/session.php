<?php
/**
 * User session manager
 */
class session {
	private static $user;

	/**
	 * Start the session with no user details.
	 */
	public function init() {
		self::$user = null;
		core::loadClass('user_model');
		session_start();
		
		if(isset($_SESSION['user_id'])) {
			self::$user = user_model::get($_SESSION['user_id']);
			if(!self::$user) {
				self::logoutUser();
			}
		}
	}

	/**
	 * Log in as a given user, storing information in $_SESSION
	 *
	 * @param mixed $user The user to log in as
	 * @return boolean True if the user was logged in successfully, false if the details don't match the database.
	 */
	public static function loginUser(user_model $user) {
		/* Use these */
		$_SESSION['user_id'] = $user -> user_id;
	}

	/**
	 * Log out current user.
	 */
	public static function logoutUser() {
		unset($_SESSION['user_id']);
		self::$user = null;
		return true;
	}

	/**
	 * Get the role of the currently logged-in user
	 *
	 * @return string role of the current user, or 'anon' if there is no current user
	 */
	public static function getRole() {
		if(self::$user != null) {
			return self::$user -> user_role;
		}
		/* Default to 'anon' for non logged-in users */
		return 'anon';
	}

	/**
	 * Get information about currently logged in user, or false if not logged in
	 */
	public static function getUser() {
		if(self::$user != null) {
			return self::$user;
		}
		return false;
	}
}
?>