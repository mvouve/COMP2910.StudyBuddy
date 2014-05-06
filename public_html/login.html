<!--Study Buddy - Login Page-->
<!doctype html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile.structure-1.4.2.min.css" />
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
		<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
        <link rel="stylesheet" href="css/study-buddy-theme.min.css" />
        <link rel="stylesheet" href="css/jquery.mobile.icons.min.css" />
        <link rel="stylesheet" href="css/custom.css" />
	</head>
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
         window.location.assign("SB_main.html");
     }
     function registerClick()
     {
         window.location.assign("SB_register.html");
     }
     function recoveryClick()
     {
         window.location.assign("SB_recover.html");
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