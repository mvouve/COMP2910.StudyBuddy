<?php require_once( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
    <body>
        <div data-role="page" data-theme="a">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Password Recovery' ) ); ?>
            <div data-role="content" class="contenta center">
                <p>If you have forgotten your password, you can request an email to reset your password by entering your email here.</p>
			    <form>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="You@my.bcit.ca">
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </body>
</html>
