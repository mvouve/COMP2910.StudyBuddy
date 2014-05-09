<?php require_once( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
    <body>
        <div data-role="page" data-theme="a">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Password Recovery' ) ); ?>
            <div data-role="content" class="center">
                <p>If you have forgotten your password, you can request an email to reset your password by entering your email here.</p>
			    <form name="recovery-request-form" id="recovery-request-form" method="POST" onsubmit='return false;'>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="You@my.bcit.ca">
                    <input type="hidden" name="method" value="recovery-request">
                    <a href="#" data-role="button" id="recovery-request-submit">Send Email</a>
                </form>
            </div>
        </div>
        <script>
            function onResponse(result)
	        {
		        if( result.success == true )
		        {
			        window.location.assign('password-reset.php?email=' + encodeURIComponent(document.getElementById('email').value));
		        }
		        else
		        {
			        alert('An error occurred. Perhaps the email is not currently in use.');
		        }
	        }

            $("#recovery-request-submit").on( 'click tap', function (e) 
	        {
		        e.preventDefault();
                e.stopImmediatePropagation();
                alert('double click check');
            		
    		    var formData = $("#recovery-request-form").serializeArray();
		
		        $.post( <?php echo '\'' . AJAX_URL . 'user/auth.php\''; ?>,
						formData,
						onResponse,
						"json" );
	        });
        </script>
    </body>
</html>
