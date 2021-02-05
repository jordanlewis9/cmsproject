<?php  include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>

<?php

  if(!isset($_GET['email']) && !isset($_GET['token'])){
    redirect('index');
  }

  $email = $_GET['email'];
  $token = $_GET['token'];
  if($stmt = mysqli_prepare($connection, "SELECT username, user_email, token FROM users WHERE user_email = ? AND token = ?")){
    mysqli_stmt_bind_param($stmt, "ss", $_GET['email'], $_GET['token']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if(mysqli_stmt_num_rows($stmt) === 0){
      redirect("index");
    }
    mysqli_stmt_bind_result($stmt, $username, $user_email, $token);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    if(isset($_POST['password']) && isset($_POST['password-confirm'])){
      $password = esc($_POST['password']);
      $confirmPassword = esc($_POST['password-confirm']);
      if($password !== $confirmPassword){
        redirect("index");
      }
    }
  } else {
    mysqli_error($connection);
  }
?>



<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Reset Password</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="password" name="password" placeholder="Enter Password" class="form-control"  type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="password-confirm" name="password-confirm" placeholder="Confirm Password" class="form-control"  type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

