<!--Study Buddy - Account Registration-->
<?php require_once( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
<body>
    <div data-role="page" data-theme="a">
        <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Password Reset' ) ); ?>
		<div data-role="content" id="recovery">
			<form id="recovery-form" name="recovery-form" method="POST">
                <input type="hidden" name="email" value="<?php echo urldecode($_GET[ 'eamil' ]); ?>">

                <label for="verification-code">Verification Code:</label>
                <input type="text" name="verification-string" id="verification-string">

                <label for="new-password" id="password-label">Password:</label>
				<div class="ui-icon-delete ui-btn-icon-right validated-field" id="password-div">
                    <input type="password" name="password" id="new-password">
                </div>

                <label for="confirm-password" id="confirm-label">Confirm Password:</label>
                <div class="ui-icon-delete ui-btn-icon-right validated-field" id="confirm-div">
					<input type="password" name="confirm-password" id="confirm-password">
                </div>
                <input id="recovery-submit" type="submit" value="Set New Passwords">
                <input type="hidden" name="method" value="recovery" />
			</form>
		</div>
		<div data-role="footer" id="footer">
		</div>
    </div>
    <script>
            $('#recovery-submit').on( 'click tap', function () {
                var passwordForm = $("#recovery-form").serializeArray();
                $.ajax({
                    type: "POST",
                    url: <?php echo '\'' . AJAX_URL . 'user/settings.php\''; ?>,
                    data: passwordForm,
                    error: failedSubmit(),
                    datatype: 'json',
                    success: function(json){
                        if(json.success == true){
                            window.location.assign("login.php");
                        }
                        else{
                            alert( 'json.success == false' );
                        }
                    }

                });
            });
            
            function failedSubmit(){
                alert('Please double check passwords');
            }

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
    </script>
</body>