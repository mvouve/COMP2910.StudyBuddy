<?php
define( 'APP_PATH', realpath( dirname( __FILE__ ) . '..\\..' ) . '\\' );
define( 'PHP_INC_PATH', APP_PATH . 'php_inc\\' );
define( 'WWW_PATH', APP_PATH . 'public_html\\' );
define( 'AJAX_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/public_html/ajax/' );

require( PHP_INC_PATH . 'frontend/pagelets.php' );