<?php
session_start();
// mengatasi jika user langsung masuk menggunakan link, tanpa login
if(empty($_SESSION['id_user']) or empty($_SESSION['username']))
{
  echo "<script>
            alert('Maaf, untuk mengakses halaman ini, silahkan login terlebih dahulu...!');
            document.location='index.php';
          </script>";
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <title>E-Arsip KUA</title>
  </head>
  <body>
    <!-- Awal Menu -->
    <nav class="navbar navbar-expand-lg navbar-dark" style=" background: linear-gradient(
    90deg,
    rgba(25, 46, 51, 1) 0%,
    rgba(6, 194, 84, 1) 50%,
    rgba(255, 255, 255, 1) 100%
  );">
    <div class="container">
    <img src="assets/img/oxxo.png" height="50" >
      <a class="navbar-brand" href="#">e-Arsip</a>
     

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
       
        <ul class="navbar-nav mr-auto">
    
  
    <?php if(@$_SESSION['level'] == 'admin'): ?>
        <li class="nav-item active">
            <a class="nav-link" href="?">Dashboard <span class="sr-only">(current)</span></a>
         </li>
        <li class="nav-item">
            <a class="nav-link" href="?halaman=instansi">Data Instansi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?halaman=surat-masuk">Pengirim Surat</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?halaman=arsip">Arsip Surat</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?halaman=user">Manajemen User</a>
        </li>
         <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>

    <?php endif; ?>

    <?php if(@$_SESSION['level'] == 'direktur'): ?>
         <li class="nav-item active">
              <a class="nav-link" href="?">Dashboard<span class="sr-only">(current)</span></a>
            </li>      
         <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
       
    <?php endif; ?>
</ul>
       
      </div>
    </div>

  </nav>
  <!-- Akhir Menu -->
  <!-- awal Container -->
  <div class= "container">