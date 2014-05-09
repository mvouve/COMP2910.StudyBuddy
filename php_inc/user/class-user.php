<?php

require_once( PHP_INC_PATH . 'lib/PasswordHash.php' );

class User
{
	const USER_TABLE = 'User';
	const USER_TOKEN_TABLE = 'UserToken';
	const LOGIN_ATTEMPT_TABLE = 'LoginAttempt';
	const ACCOUNT_EXISTS = 0;
	const ACCOUNT_DELETED = 1;
	const ACCOUNT_DOES_NOT_EXIST = 2; 
    const ACCOUNT_NOT_VERIFIED = 3;
	
	private $passHasher;
	private static $instance = null;
    
    /*
     * Static access to singleton.
     */
    public static function instance()
    {
        if ( User::$instance === null )
        {
            User::$instance = new User();
        }
        
        return User::$instance;
    }
    
    /*
     * Private constructor for Singleton.
     */
	private function __construct()
	{
		$this->passHasher = new PasswordHash( 8, false );
		$this->startSession();
	}

    /*
     * Log the user in
     *
     * @param $email the supplied email
     * @param $password the supplied password
     * @param $rememberMe whether to remember the user or not.
     * 
     * @return true on success, false on failure
     */
	public function login( $email, $password, $rememberMe)
	{
		if ( !$this->isLoggedIn() && $this->checkCredentials( $email, $password ) )
		{
			if ( $this->getAccountStatus( $email ) === User::ACCOUNT_EXISTS )
            {
                $_SESSION['valid'] = 1;
                $_SESSION['email'] = $email;
                
                // Store a unique id for session id
                if ( $rememberMe )
                {
                    $token = $this->storeUserToken( $email );
                    setcookie('sb_id', $email, time()+3600*24*365, '/');
                    setcookie('sb_token', $token, time()+3600*24*365, '/');
                }
                
                return true;
            }
		}
        
        return false;
	}
	
    /*
     * Log the user out.
     */
    public function logout()
	{
        $_SESSION = array();
        session_destroy();
        
        // Unset token cookies!
        if ( isset( $_COOKIE['sb_id'] ) )
        {
            setcookie('sb_id', $email, time()-3600, '/');
            unset( $_COOKIE['sb_id'] );
        }
        
        if ( isset( $_COOKIE['sb_token'] ) )
        {
            setcookie('sb_token', $email, time()-3600, '/');
            unset( $_COOKIE['sb_token'] );
        }
	}
    
    /*
     * Check if the user is currently logged in.
     */
    public function isLoggedIn()
    {
        // Check if the user is explicitly logged in.
        if ( isset( $_SESSION['valid'] ) && $_SESSION['valid'] )
        {
            return true;
        }
        else
        {
            // Check if the user has a valid token in their cookies
            if ( isset( $_COOKIE['sb_id'] ) && isset( $_COOKIE['sb_token'] ) )
            {
                if ( $this->isTokenValid( $_COOKIE['sb_id'], $_COOKIE['sb_token'] ) )
                {
                    $_SESSION['valid'] = 1;
                    $_SESSION['email'] = $_COOKIE['sb_id'];
                    return true;
                }
            }
        }
        
        return false;
    }
	
	/*
	 * Mark an account as deleted.
	 */
	public function deleteAccount( $email )
	{
		global $db;
		
		$sql = 'UPDATE ' . User::USER_TABLE . ' 
				SET deleted=\'T\'
				WHERE email=:email
				;';
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':email', $email );
		return $sql->execute();
	}
    
    /*
     * Check if a users credentials are correct.
     *
     * @param $email the supplied email address.
     * @param $password the supplied password.
     *
     * @return true if the credentials are correct, false if the credentials are incorrect.
     */
	public function checkCredentials( $email, $password)
	{
		global $db;
		
        // Get the password associated with the email address.
		$sql = 'SELECT password
                FROM ' . User::USER_TABLE . ' 
                WHERE email=:email
                ;';
                
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':email', $email );
		$sql->execute();
        
        $result = $sql->fetch( PDO::FETCH_ASSOC );
		
        // Only check if the user exists!
        if ( $result != false )
        {
            // Compare the hashes.
            if ( $this->passHasher->CheckPassword($password, $result['password']) )
            {
                return true;
            }
        }
        
        return false;
	}
	
	public function checkVerificationString( $email, $vString )
	{
		global $db;
		
		$sql = 'SELECT *
				FROM ' . User::USER_TABLE . ' 
				WHERE email=:email
					AND verificationString=:vString
				;';
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':email', $email );
		$sql->bindParam( ':vString', $vString );
		
		if ( $sql->execute() )
		{
			if ( $sql->fetch() )
			{
				return true;
			}
		}
		
		return false;
	}
	
	/*
	 * Get the status of an account indicated by an email address.
	 *
	 * @param $email the email address of the account to check.
	 * 
	 * @returns ACCOUNT_EXISTS, ACCOUNT_DOES_NOT_EXIST, ACCOUNT_DELETED, ACCOUNT_NOT_VERIFIED
	 */
	public function getAccountStatus( $email )
	{
		global $db;
		$retval = User::ACCOUNT_EXISTS;
		
		$sql = 'SELECT *
				FROM ' . User::USER_TABLE . ' 
				WHERE email=:email
				;';
				
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':email', $email );
		$sql->execute();
		
		$user = $sql->fetch( PDO::FETCH_ASSOC );
		
		if ( $user === false )
		{
			$retval = User::ACCOUNT_DOES_NOT_EXIST;
		}
		else 
        {
            if ( $user['deleted'] === 'T' )
            {
                $retval = User::ACCOUNT_DELETED;
            }
            else if ( $user['verified'] === 'F' )
            {
                $retval = User::ACCOUNT_NOT_VERIFIED;
            }
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
	 * @returns userID on success, FALSE on failure.
	 */
	public function register( $email, $displayName, $password )
	{
		$success = false;
		$accountStatus = $this->getAccountStatus( $email );
	
		if ( $accountStatus === User::ACCOUNT_DOES_NOT_EXIST )
		{
			$success = $this->createNewUser( $email, $displayName, $password );
		}
		
		return $success;
	}
	
    /*
     * Change a users Password
     *
     * @param $email the email address that identifies the user.
     * @param $password the users new password.
     *
     * @return true on success, false on failure (or invalid password)
     */
	public function changePassword( $email, $password )
	{
        global $db;
        
        // Ensure the password is valid.
        if ( !InputValidation::isValidPassword( $password ) )
        {
            return false;
        }
        
        $sql = 'UPDATE ' . User::USER_TABLE . ' 
                SET password=:password
                WHERE email=:email
                ;';
        
		$hashedPassword = $this->passHasher->HashPassword( $password );
        
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':password', $hashedPassword );
        $sql->bindParam( ':email', $email );
        return $sql->execute();
	}
	
    /*
     * Change the users password, ensuring the user has access to the old password.
     *
     * @param $email the users email.
     * @param $oldPassword the users current password.
     * @param $newPassword the password the user wants to have.
     * @param $confirmPassword a confirmation copy of newPassword.
     *
     * @return true on success, false on failure.
     */
    public function updatePassword( $email, $oldPassword, $newPassword, $confirmPassword )
    {
		require_once( '../class-input-validation.php' );
	
        // Ensure the password is valid.
        if ( !InputValidation::isValidPassword( $newPassword ) )
        {
            return false;
        }
        
        // Ensure the new passwords match.
        if ( $newPassword != $confirmPassword )
        {
            return false;
        }
        
        // Ensure the user has permission to do this
        if ( !$this->checkCredentials( $email, $oldPassword ) )
        {
            return false;
        }
        
        // Try to change the password.
        return $this->changePassword( $email, $newPassword );
    }
    
    /*
     * Change a users DisplayName
     *
     * @param $email the users email address.
     * @param $displayName the users new displayName
     *
     * @return true on success, false on failure or invalid displayName.
     */
    public function updateDisplayName( $email, $displayName )
    {
        global $db;
        
        // Ensure the new display name is valid.
        if ( !InputValidation::isValidDisplayName( $displayName ) )
        {
            return false;
        }
        
        $sql = 'UPDATE ' . User::USER_TABLE . ' 
                SET displayName=:displayName
                WHERE email=:email
                ;';
                
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':displayName', $displayName );
        $sql->bindParam( ':email', $email );
        
        return $sql->execute();
    }
    
	/*
	 * Verify an account with a given verification string.
	 *
	 * @param $verificationString the verificationString given to the user.
	 */
	public function verifyAccount( $verificationString )
	{
		global $db;
		$success = false;
		
		$sql = 'SELECT *
				FROM ' . User::USER_TABLE . ' 
				WHERE ( verified=\'F\' OR deleted=\'T\' )
					AND verificationString=:verString
				;';
				
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':verString', $verificationString );
		
		$sql->execute();
		$user = $sql->fetch( PDO::FETCH_ASSOC );
		
		//The verification string exists.
		if ( $user != false )
		{
			// User waited too long to verify.
			/* COME BACK TO IT LATER *
			if ( time() - $user['verificationTime'] > VERIFICATION_EXPIRATION )
			{
				require_once( '/../exceptions/class-expired-verification-string-exception.php' );
				throw new ExpiredVerificationStringException();
			}
			*/
			// Valid String and Time, user is verified!
			//else
			{
				$success = $this->setVerified( $user[ 'ID' ] );
			}
		}
		
		return $success;
	}
	
    /** Sebastian
     * change the verification string in the database for the user. (use $this->generateVerificationString(); )
     * verificationString in USER_TABLE
     * and set verificationTime in USER_TABLE to CURRENT_TIMESTAMP
     * send them an email about it
     * return true or false for success
     */
    public function giveNewVerificationString( $id )
    {
        global $db;
        $success = FALSE;

		// Get user email
		$sql = 'SELECT email
				FROM ' . User::USER_TABLE . ' 
				WHERE ID=:id
				;';
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':id', $id );
		if ( !$sql->execute() )
		{
			return false;
		}
		
		$email = $sql->fetch( PDO::FETCH_ASSOC );
		$email = $email['email'];
		
        //create a new verification string
        $newVString = generateVerificationString();

        //update USER_TABLE with new verificationString
        $sql = 'UPDATE ' . User::USER_TABLE . ' 
                SET verificationString=:newVString,
                    verificationTime=CURRENT_TIMESTAMP
                WHERE email=:email
                ;';

        //prepare the sql statement for execution
        $sql = $db->prepare( $sql );

        //bind the parameter to the variable name
        $sql->bindParam( ':newVString', $newVString );
		$sql->bindParam( ':email', $email );
        $success = $sql->execute();

        // If the verification string was created, send it to the email.
        if ( $success )
        {
            $success = emailVerificationString( $email, $newVString );
        }
        
        return $success;
    }
    
    /** Sebastian
     * send the verificationString to the email address.
     * return true or false for success
     */
    public function emailVerificationString( $id )
    {
		global $db;
		
		$sql = 'SELECT verificationString, email
				FROM ' . User::USER_TABLE . ' 
				WHERE ID=:id
				;';
				
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':id', $id );
		
		if ( !$sql->execute() )
		{
			return false;
		}
		
		$result = $sql->fetch( PDO::FETCH_ASSOC );
		$verificationString = $result['verificationString'];
		$email = $result['email'];
	
        //the subject line for the verification e-mail
        $subject = 'Study Buddy Verification';

        //the message to be sent
        $message = 'You have requested a verification email for Study Buddy. Your verification 
					code is provided below:<br/>' . $verificationString . '<br/><br/>Thank you for 
					using Study Buddy.<br/><br/>Sincerely,<br/>The Study Buddy Team';

        // Use wordwrap() to ensure the message is no longer than 70 columns long (industry standard)
        $message = wordwrap($message, 70, '<br/>');

        // Send mail
        return mail($email, $subject, $message, 'From: bcit.study.buddy@gmail.com');
    }
    
	public function emailPasswordChange( $email )
	{
		global $db;
		
		$verString = $this->generateVerificationString();
		
		$sql = 'UPDATE ' . User::USER_TABLE. ' 
				SET verificationString=:vString
				WHERE email=:email
				;';
				
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':email', $email );
		$sql->bindParam( ':vString', $verString );
		
		if ( !$sql->execute() )
		{
			return false;
		}
	
        //the subject line for the verification e-mail
        $subject = 'Study Buddy Verification';

        //the message to be sent
        $message = 'You have requested a password change email for Study Buddy. Your verification 
					code is provided below:<br/>' . $verString . '<br/><br/>Thank you for 
					using Study Buddy.<br/><br/>Sincerely,<br/>The Study Buddy Team';

        // Use wordwrap() to ensure the message is no longer than 70 columns long (industry standard)
        $message = wordwrap($message, 70, '<br/>');

        // Send mail
        mail($email, $subject, $message, 'From: bcit.study.buddy@gmail.com');
	}
	
	/*
	 * Get a User ID from their email
	 *
	 * @param $email the users email
	 *
	 * @return the user ID, or false on failure.
	 */
	public function getUserID( $email )
	{
		global $db;
		
		$sql = 'SELECT ID
				FROM ' . User::USER_TABLE . ' 
				WHERE email=:email
				;';
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':email', $email );
		
		if ( !$sql->execute() )
		{
			return false;
		}
		
		$id = $sql->fetch( PDO::FETCH_ASSOC );
		$id = $id['ID'];
		
		return $id;
	}
	
	/*
	 * Create a new user in the database.
	 * 
	 * @param $email a valid email address.
	 * @param $displayName a valid displayName.
	 * @param $password the users password.
	 *
	 * @returns the ID of the created user on success, or false on failure.
	 */
	private function createNewUser( $email, $displayName, $password )
	{
		global $db;
			
		$sql = 'INSERT INTO ' . User::USER_TABLE . ' 
					(email, displayName, password, verified, deleted, verificationString)
				VALUES
					(:email, :displayName, :password, \'F\', \'F\', :verificationString)
				;';
				
		$hashedPassword = $this->passHasher->HashPassword( $password );
		$verificationString = $this->generateVerificationString();
		
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':email', $email );
		$sql->bindParam( ':displayName', $displayName );
		$sql->bindParam( ':password', $hashedPassword );
		$sql->bindParam( ':verificationString', $verificationString );
        
		if ( $sql->execute() )
        {
            return $db->lastInsertId();
        }
        else
        {
            print_r( $sql->errorInfo() );
        }
        
        return false;
	}
	
	/*
	 * Indicate that the User is now verified.
	 */
	private function setVerified( $userID )
	{
		global $db;
		
		$sql = 'UPDATE ' . User::USER_TABLE . ' 
				SET verified=\'T\', verificationTime=CURRENT_TIMESTAMP
				WHERE ID=:id
				;';
				
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':id', $userID );
		return $sql->execute();
	}
	
	/*
	 * Generate a random verification string.
	 */
	private function generateVerificationString()
	{
		return sha1(microtime(true).mt_rand(10000,90000));
	}
	
    /*
     * Start the session.
     */
	private function startSession()
	{
		ini_set('session.use_only_cookies', 1);
		
		$cookieParams = session_get_cookie_params();
		session_set_cookie_params($cookieParams["lifetime"],
								  $cookieParams["path"], 
								  $cookieParams["domain"], 
								  false,
								  true
								  );
								  
		session_name( 'studybuddy' );
		session_start();
		session_regenerate_id();
	}
    
    /*
     * Store a User Token.
     */
    private function storeUserToken( $email )
    {
        global $db;
        
        $token = substr( $this->generateVerificationString(), 0, 32 );
        
        $sql = 'INSERT INTO ' . User::USER_TOKEN_TABLE . ' 
                    (email, token)
                VALUES
                    (:email, :token)
                ;';
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':email', $email );
        $sql->bindParam( ':token', $token );
        
        $sql->execute();
        
        return $token;
    }
    
    /*
     * Check if the given token is in use by a user, and will let the user log in.
     */
    private function isTokenValid( $email, $token )
    {
        global $db;
        
        $sql = 'SELECT email
                FROM ' . User::USER_TOKEN_TABLE . ' 
                WHERE email=:email
                    AND token=:token
                ;';
                
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':email', $email );
        $sql->bindParam( ':token', $token );
        $sql->execute();
        
        if ( $sql->fetch() != false )
        {
            return true;
        }
        
        return false;
    }
}
