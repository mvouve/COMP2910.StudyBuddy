<!-- Study Buddy Email Verification Request -->
<?php require( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
	<body>
		<div data-role="page" data-theme="a">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Study Buddy' ) ); ?>
			<div class="contenta center" data-role="content">
				<img src="images/check-mark.png" alt="Check">
				<br>Account Verified!
                <br>
                <a href="main.html" data-role="button" data-mini="true">Let's Begin!</a>
			</div>
		</div>
	</body>
</html>