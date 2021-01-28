<?php 
    include "includes/header.php";
?>

    <!-- Navigation -->
<?php
    include "includes/navigation.php";
?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

<?php
if(isset($_GET['category']) && isset($_GET['name'])){
  $post_category_id = esc($_GET['category']);
  $category_name = esc($_GET['name']);
} else {
    header("Location: index.php");
    exit;
}
echo "<h1 class='page-header'>$category_name</h1>";
if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'){
    $user_role = $_SESSION['user_role'];
    $query = "SELECT * FROM posts WHERE post_category_id = {$post_category_id} ORDER BY post_date DESC";
} else {
    $query = "SELECT * FROM posts WHERE post_category_id = {$post_category_id} AND post_status = 'Published' ORDER BY post_date DESC";
}
$select_all_posts_query = mysqli_query($connection, $query);
if(mysqli_num_rows($select_all_posts_query) === 0) {
    echo "<h1>Sorry, no posts are available under this category.</h1>";
}
while($row = mysqli_fetch_assoc($select_all_posts_query)){
    $post_id = $row['post_id'];
    $post_title = $row['post_title'];
    $post_author = $row['post_author'];
    $post_date = $row['post_date'];
    $post_image = $row['post_image'];
    $post_content = $row['post_content'];
    $post_status = $row['post_status'];
    if(strlen($post_content) > 100){
      $post_content = substr($post_content, 0, 100) . "...";
  }

?>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
<?php
    if (!empty($user_role)) {
        echo "<h4>$post_status</h4><hr>";
    }
?>
                <a href="post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src="./images/<?php echo $post_image; ?>" alt=""></a>
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
<?php } ?>

            </div>

<?php 
    include "includes/sidebar.php";
?>

        </div>
        <!-- /.row -->

        <hr>
<?php
    include "includes/footer.php";
?>