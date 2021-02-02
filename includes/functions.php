<?php

function confirmQuery($result) {
  global $connection;
  if(!$result){
    die("QUERY FAILED" . mysqli_error($connection));
  }
}

  function esc($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
  }

  function username_exists($username) {
    global $connection;
  
    $query = "SELECT username FROM users WHERE username = '{$username}'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
  
    if(mysqli_num_rows($result) > 0) {
      return true;
    } else {
      return false;
    }
  }

  function email_exists($email) {
    global $connection;

    $query = "SELECT user_email FROM users WHERE user_email = '{$email}'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if(mysqli_num_rows($result) > 0) {
      return true;
    } else {
      return false;
    }
  }

  function register_user($username, $email, $password) {
    global $connection;

      $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

      $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
      $query .= "VALUES('{$username}', '{$email}', '{$password}', 'Subscriber')";
      $register_user_query = mysqli_query($connection, $query);
      confirmQuery($register_user_query);
      // $message = "Your registration has been submitted!";
      // header("Location: index.php?signed_up={$message}");
      // exit;
  }

  function login_user($username, $password, $from_registration = false){
    global $connection;

    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_query = mysqli_query($connection, $query);
    if(!$select_user_query) {
      die('QUERY FAILED ' . mysqli_error($connection));
    }
  
    while($row = mysqli_fetch_assoc($select_user_query)){
      $db_user_id = $row['user_id'];
      $db_username = $row['username'];
      $db_user_password = $row['user_password'];
      $db_user_firstname = $row['user_firstname'];
      $db_user_lastname = $row['user_lastname'];
      $db_user_role = $row['user_role'];
    }
  
    if($username === $db_username && password_verify($password, $db_user_password)){
      $_SESSION['username'] = $db_username;
      $_SESSION['firstname'] = $db_user_firstname;
      $_SESSION['lastname'] = $db_user_lastname;
      $_SESSION['user_role'] = $db_user_role;
      $_SESSION['user_id'] = $db_user_id;
      if ($db_user_role === 'Admin'){
        header('Location: ../admin/index.php');
        exit;
      } else {
        $message = "Welcome, $db_username";
        if($from_registration) {
          header("Location: index.php?signed_in=$message");
          exit;
        }
        header("Location: ../index.php?signed_in=$message");
        exit;
      }
    } else {
      $message = "Username or password do not match our records. Please try again.";
      header("Location: ../index.php?signed_in=$message");
    }
  }

  function is_admin($username) {
    global $connection;
  
    $query = "SELECT user_role FROM users WHERE username = '{$username}'";
  
    $result = mysqli_query($connection, $query);
  
    confirmQuery($result);
  
    $row = mysqli_fetch_array($result);
  
    if($row['user_role'] === 'Admin')  {
      return true;
    } else {
      return false;
    }
  }


?>