<!--Study Buddy - Account Registration-->

<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile.structure-1.4.2.min.css" />
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
		<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
        <link rel="stylesheet" href="css/study-buddy-theme.min.css" />
        <link rel="stylesheet" href="css/jquery.mobile.icons.min.css" />
        <link rel="stylesheet" href="css/custom.css"/>
	</head>
	<body>
		<div data-role="page" data-theme="a">
			<div data-role="header" id="header">
				<img src="images/sb-logo.png" alt="SB"/>
				<h1>Register Account</h1>
			</div>
			<div class="contenta" data-role="content" id="register">
				<form id="registerForm" name="registerForm" method="POST">
					<label for="email">E-mail:</label>
					<input type="text" name="email" id="email"><br/>
					<label for="displayName">Display Name:</label>
					<input type="text" name="display_name" id="displayName"><br/>
					<label for="password">Password:</label>
					<input type="password" name="password" id="password"><br/>
					<label for="confirm">Confirm Password:</label>
					<input type="password" name="confirm_password" id="confirm"><br/>
                    <input id="register-submit" type="submit" value="Register" />
                    <input type="hidden" name="method" value="register" />
				</form>
			</div>
			<div data-role="footer" id="footer">
			</div>
		</div>
        <script>
            //used to ensure a user-entered display name is not null or empty
            function validateUsername() {
                var displayNameRegex = /[0-9A-Za-z-]{5,32}$/g;
                var username = document.form["registerForm"]["display_name"].value.match(displayNameRegex);
                if ((username == null) || (username == "")) {
                    alert("Please enter a user display name, 5-32 alphaneumeric characters.");
                    return false;
                }
                return true;
            }

            //used to ensure a user-entered email is a valid BCIT e-mail
            function validateMail() {
                var emailRegex = /@my.bcit.ca$/g;
                var validEmail = document.form["loginForm"]["email"].value.match(emailRegex);
                if (validEmail == null) {
                    alert("must use a @my.bcit.ca e-mail address.");
                    return false;
                }
                return true;
            }

            function checkEmail() {

            }
            
            function onRegister( result ) {
                alert( JSON.stringify(result, null, 4) );
            }
            
            $( "#register-submit" ).click( function( e ) {
                var formData = $( "#registerForm" ).serializeArray();
                
                $.post( "http://localhost/StudyBuddy/public_html/ajax/user/auth.php",
                        formData,
                        onRegister,
                        "json" );
                        
                e.preventDefault();
            });
        </script>
	</body>
</html>