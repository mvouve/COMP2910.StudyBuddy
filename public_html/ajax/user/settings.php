<?php
$retval = array('success' => false );

//Only do something if a method is set.
if ( isset( $_POST['method']) )
{
	// Update name Function.
	if( $_POST['method'] == 'update-display-name' )
	{
		$retval = updateDisplayName( $_POST['email'],
									 $_POST['display-name']
								    );
	}
	
	// Update password Function.
	else if( $_POST['method'] == 'update-password' )
	{
		$retval = updatePassword( $_POST['email'],
								  $_POST['old-password'],
								  $_POST['new-password'],
								  $_POST['confirm-password']
								);
	}
	
	
	echo json_encode( $retval );
}

/*
 * Update user display name.
 * @returns [ success=true|false ]
 */
function updateDisplayName( $email, $displayName )
{
	$user = User::instance();
	
	if( $user->updateDisplayName( $email, $displayName ) )
	{
		$retval = array( 'success' => true );
	}
}

/*
 * Update user password.
 * @returns [ success=true|false ]
 */
function updatePassword( $email, $oldPassword, $newPassword, $confirmPassword )
{
	$user = User::instance();
	
	if( $user->updatePassword( $email, $oldPassword, $newPassword, $confirmPassword ) )
	{
		$retval = array( 'success' => true );
	}
}
