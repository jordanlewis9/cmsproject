<?php

  function insert_categories() {
    global $connection;
    if(isset($_POST['submit'])){
      $post_cat_title = $_POST['cat_title'];
      if($post_cat_title === "" || empty($post_cat_title)){
        echo "This field should not be empty";
      } else {
        $query = "INSERT INTO categories(cat_title) VALUES ('{$post_cat_title}')";
        $create_category_query = mysqli_query($connection, $query);
  
        if(!$create_category_query){
          die('QUERY FAILED' . mysqli_error($connection));
        } else {
          header("Location: categories.php");
          exit;
        }
      }
    }
  }

  function delete_category() {
    global $connection;
    if(isset($_GET['delete'])){
      $delete_cat_id = $_GET['delete'];
      $query = "DELETE FROM categories WHERE cat_id = {$delete_cat_id}";
      $delete_category_query = mysqli_query($connection, $query);
  
      if(!$delete_category_query){
        die('QUERY FAILED' . mysqli_error($connection));
      } else {
        header("Location: categories.php");
        exit;
      }
    }
  }

  function render_table() {
    global $connection;
    $query = "SELECT * FROM categories ORDER BY cat_id";
    $select_admin_categories = mysqli_query($connection, $query);
    if(!$select_admin_categories){
      die("There was an error " . mysqli_error($connection));
    }
    while($row = mysqli_fetch_assoc($select_admin_categories)){
      $get_cat_id = $row['cat_id'];
      $get_cat_title = $row['cat_title'];
      echo "<tr>
      <td>{$get_cat_id}</td>
      <td>{$get_cat_title}</td>
      <td><a href='categories.php?delete={$get_cat_id}'>Delete</a></td>
      <td><a href='categories.php?edit={$get_cat_id}'>Edit</a></td>
    </tr>";
    }
  }

?>