<?php require_once( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
    <body>
        <div data-role="page" data-theme="a">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Password Recovery' ) ); ?>
            <div data-role="content" class="center">
                <p>If you have forgotten your password, you can request an email to reset your password by entering your email here.</p>
			    <form name="recovery-request-form" id="recovery-request-form" method="POST">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="You@my.bcit.ca">
                    <input type="hidden" name="recovery-request" value="true">
                    <input type="button" value="Submit" id="recovery-request-submit">
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
			        alert('result.success == false');
		        }
	        }

            $("#recovery-request-submit").on( 'click tap', function (e) 
	        {
		        e.preventDefault();
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
