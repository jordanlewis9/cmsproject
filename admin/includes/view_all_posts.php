<?php
  if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $postValueId){
      $bulk_options = $_POST['bulk_options'];
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
        default:
          header("Location: posts.php?message=action");
          exit;
      }
    }
    header("Location: posts.php");
    exit;
  }

  if(isset($_GET['post_status'])){
    $status = $_GET['post_status'];
    $new_post_id = $_GET['new_post_id'];
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
                          <th>View Post</th>
                          <th>Edit</th>
                          <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody>
<?php 
  $query = "SELECT * FROM posts";
  $all_posts = mysqli_query($connection, $query);
  while($row = mysqli_fetch_assoc($all_posts)){
    $post_id = $row['post_id'];
    $post_author = $row['post_author'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];

    echo "<tr>
          <td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value={$post_id}></td>
          <td>{$post_id}</td>
          <td>{$post_author}</td>
          <td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
    $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
    $category_title = mysqli_query($connection, $query);
    while($name_title = mysqli_fetch_assoc($category_title)){
      $cat_title = $name_title['cat_title'];
      echo "<td>{$cat_title}</td>";
    }
    echo "<td>{$post_status}</td>
          <td><img width=100 src='../images/{$post_image}' alt='Blog image preview'></td>
          <td>{$post_tags}</td>
          <td>{$post_comment_count}</td>
          <td>{$post_date}</td>
          <td><a href='../post.php?p_id={$post_id}'>View Post</a></td>
          <td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>
          <td><a href='posts.php?delete={$post_id}'>Delete</a></td>
          </tr>";
  }
?>
                      </tbody>
                    </table>
</form>
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