<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/cmsproject/index">Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
<?php
$query = "SELECT * FROM categories";
$select_all_categories_query = mysqli_query($connection, $query);
while($row = mysqli_fetch_assoc($select_all_categories_query)){
    $cat_title = $row['cat_title'];
    $cat_id = $row['cat_id'];
    $active_class = $_GET['name'] ?? null;
    if ($active_class === $cat_title){
        echo "<li class='active'><a href='/cmsproject/category/$cat_id/$cat_title'>{$cat_title}</a></li>";
    } else {
        echo "<li><a href='/cmsproject/category/$cat_id/$cat_title'>{$cat_title}</a></li>";
    }
}


?>
<?php if(!isLoggedIn()): ?>
                    <li>
                        <a href='/cmsproject/login'>Login</a>
                    </li>
<?php elseif ($_SESSION['user_role'] === 'Admin' || $_SESSION['user_role'] === 'Author'): ?>
                    <li>
                        <a href='admin'>Admin</a>
                    </li>
                    <li>
                        <a href='includes/logout.php'>Logout</a>
                    </li>
<?php else: ?>
                    <li>
                        <a href='/cmsproject/admin/profile.php'>Edit Profile</a>
                    </li>
                    <li>
                        <a href='includes/logout.php'>Logout</a>
                    </li>
<?php endif; ?>
                    <li>
                        <a href='/cmsproject/registration'>Register</a>
                    </li>
                    <li>
                        <a href="/cmsproject/contact">Contact</a>
                    </li>
<?php
    if(isset($_SESSION['user_role'])){
        $role = $_SESSION['user_role'];
        if(isset($_GET['p_id']) && $role === "Admin"){
            $the_post_id = esc($_GET['p_id']);
            echo "<li><a href='admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
        }
    }

    if(isset($_SESSION['username'])) {
        $user = $_SESSION['username'];
        echo "<li><a href=''>Howdy, $user</a></li>";
    }
?>
                    <!--<li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li> -->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>