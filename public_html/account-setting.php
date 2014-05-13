<!--Beginning of account-settings.php-->
<?php
    $email = $_SESSION['email'];
    $display_name = $_SESSION['display_name'];
?>
        <div data-role="page" data-theme="a" id='page-account-settings'>
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Account Settings' ) ); ?>

            <div data-role="content" data-theme="a">
                <div class="center">
                    <p><?php echo $email; ?></p>
                </div>
                <!-- Colapsable change your display name div -->
                <div data-role="collapsible">
                    <h3>Change your display name</h3>
                    <form id="name-change" name="name-change" method="POST">
                        <!-- display name, automaticly renders current display name to be edited directly-->
                        <label for="display-name">New Name:</label>
                        <div class="ui-icon-check ui-btn-icon-right validated-field" id="display-name-div">
                            <input type="text" name="display-name" id="display-name" value="<?php echo $display_name ?>">
                        </div>
                        
                        <!-- Submit button for updating display name -->
                        <a href="#" data-role="button" id="submit-display-name">Update Name</a>
                        
                        <!-- accounts email address, used to reference account in the database -->
                        <input type="hidden" name="email" value="<?php echo $email; ?>">
                        <!-- Tells the PHP which method to use with this information -->
                        <input type="hidden" name="method" value="update-display-name" />
                    </form>
                    <!-- appears if the name change was successful, made visible via javascript -->
                    <div id="name-change-success" style="display:none">
                        <p>Name Change Successful!</p>
                    </div>
                </div>
                
                
                
                <!-- password change div -->
                <div data-role="collapsible">
                    <h3>Change your password</h3> 
                    <form id="password-change" name="password-change" method="POST">
                        <input type="hidden" name="email" value="<?php echo $email; ?>">
                        
                        <!-- FLAG FOR RENAME "current-password" -->
                        <!-- Field for the users current password-->
                        <label for="old-password">Current Password:</label>
                        <input type="password" name="old-password" id="old-password" required><br/>

                        <!-- Field for the new password. -->
                        <label for="new-password">New Password:</label>
                        <div class="ui-icon-delete ui-btn-icon-right validated-field" id="password-div">
                            <input type="password" name="new-password" id="new-password" required>
                        </div>
                        
                        <!-- Field to double confirm the new password. -->
                        <label for="confirm-password">Confirm New Password:</label>
                        <div class="ui-icon-delete ui-btn-icon-right validated-field" id="confirm-div">
                            <input type="password" name="confirm-password" id="confirm-password" required>
                        </div>
                        
                        <!-- FLAG FOR ID CHANGE -->
                        <!-- Submit button for password change -->
                        <a href="#" data-role="button" id="update-password">Update Password</a>
                        
                        <!-- method to be used by PHP. -->
                        <input type="hidden" name="method" value="update-password">
                    </form>
                    
                    <!-- FLAG FOR ID CHANGE -->
                    <!-- displayed when theres an issue with the password change -->
                    <div id="mismatch" style="display:none">
                        <p>Please check your new passwords</p>
                    </div>
                    
                    <!-- displayed when password is successfully changed -->
                    <div id="password-change-success" style="display:none">
                        <p>Password Change Successful!</p>
                    </div>
                </div>
                
                <!-- account deactivation area -->
                <div data-role="collapsible">
                    <h3>Deactivate your account</h3>
                    <form id="deactivate-account-form" name="deactivate-account-form" method="POST">
                        <!-- Text area to enter password for deactivation -->
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" required>
                        
                        <!-- FLAG FOR NAME CHANGE -->
                        <!-- submit button for deactivating account -->
                        <a href="#" data-role="button" id="deactivate-account">Deactivate Account</a>
                        <input type="hidden" name="method" value="delete-account" />
                    </form>
                </div>
            </div>
            <div data-role="footer" id="footer">
            </div>
        </div>
        <script>
            // variables for stopping double clicks from registering
            var changingName = false;
            var changingPass = false;
            var deactivating = false;
            
            /* disable the buttons for updating password */
            $('#update-password').addClass('ui-disabled');
            /* disable the button for deactivating account.*/
            $('#deactivate-account').addClass('ui-disabled');
            
            /*
             * When the user enters in a password to be changed. Send info to server.
             *
             */
            $('#update-password').on( 'click tap', function (e) {
                e.preventDefault();
                
                if ( changingPass == false ) {
                    changingPass = true;
                    var formData = $("#password-change").serializeArray();
                    
                    $.post( <?php echo '\'' . AJAX_URL . 'user/settings.php\''; ?>,
                            formData,
                            onPasswordChange,
                            "json" );
                }
            });

            /* 
             * When user updates their name, update on the server as well.
             *
             */
            $('#submit-display-name').on( 'click tap', function () {
                if ( changingName == false ) {
                    changingName = true;
                    var updateNameForm = $("#name-change").serializeArray();

                    $.ajax
                    ({
                        type: "POST",
                        url: <?php echo '\'' . AJAX_URL . 'user/settings.php\''; ?>,
                        data: updateNameForm,
                        datatype: 'json',
                        success: function (json) {
                            changingName = false;
                            json = $.parseJSON( json );
                            if (json.success == true) { 
                                nameChangeSuccess();
                            }
                        }
                    });
                }
            });
            
            /*
             * If the user wishes to deactivate their account, verify their password and notify them
             * that their account has been deleted. else, do nothing.
             */
            $('#deactivate-account').on( 'click tap', function () {
                if ( deactivating == false ) {
                    deactivating = true;
                    var deactivateAccountForm = $("#deactivate-account-form").serializeArray();
                    
                    $.ajax
                    ({
                        type: "POST",
                        url: <?php echo '\'' . AJAX_URL . 'user/auth.php\''; ?>,
                        data: deactivateAccountForm,
                        datatype: 'json',
                        success: function (json) {
                            deactivating = false;
                            json = $.parseJSON( json );
                            if (json.deleted == true)
                            {
                                alert( 'Your account has been deactivated and may be permanently ' +
                                       'removed in the near future.' );
                                window.location.assign("login.php");
                            }
                        }
                    });
                }
            });
            
            /*
             * Validates the display name, and changes the button and the icon to be on or off.
             *
             * @return true|false
             */
            function validateDisplayName() {
                var displayNameRegex = /^[0-9A-Za-z-]{5,32}$/g;
                var displayName = document.getElementById("display-name").value.match(displayNameRegex);
                if (displayName == null || displayName.length != 1) {
                    $('#display-name-div').removeClass('ui-icon-check').addClass('ui-icon-delete');
                    $('#submit-display-name').addClass('ui-disabled');
                    return false;
                }
                $('#display-name-div').removeClass('ui-icon-delete').addClass('ui-icon-check');
                $('#submit-display-name').removeClass('ui-disabled');
                return true;
            }
            
            /*
             * Calls function to validate displayname when user types in the box.
             */
            $("#display-name").keyup( function(e){validateDisplayName();} );
               
            /*
             * Checks for valid password syntax.
             * 
             * @return true|false 
             */
            function validatePassword() {
                // The new password.
                var password = document.getElementById("new-password").value.match(passwordRegex);
                // The password confirmation field.
                var confirm = document.getElementById("confirm-password").value;
                
                // Verifies that the password field isn't empty.
                if (password == null || password.length != 1) {
                    $("#password-div").removeClass('ui-icon-check').addClass('ui-icon-delete');
                    $("#confirm-div").removeClass('ui-icon-check').addClass('ui-icon-delete');
                    $('#update-password').addClass('ui-disabled');
                    
                    return false;
                }
                $("#password-div").removeClass('ui-icon-delete').addClass('ui-icon-check');
                
                // If the two password fields do not have the same value, confimation password is invalid.
                if ( password[0] != confirm ) {
                    $("#confirm-div").removeClass('ui-icon-check').addClass('ui-icon-delete');
                    $('#update-password').addClass('ui-disabled');
                    
                    return false;
                }
                
                // If confimationa and update match allow user to try changing passwords.
                $("#confirm-div").removeClass('ui-icon-delete').addClass('ui-icon-check');
                $('#update-password').removeClass('ui-disabled');
                
                return true;

            }
            
            /*
             * Checks if password in deactivation area could be correct.
             * @return true | false
             */
            function validateDeactivation()
            {
                // password for deletion
                var delpass = document.getElementById('password').value;
                
                // if something is entered, could be valid.
                if (delpass == null || delpass.length < 1) {
                    $('#update-password').addClass('ui-disabled');
                    
                    return false;
                }
                
                // enable button.
                $('#deactivate-account').removeClass('ui-disabled');
                
                return true;
            }
            
            /*
             * Calls function to validate passwords when user types in new-password
             */
            $("#new-password").keyup( function(e){validatePassword();} );
            
            /*
             * Calls function to validate passwords when user types in confirm password
             */
            $("#confirm-password").keyup( function(e){validatePassword();} );
            
            /*
             * Calls function to validate passwords when user types in the old password
             */
            $("#old-password").keyup( function(e){ validateDeactivation();} );
            
            /*
             * Displays message that password change was successful.
             */
            function onPasswordChange(data) {
                $('#password-change-success').show();
                changingPass = false;
            }
            
            /*
             * Displays message that display name change was successful.
             */
            function nameChangeSuccess() {
                $('#name-change-success').show();
            }
        </script>
<!--End of account-settings.php-->