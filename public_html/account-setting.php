<?php require( 'config.php' ); ?>
<?php $sliderHeader = array( '{{customHeadTags}}' => '
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.slidepanel.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.slidepanel.css">
    ');

    $email = "you@my.bcit.ca";
?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>

    <body>
        <div data-role="page" data-theme="a">
            <?php define('HAS_MENU',1);
                  renderPagelet( 'banner.php', array( '{{title}}' => 'Account Settings' ) ); ?>

			<div class="contenta" data-role="content" data-theme="b">
                <div class="center contenta">
                    <p><?php echo $email; ?></p>
                </div>
                <div data-role="collapsible">
                    <h3>Change your display name</h3>
                    <form id="name-change" name="name-change" method="POST">
                        <label for="display-name">New Name:</label>
                        <input type="text" name="display-name" id="display-name">
                        <input id="update-name" type="button" value="Update Name">
                        <input type="hidden" name="method" value="update-display-name" />
                    </form>
                </div>
                <div data-role="collapsible">
                    <h3>Change your password</h3> 
				    <form id="password-change" name="password-change" method="POST">
                        <label for="old-password">Current Password:</label>
					    <input type="password" name="old-password" id="old-password" required><br/>


					    <label for="new-password">New Password:</label>
					    <input type="password" name="new-password" id="new-password" required><br/>


					    <label for="confirm-password">Confirm New Password:</label>
					    <input type="password" name="confirm-password" id="confirm-password" required><br/>


                        <input id="update-password" type="button" value="Update Password">
                        <input type="hidden" name="method" value="update-password">
				    </form>
                    <div id="mismatch" style="display:none">
                        <p>Please check your new passwords</p>
                    </div>
                </div>
			</div>
			<div data-role="footer" id="footer">
			</div>
		</div>
        <script>
            $('#confirm-password').blur(function () {
                $('update-password').attr('disabled', 'disabled');
                $('#mismatch').hide();
                var newp = $('#new-password').val();
                var newp2 = $('#confirm-password').val();
                if (newp != newp2) {
                    $('#mismatch').show();
                    $('update-password').attr('disabled');
                }
                return false;
            });

            $('password-change').submit(function(){
            $.ajax({
                type:"POST",
                url:placeholderurl.php, //WHERE DOES THE STUFF GO
                data: $('password-change').serialize()
                });
                ev.preventDefault();
            } 
           
        </script>
	</body>
</html>