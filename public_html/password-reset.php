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
                var passwordForm = $("#recovery-submit").serializeArray();
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
                            failedSubmit();
                        }
                    }

                });
            });
            
            function failedSubmit(){
                alert('Please double check passwords');
            }
    </script>
</body>