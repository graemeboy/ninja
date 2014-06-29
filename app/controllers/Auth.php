<?php
/**
 * Class Auth
 * Contains controller functions for signing in and out of the admin area.
 */

class Auth {

	function __construct () {


	}

	function index () {
		// If this controller is called, redirect to signIn controller.
	}

	function signIn () {
		// Load the sign-in form
	}

	function signInProcess () {
		// The sign-in form has been submitted, process request:
		// Define rules for login
		// Ensure that rules are supported by credentials.
		// If failure, throw new ValidationException.
		// Else, authenticate the user.
		// Redirect back to the admin area, or to an intended admin page.

	}

	function signOut () {
		// Run the admin logout function that clears the session.
		// Redirect to some non-admin page.

	}

	function resetPassword () {
		// Update the password to something random.
		// Send the new random password to the email address stored on file.

	}
}

?>