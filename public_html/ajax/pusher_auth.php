<?php
require( '../config.php' );
require( PHP_INC_PATH . 'common.php' );

$user = User::instance();
if ( !$user->isLoggedIn() )
{
	die();
}

echo $pusher->socket_auth($_POST['channel_name'], $_POST['socket_id']);
return;