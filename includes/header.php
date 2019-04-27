<?php
	require 'config/config.php';

	if(isset($_SESSION['username']))
	{
		$userLoggedIn = $_SESSION['username'];
    echo "<script>console.log('".$userLoggedIn."');</script>";
		$user_details_query = mysqli_query($con,"SELECT * FROM users WHERE username = '$userLoggedIn'");
		$user = mysqli_fetch_array($user_details_query);
	}
	else
	{
		header("Location: login.php");
	}

?>
<html lang='en'>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="assets/images/icons/logo.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="assets/images/icons/logo.ico" type="image/x-icon" />

		<script src="assets/js/jquery.js"></script>
		<script src="assets/js/popper.js"></script>
		<script src="assets/js/script.js"></script>

		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css"/>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css"/>

    <title>CSIT ASCOL</title>

</head>
<body>
	<div class="top_bar fixed-top">
		<div class="logo">
			<a href="index.php"><img src="assets/images/logo.png"></a>
		</div>

		<nav>
			<div class="small_profile">
				<a href="<?php echo $userLoggedIn;?>"><img src="<?php echo $user['profile_pic'];?>" title="<?php echo $user['username']; ?>" alt="<?php echo $user['username']; ?>"></a>
			</div>
			<div class="contents">
				<a href="<?php echo $userLoggedIn;?>">
					<?php echo $user['username']; ?>
				</a>
				<a href="index.php"><img src="assets/images/icons/home.png" title="Home" alt="Home"></a>
				<a href="#"><img src="assets/images/icons/message.png" title="Messages" alt="Messages"></a>
				<a href="#"><img src="assets/images/icons/notification.png" title="Notifications" alt="Notifications"></a>
				<a href="settings.php"><img src="assets/images/icons/setting.png" title="Settings" alt="Settings"></a>
				<a href="includes/handlers/logout.php"><img src="assets/images/icons/logout.png" title="Logout" alt="Logout"></a>
			</div>
		</nav>
	</div>
	<div class="wrapper">
