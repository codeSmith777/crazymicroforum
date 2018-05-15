<?php


  function title(){
    echo 'I am the guest';
  }
  function posts(){
    $sql = "SELECT `content`, `who`, `topic` FROM `posts` WHERE 1" ;
    $result = mysql_query($sql);
    if($result){
      while($row = mysql_fetch_array($result)){
          echo "<div class='postclass'><h1>{$row['topic']}</h1></br><p>{$row['content']}</p></div>";
      }
    }
  }

 ?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Guest</title>
    <link rel="stylesheet" type="text/css" href="<?php  echo config('baseurl');?>views/style_guest.css">
  </head>
  <body>
    <div id="maincontent">
    <div id="header">
      <?php title(); ?>
    </div>
    <div id="content">
    <div id="postarea">
      <?php posts(); ?>
    </div>
    <div id="formarea">
    <h2>Login Form</h2>
    <form action="<?php echo config('baseurl'); ?>login" method="post">
      Username:<input type="text" name="username" value=""></br>
      Password:<input type="password" name="password" value=""></br>
      <input type="submit" name="login" value="login">
    </form>
    <h2>Sign up</h2>
    <form action="<?php echo config('baseurl'); ?>signup" method="post">
      Username:<input type="text" name="username" value="user101"></br>
      Password:<input type="password" name="password" value="password"></br>
      Repeat-Password:<input type="password" name="user_pass_check" value="password"></br>
      Email:<input type="text" name="email" value="user@email.com"></br>
      Phone:<input type="text" name="phone" value="03211231234"></br>
      Gender:<input type="text" name="gender" value="male"></br>
      <input type="submit" name="signup" value="signup">
    </form>
  </div>
  <div class="fnull">

  </div>
  </div>
  </div>
  </body>
</html>
