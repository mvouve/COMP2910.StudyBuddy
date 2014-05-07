<!--Study Buddy - Login Page-->
<?php require( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
	<body>
		<div data-role="page" data-theme="a">
			<div data-role="header">
				<img src="images/sb-logo.png" alt="Study Buddy" />
			</div>
			<div class="contenta" data-role="content" id="login">
				<form name="loginform">
					<input type="text" name="email" id="email" placeholder="email">
					<input type="text" name="password" id="password" placeholder="password">
					<label for="remember">Remember me</label>
					<input type="checkbox" name="remember" id="remember">
					<input type="submit" value="Login" onclick="loginClick()"> <!-- should do an ajax request checking for correct input, if it is, go to next page -->	
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

     function credentialCheck()
     {
         var email = $("#emailbutton").val();
         var password = $("#passwordbutton").val();

         $.AJAX
         ({
             datatype:"json",
             type: "POST",
             url:"/ajax/user/auth.php",
             data:
             {
                method: check_credentials,
		        email: email,
		        password: password,
             },
             success: function (json)
             {
                 if (json.valid == true)
                 {
                     window.location.assign("SB_main.html");
                 }
                 else
                 {
                     showError();
                 }
             },
             error: showError(),
        });
    }
	</script>
	</body>
</html>