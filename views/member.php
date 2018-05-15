<?php

//  $_SESSION['name'] = 'test user';
  function posts(){
    $sql = "SELECT `content`, `who`, `topic` FROM `posts` WHERE 1" ;
    $result = mysql_query($sql);
    if($result){
      while($row = mysql_fetch_array($result)){
          echo "<h1>{$row['topic']}</h1></br><p>{$row['content']}</p>";
      }
    }
  }

 ?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $_SESSION['name'];?></title>
  </head>
  <body>
    <h1>Member Dashboard</h1>
    <p><?php  posts() ; ?></p></br>
    <h2>Post Something</h2>
    <form action="<?php echo config('baseurl'); ?>postit" method="post">
      topic : <input type="text" name="topic" value=""><br>
      content : <input type="text" name="content" value=""><br>
      <input type="submit" name="postit" value="post">
    </form>
    <form  action="<?php echo config('baseurl'); ?>logout" method="post">
      <input type="submit" name="logout" value="logout">
    </form>
  </body>
</html>
