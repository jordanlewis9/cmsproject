<?php
error_reporting(E_ALL);
  if(isset($_POST['create_post'])){
    $post_title = esc($_POST['title']);
    // $post_author = $_POST['author'];
    $post_author_id = esc($_POST['author']);
    $post_category_id = esc($_POST['post_category_id']);
    $post_status = esc($_POST['post_status']);

    $post_image = esc($_FILES['image']['name']);
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags = esc($_POST['post_tags']);
    $post_content = esc($_POST['post_content']);
    $post_date = date('d-m-y');

    move_uploaded_file($post_image_temp, "../images/$post_image");

    if ($post_status === "Published") {
      $author_query = "SELECT username FROM users WHERE user_id = {$post_author_id}";
      $get_author = mysqli_query($connection, $author_query);
      confirmQuery($get_author);
      $post_author = mysqli_fetch_assoc($get_author)['username'];
      $query = "INSERT INTO posts (post_category_id, post_title, post_date, post_image, post_content, 
      post_tags, post_status, post_author, post_author_id) VALUES ({$post_category_id}, '{$post_title}', 
      now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}', '{$post_author}', {$post_author_id})";
    } else {
      $query = "INSERT INTO posts (post_category_id, post_title, post_date, post_image, post_content, 
      post_tags, post_status, post_author, post_author_id) VALUES ({$post_category_id}, '{$post_title}', 
      now(), '{$post_image}', '{$post_content}', '{$post_tags}', 'Draft', '{$_SESSION['username']}', {$post_author_id})";
    }

    $create_post_query = mysqli_query($connection, $query);

    confirmQuery($create_post_query);
    $new_post_id = mysqli_insert_id($connection);
    header("Location: posts.php?post_status={$post_status}&new_post_id={$new_post_id}");
    exit;

  }


?>

<form action="" method="POST" enctype="multipart/form-data">

  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" class="form-control" name="title">
  </div>
  <div class="form-group">
    <label for="post_category_id">Category</label>
    <select name="post_category_id">
<?php 
  $query = "SELECT * FROM categories";
  $all_categories = mysqli_query($connection, $query);

  confirmQuery($all_categories);
  while($row = mysqli_fetch_assoc($all_categories)){
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];
    echo "<option value={$cat_id}>{$cat_title}</option>";
  }
?>
    </select>
  </div>
  <!-- <div class="form-group">
    <label for="author">Post Author</label>
    <input type="text" class="form-control" name="author">
  </div> -->
  <div class="form-group">
  <label for="author">Author</label>
  <select name="author">
<?php
  if($current_user_role === 'Admin'){
    $query = "SELECT * FROM users WHERE user_role = 'Admin' OR user_role = 'Author'";
    $all_users = mysqli_query($connection, $query);
  
    confirmQuery($all_users);
    while($row = mysqli_fetch_assoc($all_users)){
      $user_id = $row['user_id'];
      $username = $row['username'];
      echo "<option value={$user_id}>{$username}</option>";
    }
  } else {
    echo "<option value={$current_user_id} selected>{$_SESSION['username']}</option>";
  }
?>
  </select>
  </div>
  <div class="form-group">
    <label for="post_status">Post Status</label>
    <select name="post_status">
<?php if($current_user_role === 'Admin'){
  echo "<option value='Draft'>Draft</option>
  <option value='Published'>Published</option>";
} else {
  echo "<option value='Draft' selected>Draft</option>";
}
?>
    </select>
  </div>
  <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" class="form-control" name="image">
  </div>
  <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input type="text" class="form-control" name="post_tags">
  </div>
  <div class="form-group">
    <label for="post_content">Post Content</label>
      <textarea class="form-control" id="body" name="post_content" cols="30" rows="10" ></textarea>
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="create_post" value="Submit Post">
  </div>
</form>