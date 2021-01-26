<?php
  if(isset($_POST['create_user'])){
    $username = esc($_POST['username']);
    $user_role = esc($_POST['user_role']);
    $user_firstname = esc($_POST['user_firstname']);
    $user_lastname = esc($_POST['user_lastname']);
    $user_email = esc($_POST['user_email']);
    $user_password = esc($_POST['user_password']);

    // move_uploaded_file($post_image_temp, "../images/$post_image");

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

    $query = "INSERT INTO users (username, user_role, user_firstname, user_lastname, user_email, user_password) 
    VALUES ('{$username}', '{$user_role}', '{$user_firstname}', '{$user_lastname}', '{$user_email}', '{$user_password}')";  

    $create_user_query = mysqli_query($connection, $query);

    confirmQuery($create_user_query);
    header("Location: users.php?new_user={$username}");
    exit;
  }


?>

<form action="" method="POST" enctype="multipart/form-data">

  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="username">
  </div>
  <div class="form-group">
    <label for="user_role">Role</label>
    <select name="user_role">
      <option value="Subscriber">---Select Role---</option>
      <option value="Admin">Admin</option>
      <option value="Subscriber">Subscriber</option>
    </select>
  </div>
  <div class="form-group">
    <label for="user_firstname">First Name</label>
    <input type="text" class="form-control" name="user_firstname">
  </div>
  <div class="form-group">
    <label for="user_lastname">Last Name</label>
    <input type="text" class="form-control" name="user_lastname">
  </div>
  <!-- <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" class="form-control" name="image">
  </div> -->
  <div class="form-group">
    <label for="user_email">Email</label>
    <input type="email" class="form-control" name="user_email">
  </div>
  <div class="form-group">
    <label for="user_password">Password</label>
    <input type="password" class="form-control" name="user_password">
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
  </div>
</form>