<?php
class InputValidation
{
    /* 
     * Check if input password is valid.
     *
     * @param $displayName the display name to be checked
     *
     * @returns true on valid, false on invalid 
     */
    static function isValidDisplayName( $displayName )
    {
        // define regular expression
        $displayNameRegex = '/(^[0-9A-Za-z._]{5,32}$)/';
        
        //check if displayname matches regular expression
        if( !preg_match_all( $displayNameRegex, $displayName ) )
        {
            return false;
        }
        
        return true;
    }
    /* 
     * Check if input password is valid.
     *
     * @param $password the password to be checked
     *
     * @returns true on valid, false on invalid 
     */
    static function isValidPassword( $password )
    {
        // define regular expression
        $passwordRegex = '/(^[0-9A-Za-z._]{5,50}$)/';
        
        //check if password matches regular expression
        if( !preg_match_all( $passwordRegex, $password ) )
        {
            return false;
        }
        
        return true;
    }
    /* 
     * Check if input email is valid. Valid emails must end in @my.bcit.ca
     *
     * @param $email the email to be checked
     *
     * @returns true on valid, false on invalid 
     */
    static function isValidEmail( $email )
    {
        // define regular expression
        $emailRegex = array(
                            '/(@my.bcit.ca$)/',
                            '/(@bcit.ca$)/'
                            );
        
        //check if email matches regular expression
        foreach ( $emailRegex as $regex )
        {
            if ( preg_match_all( $regex, $email ) )
            {
                return true;
            }
        }
        
        return false;
    }

}
