<!-- Study Buddy Email Verification Request -->
<?php require_once( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
	<body>
		<div data-role="page" data-theme="a">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Study Buddy' ) ); ?>
			<div class="center" data-role="content">
				<img src="images/check-mark.png" alt="Check">
				<br>Account Verified!
                <br>
                <a href="login.php" data-role="button" rel='external' data-mini="true">Let's Begin!</a>
			</div>
		</div>
	</body>
</html>