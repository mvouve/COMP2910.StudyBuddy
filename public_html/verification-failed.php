<!-- Study Buddy Email Verification Request -->
<?php require( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
	<body>
		<div data-role="page" data-theme="a">
			<div data-role="header">
		        <img src="images/sb-logo.png" alt="Study Buddy" />
				<h1>StudyBuddy</h1>
			</div>
			<div class="contenta" data-role="content">
				<img src="images/x-mark.png" alt="Check">
				<br>Account verification failed
			</div>
		</div>
	</body>
</html>