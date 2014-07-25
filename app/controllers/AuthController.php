<?php namespace ninja\Controllers;

use ninja\Models\Auth;
use ninja\Libraries\UploadHandler;

require_once APPPATH . 'models/Auth.php';

/**
 * Class Auth
 * Contains controller functions for signing in and out of the admin area.
 */
class AuthController {

	static $app;

	/**
	 * The model for authentication settings.
	 *
	 * @access public static
	 * @var  string
	 */
	public static $authModel;

	function __construct() {
		global $router;
		static::$app = $router;

		// Init auth model.
		static::$authModel = new Auth();
	}

	

	function index() {
		// If this controller is called, redirect to signIn controller.
		echo "redirecting";
		static::$app->redirect( '/auth/sign-in' );
	}



	function signIn() {
		// Load the sign-in form
		static::$app->render( 'admin/auth/login.php' );
		//static::$authModel->setUserData('graeme', 'pass1');
	}

	function processSignIn( $data ) {
		// The sign-in form has been submitted, process request:
		// Define rules for login
		// Ensure that rules are supported by credentials.
		// If failure, throw new ValidationException.
		// Else, authenticate the user.
		// Redirect back to the admin area, or to an intended admin page.
		if ( static::$authModel->checkPassword( $data['username'], $data['password'] ) ) {
			// Login is valid, sign in this user

			require_once APPPATH . 'libraries/SecureSession.php';
			// change the default session folder in a temporary dir
			$sessionPath = sys_get_temp_dir();
			session_save_path( $sessionPath );
			session_start();
			$sessionStarted = time();
			if ( empty( $_SESSION['session_started'] ) ) {
				$_SESSION['session_started'] = $sessionStarted;
				static::$authModel->setLastSession( $sessionStarted );
			}
			$_SESSION['username'] = $data['username'];

			static::$app->redirect('/admin/dashboard');

		} else {
			// Login is invalid, reload the login page with errors.
			static::$app->render( 'admin/auth/login.php', array (
					'error' => 'The username and password combination was not valid. Please try again.',
				) );
		}
	}

	function signOut() {
		// Run the admin logout function that clears the session.
		
		static::$app->redirect('/' . SIGNIN_PATH . '?signed=out');
		
		if ( static::$authModel->isSignedIn() ) {
			// Destroy the session
			static::$authModel->signOut();
			// Redirect to the login page
			
		} else {
			static::$app->render( '404.php' );
		}

		// Redirect to some non-admin page.

	}

	function resetPassword() {
		// Update the password to something random.
		// Send the new random password to the email address stored on file.

	}
}

?>
