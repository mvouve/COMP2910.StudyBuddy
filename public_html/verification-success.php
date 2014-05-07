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
				<img src="images/check-mark.png" alt="Check">
				<br>Account Verified!
                <br>
                <a href="main.html" data-role="button" data-mini="true">Let's Begin!</a>
			</div>
		</div>
	</body>
</html>