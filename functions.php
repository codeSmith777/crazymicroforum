<?php
// 1-> guest , 2-> user / 3->admin

function login(){
  if(!(isset($_POST['username']) && isset($_POST['password']))){
    return ;
  }
  else{
    $user = htmlspecialchars($_POST['username']);
    $pass = htmlspecialchars($_POST['password']);
    $sql = "SELECT `username`, `password` ,`level` FROM `user` WHERE `username` = '{$user}'";
    $result = mysql_query($sql);
    if($result){
      $row = mysql_fetch_array($result);
      if(!strcmp(sha1($pass) , $row['password'])){
        $_SESSION['level'] = $row['level'];
        $_SESSION['name'] = $row['username'];
      }
      else{
        $_SESSION['level'] = 1 ;
        $_SESSION['name'] = 'guest';
      }
    }
  }
}


function signup(){
  $errors = array(); /* declare the array for later use */
    if(isset($_POST['username']))
    {
        //the user name exists
        if(!ctype_alnum($_POST['username']))
        {
            $errors[] = 'The username can only contain letters and digits.';
        }
        if(strlen($_POST['username']) > 30)
        {
            $errors[] = 'The username cannot be longer than 30 characters.';
        }
    }
    else
    {
        $errors[] = 'The username field must not be empty.';
    }
    if(isset($_POST['password']))
    {
        if($_POST['password'] != $_POST['user_pass_check'])
        {
            $errors[] = 'The two passwords did not match.';
        }
    }
    else
    {
        $errors[] = 'The password field cannot be empty.';
    }
    if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
    {
        echo 'Uh-oh.. a couple of fields are not filled in correctly..';
        echo '<ul>';
        foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
        {
            echo '<li>' . $value . '</li>'; /* this generates a nice error list */
        }
        echo '</ul>';
    }
    else
    {
        //the form has been posted without, so save it
        //notice the use of mysql_real_escape_string, keep everything safe!
        //also notice the sha1 function which hashes the password
         $sql = "INSERT INTO
                    user(username, password, email , date, level, active)
                VALUES('" . mysql_real_escape_string($_POST['username']) . "',
                       '" . sha1($_POST['password']) . "',
                       '" . mysql_real_escape_string($_POST['email']) . "',
                        NOW(),
                        0, 0)";
        $result = mysql_query($sql);
        if(!$result)
        {
            //something went wrong, display the error
            echo 'Something went wrong while registering. Please try again later.';
            //echo mysql_error(); //debugging purposes, uncomment when needed
        }
        else
        {
            echo 'Successfully registered.  Please wait until an Admin activates your account. <a href="index.php">Return to forum</a>';
        }
    }
}


function postit(){
  if (!(isset($_POST['content']) && isset($_POST['topic']))){
    return ;
  }
  $content = htmlspecialchars($_POST['content'] , ENT_QUOTES);
  $topic = htmlspecialchars($_POST['topic'] , ENT_QUOTES);
  $sql = "INSERT INTO `posts`(`content`, `who`, `topic`) VALUES ('{$content}','{$_SESSION['name']}','{$topic}');" ;
  $result = mysql_query($sql);
}

function logout(){
  $_SESSION['level'] = 1 ;
  session_destroy();
}



function setlevel(){
  if(!isset($_SESSION['level'])){
      $_SESSION['level'] = 1 ;
  }

}

function level_translation(){
  if($_SESSION['level'] == 1){
    return 'views/guest.php';
  }
  elseif($_SESSION['level'] == 2){
    return 'views/member.php';
  }
  elseif($_SESSION['level'] == 3){
    return 'views/admin.php';
  }
}


function pathfinder(){
  $mypath ;
  if(!isset($_GET['page'])){
    $mypath = level_translation();
    return  $mypath;
  }
  else{
    $mypath = explode( '/' , $_GET['page'] );
    $pathaction = router($mypath[0]);
    if($pathaction){
      $pathaction();    // may change the level of session ie make guest menber of admin etc
      $mypath = level_translation();
      return  $mypath;
    }
    else {
      //echo $_GET['page'];
      //print_r($mypath);
      return 'views/404.php';
    }
  }
}

function run(){
  setlevel();
  $myroute = pathfinder();
  include($myroute);
}

 ?>
