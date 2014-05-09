<?php require_once( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array() ); ?>

    <body>
        <div data-role="page" id="page">
            <?php define('HAS_MENU',1);
                  renderPagelet( 'banner.php', array( '{{title}}' => 'Reactvation Page' ) ); ?>
            <div class="center" data-role="main">
                    <img src="images/x-mark.png" alt="Check">
                    <p>The account has been previously deactivated, if you would like to reactivate your account, click below to send a verification email to reactivate your account</p>
                    <a href="verification-request.php" rel='external' data-role="button">Click Here</a>
            </div>
        </div>
    </body>
</html>