<?php
require( '../config.php' );
require( PHP_INC_PATH . 'common.php' );

$user = User::instance();
if ( !$user->isLoggedIn() )
{
	die();
}

date_default_timezone_set( 'America/Los_Angeles' );

// Push to the user who created it to create their notification in phonegap app
if ( isset( $_POST['notify-demo-message'] ) )
{
    global $pusher;

    $data = array( 'meetingID' => '-11',
                   'title' => 'Notification Test!',
                   'message' => $_POST['notify-demo-message'],
                   'date' => new DateTime()
                 );
                 
    $uid = $user->getUserID( $_SESSION['email'] );
                 
    $pusher->trigger( 'study_buddy_user_' . $uid, 'create_notification', $data );
}