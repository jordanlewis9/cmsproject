<?php
if(isset($_GET['p_id'])){
  $post_id = $_GET['p_id'];

  $query = "SELECT * FROM posts WHERE post_id = {$post_id}";
  $edit_post = mysqli_query($connection, $query);

  confirmQuery($edit_post);

  while($row = mysqli_fetch_assoc($edit_post)){
    $post_id = $row['post_id'];
    $post_author = $row['post_author'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_content = $row['post_content'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
  }

  // POSTING EDIT
  if(isset($_POST['update_post'])){
    $edit_post_title = $_POST['title'];
    $edit_post_author = $_POST['author'];
    $edit_post_category_id = $_POST['post_category_id'];
    $edit_post_status = $_POST['post_status'];

    $edit_post_image = $_FILES['image']['name'];
    $edit_post_image_temp = $_FILES['image']['tmp_name'];

    $edit_post_tags = $_POST['post_tags'];
    $edit_post_content = $_POST['post_content'];

    move_uploaded_file($edit_post_image_temp, "../images/{$edit_post_image}");

    if(empty($edit_post_image)){
      $query = "SELECT * FROM posts WHERE post_id = {$post_id}";
      $select_image = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($select_image)) {
        $edit_post_image = $row['post_image'];
      }
    }

    $query = "UPDATE posts SET ";
    $query .= "post_title = '{$edit_post_title}', ";
    $query .= "post_category_id = '{$edit_post_category_id}', ";
    $query .= "post_date = now(), ";
    $query .= "post_author = '{$edit_post_author}', ";
    $query .= "post_status = '{$edit_post_status}', ";
    $query .= "post_tags = '{$edit_post_tags}', ";
    $query .= "post_content = '{$edit_post_content}', ";
    $query .= "post_image = '{$edit_post_image}' ";
    $query .= "WHERE post_id = {$post_id}";

    $update_post = mysqli_query($connection, $query);

    confirmQuery($update_post);
    header('Location: posts.php');
    exit;
  }
?>
<form action="" method="POST" enctype="multipart/form-data">

  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" class="form-control" name="title" value=<?php echo $post_title; ?>>
  </div>
  <div class="form-group">
    <select name="post_category_id" id="post_category">
<?php
  $query = "SELECT * FROM categories";
  $select_categories = mysqli_query($connection, $query);

  confirmQuery($select_categories);

  while($row = mysqli_fetch_assoc($select_categories)){
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];
    if($post_category_id === $cat_id){
      echo "<option value={$cat_id} selected>{$cat_title}</option>";
    } else {
      echo "<option value={$cat_id}>{$cat_title}</option>";
    }
  }

?>
    </select>
  </div>
  <div class="form-group">
    <label for="author">Post Author</label>
    <input type="text" class="form-control" name="author" value=<?php echo $post_author; ?>>
  </div>
  <div class="form-group">
    <label for="post_status">Post Status</label>
    <input type="text" class="form-control" name="post_status" value=<?php echo $post_status; ?>>
  </div>
  <div class="form-group">
    <img width=100 src="../images/<?php echo $post_image; ?>" alt="">
    <input type="file" class="form-control" name="image" value=<?php echo $post_image; ?>>
  </div>
  <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input type="text" class="form-control" name="post_tags" value=<?php echo $post_tags; ?>>
  </div>
  <div class="form-group">
    <label for="post_content">Post Content</label>
    <textarea class="form-control" name="post_content" cols="30" rows="10"><?php echo $post_content; ?></textarea>
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
  </div>
</form>
<?php } ?>