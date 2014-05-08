<!-- Study Buddy account verification page-->
<?php require( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
	<body>
		<div data-role="page" data-theme="a">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Study Buddy' ) ); ?>
			<div class="contenta" data-role="content">
				<form name="accountverify-" method="POST">
                        <label for="verify">Input Verification Code:</label>
                        <input type="text" name="verify" id="verify">
                        <input type="submit" id="verify-submit" value="Verify My Account">
                </form>
			</div>
		</div>
	</body>
</html>