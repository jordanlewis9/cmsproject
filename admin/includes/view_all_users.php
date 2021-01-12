<table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Username</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Email</th>
                          <th>Role</th>
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
          </tr>";
  }
?>
                      </tbody>
                    </table>

<?php

if(isset($_GET['delete'])){
  $delete_comment_id = $_GET['delete'];

  $query = "DELETE FROM comments WHERE comment_id = {$delete_comment_id}";
  $delete_query = mysqli_query($connection, $query);

  confirmQuery($delete_query);
  header('Location: comments.php');
  exit;
}

if(isset($_GET['unapprove'])){
  $unapprove_comment_id = $_GET['unapprove'];

  $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = $unapprove_comment_id";
  $unapprove_query = mysqli_query($connection, $query);
  confirmQuery($unapprove_query);
  header('Location: comments.php');
  exit;
}

if(isset($_GET['approve'])){
  $approve_comment_id = $_GET['approve'];

  $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = $approve_comment_id";
  $approve_query = mysqli_query($connection, $query);
  confirmQuery($approve_query);
  header('Location: comments.php');
  exit;
}

?>