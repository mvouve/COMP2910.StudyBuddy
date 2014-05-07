<?php
require( '../../config.php' );
require( PHP_INC_PATH . 'common.php' );

$retval = array();

// Only do something if a 'method' was set.
if ( isset( $_POST['method'] ) )
{
	// DUMMY CHECK_CREDENTIALS METHOD!
	if ( $_POST['method'] == 'check_credentials' )
	{
		if ( $_POST['email'] === 'me@bcit.ca' && $_POST['password'] === 'password' )
		{
			$retval['valid'] = true;
		}
		else
		{
			$retval['valid'] = false;
		}
	}
	// DUMMY EMAIL_EXISTS METHOD!
	else if ( $_POST['method'] == 'email_exists' )
	{
		if ( $_POST['email'] == 'me@bcit.ca' )
		{
			$retval['exists'] = true; 
		}
		else
		{
			$retval['exists'] = false;
		}
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
    require( PHP_INC_PATH . 'user/class-user-auth.php' );
    require( PHP_INC_PATH . 'class-input-validation.php' );
    
    $userAuth = new UserAuth();
    $accountStatus = UserAuth::ACCOUNT_DOES_NOT_EXIST;
    $retval = array (
        'valid'             => true,
        'invalidAttributes' => array(),
        'accountExists'     => false,
        'accountDeleted'    => false,
        'userID'            => false
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
        $accountStatus = $userAuth->getAccountStatus( $email );
        
        if ( $accountStatus === UserAuth::ACCOUNT_EXISTS )
        {
            $retval['valid'] = false;
            $retval['accountExists'] = true;
        }
        else if ( $accountStatus === UserAuth::ACCOUNT_DELETED )
        {
            $retval['valid'] = false;
            $retval['accountDeleted'] = true;
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
        $retval['valid'] = $userAuth->register( $email, $displayName, $password );
    }
    
    return $retval;
}