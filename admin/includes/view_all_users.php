<table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Username</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Email</th>
                          <th>Role</th>
                          <th>Edit</th>
                          <th>Delete User</th>
                          <th>Change to Admin</th>
                          <th>Change to Sub</th>
                        </tr>
                      </thead>
                      <tbody>
<?php 
  $query = "SELECT * FROM users";
  $all_users = mysqli_query($connection, $query);
  while($row = mysqli_fetch_assoc($all_users)){
    $user_id = $row['user_id'];
    $username = $row['username'];
    $user_email = $row['user_email'];
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_image = $row['user_image'];
    $user_role = $row['user_role'];

    echo "<tr>
          <td>{$user_id}</td>
          <td>{$username}</td>
          <td>{$user_firstname}</td>
          <td>{$user_lastname}</td>
          <td>{$user_email}</td>
          <td>{$user_role}</td>
          <td><a href='users.php?source=edit_user&u_id=$user_id'>Edit</a></td>
          <td><a href='users.php?delete=$user_id'>Delete</a></td>
          <td><a href='users.php?change_to_admin=$user_id'>Change to Admin</a></td>
          <td><a href='users.php?change_to_sub=$user_id'>Change to Sub</a></td>
          </tr>";
  }
?>
                      </tbody>
                    </table>

<?php

if(isset($_GET['delete'])){
  if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === "Admin") {
    $delete_user_id = esc($_GET['delete']);

    $query = "DELETE FROM users WHERE user_id = {$delete_user_id}";
    $delete_query = mysqli_query($connection, $query);
  
    confirmQuery($delete_query);
    header('Location: users.php');
    exit;
  }
  header("Location: ../index.php");
  exit;
}

if(isset($_GET['change_to_admin'])){
  if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === "Admin"){
    $change_to_admin_id = esc($_GET['change_to_admin']);

    $query = "UPDATE users SET user_role = 'Admin' WHERE user_id = $change_to_admin_id";
    $change_to_admin_query = mysqli_query($connection, $query);
    confirmQuery($change_to_admin_query);
    header('Location: users.php');
    exit;
  }
  header("Location: ../index.php");
  exit;
}

if(isset($_GET['change_to_sub'])){
  if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === "Admin"){
    $change_to_sub_id = esc($_GET['change_to_sub']);

    $query = "UPDATE users SET user_role = 'Subscriber' WHERE user_id = $change_to_sub_id";
    $change_to_sub_query = mysqli_query($connection, $query);
    confirmQuery($change_to_sub_query);
    header('Location: users.php');
    exit;
  }
  header("Location: ../index.php");
  exit;
}

?>