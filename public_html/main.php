<?php require_once( 'config.php' ); ?>
<?php require_once( PHP_INC_PATH . 'common.php' ); ?>
<?php
	$user = User::instance();
	if ( !$user->isLoggedIn() )
	{
		include( 'login.php' );
		die();
	}
?>
<?php $sliderHeader = array( '{{customHeadTags}}' => '
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.slidepanel.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.slidepanel.css">
    ');
?>
<?php renderPagelet( 'header.php', $sliderHeader ); ?>
    <body>
        <div data-role="page" id="page" data-theme="a">
            <?php define('HAS_MENU',1);
                  renderPagelet( 'banner.php', array( '{{title}}' => 'Main Page' ) ); ?>
            <div class="center" data-role="main">
                    <p>Main Page</p>
            </div>     
        </div>
		
		<?php include( 'account-setting.php' ) ?>
		<?php include( 'all-courses.php' ); ?>
		<?php include( 'my-courses.php' ); ?>
		<?php include( 'add-course.php' ); ?>
		<?php /* Change for the sake of change. */ ?>
    </body>
</html>