<?php
  include("includes/header.php");
  include("includes/functions/userFunctions.php");
  include("includes/functions/postFunctions.php");

  $userProfile = $_GET['profile_username'];
  echo "<script>console.log('".$userProfile."');</script>";
  $pr_user_details_query = mysqli_query($con,"SELECT * FROM users WHERE username = '$userProfile'");
  $pr_user = mysqli_fetch_array($pr_user_details_query);

?>

  <div class="user_details column">
        <a href="#"><img src="<?php echo $pr_user['profile_pic'];?>"></a>

        <div class="user_details_left_right">
          <a href="#">
          <?php
            echo $pr_user['firstname'].' '.$pr_user['lastname']."<br>";
          ?>
          </a>
          <?php
            echo "Posts:".$pr_user['num_posts']."<br>";
            echo "Likes:".$pr_user['num_likes']."<br>";
          ?>
        </div>
        <div class="bio">
          <?php echo $pr_user['bio'];?>
        </div>
  </div>

  <div class="main_column column">
    <div class="posts_area"></div>
		<img id="loading" src="assets/images/icons/loading.gif">
  </div>
  <script>
     var userLoggedIn = '<?php echo $userProfile; ?>';

     $(document).ready(function()
     {
       $('#loading').show();
       //original ajax requests for loading first posts
       $.ajax({
         url: "includes/handlers/ajax_load_profile_posts.php",
         type: "POST",
         data: "page=1&userLoggedIn="+userLoggedIn,
         cache: false,

         success: function(data){
           $('#loading').hide();
           $('.posts_area').html(data);
         }
       });

       $(window).scroll(function(){
         var buffer = 0;
         var height = $('.posts_area').height();//Div Containing Posts
         var scroll_top = $(this).scrollTop();
         var page = $('.posts_area').find('.nextPage').val();
         var noMorePosts = $('.posts_area').find('.noMorePosts').val();

         var scrollHeight = document.body.scrollHeight;
         var innerHeight = window.innerHeight;
         var scrollTop = Number(Math.round(document.body.scrollTop+'e2')+'e-2');

         console.log("inner height: "+innerHeight);
         console.log("scrollTop: "+scrollTop);
         console.log("obtained scrollHeight: "+(innerHeight+scrollTop));
         console.log("scrollHeight: "+(scrollHeight));

         var temp_buffer = Number(Math.round((scrollHeight-(scrollTop+innerHeight))+'e2')+'e-2');
         if(temp_buffer>0 && temp_buffer<1)
         {
           buffer = temp_buffer;
         }
         else if(temp_buffer<0)
         {
           buffer = temp_buffer;
         }
         console.log("temp buffer:"+temp_buffer);
         console.log("buffer:"+buffer);
         console.log("final scrollHeight: "+(scrollTop+innerHeight+buffer));

         if((scrollHeight == (scrollTop + innerHeight + buffer)) && noMorePosts == 'false')
         {
           console.log('reached Bottom!');
           $('#loading').show();

           var ajaxReq = $.ajax({
             url: "includes/handlers/ajax_load_posts.php",
             type: "POST",
             data: "page="+page+"&userLoggedIn="+userLoggedIn,
             cache: false,

             success: function(response){
               $('.posts_area').find('.nextPage').remove(); //Removes current .nextpage
               $('.posts_area').find('.noMorePosts').remove(); //Removes current .noMorePosts

               console.log('Appending posts');
               $('#loading').hide();
               $('.posts_area').append(response);
             }
           });
         }//End if

         return false;

       });//End (window).scroll(function)

     });
  </script>
  </div>
</div> <!--this is a closing tag for the "wrapper" div-->
</body>
</html>
