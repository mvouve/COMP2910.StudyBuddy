<!--Study Buddy - Account Registration-->
<?php require_once( 'config.php' ); ?>
<?php
if ( !isset( $_GET['email'] ) )
{
    $email = '';
}
else
{
    $email = $_GET['email'];
}
?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
<body>
    <div data-role="page" data-theme="a">
        <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Password Reset' ) ); ?>
		<div data-role="content" id="recovery">
			<form id="recovery-form" name="recovery-form" method="POST" onsubmit='return false;'>
                <input type="hidden" name="email" value="<?php echo urldecode($email); ?>">

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
                <input id="recovery-submit" type="submit" value="Change Password">
                <input type="hidden" name="method" value="password-recovery" />
			</form>
		</div>
		<div data-role="footer" id="footer">
		</div>
    </div>
    <script>
            var doingAjax = false;
            
            $('#recovery-submit').on( 'click touchend', function () {
                if ( doingAjax == false )
                {
                    doingAjax = true;
                    var passwordForm = $("#recovery-form").serializeArray();
                    
                    $.post( <?php echo '\'' . AJAX_URL . 'user/auth.php\''; ?>,
                            passwordForm,
                            onPasswordChange,
                            "json" );
                }
            });

            function onPasswordChange( data ) {
                doingAjax = false;
                if (data.success == true){
                    window.location.assign("login.php");
                }
                else {
                    alert( 'Could not change password. Perhaps your verification code is ' +
                           'incorrect?' );
                }
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