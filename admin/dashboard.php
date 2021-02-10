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
    $post_count = get_table_count('posts');

    // COMMENTS QUERY
    $comment_count = get_table_count('comments');

    // USERS QUERY
    $users_count = get_table_count('users');

    // CATEGORIES QUERY
    $categories_count = get_table_count('categories');

?>
<div class="row">
<?php

$widgets = [['posts', $post_count, 'yellow'], ['comments', $comment_count, 'primary'], ['users', $users_count, 'green'], ['categories', $categories_count, 'danger']];
foreach ($widgets as $widget) {
    echo_stat_widgets($widget[0], $widget[1], $widget[2], $current_user_role);
}
?>
</div>
<?php
    $posts = get_precise_stats('posts', 'post_status', 'Published', 'Draft');
    $published_count = $posts[0];
    $draft_count = $posts[1];


    $comments = get_precise_stats('comments', 'comment_status', 'Approved', 'Unapproved');
    $approved_count = $comments[0];
    $unapproved_count = $comments[1];


    $users = get_precise_stats('users', 'user_role', 'Admin', 'Subscriber');
    $admin_count = $users[0];
    $sub_count = $users[1];

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