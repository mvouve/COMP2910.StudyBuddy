<!--Study Buddy - Account Registration-->
<?php require_once( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
    <body>
        <div data-role="page" data-theme="a">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Register Account' ) ); ?>
			<div data-role="content" id="register">
				<form id="register-form" name="register-form" method="POST">
					<label for="email">Email: <span id="invalid-email-span" style="color: #FF0000">Account already exists!</span></label>
                    <div class="ui-icon-delete ui-btn-icon-right validated-field" id="email-div">
					<input type="text" name="email" id="email"></div>

					<label for="display-name" id="display-name-label">Display Name:</label>
                    <div class="ui-icon-delete ui-btn-icon-right validated-field" id="display-name-div">
					    <input type="text" name="display-name" id="display-name">
                    </div>

                    <label for="password" id="password-label">Password:</label>
					<div class="ui-icon-delete ui-btn-icon-right validated-field" id="password-div">
                        <input type="password" name="password" id="password">
                    </div>

                    <label for="confirm" id="confirm-label">Confirm Password:</label>
                    <div class="ui-icon-delete ui-btn-icon-right validated-field" id="confirm-div">
					    <input type="password" name="confirm-password" id="confirm">
                    </div>
                    <a href="#" data-role="button" id="register-submit">Register</a>
                    <input type="hidden" name="method" value="register" />
				</form>
			</div>
			<div data-role="footer" id="footer">
			</div>
		</div>
        <script>
            $('#register-submit').addClass('ui-disabled');
            $('#invalid-email-span').hide();

            function validateAll()
            {
                if( validateEmail()
                 && validateDisplayName()
                 && validatePassword() )
                {
                    $('#register-submit').removeClass('ui-disabled');
                }
                else
                {
                    $('#register-submit').addClass('ui-disabled');
                }
            }

            //used to ensure a user-entered email is a valid BCIT e-mail
            function validateEmail() {
                var emailRegex = /^(([0-9a-z_.]+@((my\.bcit\.ca)|(bcit.ca)))|(a\d{8}@((mybcit\.ca)|(learn\.bcit\.ca))))$/gi;
                var validEmail = document.getElementById("email").value.match(emailRegex);
                if (validEmail == null || validEmail.length != 1) {
                    $("#email-div").removeClass('ui-icon-check').addClass('ui-icon-delete');
                    return false;
                }
                $("#email-div").removeClass('ui-icon-delete').addClass('ui-icon-check');
                return true;
            }

            //used to ensure a user-entered display name is not null or empty
            function validateDisplayName() {
                var displayNameRegex = /^[0-9A-Za-z-]{5,32}$/g;
                var displayName = document.getElementById("display-name").value.match(displayNameRegex);
                if (displayName == null || displayName.length != 1) {
                    $("#display-name-div").removeClass('ui-icon-check').addClass('ui-icon-delete');
                    return false;
                }
                $("#display-name-div").removeClass('ui-icon-delete').addClass('ui-icon-check');
                return true;
            }

            function validatePassword() {
                var passwordRegex = /^.+$/g;
                var password = document.getElementById("password").value.match(passwordRegex);
                var confirm = document.getElementById("confirm").value;
                if (password == null || password.length != 1) {
                    $("#password-div").removeClass('ui-icon-check').addClass('ui-icon-delete');
                    return false;
                }
                $("#password-div").removeClass('ui-icon-delete').addClass('ui-icon-check');
                if ( password[0] != confirm ) {
                    $("#confirm-div").removeClass('ui-icon-check').addClass('ui-icon-delete');
                    return false;
                }
                $("#confirm-div").removeClass('ui-icon-delete').addClass('ui-icon-check');
                return true;

            }

            
            function onRegister(result) {
                alert(JSON.stringify(result, null, 4));

                if( result.valid != false )
                {
                    window.location.assign('verification-request.php?id=' + result.valid);
                }
                else if( result.accountExists )
                {
                    $('#invalid-email-span').show();
                }
                else if( result.accountNotVerified )
                {
                    window.location.assign('verification-request.php?id=' + result.userID);
                }
                else if( result.accountDeleted )
                {
                    window.location.assign('reactivate-account.php?id=' + result.userID);
                }

                // Reset the Submit button to inactive after being pressed
                $.mobile.activePage.find('.ui-btn-active').removeClass('ui-btn-active ui-focus');
                registerClicked = false;
            }
            
            $("#email").keyup( function(e){
                $('#invalid-email-span').hide();
                validateAll();} );
            $("#display-name").keyup( function(e){validateAll();} );
            $("#password").keyup( function(e){validateAll();} );
            $("#confirm").keyup( function(e){validateAll();} );
            
            var registerClicked = false;
            // Note the change from $().click to $().on( 'click tap', function( e ) {} );
            $("#register-submit").on( 'click tap', function (e) {
                // Use e.preventDefault() to stop page redirection!

                //sebastians button fix start
                var btn = $('#register-submit');
                btn.disabled = true;
                //sebastians button fix end

                e.preventDefault();
                if( !registerClicked )
                {
                    registerClicked = true;
                }
                else
                {
                    return;
                }

                if( !validateEmail() )
                {
                    alert("Invalid Email!");
                    return;
                }
                if( !validateDisplayName() )
                {
                    alert("Invalid Display Name!");
                    return;
                }
                if( !validatePassword() )
                {
                    alert("Invalid Password pair!");
                    return;
                }
                var formData = $("#register-form").serializeArray();

                $.post( <?php echo '\'' . AJAX_URL . 'user/auth.php\''; ?>,
                        formData,
                        onRegister,
                        "json");
            });
        </script>
	</body>
</html>