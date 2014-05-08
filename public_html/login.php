<!--Study Buddy - Login Page-->
<?php require_once( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
	<body>
		<div data-role="page" data-theme="a">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Login' ) ); ?>
			<div data-role="content" id="login">
				<div id="error" style="display:none">
					<p>Login failed. Please try again.</p>
				</div>
				<form name="login-form" id="login-form" method="POST">
					<input type="text" name="email" id="email" placeholder="email">
					<input type="password" name="password" id="password" placeholder="password">
					<label for="remember">Remember me</label>
					<input type="checkbox" name="remember" id="remember">
					<input type="submit" id="login-submit" value="Login">
					<input type="hidden" name="method" value="login"/>
					<!-- should do an ajax request checking for correct input, if it is, go to next page -->	
				</form>
                <br>
                <a href="register.php" rel="external">
                    <input type="button" value="Register">
                </a>
                <br>
                <a href="recovery-request.php" rel="external">
			        <input type="button" value="Forgot Your Password?">
                </a>
			</div>
            
			<div data-role="footer">
			</div>
		</div>
	<script>
	function onLogin(result)
	{
		if( result.valid )
		{
			window.location.assign("main.php");
		}
		else
		{
			document.getElementById( 'error' ).style.display = 'block';
		}
	}

    function showError()
    {
        document.getElementById( 'error' ).style.display = 'block';
    }
	
	$("#login-submit").on( 'click tap', function (e) 
	{
		e.preventDefault();
		
		var formData = $("#login-form").serializeArray();
		
		$.post( <?php echo '\'' . AJAX_URL . 'user/auth.php\''; ?>,
						formData,
						onLogin,
						"json" );
	});
	</script>
	</body>
</html>