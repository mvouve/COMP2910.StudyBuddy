<?php
require( '../../config.php' );
require( PHP_INC_PATH . 'common.php' );

$retval = array();

// Only do something if a 'method' was set.
if ( isset( $_POST['method'] ) )
{
	// Login METHOD!
	if ( $_POST['method'] == 'login' )
	{
        $retval = login( $_POST['email'], $_POST['password'], isset( $_POST['remember'] ) );
	}
	// DUMMY EMAIL_EXISTS METHOD!
	else if ( $_POST['method'] == 'email-exists' )
	{
        $retval = checkEmail( $_POST['email'] );
	}
    // Registration Method
    else if ( $_POST['method'] == 'register' )
    {
        $retval = registerAccount( $_POST['email'],
                                   $_POST['display-name'],
                                   $_POST['password'],
                                   $_POST['confirm-password'] 
                                  );
    }
	// DEACTIVATE ACCOUNT
	else if ( $_POST['method'] == 'delete-account' )
	{
		$retval = deactivate( $email, $password );
	}
	// Password Recovery
	else if( $_POST['method'] == 'password-recovery' )
	{
		$retval = passwordRecovery( $_POST['verification-string'],
									$_POST['new-password'],
									$_POST['confirm-password']
									);
	}
	// Verify Account
	else if ( $_POST['method'] == 'verify' )
	{
		$retval = verify( $_POST['verification-code'] );
	}
	//Resend verification email
	else if ( $_POST['method'] == 'resend_verification' )
	{
		$retval = resend_verification( $_POST['email'] );
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
		'userID'			 => false,
		'emailSent'			 => false
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
        $id = $User->getUserID( $email );
		$retval['userID'] = $id;
		
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
		
		if ($retval['valid'] != false )
		{
			$retval['emailSent'] = $User->emailVerificationString( $retval['valid'] );
		}
    }
    
    return $retval;
}

function deactivate( $email, $password )
{
	$user = User::instance();
	$retval = array( 'deleted' => false );
	
	if ( $user->checkCredentials( $email, $password ) )
	{
		$retval['deleted'] = $user->deleteAccount( $email );
	}
	
	return $retval;
}

function passwordRecovery( $verificationString, $newPassword, $confirmPassword )
{
	$user = User::instance();
	$retval = array( 'success' => false );
	
	if ( $user->passwordRecovery( $verificationString, 
								  $newPassword, 
								  $confirmPassword ) )
	{
		$retval['success'] = true;
	}
	
	return $retval;
}

function verify( $vCode )
{
	$user = User::instance();
	$retval = array( 'valid' => false, 'expired' => false );
	
	try
		{
		if ( $user->verifyAccount( $vCode ) )
		{
			$retval['valid'] = true;
		}
	}
	catch ( Exception $e )
	{
		$retval['expired'] = true;
	}
	
	return $retval;
}

function resend_verification( $email )
{
	$user = User::instance();
	
}