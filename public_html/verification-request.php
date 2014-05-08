<!-- Study Buddy Email Verification Request -->
<?php require( 'config.php' ); ?>
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
                    <form id="name-change" name="name-change" method="POST">
                        <label for="display-name">Please enter your verification code:</label>
                        <input type="text" name="display-name" id="display-name">
                        <input id="update-name" type="button" value="Submit">
                        <input type="hidden" name="method" value="update-display-name" />
                    </form>
                </div>
                                
			</div>
		</div>
	</body>
</html>