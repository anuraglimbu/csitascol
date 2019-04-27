<?php
  //declaration of variables
  $errorArray = array(); //holds error messages as an array

  function sanitizeFormPassword($inputText) {
	$inputText = strip_tags($inputText);
	return $inputText;
}

function sanitizeFormUsername($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	return $inputText;
}

function sanitizeFormString($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	$inputText = ucfirst(strtolower($inputText));
	return $inputText;
}

if(isset($_POST['register_button'])) {
	//Register button was pressed
	$username = sanitizeFormUsername($_POST['username']);
	$firstName = sanitizeFormString($_POST['firstName']);
	$lastName = sanitizeFormString($_POST['lastName']);
	$email = sanitizeFormString($_POST['email']);
	$email2 = sanitizeFormString($_POST['email2']);
	$password = sanitizeFormPassword($_POST['password']);
	$password2 = sanitizeFormPassword($_POST['password2']);

  //Username check
  if(strlen($username) > 25 || strlen($username) < 5) {
    array_push($errorArray, $usernameCharacters);
  }

  $checkUsernameQuery = mysqli_query($con,"SELECT username FROM users WHERE username='$username'");
  if (mysqli_num_rows($checkUsernameQuery) != 0)
  {
    array_push($errorArray, $usernameTaken);
  }

  //FirstName check
  if(strlen($firstName) > 25 || strlen($firstName) < 2) {
    array_push($errorArray, $firstNameCharacters);
  }

  //lastname check
  if(strlen($lastName) > 25 || strlen($lastName) < 2) {
    array_push($errorArray, $lastNameCharacters);
  }

  //email check
  if($email != $email2) {
    array_push($errorArray, $emailsDoNotMatch);
  }

  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    array_push($errorArray, $emailInvalid);
  }

  $checkEmailQuery = mysqli_query($con,"SELECT username FROM users WHERE email='$email'");
  if (mysqli_num_rows($checkEmailQuery) != 0)
  {
    array_push($errorArray, $emailTaken);
  }

  //password check
  if($password != $password2) {
    array_push($errorArray, $passwordsDoNoMatch);
  }

  if(preg_match('/[^A-Za-z0-9]/', $password)) {
    array_push($errorArray, $passwordNotAlphanumeric);
  }

  if(strlen($password) > 30 || strlen($password) < 5) {
    array_push($errorArray, $passwordCharacters);
  }

  if(empty($errorArray) == true) {
    $encryptedPw = md5($password);
    $rand = rand(1,16);
    $profilePic = "assets/images/profile_pics/defaults/$rand.png"; //randomize the profile picture
    $date = date("Y-m-d");

    $wasSuccessful = mysqli_query($con, "INSERT INTO users VALUES ('0', '$username', '$firstName', '$lastName', '$email', '$encryptedPw', '$date', '$profilePic','','0','0','0','no','')");
	}
	else {
        echo "<script>alert('error occured');</script>";
				$wasSuccessful = false;
	}


  //registering
	//$wasSuccessful = register($username, $firstName, $lastName, $email, $password, $errorArray, $con);
  //echo "<script>alert($wasSuccessful);</script>";

	if($wasSuccessful == true)
	{
		$_SESSION['username'] = $username;
		header("Location: settings.php");
	}

}

?>
