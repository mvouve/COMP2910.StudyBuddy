<!--Study Buddy - Account Registration-->
<?php require( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
    <body>
        <div data-role="page" data-theme="a">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Register Account' ) ); ?>
			<div class="contenta" data-role="content" id="register">
				<form id="registerForm" name="registerForm" method="POST">
					<label for="email" id="emailLabel">Email:</label>
					<input type="text" name="email" id="email"><br/>
					<label for="display_name">Display Name:</label>
					<input type="text" name="display_name" id="display_name"><br/>
					<label for="password">Password:</label>
					<input type="password" name="password" id="password"><br/>
					<label for="confirm">Confirm Password:</label>
					<input type="password" name="confirm_password" id="confirm"><br/>
                    <input id="register-submit" type="button" value="Register">
                    <input type="hidden" name="method" value="register" />
				</form>
			</div>
			<div data-role="footer" id="footer">
			</div>
		</div>
        <script>
            var valid = false;
            //used to ensure a user-entered email is a valid BCIT e-mail
            function validateEmail() {
                var emailRegex = /^[0-9a-z_.]@my\\.bcit\\.ca$/gi;
                var emailLabel = document.getElementById("emailLabel");
                var validEmail = document.getElementById("email").value.match(emailRegex);
                if (validEmail == null || validEmail.length != 1) {
                    emailLabel.style.color="#FF0000";
                    valid = false;
                    return false;
                }
                emailLabel.style.color="#00FF00";
                valid &= true;
                return true;
            }

            //used to ensure a user-entered display name is not null or empty
            function validateDisplayName() {
                var displayNameRegex = /^[0-9A-Za-z-]{5,32}$/g;
                var displayNameLabel = document.getElementById("displayNameLabel");
                var displayName = document.getElementById("displayName").value.match(displayNameRegex);
                if (displayName == null || displayName.length != 1) {
                    displayNameLabel.style.color="#FF0000";
                    return false;
                }
                displayNameLabel.style.color="#00FF00";
                return true;
            }

            function onRegister(result) {
                alert(JSON.stringify(result, null, 4));

                // Reset the Submit button to inactive after being pressed
                $.mobile.activePage.find('.ui-btn-active').removeClass('ui-btn-active ui-focus');
            }
            
            $("#email").keyup( function(e){validateEmail();} );
            $("#displayName").keyup( function(e){validateDisplayName();} );

            // Note the change from $().click to $().on( 'click tap', function( e ) {} );
            $("#register-submit").on( 'click tap', function (e) {
                if( !validateEmail() || !validateDisplayName() )
                {
                    alert("Invalid email or displayName");
                    return;
                }
                var formData = $("#registerForm").serializeArray();

                $.post( <?php echo '\''.AJAX_URL . 'user/auth.php\''; ?>,
                        formData,
                        onRegister,
                        "json");

                // Use e.preventDefault() to stop page redirection!
                e.preventDefault();
            });
        </script>
	</body>
</html>