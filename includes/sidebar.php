<?php
    if(ifItIsMethod('post')){
        if(isset($_POST['username']) && isset($_POST['password'])){
            $username = esc($_POST['username']);
            $password = esc($_POST['password']);
            login_user($username, $password);
        } else {
            redirect('/cmsproject/login');
        }
    }
?>
            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">


                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="POST">
                        <div class="input-group">
                            <input name="search" type="text" class="form-control">
                            <span class="input-group-btn">
                                <button name="submit" class="btn btn-default" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </form>
                    <!-- /.input-group -->
                </div>

                                <!-- Login -->
                <div class="well">
<?php if(isset($_SESSION['user_role'])): ?>
                    <h4>Logged in as <?php echo $_SESSION['username']; ?></h4>
                    <a href="includes/logout.php" class="btn btn-primary">Logout</a>
<?php else: ?>
                    <h4>Login</h4>
                    <form action="" method="POST">
                        <div class="form-group">
                            <input name="username" type="text" class="form-control" placeholder="Username">
                        </div>
                        <div class="input-group">
                            <input name="password" type="password" class="form-control" placeholder="Password">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" name="login" type="submit">Submit</button>
                            </span>
                        </div>
                        <div class="form-group">
                            <a href="forgot_password.php?forgot=<?php echo uniqid(true); ?>">Forgot Password?</a>
                        </div>
                    </form>
<?php endif; ?>
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->

<?php 
    $query = "SELECT * FROM categories";
    $select_categories_sidebar = mysqli_query($connection, $query);
?>
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
<?php 
    while($row = mysqli_fetch_assoc($select_categories_sidebar)){
        $cat_title = $row['cat_title'];
        $cat_id = $row['cat_id'];
        echo "<li><a href='category.php?category={$cat_id}'>{$cat_title}</a></li>";
    }
?>
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
<?php include "widget.php"; ?>

            </div>