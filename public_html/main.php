<?php require_once( 'config.php' ); ?>
<?php require_once( PHP_INC_PATH . 'common.php' ); ?>
<?php
	$user = User::instance();
	if ( !$user->isLoggedIn() )
	{
		include( 'login.php' );
		die();
	}
    
    define( 'HAS_MENU', 1 );
?>
<?php $sliderHeader = array( '{{customHeadTags}}' => '');
?>
<?php renderPagelet( 'header.php', $sliderHeader ); ?>
    <body id='page-container'>
        <?php include( 'my-meetings.php' ); ?>
        <?php include( 'create-meetings.php' ); ?>
		<?php include( 'account-setting.php' ); ?>
		<?php include( 'all-courses.php' ); ?>
		<?php include( 'my-courses.php' ); ?>
		<?php include( 'add-course.php' ); ?>
        <?php include( 'edit-meetings.php' ); ?>
        <?php include( 'notify-demo.php' ); ?>
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
            
            $( '#page-container' ).on( 'pagecontainerbeforeshow', function() {
				$( '#page-container' ).find( '.ui-btn-active' ).removeClass( 'ui-btn-active ui-focus' );
                
                // Reset Create-Meeting form when loading page
                if ( $.mobile.activePage.attr( 'id' ) == 'page-create-meeting' )
                {
                    document.getElementById('create-meeting-form').reset();
                }
                else if ( $.mobile.activePage.attr( 'id' ) == 'page-edit-meeting' )
                {
                    document.getElementById('edit-meeting-form').reset();
                }
                
				colorChange();
            });
			
			setTimeout( function() { colorChange(); }, 250 );
            
            // Open the Menu Panel when the Menu button is clicked on a specific page.
            $( '.menu-toggle' ).on( "click touchend", function() {
                $.mobile.activePage.find(".menu-panel" ).panel( "open" );
            });
        
			// Setup Pusher for receiving events.
			setupPusher( ajaxURL );
			
		
            // Various Page "onReady" functions
            
            accountSettingsOnReady();
            addCourseOnReady();
            allCoursesOnReady();
            myCourseOnReady();
			myMeetingOnReady();

		    getCourseList(ajaxURL);
            getUserCourses( ajaxURL );
        });
	</script>
	
</html>