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
                  renderPagelet( 'banner.php', array( '{{title}}' => 'RiacTvIsion pAije' ) ); ?>
            <div class="center" data-role="main">
                    <p>Reactivation page</p>
            </div>     
        </div>
    </body>
</html>