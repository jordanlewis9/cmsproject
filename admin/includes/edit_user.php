<?php
if(isset($_GET['u_id'])){
  $user_id = $_GET['u_id'];

  $query = "SELECT * FROM users WHERE user_id = {$user_id}";
  $edit_user = mysqli_query($connection, $query);

  confirmQuery($edit_user);

  while($row = mysqli_fetch_assoc($edit_user)){
    $user_id = $row['user_id'];
    $username = $row['username'];
    $user_role = $row['user_role'];
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_email = $row['user_email'];
    $user_password = $row['user_password'];
  }

  // POSTING EDIT
  if(isset($_POST['update_user'])){
    $edit_username = $_POST['username'];
    $edit_user_role = $_POST['user_role'];
    $edit_user_firstname = $_POST['user_firstname'];
    $edit_user_lastname = $_POST['user_lastname'];
    $edit_user_email = $_POST['user_email'];
    $edit_user_password = $_POST['user_password'];

    // $edit_post_image = $_FILES['image']['name'];
    // $edit_post_image_temp = $_FILES['image']['tmp_name'];

    // move_uploaded_file($edit_post_image_temp, "../images/{$edit_post_image}");

    // if(empty($edit_post_image)){
    //   $query = "SELECT * FROM posts WHERE post_id = {$post_id}";
    //   $select_image = mysqli_query($connection, $query);

    //   while($row = mysqli_fetch_assoc($select_image)) {
    //     $edit_post_image = $row['post_image'];
    //   }
    // }

    // if(!empty($edit_user_password)){
    //   $query_password = "SELECT user_password FROM users WHERE user_id = $user_password";
    //   $get_user_query = mysqli_query($connection, $query_password);
    //   confirmQuery($get_user_query);

    //   $row = mysqli_fetch_assoc($get_user_query);

    //   $edit_user_password = $row['user_password'];
    // }

    if (empty($edit_user_password)) {
      $edit_user_password = $user_password;
    } else {
      $edit_user_password = password_hash($edit_user_password, PASSWORD_BCRYPT, array('cost' => 12));
    }



    $query = "UPDATE users SET ";
    $query .= "username = '{$edit_username}', ";
    $query .= "user_role = '{$edit_user_role}', ";
    $query .= "user_firstname = '{$edit_user_firstname}', ";
    $query .= "user_lastname = '{$edit_user_lastname}', ";
    $query .= "user_email = '{$edit_user_email}', ";
    $query .= "user_password = '{$edit_user_password}' ";
    $query .= "WHERE user_id = {$user_id}";

    $update_user = mysqli_query($connection, $query);

    confirmQuery($update_user);
    header('Location: users.php');
    exit;
  }
?>
<form action="" method="POST" enctype="multipart/form-data">

  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="username" value=<?php echo $username; ?>>
  </div>
  <div class="form-group">
    <select name="user_role" id="user_role">
<?php
  if($user_role === "Admin"){
    echo "<option value='Admin' selected>Admin</option>
          <option value='Subscriber'>Subscriber</option>";
  } else {
    echo "<option value='Admin'>Admin</option>
          <option value='Subscriber' selected>Subscriber</option>";
  }
?>
    </select>
  </div>
  <div class="form-group">
    <label for="user_firstname">First Name</label>
    <input type="text" class="form-control" name="user_firstname" value=<?php echo $user_firstname; ?>>
  </div>
  <div class="form-group">
    <label for="user_lastname">Last Name</label>
    <input type="text" class="form-control" name="user_lastname" value=<?php echo $user_lastname; ?>>
  </div>
  <!-- <div class="form-group">
    <img width=100 src="../images/<?php echo $post_image; ?>" alt="">
    <input type="file" class="form-control" name="image" value=<?php echo $post_image; ?>>
  </div> -->
  <div class="form-group">
    <label for="user_email">Email</label>
    <input type="email" class="form-control" name="user_email" value=<?php echo $user_email; ?>>
  </div>
  <div class="form-group">
    <label for="user_password">Password</label>
    <input type="password" class="form-control" name="user_password" autocomplete="off">
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
  </div>
</form>
<?php } else {
  header("Location: index.php");
  exit;
}?>