<?php
  require 'config/config.php';
  require 'includes/form_handlers/constants.php';
  require 'includes/form_handlers/register_handler.php';
  require 'includes/form_handlers/login_handler.php';

  //echo "<script>console.log('errorArray(): $errorArray');</script>";

  function getInputValue($name)
  {
		if(isset($_POST[$name]))
    {
			echo $_POST[$name];
		}
	}
?>
<!DOCTYPE HTML>
<html lang='en'>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <link rel="icon" href="assets/images/icons/logo.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="assets/images/icons/logo.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="assets/css/login.css">

    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/register.js"></script>

    <title>Login</title>
</head>
<body>
  <?php
        if (isset($_POST['register_button'])) {
        	echo   '
            <script>
				        $(document).ready(function() {
							$("#login").hide();
							$("#register").show();
				        });
				    </script>';
        }
        else
        {
        	echo   '
            <script>
				        $(document).ready(function() {
							$("#login").show();
							$("#register").hide();
				        });
				    </script>';
        }

    ?>
  <div id="background" >
      <div id="loginContainer">
          <div id="inputContainer">
              <div id="logo">
                      <img src="assets/images/logo.png">
              </div>

              <form id="login" action="login.php" method="POST">
                <h2>Log in here</h2>
                <?php if(in_array( $loginFailed, $errorArray )) { echo  $loginFailed; }?>
                  <p>
                      <label for="username_log">Username or Email</label>
                      <input type="text" name="username_log" placeholder="Username" value="<?php getInputValue('username_log') ?>" required>
                  </p>
                  <p>
                      <label for="password">Password</label>
                      <input type="password" name="password" placeholder="Password" required>
                  </p>
                  <p>
                      <button type="submit" name="login_button">LOG IN</button>
                  </p>
                  <div class="hasAccountText">
						              <span id="hideLogin">Don't have an account yet? Signup here</span>
					        </div>

              </form>
              <form id="register" action="login.php" method="POST">
                <h2>Sign Up Here</h2>
                  <p>
                      <?php if(in_array( $usernameCharacters, $errorArray )) { echo  $usernameCharacters; }?>
                      <?php if(in_array( $usernameTaken, $errorArray )) { echo  $usernameTaken; }?>
                      <label for="username">Username</label>
                      <input type="text" id="username" name="username" placeholder="Username" value="<?php getInputValue('username') ?>" required>
                  </p>

                  <p>
                    <?php if(in_array( $firstNameCharacters, $errorArray )) { echo  $firstNameCharacters; }?>
        						<label for="firstName">First name</label>
        						<input id="firstName" name="firstName" type="text" placeholder="e.g. Anurag" value="<?php getInputValue('firstName') ?>" required>
        					</p>

        					<p>
                    <?php if(in_array( $lastNameCharacters, $errorArray )) { echo  $lastNameCharacters; }?>
        						<label for="lastName">Last name</label>
        						<input id="lastName" name="lastName" type="text" placeholder="e.g. Limbu" value="<?php getInputValue('lastName') ?>" required>
        					</p>

        					<p>
                    <?php if(in_array( $emailsDoNotMatch ,$errorArray )) { echo  $emailsDoNotMatch; }?>
                    <?php if(in_array( $emailInvalid ,$errorArray )) { echo  $emailInvalid; }?>
                    <?php if(in_array( $emailTaken ,$errorArray )) { echo  $emailTaken; }?>
        						<label for="email">Email</label>
        						<input id="email" name="email" type="email" placeholder="e.g. anu@gmail.com" value="<?php getInputValue('email') ?>" required>
        					</p>

        					<p>
        						<label for="email2">Confirm email</label>
        						<input id="email2" name="email2" type="email" placeholder="e.g. anu@gmail.com" value="<?php getInputValue('email2') ?>" required>
        					</p>

                  <p>
                      <?php if(in_array( $passwordsDoNoMatch ,$errorArray )) { echo  $passwordsDoNoMatch; }?>
                      <?php if(in_array( $passwordNotAlphanumeric ,$errorArray )) { echo  $passwordNotAlphanumeric; }?>
                      <?php if(in_array( $passwordCharacters ,$errorArray )) { echo  $passwordCharacters; }?>
                      <label for="password">Password</label>
                      <input type="password" id="password" name="password" placeholder="Password" required>
                  </p>
                  <p>
                      <label for="password">Confirm Password</label>
                      <input type="password" id="password2" name="password2" placeholder="Password" required>
                  </p>

                  <p>
                      <button type="submit" name="register_button">Sign Up</button>
                  </p>
                  <div class="hasAccountText">
						              <span id="hideRegister">Already have an account? Login here</span>
					        </div>
              </form>
          <div>
      </div>
  </div>
</body>
</html>
