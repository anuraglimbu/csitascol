<?php
  function submitPost($con, $user, $body, $user_to)
  {
      $body = strip_tags($body);//removes html tags
      $body = mysqli_real_escape_string($con, $body);
      $check_empty = preg_replace('/\s+/', '',$body);//Deletes all spaces

      if($check_empty != "")
      {
          //Current date and time
          $date_added = date("Y-m-d H:i:s");

          //get username
          $added_by = getUsername($con,$user);

          if($user_to == $added_by)
          {
            $user_to = "none";
          }

          //insert post
          $query = mysqli_query($con, "INSERT INTO posts VALUES('0','$body','$added_by','$user_to','$date_added','no','no','0')");
          //echo "<script>alert('INSERT INTO posts VALUES(\'0\',\'".$body."\',\' ".$added_by."\',\'".$user_to."\',\'".$date_added."\',\'no\',\'no\',\'0\')');</script>";
          $return_id = mysqli_insert_id($con);

          //Insert notification

          //Update post count for user
          $num_posts = getNumPosts($con,$user);
          $num_posts++;
          $update_query = mysqli_query($con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");
      }
  }

  function loadPostsFriends($con, $user, $data, $limit)
  {
    $page = $data['page'];
    $userLoggedIn = getUsername($con, $user);

    if($page == 1)
    {
      $start = 0;
    }
    else
    {
      $start = ($page-1)*$limit;
    }

    $str = "";//string to return
    $data_query = mysqli_query($con,"SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC");

    if (mysqli_num_rows($data_query)>0)
    {
      $num_iterations = 0; //Number of results checked(not necessarily posted)
      $count = 1;

      while ($row = mysqli_fetch_array($data_query))
      {
        $id = $row['id'];
        $body = $row['body'];
        $added_by = $row['added_by'];
        $date_time = $row['date_added'];
        $likes = $row['likes'];

        //Prepare user_to string so it can be included even if not popsted to a users
        if($row['user_to'] == "none")
        {
          $user_to = "";
        }
        else
        {
          $user_to_name = getFirstAndLastName($con,$row['user_to']);
          $user_to = " to <a href=''".$row['user_to']."''>".$user_to_name."</a>";
        }

        //checks if the user who posted has their account closed
        if(isClosed($con, $added_by))
        {
          continue;
        }

        if($num_iterations++ < $start)
        {
          continue;
        }

        //once 10 posts have been loaded, break
        if($count > $limit)
        {
          break;
        }
        else
        {
          $count++;
        }

        $user_details_query = mysqli_query($con,"SELECT firstname, lastname,profile_pic FROM users WHERE username='$added_by'");
        $user_row = mysqli_fetch_array($user_details_query);
        $firstname = $user_row['firstname'];
        $lastname = $user_row['lastname'];
        $profile_pic = $user_row['profile_pic'];

?>
<script>
  function toggle<?php  echo $id; ?>()
  {
    var element = document.getElementById("toggleComment<?php  echo $id;?>");

    if(element.style.display == "block")
      element.style.display = "none";
    else
      element.style.display = "block";
  }

  function like<?php  echo $id; ?>()
  {
    var post_id = <?php  echo $id; ?>;
    var userLoggedIn = '<?php  echo $userLoggedIn; ?>';
    var text = $('.like<?php  echo $id; ?>').text();
    var count = parseInt($('.like_counter<?php  echo $id; ?>').text());
    //alert("Clicked on like of post_id:  <?php  echo $id; ?> and Text:"+text+" Likes:"+count+"  added1:"+(count+1));
    console.log("userLoggedIn: "+userLoggedIn);
    //checking if already liked or not
    if(text == "Unlike")
    {
      like_check = 1;
      console.log("Unlike detected so like_check="+like_check+"previous_count="+count);
    }
    if(text == "Like")
    {
      like_check = 0;
      console.log("Like detected so like_check="+like_check+"previous_count="+count);
    }

    //sending ajax request
    var ajaxReq = $.ajax({
      url: "includes/handlers/ajax_like_posts.php",
      type: "POST",
      data: "post_id="+post_id+"&userLoggedIn="+userLoggedIn+"&liked="+like_check,
      cache: false,

      success: function(response){
        console.log("Clicked on like of post_id: <?php  echo $id; ?> and Text:"+text);
        if(text == "Like")
        {
          $('.like<?php  echo $id; ?>').text("Unlike");
          $('.like_counter<?php  echo $id; ?>').text(count+1);
          console.log("Liked post: <?php  echo $id; ?>");
        }
        else
        {
          $('.like<?php  echo $id; ?>').text("Like");
          $('.like_counter<?php  echo $id; ?>').text(count-1);
          console.log("Unliked post: <?php  echo $id; ?> and counter changes from "+count+" to "+(count-1));
        }
      }
    });
  }
</script>
<?php
        //Time Frames (This portion coded with the help of Internet)
        $date_time_now = date("Y-m-d H:i:s");
        $start_date = new DateTime($date_time);//time of post_text
        $end_date = new DateTime($date_time_now);//current date
        $interval = $start_date->diff($end_date);//Difference between dates

        if($interval->y >=1)
        {
          if ($interval == 1)
          {
            $time_message = $interval->y ." year ago";//1year ago
          }
          else
          {
            $time_message = $interval->y ." years ago";//1year ago
          }
        }
        elseif($interval->m >= 1)
        {
          if($interval->d == 0)
          {
            $days = " ago";
          }
          elseif($interval->d == 1)
          {
            $days = $interval->d ." day ago";
          }
          else
          {
            $days = $interval->d ." days ago";
          }

          if($interval->m == 1)
          {
            $time_message = $interval->m ." month".$days;
          }
          else
          {
            $time_message = $interval->m ." months".$days;
          }
        }
        elseif($interval->d >=1)
        {
          if($interval->d == 1)
          {
            $time_message = "Yesterday";
          }
          else
          {
            $time_message = $interval->d ." days ago";
          }
        }
        elseif($interval->h >=1)
        {
          if($interval->h == 1)
          {
            $time_message= $interval->h ." hour ago";
          }
          else
          {
            $time_message = $interval->h ." hours ago";
          }
        }
        elseif($interval->i >=1)
        {
          if($interval->i == 1)
          {
            $time_message= $interval->i ." minute ago";
          }
          else
          {
            $time_message = $interval->i ." minutes ago";
          }
        }
        else
        {
          if($interval->s <= 30)
          {
            $time_message="Just now";
          }
          else
          {
            $time_message = $interval->s ." seconds ago";
          }
        }

        //comments Number
        $comment_query = mysqli_query($con,"SELECT * FROM comments WHERE post_id='$id'");
        $comment_num = mysqli_num_rows($comment_query);

        $like_query = mysqli_query($con,"SELECT * FROM likes WHERE post_id='$id'");
        $like_num = mysqli_num_rows($like_query);
        $like = "Like";
        if($like_num>0)
        {
          while($row = mysqli_fetch_array($like_query))
          {
            if($row['username'] == $userLoggedIn)
            {
              $like = "Unlike";
              break;
            }
          }
        }

        $str .= "<div class='status_post'>
                  <div class='post_profile_pic'>
                    <img src='$profile_pic' width='50'>
                  </div>

                  <div class='posted_by' style='color:#ACACAC;'>
                    <a href='$added_by'>$firstname $lastname</a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message
                  </div>
                  <div id='post_body'>
                    $body
                  </div>
                  <br><div><span class='like_counter$id'>$likes</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class='like$id' style='cursor:pointer' onclick='javascript:like$id()'>$like</span>&nbsp;&nbsp;&nbsp;&nbsp;<span style='cursor:pointer' onclick='javascript:toggle$id()'>Comments($comment_num)</span></div>
                </div>
                <div class='post_comment' id='toggleComment$id' style='display:none;'>
                 <iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder=''></iframe>
                </div>
                <hr>";
      }

      if($count > $limit)
      {
        $str.= "<input type='hidden' class='nextPage' value='".($page+1)."'>
                <input type='hidden' class='noMorePosts' value='false'>";
      }
      else
      {
        $str.= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align; centre;'>No more posts to show</p>";
      }
    }

    echo $str;
  }



//for loading posts of certain profile
  function loadPostsProfile($con, $user, $data, $limit)
  {
    $page = $data['page'];
    $userLoggedIn = getUsername($con,$user);

    if($page == 1)
    {
      $start = 0;
    }
    else
    {
      $start = ($page-1)*$limit;
    }

    $str = "";//string to return
    $data_query = mysqli_query($con,"SELECT * FROM posts WHERE deleted='no' AND added_by='$userLoggedIn' ORDER BY id DESC");
    //echo "<script><alert>Profile_name: $userLoggedIn</alert></script>";

    if (mysqli_num_rows($data_query)>0)
    {
      $num_iterations = 0; //Number of results checked(not necessarily posted)
      $count = 1;

      while ($row = mysqli_fetch_array($data_query))
      {
        $id = $row['id'];
        $body = $row['body'];
        $added_by = $row['added_by'];
        $date_time = $row['date_added'];
        $likes = $row['likes'];

        //Prepare user_to string so it can be included even if not popsted to a users
        if($row['user_to'] == "none")
        {
          $user_to = "";
        }
        else
        {
          $user_to_name = getFirstAndLastName($con,$row['user_to']);
          $user_to = " to <a href=''".$row['user_to']."''>".$user_to_name."</a>";
        }

        //checks if the user who posted has their account closed
        if(isClosed($con, $added_by))
        {
          continue;
        }

        if($num_iterations++ < $start)
        {
          continue;
        }

        //once 10 posts have been loaded, break
        if($count > $limit)
        {
          break;
        }
        else
        {
          $count++;
        }

        $user_details_query = mysqli_query($con,"SELECT firstname, lastname,profile_pic FROM users WHERE username='$added_by'");
        $user_row = mysqli_fetch_array($user_details_query);
        $firstname = $user_row['firstname'];
        $lastname = $user_row['lastname'];
        $profile_pic = $user_row['profile_pic'];

?>
<script>
  function toggle<?php  echo $id; ?>()
  {
    var element = document.getElementById("toggleComment<?php  echo $id;?>");

    if(element.style.display == "block")
      element.style.display = "none";
    else
      element.style.display = "block";
  }

  function like<?php  echo $id; ?>()
  {
    var post_id = <?php  echo $id; ?>;
    var userLoggedIn = '<?php  echo $userLoggedIn; ?>';
    var text = $('.like<?php  echo $id; ?>').text();
    var count = parseInt($('.like_counter<?php  echo $id; ?>').text());
    //alert("Clicked on like of post_id:  <?php  echo $id; ?> and Text:"+text+" Likes:"+count+"  added1:"+(count+1));
    console.log("userLoggedIn: "+userLoggedIn);
    //checking if already liked or not
    if(text == "Unlike")
    {
      like_check = 1;
      console.log("Unlike detected so like_check="+like_check+"previous_count="+count);
    }
    if(text == "Like")
    {
      like_check = 0;
      console.log("Like detected so like_check="+like_check+"previous_count="+count);
    }

    //sending ajax request
    var ajaxReq = $.ajax({
      url: "includes/handlers/ajax_like_posts.php",
      type: "POST",
      data: "post_id="+post_id+"&userLoggedIn="+userLoggedIn+"&liked="+like_check,
      cache: false,

      success: function(response){
        console.log("Clicked on like of post_id: <?php  echo $id; ?> and Text:"+text);
        if(text == "Like")
        {
          $('.like<?php  echo $id; ?>').text("Unlike");
          $('.like_counter<?php  echo $id; ?>').text(count+1);
          console.log("Liked post: <?php  echo $id; ?>");
        }
        else
        {
          $('.like<?php  echo $id; ?>').text("Like");
          $('.like_counter<?php  echo $id; ?>').text(count-1);
          console.log("Unliked post: <?php  echo $id; ?> and counter changes from "+count+" to "+(count-1));
        }
      }
    });
  }
</script>
<?php
        //Time Frames (This portion coded with the help of Internet)
        $date_time_now = date("Y-m-d H:i:s");
        $start_date = new DateTime($date_time);//time of post_text
        $end_date = new DateTime($date_time_now);//current date
        $interval = $start_date->diff($end_date);//Difference between dates

        if($interval->y >=1)
        {
          if ($interval == 1)
          {
            $time_message = $interval->y ." year ago";//1year ago
          }
          else
          {
            $time_message = $interval->y ." years ago";//1year ago
          }
        }
        elseif($interval->m >= 1)
        {
          if($interval->d == 0)
          {
            $days = " ago";
          }
          elseif($interval->d == 1)
          {
            $days = $interval->d ." day ago";
          }
          else
          {
            $days = $interval->d ." days ago";
          }

          if($interval->m == 1)
          {
            $time_message = $interval->m ." month".$days;
          }
          else
          {
            $time_message = $interval->m ." months".$days;
          }
        }
        elseif($interval->d >=1)
        {
          if($interval->d == 1)
          {
            $time_message = "Yesterday";
          }
          else
          {
            $time_message = $interval->d ." days ago";
          }
        }
        elseif($interval->h >=1)
        {
          if($interval->h == 1)
          {
            $time_message= $interval->h ." hour ago";
          }
          else
          {
            $time_message = $interval->h ." hours ago";
          }
        }
        elseif($interval->i >=1)
        {
          if($interval->i == 1)
          {
            $time_message= $interval->i ." minute ago";
          }
          else
          {
            $time_message = $interval->i ." minutes ago";
          }
        }
        else
        {
          if($interval->s <= 30)
          {
            $time_message="Just now";
          }
          else
          {
            $time_message = $interval->s ." seconds ago";
          }
        }

        //comments Number
        $comment_query = mysqli_query($con,"SELECT * FROM comments WHERE post_id='$id'");
        $comment_num = mysqli_num_rows($comment_query);

        //echo "<script>alert('post_id:$id added_by:$added_by firstname:$firstname');</script>";
        $like_query = mysqli_query($con,"SELECT * FROM likes WHERE post_id='$id'");
        $like_num = mysqli_num_rows($like_query);
        $like = "Like";
        if($like_num>0)
        {
          while($row = mysqli_fetch_array($like_query))
          {
            if($row['username'] == $userLoggedIn)
            {
              $like = "Unlike";
              break;
            }
          }
        }



        $str .= "<div class='status_post' >
                  <div class='post_profile_pic'>
                    <img src='$profile_pic' width='50'>
                  </div>

                  <div class='posted_by' style='color:#ACACAC;'>
                    <a href='$added_by'>$firstname $lastname</a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message
                  </div>
                  <div id='post_body'>
                    $body
                  </div>
                  <br><div><span class='like_counter$id'>$likes</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class='like$id' style='cursor:pointer' onclick='javascript:like$id()'>$like</span>&nbsp;&nbsp;&nbsp;&nbsp;<span style='cursor:pointer' onclick='javascript:toggle$id()'>Comments($comment_num)</span></div>
                </div>
                <div class='post_comment' id='toggleComment$id' style='display:none;'>
                 <iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder=''></iframe>
                </div>
                <hr>";
      }

      if($count > $limit)
      {
        $str.= "<input type='hidden' class='nextPage' value='".($page+1)."'>
                <input type='hidden' class='noMorePosts' value='false'>";
      }
      else
      {
        $str.= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align; centre;'>No more posts to show</p>";
      }
    }

    echo $str;
  }
  ?>
