<?php ob_start(); ?>
<?php include "../includes/db.php"; ?>
<?php include "functions.php"; ?>
<?php session_start(); ?>
<?php
    if(!isset($_SESSION['user_role'])) {
        header("Location: /cmsproject/index");
    } else {
        $current_user_role = $_SESSION['user_role'];
        $current_user_id = $_SESSION['user_id'];
    }

    $current_url = $_SERVER['PHP_SELF'];
    $current_basename = basename($current_url);

    if($current_user_role === 'Subscriber' && $current_basename !== 'profile.php'){
        redirect("/cmsproject/index");
    }

    $author_prohibited_urls = ["categories.php", "comments.php", "dashboard.php", "users.php"];

    if($current_user_role === 'Author'){
        foreach($author_prohibited_urls as $cur_url){
            if($current_basename === $cur_url){
                redirect("/cmsproject/index");
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <link rel="stylesheet" href="css/styles.css">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
