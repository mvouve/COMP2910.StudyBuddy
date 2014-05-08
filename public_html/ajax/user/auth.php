<?php
require( '../../config.php' );
require( PHP_INC_PATH . 'common.php' );

$retval = array();

// Only do something if a 'method' was set.
if ( isset( $_POST['method'] ) )
{
	// DUMMY CHECK_CREDENTIALS METHOD!
	if ( $_POST['method'] == 'login' )
	{
        $retval = login( $_POST['email'], $_POST['password'], isset( $_POST['remember'] ) );
	}
	// DUMMY EMAIL_EXISTS METHOD!
	else if ( $_POST['method'] == 'email_exists' )
	{
        $retval = checkEmail( $_POST['email'] );
	}
    // Registration Method
    else if ( $_POST['method'] == 'register' )
    {
        $retval = registerAccount( $_POST['email'],
                                   $_POST['display_name'],
                                   $_POST['password'],
                                   $_POST['confirm_password'] 
                                  );
    }
	
	echo json_encode( $retval );
}

/*
 * Attempt to log the user in.
 * @returns [ valid=true|false ]
 */
function login( $email, $password, $remember )
{
    $user = User::instance();
    
    $loggedIn = $user->login( $email, $password, $remember );
    
    return array( 'valid' => $loggedIn );
}

/*
 * Checks if an email is already registered
 * @returns [ exists=true|false ]
 */
function checkEmail( $email )
{
    $user = User::instance();
    $retval = array( 'exists' => 'true' );
    
    if ( $user->getAccountStatus( $email ) === User::ACCOUNT_DOES_NOT_EXIST )
    {
        $retval['exists'] = false;
    }
    
    return $retval;
}

/*
 * Attempt to register an account given details from the input form.
 *
 * @returns [ valid=true|false
             ,invalidAttributes[] (array of field names that were invalid)
             ,accountExists=true|false
             ,accountDeleted=true|false
             ,userID=integer (or false on failure)
             ]
 */
function registerAccount( $email, $displayName, $password, $confirmPassword )
{
    require_once( PHP_INC_PATH . 'class-input-validation.php' );
    
    $User = User::instance();
    $accountStatus = User::ACCOUNT_DOES_NOT_EXIST;
    $retval = array (
        'valid'              => true,
        'invalidAttributes'  => array(),
        'accountExists'      => false,
        'accountDeleted'     => false,
        'accountNotVerified' => false,
        'userID'             => false
    );
    
    // Check if Email is valid.
    if ( !InputValidation::isValidEmail( $email ) )
    {
        $retval['valid'] = false;
        $retval['invalidAttributes'][] = 'email';
    }
    
    // Check if email is already used or the account was recently deleted.
    if ( $retval['valid'] )
    {
        $accountStatus = $User->getAccountStatus( $email );
        
        if ( $accountStatus === User::ACCOUNT_EXISTS )
        {
            $retval['valid'] = false;
            $retval['accountExists'] = true;
        }
        else if ( $accountStatus === User::ACCOUNT_DELETED )
        {
            $retval['valid'] = false;
            $retval['accountDeleted'] = true;
        }
        else if ( $accountStatus === User::ACCOUNT_NOT_VERIFIED )
        {
            $retval['valid'] = false;
            $retval['accountNotVerified'] = true;
        }
    }
    
    // Check if Display Name is valid.
    if ( !InputValidation::isValidDisplayName( $displayName ) )
    {
        $retval['valid'] = false;
        $retval['invalidAttributes'][] = 'display_name';
    }
    
    // Check if Password is Valid.
    if ( !InputValidation::isValidPassword( $password ) )
    {
        $retval['valid'] = false;
        $retval['invalidAttributes'][] = 'password';
    }
    
    // Check if password matches confirmation input.
    if ( $password != $confirmPassword )
    {
        $retval['valid'] = false;
        $retval['invalidAttributes'][] = 'confirm_password';
    }
    
    // Create the User account if all inputs are valid.
    if ( $retval['valid'])
    {
        $retval['valid'] = $User->register( $email, $displayName, $password );
    }
    
    return $retval;
}