<?php

include("delete_modal.php");
  function clonePost($id) {
    global $connection;

    $query = "SELECT * FROM posts WHERE post_id = $id";
    $cloned_post = mysqli_query($connection, $query);
    confirmQuery($cloned_post);

    while($row = mysqli_fetch_assoc($cloned_post)){
      $post_category_id = $row['post_category_id'];
      $post_title = $row['post_title'];
      $post_author = $row['post_author'];
      $post_author_id = $row['post_author_id'];
      $post_image = $row['post_image'];
      $post_content = $row['post_content'];
      $post_tags = $row['post_tags'];
    }

    $query = "INSERT INTO posts (post_category_id, post_title, post_author, post_author_id, post_date, post_image, post_content, post_tags) ";
    $query .= "VALUES ({$post_category_id}, '{$post_title}', '{$post_author}', {$post_author_id}, now(), '{$post_image}', '{$post_content}', '{$post_tags}')";
    $new_cloned_post = mysqli_query($connection, $query);
    confirmQuery($new_cloned_post);
  }


  if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $postValueId){
      $bulk_options = esc($_POST['bulk_options']);
      switch($bulk_options){
        case 'Published':
          $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = $postValueId";
          $update_to_published = mysqli_query($connection, $query);
          break;
        case 'Draft':
          $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = $postValueId";
          $update_to_draft = mysqli_query($connection, $query);
          break;
        case 'delete':
          $query = "DELETE FROM posts WHERE post_id = $postValueId";
          $mass_delete = mysqli_query($connection, $query);
          break;
        case 'clone':
          clonePost($postValueId);
          break;
        default:
          header("Location: posts.php?message=action");
          exit;
      }
    }
    header("Location: posts.php");
    exit;
  }

  if(isset($_GET['post_status'])){
    $status = esc($_GET['post_status']);
    $new_post_id = esc($_GET['new_post_id']);
    if ($status === 'Published'){
      echo "<p class='bg-success'>Post published successfully! <a href='../post.php?p_id={$new_post_id}'>View here</a></p>";
    } else {
      echo "<p class='bg-success'>Post draft successfully saved.</p>";
    }
  }

  if(isset($_GET['message'])){
    echo "<p>Please select an action</p>";
  }

?>

<form action="" method="POST">

<div id="bulkOptionsContainer" class="col-xs-4">
    <select class="form-control" name="bulk_options" id="">
      <option value="">--Select Option--</option>
      <option value="Published">Publish</option>
      <option value="Draft">Draft</option>
      <option value="delete">Delete</option>
      <option value="clone">Clone</option>
    </select>
  </div>
  <div class="col-xs-4">
    <input type="submit" name="submit" class="btn btn-success" value="Apply">
    <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
  </div>

<table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th><input id="selectAllBoxes" type="checkbox"></th>
                          <th>Id</th>
                          <th>Author</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Status</th>
                          <th>Image</th>
                          <th>Tags</th>
                          <th>Comments</th>
                          <th>Date</th>
                          <th>Views</th>
                          <th>Edit</th>
                          <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody>
<?php 
  $query = "SELECT * FROM posts INNER JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY post_id DESC";
  $all_posts = mysqli_query($connection, $query);
  while($row = mysqli_fetch_assoc($all_posts)){
    $post_id = $row['post_id'];
    $post_author = $row['post_author'];
    $post_user = $row['post_user'];
    $post_title = $row['post_title'];
    $post_category_title = $row['cat_title'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_date = $row['post_date'];
    $post_views = $row['post_views_count'];

    $comment_query = "SELECT * FROM comments WHERE comment_post_id = {$post_id}";
    $num_comments = mysqli_query($connection, $comment_query);
    $post_comment_count = mysqli_num_rows($num_comments);

    echo "<tr>
          <td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value={$post_id}></td>
          <td>{$post_id}</td>";

    if (!empty($post_author)){
      echo "<td>{$post_author}</td>";
    } else {
      $user_query = "SELECT username FROM users WHERE user_id = {$post_user}";
      $get_username = mysqli_query($connection, $user_query);
      confirmQuery($get_username);
      $post_user = mysqli_fetch_array($get_username)['username'];
      echo "<td>{$post_user}</td>";
    }
    
    echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
    echo "<td>{$post_category_title}</td>";
    echo "<td>{$post_status}</td>
          <td><img width=100 src='../images/{$post_image}' alt='Blog image preview'></td>
          <td>{$post_tags}</td>
          <td><a href='comments.php?id={$post_id}'>{$post_comment_count}</a></td>
          <td>{$post_date}</td>
          <td>{$post_views}</td>
          <td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>
          <td><a href='' data-id='$post_id' data-toggle='modal' data-target='#myModal' data-title='$post_title' class='delete_link'>Delete</a></td>
          </tr>";
  }
?>
                      </tbody>
                    </table>
</form>
<?php

if(isset($_GET['delete'])){
  $delete_post_id = esc($_GET['delete']);

  $query = "DELETE FROM posts WHERE post_id = {$delete_post_id}";
  $delete_query = mysqli_query($connection, $query);

  confirmQuery($delete_query);
  header('Location: posts.php');
  exit;
}

?>
<script>
$(document).ready(function() {
  $(".delete_link").on("click", function() {
    var id = $(this).data("id");
    var title = $(this).data("title");
    var delete_url = `posts.php?delete=${id}`;
    $(".modal_delete_link").attr("href", delete_url);
    $(".modal-title").text(`Delete ${title}`);
  })
});
</script>