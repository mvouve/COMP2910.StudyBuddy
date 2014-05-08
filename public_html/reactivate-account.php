<?php require_once( 'config.php' ); ?>
<?php $sliderHeader = array( '{{customHeadTags}}' => '
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.slidepanel.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.slidepanel.css">
    ');
?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => $sliderHeader ) ); ?>

    <body>
        <div data-role="page" id="page">
            <?php define('HAS_MENU',1);
                  renderPagelet( 'banner.php', array( '{{title}}' => 'Reactvation Page' ) ); ?>
            <div class="center contenta" data-role="main">
                    <img src="images/x-mark.png" alt="Check">
                    <p>The account has been previously deactivated, if you would like to reactivate your account, click below to send a verification email to reactivate your account</p>
                    <a href="verification-request.php" data-role="button">Click Here</a>
            </div>
        </div>
    </body>
</html>