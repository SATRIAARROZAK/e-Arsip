<?php
    // Panggil fungsi upload
    include "config/function.php";

    // --- LOGIKA SIMPAN (Create/Update) ---
    if(isset($_POST['bsimpan']))
    {
        // 1. Amankan Inputan
        $no_surat         = mysqli_real_escape_string($koneksi, $_POST['no_surat']);
        $tanggal_surat    = mysqli_real_escape_string($koneksi, $_POST['tanggal_surat']);
        $tanggal_diterima = mysqli_real_escape_string($koneksi, $_POST['tanggal_diterima']);
        $perihal          = mysqli_real_escape_string($koneksi, $_POST['perihal']);
        $id_departemen    = mysqli_real_escape_string($koneksi, $_POST['id_departemen']);
        $id_pengirim      = mysqli_real_escape_string($koneksi, $_POST['id_pengirim']);

        // Cek Edit atau Baru
        if(isset($_GET['hal']) && $_GET['hal'] == "edit")
        {
            // --- LOGIKA EDIT ---
            // Cek apakah user ganti gambar/file
            if($_FILES['file']['error'] === 4){
                // Jika error 4 berarti user tidak upload file baru, pakai file lama
                $file = $vfile; 
            } else {
                // Jika user upload file baru
                $file = upload();
            }

            $ubah = mysqli_query($koneksi, "UPDATE tbl_arsip SET 
                                            no_surat         = '$no_surat',
                                            tanggal_surat    = '$tanggal_surat',
                                            tanggal_diterima = '$tanggal_diterima',
                                            perihal          = '$perihal',
                                            id_departemen    = '$id_departemen', 
                                            id_pengirim      = '$id_pengirim', 
                                            file             = '$file'  
                                            WHERE id_arsip   = '$_GET[id]'");
            
            if($ubah){
                echo "<script>alert('Ubah Data Sukses'); document.location='?halaman=arsip';</script>";
            } else {
                echo "<script>alert('Ubah Data Gagal: ".mysqli_error($koneksi)."');</script>";
            }            
        }
        else 
        {
            // --- LOGIKA SIMPAN BARU ---
            $file = upload(); 
            
            // Jika upload gagal/kosong, beri nilai default string kosong atau warning
            if(!$file){
                $file = ''; 
            }

            $query = "INSERT INTO tbl_arsip 
                      (no_surat, tanggal_surat, tanggal_diterima, perihal, id_departemen, id_pengirim, file) 
                      VALUES 
                      ('$no_surat', '$tanggal_surat', '$tanggal_diterima', '$perihal', '$id_departemen', '$id_pengirim', '$file')";
            
            $simpan = mysqli_query($koneksi, $query);

            if($simpan){
                echo "<script>alert('Simpan Data Sukses'); document.location='?halaman=arsip';</script>";
            } else {
                echo "<script>alert('Simpan Data Gagal! Error: ".mysqli_error($koneksi)."');</script>";
            }
        }
    }

    // --- LOGIKA TAMPIL DATA UNTUK EDIT ---
    $vno_surat = ""; $vtanggal_surat = ""; $vtanggal_diterima = ""; $vperihal = "";
    $vid_departemen = ""; $vnama_departemen = "Pilih Departemen";
    $vid_pengirim = ""; $vnama_pengirim = "Pilih Pengirim";
    $vfile = "";

    if(isset($_GET['hal']))
    {
        if($_GET['hal'] == "edit")
        {
            $tampil = mysqli_query($koneksi, "SELECT tbl_arsip.*, tbl_departemen.nama_departemen, tbl_pengirim_surat.nama_pengirim 
                                              FROM tbl_arsip 
                                              LEFT JOIN tbl_departemen ON tbl_arsip.id_departemen = tbl_departemen.id_departemen
                                              LEFT JOIN tbl_pengirim_surat ON tbl_arsip.id_pengirim = tbl_pengirim_surat.id_pengirim_surat 
                                              WHERE tbl_arsip.id_arsip='$_GET[id]'");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                $vno_surat = $data['no_surat'];
                $vtanggal_surat = $data['tanggal_surat'];
                $vtanggal_diterima = $data['tanggal_diterima'];
                $vperihal = $data['perihal'];
                $vid_departemen = $data['id_departemen'];
                $vnama_departemen = $data['nama_departemen']; // Mengambil nama departemen lama
                $vid_pengirim = $data['id_pengirim'];
                $vnama_pengirim = $data['nama_pengirim']; // Mengambil nama pengirim lama
                $vfile = $data['file'];
            }
        }
    }
?>

<div class="card mt-3">
  <div class="card-header" style="background-color: #f7d914;">
    Form Data Arsip Surat
  </div>
  <div class="card-body">
  <form method="post" action="" enctype="multipart/form-data" >
    
    <div class="form-group">
        <label for="no_surat">No Surat</label>
        <input type="text" class="form-control" id="no_surat" name="no_surat" value="<?=$vno_surat?>" required>
    </div>
    <div class="form-group">
        <label for="tanggal_surat">Tanggal Surat</label>
        <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" value="<?=$vtanggal_surat?>" required>
    </div>
    <div class="form-group">
        <label for="tanggal_diterima">Tanggal Diterima</label>
        <input type="date" class="form-control" id="tanggal_diterima" name="tanggal_diterima" value="<?=$vtanggal_diterima?>" required>
    </div>
    <div class="form-group">
        <label for="perihal">Perihal</label>
        <input type="text" class="form-control" id="perihal" name="perihal" value="<?=$vperihal?>" required>
    </div>
    
    <div class="form-group">
        <label for="id_departemen">Departemen / Tujuan</label>
        <select class="form-control" name="id_departemen" required>
            <option value="<?=$vid_departemen?>"><?=$vnama_departemen?></option>
            <?php
            $tampil = mysqli_query($koneksi, "SELECT * from tbl_departemen order by nama_departemen asc");
            while($data = mysqli_fetch_array($tampil)){
                echo "<option value='$data[id_departemen]'>$data[nama_departemen]</option>";
            }
            ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="id_pengirim">Pengirim Surat</label>
        <select class="form-control" name="id_pengirim" required>
            <option value="<?=$vid_pengirim?>"><?=$vnama_pengirim?></option>
            <?php
            $tampil = mysqli_query($koneksi, "SELECT * from tbl_pengirim_surat order by nama_pengirim asc");
            while($data = mysqli_fetch_array($tampil)){
                echo "<option value='$data[id_pengirim_surat]'>$data[nama_pengirim]</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="file">Pilih File (PDF/Gambar)</label>
        <input type="file" class="form-control" id="file" name="file">
        <?php if(!empty($vfile)): ?>
            <small class="text-danger">File saat ini: <?=$vfile?></small>
        <?php endif; ?>
    </div>

    <button type="submit" name="bsimpan" class="btn btn-success">Simpan</button>
    <a href="?halaman=arsip" class="btn btn-danger">Batal</a>
    </form>
  </div>
</div>