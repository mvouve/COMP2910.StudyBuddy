<?php
require( '../../config.php' );
require( PHP_INC_PATH . 'common.php' );

global $user;

if( $user->isLoggedIn() )
{
    include 'main.php';
}
else
{
    include 'login.php';
}
?>
