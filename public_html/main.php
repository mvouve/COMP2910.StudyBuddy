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
            $( '#page-container' ).on( "pagecontainerhide", function() {
                var menuPanel = $.mobile.activePage.find(".menu-panel" );
                $.mobile.activePage.find('.ui-btn-active').each( function() { console.log("ASFA"); } );
                $.mobile.activePage.find('.ui-btn-active').removeClass('ui-state-persist');
                menuPanel.panel( "close" );
            });
            
            $( '#page-container' ).on( 'pagecontainerbeforehide', function() {
				$( '#page-container' ).find( '.ui-btn-active' ).removeClass( 'ui-btn-active ui-focus' );
                $.mobile.activePage.find('.ui-btn-active').each( function() { console.log("ASFA"); } );
            });
            
            // Open the Menu Panel when the Menu button is clicked on a specific page.
            $( '.menu-toggle' ).on( "click tap", function() {
                $.mobile.activePage.find(".menu-panel" ).panel( "open" );
            });
        
			// Setup Pusher for receiving events.
			setupPusher( ajaxURL );
            colorChange();
		
            // Various Page "onReady" functions
            accountSettingsOnReady();
            addCourseOnReady();
            allCoursesOnReady();
            myCourseOnReady();

		    getCourseList(ajaxURL);
            getUserCourses( ajaxURL );
        });
	</script>
	
</html>