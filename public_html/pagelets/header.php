<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script>
            <?php global $user; ?>
            var ajaxURL = "<?php echo AJAX_URL; ?>";
            var uid = <?php 
							if ( $user != null && $user->isLoggedIn() )
							{
								echo $user->getUserID( $_SESSION['email'] ); 
							}
							else
							{
								echo '-1';
							}
						?>;
        </script>
        <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="js/jqm.js"></script>
		<!--Source: http://www.kelvinluck.com/assets/jquery/styleswitch/-->
	    <script type="text/javascript" src="js/styleswitch.js"></script>
        <script src="js/misc.js"></script>
		<script src="http://js.pusher.com/2.2/pusher.min.js"></script>
        <script src="js/pusher-events.js"></script>
		<script src="js/courses.js"></script>
		<script src="js/meetings.js"></script>
        <!-- Source: http://www.jqueryrain.com/?lnsG0UbP -->
        <link rel="stylesheet" type="text/css" href="js/datetimepicker/jquery.datetimepicker.css"/>
        <script src="js/datetimepicker/jquery.datetimepicker.js"></script>
	 
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile.structure-1.4.2.min.css" />
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
        
        <link rel="stylesheet" type="text/css" href="css/study-buddy-theme-5.min.css" title="styles1"/>
        <link rel="alternate stylesheet" type="text/css" href="css/StudyBuddyV2.css" title="styles2"/>
        <link rel="alternate stylesheet" type="text/css" href="css/NightTheme.css" title="styles3"/>
        <link rel="alternate stylesheet" type="text/css" href="css/ColorBlindOption.css" title="styles4"/>

        <link rel="stylesheet" href="css/jquery.mobile.icons.min.css" />
        <link rel="stylesheet" href="css/custom.css"/>
        {{customHeadTags}}
    </head>
