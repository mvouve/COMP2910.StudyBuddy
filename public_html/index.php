<?php
require_once( 'config.php' );
require_once( PHP_INC_PATH . 'common.php' );

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
