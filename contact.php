<?php  include "includes/header.php"; ?>
<?php
    if(isset($_POST['submit'])){
      $to = "ohsnapzbrah@live.com";
      $from = $_POST['email'];
      $subject = $_POST['subject'];
      $body = $_POST['body'];
      
      $body = wordwrap($body, 70);
      $headers = array(
          "From" => $from,
          "Reply-To" => $from
          );
      
      mail($to, $subject, $body, $headers);

          header("Location: index.php?signed_up={$message}");
          exit;
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
                <h1>Contact</h1>
                    <form role="form" action="" method="post" id="contact-form" autocomplete="off">
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" required>
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" required>
                        </div>
                         <div class="form-group">
                            <textarea class="form-control" name="body" id="body" rows=10 cols=50></textarea>
                        </div>
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
