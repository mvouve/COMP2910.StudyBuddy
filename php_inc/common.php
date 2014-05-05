<?php
define( 'DB_HOST', 'localhost' );
define( 'DB_USER', 'root' );
define( 'DB_PASS', 'password' );

$db = new PDO( 'mysql:host=' . DB_HOST . ';dbname=StudyBuddy;charset=utf8', DB_USER, DB_PASS);