<?php
    // Hitung Jumlah Data untuk Statistik
    $count_arsip = mysqli_fetch_array(mysqli_query($koneksi, "SELECT count(*) as total FROM tbl_arsip"));
    $count_dep   = mysqli_fetch_array(mysqli_query($koneksi, "SELECT count(*) as total FROM tbl_departemen"));
    $count_peng  = mysqli_fetch_array(mysqli_query($koneksi, "SELECT count(*) as total FROM tbl_pengirim_surat"));
?>

<div class="jumbotron mt-3">
 
  <h1 class="display-4">Selamat Datang, <?=$_SESSION['nama_lengkap']?>!</h1>
  <p class="lead">Anda login sebagai <b>Admin</b>. Berikut adalah laporan statistik E-Arsip.</p>
  <hr class="my-4">
  
  <div class="row">
      <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
          <div class="card-header">Total Arsip Surat</div>
          <div class="card-body">
            <h1 class="card-title"><?=$count_arsip['total']?></h1>
            <p class="card-text">Dokumen tersimpan.</p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
          <div class="card-header">Total Instansi</div>
          <div class="card-body">
            <h1 class="card-title"><?=$count_dep['total']?></h1>
            <p class="card-text">Instansi terdaftar.</p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
          <div class="card-header">Total Pengirim</div>
          <div class="card-body">
            <h1 class="card-title"><?=$count_peng['total']?></h1>
            <p class="card-text">Instansi pengirim terdata.</p>
          </div>
        </div>
      </div>
</div>