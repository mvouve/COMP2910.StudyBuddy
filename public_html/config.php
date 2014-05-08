<?php
define( 'APP_PATH', realpath( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR .'..' . DIRECTORY_SEPARATOR );
define( 'PHP_INC_PATH', APP_PATH . 'php_inc' . DIRECTORY_SEPARATOR );
define( 'WWW_PATH', APP_PATH . 'public_html' . DIRECTORY_SEPARATOR );

// Setup and define the base URI of public_html
$uriinfo = pathinfo( $_SERVER[ 'PHP_SELF' ] );
$length  = strlen( $_SERVER[ 'PHP_SELF' ] ) - strlen( $uriinfo['basename'] );
define( 'BASE_URI', substr( $_SERVER[ 'PHP_SELF' ], 0, $length ) );


// Setup and define the AJAX URL
$ajaxPath = 'http://';
$ajaxPath .= $_SERVER[ 'HTTP_HOST' ];
$ajaxPath .= BASE_URI;
$ajaxPath .= 'ajax/';

$ajaxPath = addslashes( $ajaxPath );

define( 'AJAX_URL', $ajaxPath );

// Setup Pagelets functionality
require( PHP_INC_PATH . 'frontend/pagelets.php' );
