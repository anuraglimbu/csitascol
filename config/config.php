<?php
  ob_start();
  session_start();

  $timezone = date_default_timezone_set("Asia/Kathmandu");

  //$con = mysqli_connect("sql302.epizy.com","epiz_23801517","Af5ZI4fej","epiz_23801517_csitascol");
  $con = mysqli_connect("localhost","root","","ascolmanagement");

  if(mysqli_connect_errno())
  {
    echo "Failed to connect: " . mysqli_connect_errno();
  }
?>
