<?php
if(isset($_GET['p_id'])){
  $post_id = esc($_GET['p_id']);

  $query = "SELECT * FROM posts WHERE post_id = {$post_id}";
  $edit_post = mysqli_query($connection, $query);

  confirmQuery($edit_post);
  while($row = mysqli_fetch_assoc($edit_post)){
    $post_id = $row['post_id'];
    $post_title = $row['post_title'];
    $post_user = $row['post_user'] ?? $row['post_author_id'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_content = $row['post_content'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
    if ($post_status === "Published") {
      $post_author = $row['post_author'];
    }
  }

  

  if(isset($_GET['updated'])){
    echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$post_id}' target='_blank'>View Post</a> or <a href='posts.php'>Edit More Posts</a></p>";
  }

  // POSTING EDIT
  if(isset($_POST['update_post'])){
    $edit_post_title = esc($_POST['title']);
    $edit_post_user = esc($_POST['user']);
    $edit_post_category_id = esc($_POST['post_category_id']);
    $edit_post_status = esc($_POST['post_status']);

    $edit_post_image = esc($_FILES['image']['name']);
    $edit_post_image_temp = esc($_FILES['image']['tmp_name']);

    $edit_post_tags = esc($_POST['post_tags']);
    $edit_post_content = esc($_POST['post_content']);

    move_uploaded_file($edit_post_image_temp, "../images/{$edit_post_image}");

    if(empty($edit_post_image)){
      $query = "SELECT * FROM posts WHERE post_id = {$post_id}";
      $select_image = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($select_image)) {
        $edit_post_image = $row['post_image'];
      }
    }

    if ($edit_post_status === "Published"){
      $author_query = "SELECT username FROM users WHERE user_id = {$edit_post_user}";
      $get_author = mysqli_query($connection, $author_query);
      confirmQuery($get_author);
      $edit_post_author = mysqli_fetch_assoc($get_author)['username'];
      $edit_post_author_id = $edit_post_user;
    }

    $query = "UPDATE posts SET ";
    $query .= "post_title = '{$edit_post_title}', ";
    $query .= "post_category_id = '{$edit_post_category_id}', ";
    $query .= "post_date = now(), ";
    $query .= "post_user = '{$edit_post_user}', ";
    $query .= "post_status = '{$edit_post_status}', ";
    $query .= "post_tags = '{$edit_post_tags}', ";
    $query .= "post_content = '{$edit_post_content}', ";
    $query .= "post_image = '{$edit_post_image}', ";
    $query .= !empty($edit_post_author) ? "post_author = '{$edit_post_author}', " : "";
    $query .= !empty($edit_post_author_id) ? "post_author_id = {$edit_post_author_id}, " : "";
    $query .= "post_views_count = 0 ";
    $query .= "WHERE post_id = {$post_id}";

    $update_post = mysqli_query($connection, $query);

    confirmQuery($update_post);
    header("Location: posts.php?source=edit_post&p_id={$post_id}&updated=success");
    exit;
  }
?>
<form action="" method="POST" enctype="multipart/form-data">

  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" class="form-control" name="title" value="<?php echo $post_title; ?>">
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
    <label for="user">Change Author</label>
    <select name="user" id="">
<?php

  $users_query = "SELECT * FROM users";
  $get_users = mysqli_query($connection, $users_query);
  confirmQuery($get_users);
  while($row = mysqli_fetch_assoc($get_users)){
    $username = $row['username'];
    $user_id = $row['user_id'];

    if ($user_id === $post_user) {
      echo "<option value={$user_id} selected>{$username}</option>";
    } else {
      echo "<option value={$user_id}>{$username}</option>";
    }
  }
?>
    </select>
  </div>
  <div class="form-group">
    <label for="post_status">Post Status</label>
    <select name="post_status">
<?php 
  if($post_status === "Draft"){
    echo "<option value='Draft' selected>Draft</option>
          <option value='Published'>Published</option>";
  } else {
    echo "<option value='Draft'>Draft</option>
          <option value='Published' selected>Published</option>";
  }

?>
    </select>
  </div>
  <div class="form-group">
    <img width=100 src="../images/<?php echo $post_image; ?>" alt="">
    <input type="file" class="form-control" name="image" value="<?php echo $post_image; ?>"">
  </div>
  <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
  </div>
  <div class="form-group">
    <label for="post_content">Post Content</label>
    <textarea class="form-control" id="body" name="post_content" cols="30" rows="10"><?php echo $post_content; ?></textarea>
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
  </div>
</form>
<?php } ?>