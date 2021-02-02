<div class="row">
                  <div class="col-xs-6">
                    <form action="" method="POST">
                      <div class="form-group">
                        <label for="cat_title">Edit Category</label>
<?php
  if(isset($_GET['edit'])){
    $edit_cat_id = esc($_GET['edit']);
    $query = "SELECT * FROM categories WHERE cat_id = {$edit_cat_id}";
    $edit_category_id = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($edit_category_id)){
      $edit_cat_id = $row['cat_id'];
      $edit_cat_title = $row['cat_title'];
?>
                        <input value="<?php if(isset($edit_cat_title)) echo $edit_cat_title; ?>" class="form-control" type="text" name="cat_title">
<?php }} ?>
<?php
  if(isset($_POST['update'])){
    $edit_cat_title = esc($_POST['cat_title']);
    $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ?");
    mysqli_stmt_bind_param($stmt, "si", $edit_cat_title, $edit_cat_id);
    mysqli_stmt_execute($stmt);
    if(!$stmt){
      die('QUERY FAILED ' . mysqli_error($connection));
    } else {
      header('Location: categories.php');
      exit;
    }
  }
?>
                      </div>
                      <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="update" value="Update">
                      </div>
                    </form>
                  </div> <!--Add Category Form -->
                </div>