<?php
error_reporting(-1);
@ini_set('display_errors', 1);
 
define( 'DB_HOST', 'localhost' );
define( 'DB_USER', 'root' );
define( 'DB_PASS', 'root' );
define( 'VERIFICATION_EXPIRATION', 36000 );
define( 'SB_DEBUG', '1');
 
require( 'user/class-user.php' );
 
$user = User::instance();
 
try
{
    $db = new PDO( 'mysql:host=' . DB_HOST . ';dbname=studybuddy;charset=utf8', DB_USER, DB_PASS);
}
catch (Exception $e)
{
    echo 'NO DATABASE';
}