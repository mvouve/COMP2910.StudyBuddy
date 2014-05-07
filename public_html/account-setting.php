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
            <?php define('HAS_MENU',1);
                  renderPagelet( 'banner.php', array( '{{title}}' => 'Account Settings' ) ); ?>

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