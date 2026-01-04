<?php
    // Hitung Jumlah Data untuk Statistik
    $count_arsip = mysqli_fetch_array(mysqli_query($koneksi, "SELECT count(*) as total FROM tbl_arsip"));
    $count_dep   = mysqli_fetch_array(mysqli_query($koneksi, "SELECT count(*) as total FROM tbl_departemen"));
    $count_peng  = mysqli_fetch_array(mysqli_query($koneksi, "SELECT count(*) as total FROM tbl_pengirim_surat"));
?>

<div class="jumbotron mt-3">
  <h1 class="display-4">Selamat Datang, <?=$_SESSION['nama_lengkap']?>!</h1>
  <p class="lead">Anda login sebagai <b>Direktur</b>. Berikut adalah laporan statistik E-Arsip.</p>
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

  <div class="card mt-4">
      <div class="card-header">5 Arsip Surat Terbaru</div>
      <div class="card-body">
          <table class="table table-bordered">
              <tr>
                  <th>No Surat</th>
                  <th>Perihal</th>
                  <th>Departemen</th>
                  <th>Tanggal</th>
                  <th>File</th>
              </tr>
              <?php
                $query = mysqli_query($koneksi, "SELECT tbl_arsip.*, tbl_departemen.nama_departemen 
                                                 FROM tbl_arsip 
                                                 JOIN tbl_departemen ON tbl_arsip.id_departemen = tbl_departemen.id_departemen 
                                                 ORDER BY id_arsip DESC LIMIT 5");
                while($d = mysqli_fetch_array($query)):
              ?>
              <tr>
                  <td><?=$d['no_surat']?></td>
                  <td><?=$d['perihal']?></td>
                  <td><?=$d['nama_departemen']?></td>
                  <td><?=$d['tanggal_surat']?></td>
                  <td>
                      <?php if(!empty($d['file'])): ?>
                        <a href="file/<?=$d['file']?>" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
                      <?php endif; ?>
                  </td>
              </tr>
              <?php endwhile; ?>
          </table>
      </div>
  </div>
</div>