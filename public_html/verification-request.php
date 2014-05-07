<!-- Study Buddy Email Verification Request -->
<?php require( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
	<body>
		<div data-role="page" data-theme="a">
			<div data-role="header">
		        <img src="images/sb-logo.png" alt="Study Buddy" />
				<h1>StudyBuddy</h1>
			</div>
			<div class="contenta center" data-role="content">
				<img src="images/mail.png" alt="Check">
				<br>Your verification email has been sent. Please check your e-mail.
                <a href="my.bcit.ca" data-role="button" data-mini="true">MyBcit</a>
			</div>
		</div>
	</body>
</html>