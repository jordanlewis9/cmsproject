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
if(isset($_GET['p_id'])){
    $post_id = esc($_GET['p_id']);
} else {
    header("Location: ../index");
    exit;
}

if(isset($_SESSION['user_id'])){
    $current_user = $_SESSION['user_id'];
} else {
    $current_user = false;
}

if($current_user){
    $check_user_like_query = "SELECT * FROM likes WHERE user_id = {$current_user} AND post_id = {$post_id}";
    $run_check_user_like_query = mysqli_query($connection, $check_user_like_query);
    confirmQuery($run_check_user_like_query);
    $did_user_like = mysqli_num_rows($run_check_user_like_query);
}


if(isset($_POST['liked'])) {
    if(!$current_user){
        exit();
    }
    if($did_user_like >= 1){
        exit();
    } 
    $like_post_id = $_POST['post_id'];
    $like_user_id = $_POST['user_id'];
    //1 SELECT POST
    $search_post = "SELECT * FROM posts WHERE post_id = {$like_post_id}";
    $post_result = mysqli_query($connection, $search_post);
    confirmQuery($post_result);
    $liked_post = mysqli_fetch_array($post_result);
    $likes = $liked_post['likes'];

    //2 UPDATE post with likes
    $add_liked_post_query = "UPDATE posts SET likes = {$likes} + 1 WHERE post_id = {$like_post_id}";
    $added_like_result = mysqli_query($connection, $add_liked_post_query);
    confirmQuery($added_like_result);
    //3 create likes for post
    $place_into_likes_query = "INSERT INTO likes (user_id, post_id) VALUES ({$like_user_id}, {$like_post_id})";
    $save_to_likes = mysqli_query($connection, $place_into_likes_query);
    confirmQuery($save_to_likes);
    redirect("/cmsproject/post/{$like_post_id}");
}

if(isset($_POST['unliked'])){
    if(!$current_user){
        exit();
    }
    if($did_user_like === 0){
        exit();
    }
    $unlike_post_id = $_POST['post_id'];
    $unlike_user_id = $_POST['user_id'];
    $search_post = "SELECT * FROM posts WHERE post_id = {$unlike_post_id}";
    $post_result = mysqli_query($connection, $search_post);
    confirmQuery($post_result);
    $unliked_post = mysqli_fetch_array($post_result);
    $likes = $unliked_post['likes'];

    $add_unliked_post_query = "UPDATE posts SET likes = {$likes} - 1 WHERE post_id = {$unlike_post_id}";
    $added_unlike_result = mysqli_query($connection, $add_unliked_post_query);
    confirmQuery($added_unlike_result);
    $take_away_from_likes_query = "DELETE FROM likes WHERE user_id = {$unlike_user_id} AND post_id = {$unlike_post_id}";
    $delete_from_likes = mysqli_query($connection, $take_away_from_likes_query);
    confirmQuery($delete_from_likes);
    redirect("/cmsproject/post/{$unlike_post_id}");
}

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin') {
    $user_role = $_SESSION['user_role'];
    $query = "SELECT * FROM posts WHERE post_id = {$post_id}";
} else {
    $query = "SELECT * FROM posts WHERE post_id = {$post_id} AND post_status = 'Published'";
}

$select_all_posts_query = mysqli_query($connection, $query);

if (mysqli_num_rows($select_all_posts_query) === 0) {
    header("Location: ../index");
    exit;
}

$query = "SELECT * FROM posts WHERE post_id = {$post_id}";
$select_all_posts_query = mysqli_query($connection, $query);
while($row = mysqli_fetch_assoc($select_all_posts_query)){
    $post_title = $row['post_title'];
    $post_author = $row['post_author'];
    $post_date = $row['post_date'];
    $post_image = $row['post_image'];
    $post_content = $row['post_content'];
    $post_status = $row['post_status'];
    $post_likes = $row['likes'];
?>

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="../index"><?php echo $post_author; ?></a>
                </p>
<?php 
    if(!empty($user_role)) {
        echo "<h4>$post_status</h4><hr>";
    }
?>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="/cmsproject/images/<?php echo imagePlaceholder($post_image); ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                <hr>
<?php if(!$current_user): ?>
                <div class="row">
                    <p class="pull-right">You must be logged in to like this post. <a href="/cmsproject/login">Login here.</a></p>
                </div>
<?php elseif($did_user_like === 0): ?>
                <div class="row">
                    <p class="pull-right"><a href="" class="like"><span class="glyphicon glyphicon-thumbs-up" data-toggle="tooltip" data-placement="top" title="Like it?"></span> Like</a></p>
                </div>
<?php else: ?>
                <div class="row">
                    <p class="pull-right"><a href="" class="unlike"><span class="glyphicon glyphicon-thumbs-down" data-toggle="tooltip" data-placement="top" title="You liked this previously"></span> Unlike</a></p>
                </div>
<?php endif; ?>
                <div class="row">
                    <p class="pull-right">Like: <?php echo $post_likes; ?></p>
                </div>
                <div class="clearfix"></div>
<?php } ?>

<?php 
$view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $post_id";
$updated_views = mysqli_query($connection, $view_query);

if(!$updated_views){
    die('QUERY FAILED WITH UPDATING VIEWS' . mysqli_error($connection));
}
?>

                <!-- Blog Comments -->
<?php
    if(isset($_POST['create_comment'])){
        $comment_post_id = esc($_GET['p_id']);
        $comment_author = esc($_POST['comment_author']);
        $comment_email = esc($_POST['comment_email']);
        $comment_content = esc($_POST['comment_content']);

        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
            $query .= "VALUES ($comment_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'Unapproved', now())";
    
            $create_comment_query = mysqli_query($connection, $query);
            if(!$create_comment_query){
                die('QUERY FAILED ' . mysqli_error($connection));
            } else {
                // $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                // $query .= "WHERE post_id = $comment_post_id";
                // $update_comment_count = mysqli_query($connection, $query);
                header("Location: post.php?p_id={$comment_post_id}");
                exit;
            }
        } else {
            echo "<script>alert('Fields cannot be empty!')</script>";
        }

    }

?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="Author">Author</label>
                            <input type="text" name="comment_author" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" name="comment_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="Comment">Your Comment</label>
                            <textarea class="form-control" rows="3" name="comment_content"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
<?php
    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id AND comment_status = 'approved' ORDER BY comment_id DESC";
    $select_comment_query = mysqli_query($connection, $query);
    if(!$select_comment_query){
        die('QUERY FAILED ' . mysqli_error($connection));
    }
    while($row = mysqli_fetch_assoc($select_comment_query)){
        $comment_date = $row['comment_date'];
        $comment_content = $row['comment_content'];
        $comment_author = $row['comment_author'];

?>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>
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

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    var postId = <?php echo $post_id; ?>;
    var userId = <?php echo $current_user; ?>;
    $('.like').click(function(e){
        $.ajax({
            url: `/cmsproject/post.php?p_id=${postId}`,
            type: 'post',
            data: {
                'liked': 1,
                'post_id': postId,
                'user_id': userId
            }
        })
    })
    $('.unlike').click(function(e){
        $.ajax({
            url: `/cmsproject/post.php?p_id=${postId}`,
            type: 'post',
            data: {
                'unliked': 1,
                'post_id': postId,
                'user_id': userId
            }
        })
    })
})
</script>