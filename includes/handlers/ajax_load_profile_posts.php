<?php
  include("../../config/config.php");
  include("../functions/userFunctions.php");
  include("../functions/postFunctions.php");

  $limit = 10; //number of posts to be loaded at one time

  $user = $_REQUEST['userLoggedIn'];
  loadPostsProfile($con,$user,$_REQUEST,$limit);
?>
