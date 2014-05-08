<!--Study Buddy - Login Page-->
<?php require_once( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
	<body>
		<div data-role="page" data-theme="a">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Login' ) ); ?>
			<div class="contenta" data-role="content" id="login">
				<form name="login-form" method="POST">
					<input type="text" name="email" id="email" placeholder="email">
					<input type="password" name="password" id="password" placeholder="password">
					<label for="remember">Remember me</label>
					<input type="checkbox" name="remember" id="remember">
					<input type="submit" id="login-submit" value="Login">
					<input type="hidden" name="method" value="login"/>
					<!-- should do an ajax request checking for correct input, if it is, go to next page -->	
				</form>
                <br>
                <input type="button" value="Register" onclick="registerClick()">
                <br>
			    <input type="button" value="Forgot Your Password?" onclick="recoveryClick()">
			</div>
            <div id="error" style="display:none">
                <p>Login failed. Please try again.</p>
            </div>
			<div data-role="footer">
			</div>
		</div>
	<script>
    function registerClick()
    {
        window.location.assign("register.php");
    }
    function recoveryClick()
    {
        window.location.assign("recovery-request.php");
    }
	function onLogin(result)
	{
		if( result.valid )
		{
			window.location.assign("main.php");
		}
		else
		{
			document.getElementById(error).style.display = 'block';
		}
	}

    function showError()
    {
        document.getElementById(error).style.display = 'block';
    }
	
	$("#login-submit").on( 'click tap', function (e) 
	{
		e.preventDefault();
		
		var formData = $("#login-form").serializeArray();
		
		$.post( <?php echo '\'' . AJAX_URL . 'user/auth.php\''; ?>,
						formData,
						onLogin,
						"json");
	});
	</script>
	</body>
</html>