<?php
define( 'APP_PATH', realpath( dirname( __FILE__ ) . '..\\..' ) . '\\' );
define( 'PHP_INC_PATH', APP_PATH . 'php_inc\\' );
define( 'WWW_PATH', APP_PATH . 'public_html\\' );

// Setup and define the AJAX URL
$ajaxPath = 'http://';
$ajaxPath .= $_SERVER[ 'HTTP_HOST' ];
$ajaxPath .= substr( substr( __FILE__, strlen( $_SERVER[ 'DOCUMENT_ROOT' ] ) ), 0, -10 );
$ajaxPath .= 'ajax/';

$ajaxPath = addslashes( $ajaxPath );

define( 'AJAX_URL', $ajaxPath );

// Setup Pagelets functionality
require( PHP_INC_PATH . 'frontend/pagelets.php' );
