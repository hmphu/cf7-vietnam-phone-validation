<?php
/*
 * Plugin Name: CF7 Vietnam Phone Validation
 * Plugin URI: http://hmphu.com/
 * Description: Added vietnam phone validation for CF7 tel field
 * Version: 1.0.0
 * Text Domain: contact-form-7
 * Author: Jimmy Hoang
 * Author URI: http://hmphu.com/
 */

class JH_CF7_Vietnam_Phone_Validation {

	public function __construct() {
		
	}

	public function run() {
		add_filter('wpcf7_validate_tel', [$this, 'validate'], 10, 2); // Normal field
		add_filter('wpcf7_validate_tel*',  [$this, 'validate'], 10, 2); // Req. field
	}

	public function validate($result, $tag){
		$tagName = $tag->name;
		$value = isset($_POST[$tagName]) ? $_POST[$tagName] : false;

		if(!empty($value) && !$this->validatePhoneNumber($value)){
			$result->invalidate( $tag, __( "Telephone number that the sender entered is invalid", 'contact-form-7' ));
		}

		return $result;
	}

	private function validatePhoneNumber($phoneNumber) {
		$phoneNumber = str_replace(array('-', '.', ' '), '', $phoneNumber);

		// return false if number is not mobile number 
		if (!preg_match('/^(01[2689]|03|05|07|08|09)[0-9]{8}$/', $phoneNumber)) {
			return false;
		}

		return true;
	}
}

$oCF7VnPhoneValidation = new JH_CF7_Vietnam_Phone_Validation();
$oCF7VnPhoneValidation->run();
