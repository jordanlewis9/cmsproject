<table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Author</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Status</th>
                          <th>Image</th>
                          <th>Tags</th>
                          <th>Comments</th>
                          <th>Date</th>
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
          <td>{$post_id}</td>
          <td>{$post_author}</td>
          <td>{$post_title}</td>";
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
          <td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>
          <td><a href='posts.php?delete={$post_id}'>Delete</a></td>
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