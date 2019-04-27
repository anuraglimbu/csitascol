<?php
  include("includes/header.php");
  include("includes/functions/userFunctions.php");
  include("includes/functions/postFunctions.php");
  include("includes/functions/settingFunctions.php");

  $bio = getBio($con, $userLoggedIn);
?>

<div class="infolane">
   <h1>Settings for <?php echo $userLoggedIn; ?></h1><hr>
</div>

<div class="settings">
  <div class="bio">
    <form class="bio_form" action="settings.php" method="post">
      <span>Change your bio here:</span>
      <br>
      <textarea name="bio" rows="8" cols="80"><?php echo $bio; ?></textarea>
      <input type="submit" name="post" id="bio_button" value="Change">
    </form>
  </div>
</div>

<h1>This site is still in development. Some features are not available and many changes can take place</h1>

<h2>Proudly presented by Anurag Limbu</h2>
