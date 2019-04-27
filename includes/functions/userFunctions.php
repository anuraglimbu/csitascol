<?php
  function getFirstAndLastName($con, $user)
  {
    $username = $user;
    $query = mysqli_query($con,"SELECT firstname, lastname FROM users WHERE username='$username'");
    $row = mysqli_fetch_array($query);
    return $row['firstname']." ".$row['lastname'];
  }

  function getUsername($con, $user)
  {
    $username = $user;
    return $username;
  }

  function getNumPosts($con, $user)
  {
    $query = mysqli_query($con,"SELECT num_posts FROM users WHERE username='$user'");
    $row = mysqli_fetch_array($query);
    return $row['num_posts'];
  }

  function getNumLikes($con, $user)
  {
    $query = mysqli_query($con,"SELECT num_likes FROM users WHERE username='$user'");
    $row = mysqli_fetch_array($query);
    return $row['num_likes'];
  }

  function getBio($con, $user)
  {
    $query = mysqli_query($con,"SELECT bio FROM users WHERE username='$user'");
    $row = mysqli_fetch_array($query);
    return $row['bio'];
  }

  function isClosed($con, $user)
  {
    $query = mysqli_query($con, "SELECT user_closed FROM users WHERE username='$user'");
    $row = mysqli_fetch_array($query);
    if($row['user_closed']=="yes")
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  function getProfilePic($con,$user)
  {
    $username = $user;
    $query = mysqli_query($con,"SELECT profile_pic FROM users WHERE username='$username'");
    $row = mysqli_fetch_array($query);
    return $row['profile_pic'];
  }
?>
