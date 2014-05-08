<!-- Study Buddy Email Verification Request -->
<?php require_once( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
	<body>
		<div data-role="page" data-theme="a">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Study Buddy' ) ); ?>
			<div data-role="content">
				<img src="images/x-mark.png" alt="Check">
				<br>Account verification failed
			</div>
		</div>
	</body>
</html>