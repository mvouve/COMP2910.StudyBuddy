<?php
class User
{
    /* user athentification settings */
    private $userAuth;

    /* constructor for User */
    function __construct( $userAuth )
    {
        $this->userAuth = $userAuth;
    }
    
    /* 
     * function to update display name and password 
     */
    function updateSettings()
    {
        global $db;
        
        // unwrap $_POST variables.
        extract( $_POST );
        
        $sql = 'UPDATE INTO User SET displayName = :display_name WHERE email = :email';
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':email', $email );
        $sql->bindParam( ':display_name', trim( $displayName ) );
        
        
        
        // verify password change and update password.
        if( $change_password == 'yes'
         && $userAuth->checkCredentials( $email, $old_pass )
         && $new_pass == $confirm_pass )
        {
            $userAuth->changePassword( $email, $new_pass );
        }
        
        // verify valid displayname and update in the database.
        if ( InputValidation::isValidDisplayName( trim( $display_name ) )
        {
            $sql->execute();
        }
        
    }
    function isLoggedIn()
    {
        return true;
    }
    
}