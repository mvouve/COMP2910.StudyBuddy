<?php
require( 'config.php' );
require( PHP_INC_PATH . 'common.php' );

global $user;

if ( isset( $_GET['logout'] ) )
{
	$user = User::instance();
	$user->logout();
}

if( $user->isLoggedIn() )
{
    include 'main.php';
}
else
{
    include 'login.php';
}
?>
