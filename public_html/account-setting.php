<?php require( 'config.php' ); ?>
<?php $sliderHeader = array( '{{customHeadTags}}' => '
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.slidepanel.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.slidepanel.css">
    ');

    $email = "you@my.bcit.ca";
?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>

    <body>
        <div data-role="page" data-theme="a">
            <!-- The panel -->
            <div data-role="panel" id="menuPanel" data-theme="b" data-position="right" data-display="overlay">
                <div class="panel-content">
                    <h1>Menu</h1><br>
                    <ul data-role="listview">
                        <li><a href="main.php">My Meetings</a></li>
                        <li><a href="#">Create Meetings</a></li>
                        <li><br></li>
                        <li><a href="#">My Courses</a></li>
                        <li><a href="account-setting.php">Account Settings</a></li>
                        <li><a href="#">Logout</a></li>
                    </ul>
                </div>
            </div>
            <!-- /The panel -->
            <div data-role="header" id="header">
                <img src="images/sb-logo.png" alt="SB" class="ui-btn-left"/>
                <!-- Call the panel -->
                <a href="#menuPanel" data-role="button" data-inline="true" data-icon="bars" class="ui-btn-right" data-position="right" data-display="overlay">Menu</a>
                <!-- /Call the panel -->
                <h1>Account Settings</h1>
            </div>



			<div class="contenta" data-role="content" data-theme="b">
                <div class="center contenta">
                    <p><?php echo $email; ?></p>
                </div>
                <div data-role="collapsible">
                    <h3>Change your display name</h3>
                    <form id="nameChange" name="nameChange" method="POST">
                        <label for="newName">New Name:</label>
                        <input type="text" name="newName" id="newName">
                        <input id="nameUpdate" type="submit" value="Name Update">
                        <input type="hidden" name="method" value="nameUpdate" />
                    </form>
                </div>
                <div data-role="collapsible">
                    <h3>Change your password</h3> 
				    <form id="passwordChange" name="passwordChange" method="POST">
                        <label for="oldPassword">Current Password:</label>
					    <input type="password" name="password" id="oldPassword"><br/>
					    <label for="newPassword">New Password:</label>
					    <input type="password" name="password" id="newPassword"><br/>
					    <label for="confirmPassword">Confirm New Password:</label>
					    <input type="password" name="confirm_password" id="confirmPassword"><br/>
                        <input id="passwordUpdate" type="submit" value="Password Update">
                        <input type="hidden" name="method" value="passwordUpdate" />
				    </form>
                </div>
			</div>
			<div data-role="footer" id="footer">
			</div>
		</div>
	</body>
</html>