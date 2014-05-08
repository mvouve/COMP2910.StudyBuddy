<!-- Study Buddy Email Verification Request -->
<?php require_once( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
	<body>
		<div data-role="page" data-theme="a">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Study Buddy' ) ); ?>
			<div class="contenta center" data-role="content">
				<img src="images/mail.png" alt="Check">
				<br>Your verification email has been sent. Please check your e-mail.
                <div data-role="controlgroup" data-type="horizontal">
                    <a href="http://my.bcit.ca" data-role="button">my.bcit.ca</a>
                    <a href="http://bcit.ca" data-role="button">bcit.ca</a>
                    <a href="http://learn.bcit.ca" data-role="button">learn.bcit.ca</a>
                </div>
                </br>
                <div data-role="Verification">
                    <form id="verification-form" name="verification" method="POST">
                        <label for="verifcation">Please enter your verification code:</label>
                        <input type="text" name="display-name" id="display-name">

                        <input id="verification-submit" type="button" value="Verify">
                        <input type="hidden" name="verification-submit" value="verification-submit" />
                    </form>
                </div>
                <div data-role="content">
                    <input id="send-again" type="button" value="Re-send Verification Email" onclick="sendAgain()"/>
                </div>
			</div>
		</div>
        <script>
            $('#verification-submit').click(function () {
                var verificationCode = $("#verification-form");
                $.ajax({
                    type: "POST",
                    url: "/ajax/user/settings.php",
                    data: verificationCode,
                    error: alertTest,
                    datatype: 'json'
                });

                $.ajax({
                    type: "GET",
                    url: "",
                    data: verifiedStatus,
                    error: alertTest,
                    datatype: 'json'
                })

                if (verified == true) {
                    window.location = "verification-success.php"
                } else {
                    alert("The verification code is incorrect, please try again");
                }
            });

            function alertTest(data) {
                alert('Submitted!');
            }


        </script>
	</body>
</html>