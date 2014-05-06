<?php
$retval = array();

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
	
	$reval = json_encode( $retval );
	echo $retval;
}