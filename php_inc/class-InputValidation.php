<?php
class InputValidation
{
    /* 
     * Check if input password is valid.
     *
     * @params $displayName the display name to be checked
     *
     * @returns true on valid, false on invalid 
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
    /* 
     * Check if input password is valid.
     *
     * @params $password the password to be checked
     *
     * @returns true on valid, false on invalid 
     */
    static function isValidPassword( $password )
    {
        // define regular expression
        $passwordRegex = '/(^[0-9A-Za-z-/._]{5,50}$)/g';
        
        //check if password matches regular expression
        if( !preg_match( $passwordRegex, $password )
        {
            return false;
        }
        
        return true;
    }
    /* 
     * Check if input email is valid. Valid emails must end in @my.bcit.ca
     *
     * @params $email the email to be checked
     *
     * @returns true on valid, false on invalid 
     */
    static function isValidPassword( $email )
    {
        // define regular expression
        $emailRegex = '/(@my.bcit.ca$)/g';
        
        //check if email matches regular expression
        if( !preg_match( $emailRegex, $email )
        {
            return false;
        }
        
        return true;
    }

}
