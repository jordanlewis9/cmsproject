<?php 
    include "includes/header.php";
    include "includes/db.php";
?>

    <!-- Navigation -->
<?php
    include "includes/navigation.php";
?>
    <!-- Page Content -->
    <div class="container">
<?php

    if(isset($_GET['signed_up'])){
        $message = $_GET['signed_up'];
        echo "<p class='bg-success'>$message</p>";
    }

    if(isset($_GET['signed_in'])){
        $message = $_GET['signed_in'];
        echo "<p class=bg-success'>$message</p>";
    }
?>
        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
            <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>
<?php
$query = "SELECT * FROM posts WHERE post_status = 'Published' ORDER BY post_date DESC";
$select_all_posts_query = mysqli_query($connection, $query);
if(!mysqli_fetch_assoc($select_all_posts_query)){
    echo "<h1 class='text-center'>Sorry, no posts are published yet!</h1>";
}
while($row = mysqli_fetch_assoc($select_all_posts_query)){
    $post_id = $row['post_id'];
    $post_title = $row['post_title'];
    $post_author = $row['post_author'];
    $post_author_id = $row['post_author_id'];
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
                    by <a href="author_posts.php?author=<?php echo $post_author_id; ?>"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
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