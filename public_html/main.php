<?php require( 'config.php' ); ?>
<?php $sliderHeader = array( '{{customHeadTags}}' => '
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.slidepanel.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.slidepanel.css">
    ');
?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>

<!--doctype html>
<html>
    <head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile.structure-1.4.2.min.css" />
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
		<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
        <link rel="stylesheet" href="css/study-buddy-theme.min.css" />
        <link rel="stylesheet" href="css/jquery.mobile.icons.min.css" />
        <!-- stuff for panel->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.slidepanel.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.slidepanel.css">
        <!-- /stuff for panel->

        <link rel="stylesheet" href="css/custom.css">
    </head>
-->
    <body>
        <div data-role="page" id="page">
            <!-- The panel -->
            <div data-role="panel" id="menuPanel" data-theme="b" data-position="right" data-display="overlay">
                <div class="panel-content">
                    <h1>Menu</h1><br>
                    <ul data-role="listview">
                        <li><a href="#">My Meetings</a></li>
                        <li><a href="#">Create Meetings</a></li>
                        <li><br></li>
                        <li><a href="#">My Courses</a></li>
                        <li><a href="#">Account Settings</a></li>
                        <li><a href="#">Logout</a></li>
                    </ul>
                </div>
            </div>
            <!-- /The panel -->
            <div data-role="header">  
                <h1>studyBuddy</h1>
                <!-- Call the panel -->
                <a href="#menuPanel" data-role="button" data-inline="true" data-icon="bars" class="ui-btn-right" data-position="right" data-display="overlay">Menu</a>
                <!-- /Call the panel -->
                </div>
                    <div class="center" data-role="main">
                    <p>Main Page</p>
                </div>  
            </div>      
        </div>
    </body>
</html>