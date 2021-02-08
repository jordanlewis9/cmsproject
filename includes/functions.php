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

    $stmt = mysqli_prepare($connection, "SELECT user_email FROM users WHERE user_email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if(mysqli_stmt_num_rows($stmt) > 0) {
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
    } else if (mysqli_num_rows($select_user_query) === 0) {
      return false;
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
        header('Location: /cmsproject/admin');
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
      return false;
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

  function redirect($location){
    header("Location: {$location}");
    exit;
  }

  //Checks if the current method is equal to the server's request method IE GET, POST

  function ifItIsMethod($method = null){
    if($_SERVER['REQUEST_METHOD'] === strtoupper($method)){
      return true;
    }
    return false;
  }

  function isLoggedIn() {
    if(isset($_SESSION['user_role'])) {
      return true;
    }
    return false;
  }

  function checkIfUserIsLoggedInAndRedirect($redirectLocation = null){
    if(isLoggedIn()){
      redirect($redirectLocation);
    }
  }

  function imagePlaceholder($image = '') {
    if(!$image){
      return 'surveyformpic.jpg';
    } else {
      return $image;
    }
  }


?>