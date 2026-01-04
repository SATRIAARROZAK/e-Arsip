<?php
    // --- LOGIKA SIMPAN / EDIT DATA ---
    if(isset($_POST['bsimpan']))
    {
        // 1. Amankan Input
        $nama_pengirim = mysqli_real_escape_string($koneksi, $_POST['nama_pengirim']);
        $alamat        = mysqli_real_escape_string($koneksi, $_POST['alamat']);
        $no_hp         = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
        $email         = mysqli_real_escape_string($koneksi, $_POST['email']);

        // Cek Edit atau Baru
        if(isset($_GET['hal']) && $_GET['hal'] == "edit"){
            
            // --- QUERY UPDATE ---
            $ubah = mysqli_query($koneksi, "UPDATE tbl_pengirim_surat SET 
                                            nama_pengirim = '$nama_pengirim',
                                            alamat        = '$alamat',
                                            no_hp         = '$no_hp',
                                            email         = '$email' 
                                            WHERE id_pengirim_surat = '$_GET[id]'");
            if($ubah){
                echo "<script>alert('Ubah Data Sukses'); document.location='?halaman=surat-masuk';</script>";
            } else {
                echo "<script>alert('Ubah Gagal: ".mysqli_error($koneksi)."');</script>";
            }            
        }
        else
        {
            // --- QUERY SIMPAN BARU ---
            // PENTING: Kolom id_pengirim_surat (Auto Increment) tidak perlu ditulis disini
            $query = "INSERT INTO tbl_pengirim_surat (nama_pengirim, alamat, no_hp, email) 
                      VALUES ('$nama_pengirim', '$alamat', '$no_hp', '$email')";
            
            $simpan = mysqli_query($koneksi, $query);

            if($simpan){
                echo "<script>alert('Simpan Data Sukses'); document.location='?halaman=surat-masuk';</script>";
            } else {
                echo "<script>alert('Simpan Gagal: ".mysqli_error($koneksi)."');</script>";
            }
        }
    }

    // --- PERSIAPAN VARIABEL AGAR TIDAK ERROR ---
    $vnama_pengirim = "";
    $valamat        = "";
    $vno_hp         = "";
    $vemail         = "";

    // --- LOGIKA TAMPIL DATA EDIT / HAPUS ---
    if(isset($_GET['hal']))
    {
        if($_GET['hal'] == "edit")
        {
            $tampil = mysqli_query($koneksi, "SELECT * FROM tbl_pengirim_surat WHERE id_pengirim_surat='$_GET[id]'");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                $vnama_pengirim = $data['nama_pengirim'];
                $valamat        = $data['alamat'];
                $vno_hp         = $data['no_hp'];
                $vemail         = $data['email'];
            }
        }
        elseif($_GET['hal'] == "hapus") // PENTING: Pakai elseif
        {
            $hapus = mysqli_query($koneksi, "DELETE FROM tbl_pengirim_surat WHERE id_pengirim_surat='$_GET[id]'");
            if($hapus){
                echo "<script>alert('Hapus Data Sukses'); document.location='?halaman=surat-masuk';</script>";
            } else {
                echo "<script>alert('Hapus Gagal: ".mysqli_error($koneksi)."');</script>";
            }
        }
    }
?>

<div class="card mt-3">
  <div class="card-header" style="background-color: #f0c001;">
    Form Data Pengirim Surat
  </div>
  <div class="card-body">
  <form method="post" action="">
    <div class="form-group">
        <label for="nama_pengirim">Nama Pengirim</label>
        <input type="text" class="form-control" id="nama_pengirim" name="nama_pengirim" value="<?=$vnama_pengirim?>" required>
    </div>
    <div class="form-group">
        <label for="alamat">Alamat</label>
        <input type="text" class="form-control" id="alamat" name="alamat" value="<?=$valamat?>" required>
    </div>
    <div class="form-group">
        <label for="no_hp">No. HP</label>
        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?=$vno_hp?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?=$vemail?>" required>
    </div>

    <button type="submit" name="bsimpan" class="btn btn-success">Simpan</button>
    <a href="?halaman=surat-masuk" class="btn btn-danger">Batal</a>
    </form>
  </div>
</div>

<div class="card mt-3">
  <div class="card-header" style="background-color: #f7d914;">
    Data Pengirim Surat
  </div>
  <div class="card-body">
  <table class="table table-bordered table-hover table-striped">
    <tr>
        <th>No</th>
        <th>Nama Pengirim Surat</th>
        <th>Alamat</th>
        <th>No HP</th>
        <th>Email</th>
        <th>Aksi</th>
    </tr>
    <?php
        $tampil = mysqli_query($koneksi, "SELECT * FROM tbl_pengirim_surat ORDER BY id_pengirim_surat DESC");
        $no = 1;
        while($data = mysqli_fetch_array($tampil)) :
    ?>
    <tr>
        <td><?=$no++?></td>
        <td><?=$data['nama_pengirim']?></td>
        <td><?=$data['alamat']?></td>
        <td><?=$data['no_hp']?></td>
        <td><?=$data['email']?></td>
        <td>
            <a href="?halaman=surat-masuk&hal=edit&id=<?=$data['id_pengirim_surat']?>" class="btn btn-success">Edit</a>
            <a href="?halaman=surat-masuk&hal=hapus&id=<?=$data['id_pengirim_surat']?>" class="btn btn-danger" onclick="return confirm('Apakah yakin ingin menghapus data ini?')">Hapus</a>
        </td>
    </tr>
  <?php endwhile; ?>
  </table>
  </div>
</div>