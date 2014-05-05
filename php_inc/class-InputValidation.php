<?php
class InputValidation
{
	/*
	 * Ensures display name is valid.
	 */
	static function isValidDisplayName( $displayName )
	{
		// define regular expression
		$displayNameRegex = '/(^[0-9A-Za-z-/._]{5,32}$)/g';
		
		//check if displayname matches regular expression
		if( !preg_match( $displayNameRegex, $displayName )
		{
			return false;
		}
		
		return true;
	}
	
	static function isValidPassword( $password )
	{
		// define regular expression
		$passwordRegex = '/(^[0-9A-Za-z-/._]{5,50}$)/g';
		
		//check if displayname matches regular expression
		if( !preg_match( $passwordRegex, $password )
		{
			return false;
		}
		
		return true;
	}

}
