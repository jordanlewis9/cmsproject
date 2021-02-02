<?php ob_start(); ?>
<?php include "db.php"; ?>
<?php include "functions.php" ?>
<?php session_start(); ?>

<?php

if(isset($_POST['login'])){
  $username = esc($_POST['username']);
  $password = esc($_POST['password']);

  login_user($username, $password);
}

?>