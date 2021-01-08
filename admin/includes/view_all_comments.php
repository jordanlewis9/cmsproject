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
  $query = "SELECT * FROM comments";
  $all_comments = mysqli_query($connection, $query);
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
    echo "<td><a href='#'>Approve</a></td>
          <td><a href='#'>Deny</a></td>
          <td><a href='#'>Delete</a></td>
          <td>{$comment_date}</td>
          </tr>";
  }
?>
                      </tbody>
                    </table>

<?php

if(isset($_GET['delete'])){
  $delete_post_id = $_GET['delete'];

  $query = "DELETE FROM posts WHERE post_id = {$delete_post_id}";
  $delete_query = mysqli_query($connection, $query);

  confirmQuery($delete_query);
  header('Location: posts.php');
  exit;
}

?>