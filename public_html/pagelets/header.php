<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script>
            <?php global $user; ?>
            var ajaxURL = "<?php echo AJAX_URL; ?>";
            var uid = <?php echo $user->getUserID( $_SESSION['email'] ); ?>;
        </script>
        <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
		<script src="http://js.pusher.com/2.2/pusher.min.js"></script>
        <script src="js/pusher-events.js"></script>
		<script src="js/courses.js"></script>
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile.structure-1.4.2.min.css" />
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
        <link rel="stylesheet" href="css/study-buddy-theme-5.min.css" />
        <link rel="stylesheet" href="css/jquery.mobile.icons.min.css" />
        <link rel="stylesheet" href="css/custom.css"/>
        {{customHeadTags}}
    </head>