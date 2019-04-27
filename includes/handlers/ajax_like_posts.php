<?php
  include("../../config/config.php");
  include("../functions/userFunctions.php");
  include("../functions/postFunctions.php");


  $user = $_REQUEST['userLoggedIn'];
  $like = $_REQUEST['liked'];
  $id = $_REQUEST['post_id'];

  $custom_query = mysqli_query($con, "SELECT * FROM posts WHERE id='$id'");
  $row = mysqli_fetch_array($custom_query);
  $added_by = $row['added_by'];
  $count = $row['likes'];

  $num_likes = getNumLikes($con, $added_by);

  if($like == 0)
  {
    $count++;
    $num_likes++;
    $query_likes = mysqli_query($con, "INSERT INTO likes VALUES('0', '$user','$id')");
    $update_posts = mysqli_query($con, "UPDATE posts SET likes='$count' WHERE id='$id'");
    $update_users = mysqli_query($con, "UPDATE users SET num_likes='$num_likes' WHERE username='$added_by'");
  }
  else
  {
    $count--;
    $num_likes--;
    $query_likes = mysqli_query($con, "DELETE FROM likes WHERE username='$user' AND post_id='$id'");
    $update_posts = mysqli_query($con, "UPDATE posts SET likes='$count' WHERE id='$id'");
    $update_users = mysqli_query($con, "UPDATE users SET num_likes='$num_likes' WHERE username='$added_by'");
  }

?>
