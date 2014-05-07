<!--Study Buddy - Account Registration-->
<?php require( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
    <body>
        <div data-role="page" data-theme="a">
            <div data-role="header" id="header">
                <img src="images/sb-logo.png" alt="SB" class="ui-btn-left"/>
                <h1>Account Settings</h1>
            </div>
			<div class="contenta" data-role="content">
                <div data-role="collapsible">
                    <h3>Change your password</h3> 
				    <form id="registerForm" name="registerForm" method="POST">
                        <label for="oldPassword">Current Password:</label>
					    <input type="password" name="password" id="oldPassword"><br/>
					    <label for="newPassword">New Password:</label>
					    <input type="password" name="password" id="newPassword"><br/>
					    <label for="confirmPassword">Confirm New Password:</label>
					    <input type="password" name="confirm_password" id="confirmPassword"><br/>
                        <input id="register-submit" type="submit" value="Register">
                        <input type="hidden" name="method" value="register" />
                        
				    </form>
                </div>
			</div>
			<div data-role="footer" id="footer">
			</div>
		</div>
	</body>
</html>