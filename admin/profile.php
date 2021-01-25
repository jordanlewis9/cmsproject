<?php include "includes/admin_header.php"; ?>
<?php
  if(isset($_SESSION['user_id'])){
    $self_id = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE user_id = $self_id";
    $self_query = mysqli_query($connection, $query);

    confirmQuery($self_query);
    while($row = mysqli_fetch_assoc($self_query)){
    $user_id = $row['user_id'];
    $username = $row['username'];
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_email = $row['user_email'];
    $user_password = $row['user_password'];
    }
  }

    if(isset($_POST['update_self'])){
      $edit_username = $_POST['username'];
      $edit_user_firstname = $_POST['user_firstname'];
      $edit_user_lastname = $_POST['user_lastname'];
      $edit_user_email = $_POST['user_email'];
      $edit_user_password = $_POST['user_password'];

      if(empty($edit_user_password)){
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
      header("Location: profile.php");
      exit;
    }

?>
    <div id="wrapper">

        <!-- Navigation -->
<?php include "includes/admin_navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                    <h1 class="page-header">Welcome Admin <small><?php echo $_SESSION['username']; ?></small></h1>

                    </div>
                </div>
                <!-- /.row -->
                <form action="" method="POST" enctype="multipart/form-data">

  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="username" value=<?php echo $username; ?>>
  </div>
  <div class="form-group">
    <label for="user_firstname">First Name</label>
    <input type="text" class="form-control" name="user_firstname" value=<?php echo $user_firstname; ?>>
  </div>
  <div class="form-group">
    <label for="user_lastname">Last Name</label>
    <input type="text" class="form-control" name="user_lastname" value=<?php echo $user_lastname; ?>>
  </div>
  <div class="form-group">
    <label for="user_email">Email</label>
    <input type="email" class="form-control" name="user_email" value=<?php echo $user_email; ?>>
  </div>
  <div class="form-group">
    <label for="user_password">Password</label>
    <input type="password" class="form-control" name="user_password" autocomplete="off">
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="update_self" value="Update Self">
  </div>
</form>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php"; ?>