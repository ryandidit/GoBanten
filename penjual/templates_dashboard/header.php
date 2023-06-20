<?php 
session_start();
require_once '../config/init.php';
// cek untuk menampilkan title yang sesuai dari tab menu
if (empty($_GET['page'])) {
  $title = "Dashboard";
}else{
  $title = $_GET['page'];
}
?>
<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $title; ?></title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <!-- Simple Sidebar -->
  <!-- Custom styles for this template -->
  <link href="<?php echo BASEURL; ?>assets/css/simple-sidebar.css" rel="stylesheet">
  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <!-- Input css modified -->
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>assets/css/style.css">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Righteous&display=swap" rel="stylesheet">
</head>
<body >



