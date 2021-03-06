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
                            Welcome, <?php echo $_SESSION['username']; ?>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                       
                <!-- /.row -->
                
<?php
    // POSTS QUERY
    $post_count = get_user_table_count('posts', $current_user_id);

    // COMMENTS QUERY
    $comment_count = get_user_table_count('comments', $current_user_id);

?>
<div class="row">
<?php

$widgets = [['posts', $post_count, 'yellow'], ['comments', $comment_count, 'primary']];
foreach ($widgets as $widget) {
    echo_stat_widgets($widget[0], $widget[1], $widget[2], $current_user_role);
}
?>
</div>
<?php
    $posts = get_precise_user_stats('post_status', 'posts', $current_user_id, 'Published', 'Draft');
    $published_count = $posts[0];
    $draft_count = $posts[1];


    $comments = get_precise_user_stats('comment_status', 'comments', $current_user_id, 'Approved', 'Unapproved');
    $approved_count = $comments[0];
    $unapproved_count = $comments[1];

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
            $element_text = ['Published Posts', 'Posts in Draft', 'Approved Comments', 'Unapproved Comments'];
            $element_count = [$published_count, $draft_count, $approved_count, $unapproved_count];

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