<?php

  if (isset($_POST['login_button']))
  {
    $uname = $_POST['username_log'];
    $pw = md5($_POST['password']);

    $query = mysqli_query($con, "SELECT * FROM users WHERE (username = '$uname' OR email = '$uname') AND password = '$pw'");
    $check_login_query = mysqli_num_rows($query);

    if ($check_login_query == 1)
    {
      $row = mysqli_fetch_array($query);
      $username = $row['username'];

      $_SESSION['username'] = $username;
      header("location: index.php");
      exit();
    }
    else
    {
      array_push($errorArray, $loginFailed);
    }
  }

?>
