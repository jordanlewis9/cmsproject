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
if(isset($_GET['category'])){
  $post_category_id = esc($_GET['category']);
} else {
    header("Location: index.php");
    exit;
}
if(is_admin($_SESSION['username'])){
    $user_role = $_SESSION['user_role'];
    // $query = "SELECT  FROM posts WHERE post_category_id = {$post_category_id} ORDER BY post_date DESC";

    $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content, post_status, cat_title FROM posts INNER JOIN categories ON post_category_id = cat_id WHERE post_category_id = ? ORDER BY post_date DESC");
} else {
    $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content, post_status, cat_title FROM posts INNER JOIN categories ON post_category_id = cat_id WHERE post_category_id = ? AND post_status = ? ORDER BY post_date DESC");
    $published = 'Published';
    // $query = "SELECT post_id, post_title, post_author, post_date, post_image, post_content, post_status FROM posts WHERE post_category_id = {$post_category_id} AND post_status = 'Published' ORDER BY post_date DESC";
}

if(isset($stmt1)){
    mysqli_stmt_bind_param($stmt1, "i", $post_category_id);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content, $post_status, $post_category);
    $stmt = $stmt1;
} else {
    mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content, $post_status, $post_category);
    $stmt = $stmt2;
}
mysqli_stmt_store_result($stmt);
echo "<h1 class='page-header'>{$post_category}</h1>";
if(mysqli_stmt_num_rows($stmt) === 0) {
    echo "<h1>Sorry, no posts are available under this category.</h1>";
}
while(mysqli_stmt_fetch($stmt)){
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
<?php }
    mysqli_stmt_close($stmt); ?>

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