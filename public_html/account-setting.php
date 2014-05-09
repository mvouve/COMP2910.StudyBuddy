<?php require_once( 'config.php' ); ?>
<?php require_once( PHP_INC_PATH . 'common.php' ); ?>
<?php
	$user = User::instance();
	if ( !$user->isLoggedIn() )
	{
		include( 'login.php' );
		die();
	}
?>
<?php $sliderHeader = array( '{{customHeadTags}}' => '
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.slidepanel.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.slidepanel.css">
    ');

    $email = $_SESSION['email'];
?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>

    <body>
        <div data-role="page" data-theme="a">
            <?php define('HAS_MENU',1);
                  renderPagelet( 'banner.php', array( '{{title}}' => 'Account Settings' ) ); ?>

			<div data-role="content" data-theme="a">
                <div class="center">
                    <p><?php echo $email; ?></p>
                </div>

                <div data-role="collapsible">
                    <h3>Change your display name</h3>
                    <form id="name-change" name="name-change" method="POST">
                        <label for="display-name">New Name:</label>
                        <div class="ui-icon-delete ui-btn-icon-right validated-field" id="display-name-div">
                            <input type="text" name="display-name" id="display-name">
                        </div>
                        <a href="#" data-role="button" id="update-name">Update Name</a>
                        <input type="hidden" name="method" value="update-display-name" />
                    </form>
                </div>
                <div id="name-change-success" style="display:none">
                        <p>Name Change Successful!</p>
                </div>
                      
                <div data-role="collapsible">
                    <h3>Change your password</h3> 
				    <form id="password-change" name="password-change" method="POST">
                        <input type="hidden" name="email" value="<?php echo $email; ?>">

                        <label for="old-password">Current Password:</label>
					    <input type="password" name="old-password" id="old-password" required><br/>


					    <label for="new-password">New Password:</label>
                        <div class="ui-icon-delete ui-btn-icon-right validated-field" id="password-div">
					        <input type="password" name="new-password" id="new-password" required>
                        </div>


					    <label for="confirm-password">Confirm New Password:</label>
                        <div class="ui-icon-delete ui-btn-icon-right validated-field" id="confirm-div">
    					    <input type="password" name="confirm-password" id="confirm-password" required>
                        </div>


                        <a href="#" data-role="button" id="update-password">Update Password</a>
                        <input type="hidden" name="method" value="update-password">
				    </form>
                    <div id="mismatch" style="display:none">
                        <p>Please check your new passwords</p>
                    </div>
                </div>
                <div data-role="collapsible">
                    <h3>Deactivate your account</h3>
                    <form id="deactivate-account-form" name="deactivate-account-form" method="POST">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" required><br/>
                        <input id="deactivate-account" type="button" value="Deactivate Account">
                        <input type="hidden" name="method" value="delete-account" />
                    </form>
                </div>
			</div>
			<div data-role="footer" id="footer">
			</div>
		</div>
        <script>
            $('#update-name').addClass('ui-disabled');
            $('#update-password').addClass('ui-disabled');
            $('#update-password').on( 'click tap', function (e) {
			/*
                alert('belly');
                var passwordForm = $("#update-password").serializeArray();
                $.ajax({
                    type: "POST",
                    url: <?php echo '\'' . AJAX_URL . 'user/settings.php\''; ?>,
                    data: passwordForm,
                    error: onPasswordChange,
                    datatype: 'json'
                });
                alert('hello');
			*/
				e.preventDefault();
				var formData = $("#password-change").serializeArray();
				
				$.post( <?php echo '\'' . AJAX_URL . 'user/settings.php\''; ?>,
						formData,
						onPasswordChange,
						"json" );
            });

            
            $('#update-name').on( 'click tap', function () {
                alert('starting updating name');
                var updateNameForm = $("#update-name").serializeArray();

                $.ajax
                ({
                    type: "POST",
                    url: <?php echo '\'' . AJAX_URL . 'user/settings.php\''; ?>,
                    data: updateNameForm,
                    datatype: 'json',
                    success: function (json) {
                        if (json.success == true) { 
                            nameChangeSuccess();
                        }
                    },
                    error: errorMessage()
                });
            });

            $('#deactivate-account').on( 'click tap', function () {
                alert('account deactivation button pressed');
                var deactivateAccountForm = $("#deactivate-account-form").serializeArray();
				
                $.ajax
                ({
                    type: "POST",
                    url: <?php echo '\'' . AJAX_URL . 'user/auth.php\''; ?>,
                    data: deactivateAccountForm,
                    datatype: 'json',
                    success: function (json) {
                        if (json.deleted == true)
                        {
                            alert('Study Buddy account deactivated.');
                            redirectToMain();
                        }},
                    error: errorMessage()
                });
            });

            function validateDisplayName() {
                var displayNameRegex = /^[0-9A-Za-z-]{5,32}$/g;
                var displayName = document.getElementById("display-name").value.match(displayNameRegex);
                if (displayName == null || displayName.length != 1) {
                    $("#display-name-div").removeClass('ui-icon-check').addClass('ui-icon-delete');
                    $('#update-name').addClass('ui-disabled');
                    return false;
                }
                $('#display-name-div').removeClass('ui-icon-delete').addClass('ui-icon-check');
                $('#update-name').removeClass('ui-disabled');
                return true;
            }
            $("#display-name").keyup( function(e){validateDisplayName();} );

            function validatePassword() {
                var passwordRegex = /^.+$/g;
                var password = document.getElementById("new-password").value.match(passwordRegex);
                var confirm = document.getElementById("confirm-password").value;

                if (password == null || password.length != 1) {
                    $("#password-div").removeClass('ui-icon-check').addClass('ui-icon-delete');
                    $("#confirm-div").removeClass('ui-icon-check').addClass('ui-icon-delete');
                    $('#update-password').addClass('ui-disabled');
                    return false;
                }
                $("#password-div").removeClass('ui-icon-delete').addClass('ui-icon-check');

                if ( password[0] != confirm ) {
                    $("#confirm-div").removeClass('ui-icon-check').addClass('ui-icon-delete');
                    $('#update-password').addClass('ui-disabled');
                    return false;
                }
                $("#confirm-div").removeClass('ui-icon-delete').addClass('ui-icon-check');
                $('#update-password').removeClass('ui-disabled');
                return true;

            }
            $("#new-password").keyup( function(e){validatePassword();} );
            $("#confirm-password").keyup( function(e){validatePassword();} );

            function onPasswordChange(data) {
                alert('HI!');
            }

            function errorMessage() {
                alert('error message');
            }

            function nameChangeSuccess() {
                $('#name-change-succcess').show();
            }

            function redirectToMain()
            {
                window.location.assign("main.php");
            }
        </script>
	</body>
</html>