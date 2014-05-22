<!-- Study Buddy Email Verification Request -->
<?php require_once( 'config.php' ); ?>
<?php $id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : -1; ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
	<body>
		<div data-role="page" data-theme="a">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Study Buddy' ) ); ?>
			<div class="center" data-role="content">
				<img src="images/mail.png" alt="Check">
				<br>Your verification email has been sent. Please check your e-mail.
                <div data-role="controlgroup" data-type="horizontal">
                    <a href="http://my.bcit.ca" data-role="button" target="_blank">my.bcit.ca</a>
                    <a href="http://bcit.ca" data-role="button" target="_blank">bcit.ca</a>
                    <a href="http://learn.bcit.ca" data-role="button" target="_blank">learn.bcit.ca</a>
                </div>
                </br>
                <div data-role="Verification">
                    <form id="verification-form" name="verification" method="POST">
                        <label for="verifcation">Please enter your verification code:</label>
                        <input type="text" name="verification-code" id="verification-code">

                        <input id="verification-submit" type="button" value="Verify">
                        <input type="hidden" name="method" value="verify" />
                    </form>
                </div>
                <div data-role="content">
                    <form id="resend-form" name="resend" method="POST">
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="hidden" name="method" value="resend-verification" />
                        <input id="send-again" type="button" value="Re-send Verification Email" onclick="sendAgain();"/>
                    </form>
                </div>
			</div>
		</div>
        <script>
            var sendingEmail = false;
            var verifying = false;
            
            $('#verification-submit').on( 'click touchend', function () {
                if ( verifying == false )
                {
                    verifying = true;
                    var verificationCode = $("#verification-form").serializeArray();
                    $.ajax({
                        type: "POST",
                        url: <?php echo '\'' . AJAX_URL . 'user/auth.php\''; ?>,
                        data: verificationCode,
                        success: onVerify,
                        datatype: 'json'
                    });
                }
            });

            function onVerify(data) {
                varifying = false;
                data = $.parseJSON( data );
                if ( data.valid == true ) {
                    location.href="verification-success.php";
                }
                else {
                    alert( "Incorrect verification code." );
                }
            }

            function sendAgain() {
                if ( sendingEmail == false )
                {
                    sendingEmail = true;
                    
                    $.post( <?php echo '\'' . AJAX_URL . 'user/auth.php\''; ?>,
                            $( '#resend-form').serializeArray(),
                            onSend,
                            'json'
                    );
                }
                
                return false;
            }
            
            function onSend() {
                sendingEmail = false;
                alert( 'An email has been sent.' );
            }

        </script>
	</body>
</html>