<!--Study Buddy - Account Registration-->
<?php require( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
    <body>
        <div data-role="page" data-theme="a">
            <div data-role="header" id="header">
                <img src="images/sb-logo.png" alt="SB" class="ui-btn-left"/>
                <h1>Register Account</h1>
            </div>
			<div class="contenta" data-role="content" id="register">
				<form id="registerForm" name="registerForm" method="POST">
					<label for="email">E-mail:</label>
					<input type="text" name="email" id="email"><br/>
					<label for="displayName">Display Name:</label>
					<input type="text" name="display_name" id="displayName"><br/>
					<label for="password">Password:</label>
					<input type="password" name="password" id="password"><br/>
					<label for="confirm">Confirm Password:</label>
					<input type="password" name="confirm_password" id="confirm"><br/>
                    <input id="register-submit" type="submit" value="Register">
                    <input type="hidden" name="method" value="register" />
				</form>
			</div>
			<div data-role="footer" id="footer">
			</div>
		</div>
        <script>
            //used to ensure a user-entered display name is not null or empty
            function validateUsername() {
                var displayNameRegex = /[0-9A-Za-z-]{5,32}$/g;
                var username = document.form["registerForm"]["display_name"].value.match(displayNameRegex);
                if ((username == null) || (username == "")) {
                    alert("Please enter a user display name, 5-32 alphaneumeric characters.");
                    return false;
                }
                return true;
            }

            //used to ensure a user-entered email is a valid BCIT e-mail
            function validateMail() {
                var emailRegex = /@my.bcit.ca$/g;
                var validEmail = document.form["loginForm"]["email"].value.match(emailRegex);
                if (validEmail == null) {
                    alert("must use a @my.bcit.ca e-mail address.");
                    return false;
                }
                return true;
            }

            function checkEmail() {

            }
            
            function onRegister( result ) {
                alert( JSON.stringify(result, null, 4) );
                
                // Reset the Submit button to inactive after being pressed
                $.mobile.activePage.find('.ui-btn-active').removeClass('ui-btn-active ui-focus');
            }
            
            // Note the change from $().click to $().on( 'click tap', function( e ) {} );
            $( "#register-submit" ).on( 'click tap', function( e ) {
                // Use e.preventDefault() to stop page redirection!
                e.preventDefault();
                
                var formData = $( "#registerForm" ).serializeArray();
                
                $.post( "http://localhost/StudyBuddy/public_html/ajax/user/auth.php",
                        formData,
                        onRegister,
                        "json" );
            });
        </script>
	</body>
</html>