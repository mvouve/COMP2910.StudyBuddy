<?php

class UserAuth
{
	private static const $USER_TABLE = 'User';
	private static const $USER_TOKEN_TABLE = 'UserToken';
	private static const $LOGIN_ATTEMPT_TABLE = 'LoginAttempt';
	private static const $ACCOUNT_EXISTS = 0;
	private static const $ACCOUNT_DELETED = 1;
	private static const $ACCOUNT_DOES_NOT_EXIST = 2; 

	public function login( $email, $password, $rememberMe)
	{
		if ( checkCredentials( $email, $password ) )
		{
			
		}
	}
	
	public function checkCredentials( $email, $password)
	{
	}
	
	public function logout()
	{
	}
	
	/*
	 * Get the status of an account indicated by an email address.
	 *
	 * @param $email the email address of the account to check.
	 * 
	 * @returns ACCOUNT_EXISTS, ACCOUNT_DOES_NOT_EXIST, ACCOUNT_DELETED
	 */
	public function getAccountStatus( $email )
	{
		global $db;
		$retval = UserAuth::ACCOUNT_EXISTS;
		
		$sql = 'SELECT *
				FROM ' . UserAuth::USER_TABLE . ' 
				WHERE email=:email
				;';
				
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':email', $email );
		$sql->execute();
		
		$user = $sql->fetch( PDO::FETCH_ASSOC );
		
		if ( $user === false )
		{
			$retval = UserAuth::ACCOUNT_DOES_NOT_EXIST;
		}
		else if ( $user['deleted'] === 'T' )
		{
			$retval = UserAuth::ACCOUNT_DELETED;
		}
		
		return $retval;
	}
	
	/*
	 * Register an account.
	 * 
	 * @param $email a valid email address.
	 * @param $displayName a valid displayName.
	 * @param $password the users password.
	 *
	 * @returns TRUE on success, FALSE on failure.
	 * @throws AccountDeletedException if the account was previously deleted.
	 */
	public funcion register( $email, $displayName, $password )
	{
		$success = false;
		$accountStatus = getAccountStatus( $email );
	
		if ( $accountStatus === UserAuth::ACCOUNT_DOES_NOT_EXIST )
		{
			$success = createNewUser( $email, $displayName, $password );
		}
		else if ( $accountStatus === UserAuth::ACCOUNT_DELETED )
		{
			throw new AccountDeletedException();
		}
		
		return success;
	}
	
	public function changePassword( $email, $password )
	{
		
	}
	
	private function getRecentLoginAttempts( $email )
	{
		global $db;
		
		$sql = 'SELECT *
				FROM ' . $LOGIN_ATTEMPT_TABLE . '
				WHERE email=:email
					AND time BETWEEN ( NOW() - INTERVAL 5 MINUTE ) AND NOW()
				;';
				
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':email', $email );
		$sql->execute();
		
		/* COME BACK TO THIS LATER! */
	}
	
	/*
	 * Create a new user in the database.
	 * 
	 * @param $email a valid email address.
	 * @param $displayName a valid displayName.
	 * @param $password the users password.
	 *
	 * @returns TRUE on success, FALSE on failure.
	 */
	private function createNewUser( $email, $displayName, $password )
	{
		global $db;
			
		$sql = 'INSERT INTO ' . UserAuth::USER_TABLE . ' 
					(email, displayName, password, verified, deleted, verificationString)
				VALUES
					(:email, :displayName, :password, \'F\', \'F\', :verificationString)
				;';
				
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':email', $email );
		$sql->bindParam( ':displayName', $displayName );
		$sql->bindParam( ':password', $hashedPassword );
		$sql->bindParam( ':verificationString', $verificationString );
		
		return $sql->execute();
	}
}