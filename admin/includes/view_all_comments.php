<table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Author</th>
                          <th>Comment</th>
                          <th>Email</th>
                          <th>Status</th>
                          <th>In Response to..</th>
                          <th>Approve</th>
                          <th>Deny</th>
                          <th>Delete</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
<?php 
  if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = esc($_GET['id']);
    $query = "SELECT * FROM comments WHERE comment_post_id = {$id} ORDER BY comment_date DESC";
    $all_comments = mysqli_query($connection, $query);
    confirmQuery($all_comments);
  } else {
    $query = "SELECT * FROM comments ORDER BY comment_date DESC";
    $all_comments = mysqli_query($connection, $query);
    confirmQuery($all_comments);
    $id = '';
  }
  

  while($row = mysqli_fetch_assoc($all_comments)){
    $comment_id = $row['comment_id'];
    $comment_author = $row['comment_author'];
    $comment_email = $row['comment_email'];
    $comment_status = $row['comment_status'];
    $comment_post_id = $row['comment_post_id'];
    $comment_content = $row['comment_content'];
    $comment_date = $row['comment_date'];

    echo "<tr>
          <td>{$comment_id}</td>
          <td>{$comment_author}</td>
          <td>{$comment_content}</td>
          <td>{$comment_email}</td>
          <td>{$comment_status}</td>";
    $query = "SELECT post_title, post_id FROM posts WHERE post_id = {$comment_post_id}";
    $related_post = mysqli_query($connection, $query);
    while($name_title = mysqli_fetch_assoc($related_post)){
      $post_title = $name_title['post_title'];
      $post_id = $name_title['post_id'];
      echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
    }
    // if(isset($id)){
      echo "<td><a href='comments.php?approve=$comment_id&id={$id}'>Approve</a></td>
      <td><a href='comments.php?unapprove=$comment_id&id={$id}'>Deny</a></td>
      <td><a href='comments.php?delete=$comment_id&id={$id}'>Delete</a></td>
      <td>{$comment_date}</td>
      </tr>";
    // } else {
    //   echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>
    //   <td><a href='comments.php?unapprove=$comment_id'>Deny</a></td>
    //   <td><a href='comments.php?delete=$comment_id'>Delete</a></td>
    //   <td>{$comment_date}</td>
    //   </tr>";
    // }
  }
?>
                      </tbody>
                    </table>

<?php

if(isset($_GET['delete'])){
  $delete_comment_id = esc($_GET['delete']);
  // $id = $_GET['id'] ?? '';

  $query = "DELETE FROM comments WHERE comment_id = {$delete_comment_id}";
  $delete_query = mysqli_query($connection, $query);

  confirmQuery($delete_query);
  header("Location: comments.php?id={$id}");
  exit;
}

if(isset($_GET['unapprove'])){
  $unapprove_comment_id = esc($_GET['unapprove']);
  // $id = $_GET['id'] ?? '';

  $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = $unapprove_comment_id";
  $unapprove_query = mysqli_query($connection, $query);
  confirmQuery($unapprove_query);
  header("Location: comments.php?id={$id}");
  exit;
}

if(isset($_GET['approve'])){
  $approve_comment_id = esc($_GET['approve']);
  // $id = $_GET['id'] ?? '';

  $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = $approve_comment_id";
  $approve_query = mysqli_query($connection, $query);
  confirmQuery($approve_query);
  header("Location: comments.php?id={$id}");
  exit;
}

?>