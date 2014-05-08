<!--Study Buddy - Login Page-->
<?php require( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
	<body>
		<div data-role="page" data-theme="a">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Login' ) ); ?>
			<div class="contenta" data-role="content" id="login">
				<form name="loginform" method="POST">
					<input type="text" name="email" id="email" placeholder="email">
					<input type="password" name="password" id="password" placeholder="password">
					<label for="remember">Remember me</label>
					<input type="checkbox" name="remember" id="remember">
					<input type="submit" id="loginbutton" value="Login" onclick="loginClick()">
					<input type="hidden" name="method" value="login"/><!-- should do an ajax request checking for correct input, if it is, go to next page -->	
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
	 function loginClick()
     {
         window.location.assign("main.php");
     }
     function registerClick()
     {
         window.location.assign("register.php");
     }
     function recoveryClick()
     {
         window.location.assign("recovery-request.php");
     }

     function showError()
     {
         document.getElementById(error).style.display = 'block';
     }

     $(document).ready(function()
     {
        $("#loginbutton").click(function()
        {

            var formData = $("#loginform").serialize();
         $.ajax
         ({
            type: "POST",
            url:"/ajax/user/auth.php",
            cache: false,
            data: formData,
            datatype:"json",
            success: function (json)
            {
                if (json.valid == true)
                {
                    window.location.assign("main.php");
                }
                else
                {
                    showError();
                }
            },
            error: showError()
            });
            return false;
        });
    });
	</script>
	</body>
</html>