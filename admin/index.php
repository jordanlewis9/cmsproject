<?php include "includes/admin_header.php"; ?>

    <div id="wrapper">

<?php

    $count_users = users_online();

?>

        <!-- Navigation -->
<?php include "includes/admin_navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                       
                <!-- /.row -->
                
<?php
    // POSTS QUERY
    $query = "SELECT * FROM posts";
    $select_all_posts = mysqli_query($connection, $query);
    $post_count = mysqli_num_rows($select_all_posts);

    // COMMENTS QUERY
    $query = "SELECT * FROM comments";
    $select_all_comments = mysqli_query($connection, $query);
    $comment_count = mysqli_num_rows($select_all_comments);

    // USERS QUERY
    $query = "SELECT * FROM users";
    $select_all_users = mysqli_query($connection, $query);
    $users_count = mysqli_num_rows($select_all_users);

    // CATEGORIES QUERY
    $query = "SELECT * FROM categories";
    $select_all_categories = mysqli_query($connection, $query);
    $categories_count = mysqli_num_rows($select_all_categories);

?>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                  <div class='huge'><?php echo $post_count; ?></div>
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                     <div class='huge'><?php echo $comment_count; ?></div>
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <div class='huge'><?php echo $users_count; ?></div>
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class='huge'><?php echo $categories_count; ?></div>
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<?php
    $query = "SELECT post_status, COUNT(post_status) AS num_posts FROM posts GROUP BY post_status";
    $select_all_draft_posts = mysqli_query($connection, $query);
    confirmQuery($select_all_draft_posts);
    $published_count = 0;
    $draft_count = 0;
    while($row = mysqli_fetch_assoc($select_all_draft_posts)){
        if($row['post_status'] === 'Published'){
            $published_count  = $row['num_posts'];
        } else {
            $draft_count = $row['num_posts'];
        }
    }

    $query = "SELECT comment_status, COUNT(comment_status) AS num_comments FROM comments GROUP BY comment_status";
    $all_comments_query = mysqli_query($connection, $query);
    confirmQuery($all_comments_query);
    $approved_count = 0;
    $unapproved_count = 0;
    while($row = mysqli_fetch_assoc($all_comments_query)){
        if($row['comment_status'] === 'Approved'){
            $approved_count  = $row['num_comments'];
        } else {
            $unapproved_count = $row['num_comments'];
        }
    }

    $query = "SELECT user_role, COUNT(user_role) AS num_users FROM users GROUP BY user_role";
    $user_role_query = mysqli_query($connection, $query);
    confirmQuery($user_role_query);
    $admin_count = 0;
    $sub_count = 0;
    while($row = mysqli_fetch_assoc($user_role_query)){
        if($row['user_role'] === 'Admin'){
            $admin_count  = $row['num_users'];
        } else {
            $sub_count = $row['num_users'];
        }
    }
?>
                <!-- /.row -->
                <div class="row">
                <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Count'],
          <?php
            $element_text = ['Published Posts', 'Posts in Draft', 'Approved Comments', 'Unapproved Comments', 'Admins', 'Subscribers', 'Categories'];
            $element_count = [$published_count, $draft_count, $approved_count, $unapproved_count, $admin_count, $sub_count, $categories_count];

            for($i = 0; $i < count($element_text); $i++){
                echo "['{$element_text[$i]}', {$element_count[$i]}],";
            }
          ?>
        //   ['Posts', 1000],
        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          },
          colors: ['green', 'blue', 'green']
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php"; ?>