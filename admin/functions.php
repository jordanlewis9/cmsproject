<?php

function confirmQuery($result) {
  global $connection;
  if(!$result){
    die("QUERY FAILED" . mysqli_error($connection));
  }
}

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

  
function esc($escaped_value) {
  global $connection;
  return mysqli_real_escape_string($connection, trim($escaped_value));
}

function users_online() {

  if(isset($_GET['onlineusers'])){
    global $connection;
    if(!$connection){
      session_start();
      include("../includes/db.php");

      $session = session_id();
      $time = time();
      $time_out_in_seconds = 20;
      $time_out = $time - $time_out_in_seconds;
    
      $query = "SELECT * FROM users_online WHERE session = '{$session}'";
      $send_query = mysqli_query($connection, $query);
      $count = mysqli_num_rows($send_query);
    
      if($count === 0) {
          mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES ('{$session}', {$time})");
      } else {
          mysqli_query($connection, "UPDATE users_online SET time = {$time} WHERE session = '{$session}'");
      }
    
      $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > {$time_out}");
      echo mysqli_num_rows($users_online_query);
    }
  }
}

function get_table_count($table) {
  global $connection;
  $query = "SELECT * FROM {$table}";
  $select_all_posts = mysqli_query($connection, $query);
  confirmQuery($select_all_posts);
  return mysqli_num_rows($select_all_posts);
}

function get_precise_stats($table, $stat, $cat1, $cat2) {
  global $connection;

  $query = "SELECT {$stat}, COUNT({$stat}) AS num_items FROM {$table} GROUP BY {$stat}";
  $stat_query = mysqli_query($connection, $query);
  confirmQuery($stat_query);
  $count_1 = 0;
  $count_2 = 0;
  $count_3 = 0;
  while($row = mysqli_fetch_assoc($stat_query)){
      if($row["{$stat}"] === "{$cat1}"){
          $count_1  = $row['num_items'];
      } else if ($row["{$stat}"] === "{$cat2}") {
          $count_2 = $row['num_items'];
      } else {
        $count_3 = $row['num_items'];
      }
  }
  return [$count_1, $count_2, $count_3];
}

function echo_stat_widgets($stat, $count, $color){
  echo "<div class='col-lg-3 col-md-6'>
  <div class='panel panel-{$color}'>
      <div class='panel-heading'>
          <div class='row'>
              <div class='col-xs-3'>
                  <i class='fa fa-file-text fa-5x'></i>
              </div>
              <div class='col-xs-9 text-right'>
            <div class='huge'>$count</div>
                  <div>$stat</div>
              </div>
          </div>
      </div>
      <a href='{$stat}.php'>
          <div class='panel-footer'>
              <span class='pull-left'>View Details</span>
              <span class='pull-right'><i class='fa fa-arrow-circle-right'></i></span>
              <div class='clearfix'></div>
          </div>
      </a>
  </div>
</div>";
}

users_online();

?>