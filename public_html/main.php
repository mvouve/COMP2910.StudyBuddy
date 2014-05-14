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
<?php $sliderHeader = array( '{{customHeadTags}}' => '');
?>
<?php renderPagelet( 'header.php', $sliderHeader ); ?>
    <body id='page-container'>
        <div data-role="page" id="page-test-main" data-theme="a">
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
	
	<script>
        $( 'document' ).ready( function () {
            // Setup the pagecontainer widger
            $( "#page-container" ).pagecontainer({ defaults: true });
        
            // Close the Menu Panel when the page is changed.
            $( '#page-container' ).on( "pagecontainerhide", function( event, ui ) {
                var menuPanel = $( '#' + $( "#page-container" ).pagecontainer( 'getActivePage')[0].id + " .menu-panel" );
                
                $( 'a .ui-btn-active' ).removeClass( 'ui-btn-active' );
                menuPanel.panel( "close" );
            });
            
            // Open the Menu Panel when the Menu button is clicked on a specific page.
            $( '.menu-toggle' ).on( "click tap", function() {
                $( '#' + $( "#page-container" ).pagecontainer( 'getActivePage')[0].id + " .menu-panel" ).panel( "open" );
            });
        
            accountSettingsOnReady();
            addCourseOnReady();
            myCourseOnReady();
            allCoursesOnReady();
        });
	</script>
	
</html>