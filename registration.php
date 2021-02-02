<?php  include "includes/header.php"; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $username = esc($_POST['username']);
        $email = esc($_POST['email']);
        $password = esc($_POST['password']);

        $error = [];

        if(strlen($username) < 4) {
            $error['username'] = 'Username needs to be at least 4 characters';
        }
        if($username === '') {
            $error['username'] = 'Username cannot be empty';
        }
        if(username_exists($username)){
            $error['username'] = 'Username already exists, please choose another';
        }
        if($email === ''){
            $error['email'] = 'Email cannot be empty';
        }
        if(email_exists($email)){
            $error['email'] = 'Email is already in use, please use another or <a href="index.php">login here</a>';
        }
        if(strlen($password) < 4) {
            $error['password'] = 'Password needs to be at least 4 characters';
        }
        if($password === ''){
            $error['password'] = 'Password cannot be empty.';
        }

        if(count($error) === 0){
            register_user($username, $email, $password);
            login_user($username, $password, true);
        }
    }


?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" 
                            placeholder="Enter Desired Username" autocomplete="on" 
                            value="<?php echo isset($username) ? $username : ''; ?>" required>
                            <p><?php echo isset($error['username']) ? $error['username'] : ''; ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" 
                            placeholder="somebody@example.com" autocomplete="on" 
                            value="<?php echo isset($email) ? $email : ''; ?>" required>
                            <p><?php echo isset($error['email']) ? $error['email'] : ''; ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password" required>
                            <p><?php echo isset($error['password']) ? $error['password'] : ''; ?></p>
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
